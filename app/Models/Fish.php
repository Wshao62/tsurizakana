<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\Updater;
use App\Models\Traits\FullTextSearch;
use App\Models\Fish\Category;
use App\Models\Fish\Photo;
use App\Models\Fish\Wisher;
use App\Models\Fish\Reject;
use App\Models\Fish\Offer;
use App\Models\UserRating;
use Illuminate\Validation\Rule;
use App\Notifications\Fish\ChooseWisherNotification;
use App\Notifications\Fish\PayCompleteNotification;
use App\Notifications\Fish\TransactionRejectedNotification;
use App\Notifications\Fish\OfferRecievedNotification;
use App\Helpers\FileHelper;
use App\Notifications\DeleteNotification;

class Fish extends Model
{
    use SoftDeletes;
    use Updater;
    use FullTextSearch;
    use Notifiable;

    protected $fillable = [
        'fish_category_id',
        'fish_category_name',
        'seller_id',
        'buyer_id',
        'location',
        'destination',
        'price',
        'description',
        'status',
    ];

    protected $searchable = [
        'destination',
        'description',
    ];

    // MEMO: 数字を変更した場合、common.cssのtag_*の数値も変更すること
    // const STATUS_PRIVATE = 0;
    const STATUS_PUBLISH = 1;
    const STATUS_PAYING = 5;
    const STATUS_DELIVERY = 10;
    const STATUS_EVALUATE = 15;
    const STATUS_CLOSED = 20;
    const STATUS_REJECT = 30;
    const STATUS_EXPIRED = 99;

    const STATUS_NAMES = [
        // self::STATUS_PRIVATE => '非公開',
        self::STATUS_PUBLISH => '公開中',
        self::STATUS_PAYING => '支払い待ち',
        self::STATUS_DELIVERY => '配達待ち',
        self::STATUS_EVALUATE => '評価待ち',
        self::STATUS_CLOSED => '取引完了',
        self::STATUS_REJECT => '取引中止',
        self::STATUS_EXPIRED => '受付終了',
    ];

    // mypageの表示ステータス
    const LIST_BUY = 'buy';
    const LIST_TRANSACTION = 'transaction';
    const LIST_ALL_STATUS = [
        self::LIST_BUY,
        self::LIST_TRANSACTION,
    ];

    public function seller()
    {
        return $this->hasOne('App\Models\User', 'id', 'seller_id');
    }

    public function buyer()
    {
        return $this->hasOne('App\Models\User', 'id', 'buyer_id');
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'item_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany('App\Models\Fish\Photo', 'fish_id', 'id')->orderBy('order', 'asc');
    }

    public function onePhoto()
    {
        return $this->hasOne('App\Models\Fish\Photo', 'fish_id', 'id')
                ->whereOrder(1)
                ->withDefault(
                    ['file_name' => '']
                );
    }

    public function wishers()
    {
        return $this->hasMany('App\Models\Fish\Wisher', 'fish_id', 'id');
    }

    public function reject()
    {
        return $this->hasOne('App\Models\Fish\Reject', 'fish_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Fish\Comment', 'fish_id', 'id')->orderBy('created_at', 'asc');
    }

    /**
     * ステータス公開中のみ
     *
     * @param  mixed $query
     *
     * @return void
     */
    public function scopePublished($query)
    {
        return $query->whereStatus(self::STATUS_PUBLISH);
    }

    /**
     * 売主であるか
     *
     * @return bool
     */
    public function isOwner()
    {
        return !!(\Auth::id() == $this->seller_id);
    }

    /**
     * 買主であるか
     *
     * @return bool
     */
    public function isBuyer()
    {
        return !!(\Auth::id() == $this->buyer_id);
    }

    /**
     * 購入希望者であるか
     *
     * @return bool
     */
    public function isWisher()
    {
        $rtn = Wisher::find($this->id, \Auth::user()->id);
        return !!($rtn);
    }

    public function hasOffer4User($user_id = null)
    {
        if (empty($user_id)) {
            $user_id = \Auth::id();
        }
        // !!(count($this->wishers->toArray()) > 0);
        return !! (Offer::whereRequestUserId($user_id)->whereFishId($this->id)->first());
    }

    /**
     * 公開中ステータスか
     *
     * @return bool
     */
    public function isPublish()
    {
        return !!($this->status === self::STATUS_PUBLISH);
    }

    /**
     * 取引中止ステータスか
     *
     * @return bool
     */
    public function isReject()
    {
        return !!($this->status === self::STATUS_REJECT);
    }


    /**
     * 取引中であるか。
     * 判断はbuyer_idがあるか、statusが決済待ちから取引中止までであるかで判断
     *
     * @return bool
     */
    public function isTransaction()
    {
        $rtn = false;
        if (!empty($this->buyer_id)
        && $this->status >= self::STATUS_PAYING
        && $this->status <= self::STATUS_REJECT) {
            $rtn = true;
        }

        return $rtn;
    }

    /**
     * 評価待ちステータスか
     *
     * @return bool
     */
    public function isEvaluate()
    {
        return !!($this->status == self::STATUS_EVALUATE);
    }

    /**
     * 取引が終了ステータスか(完了・中止・受付終了)
     *
     * @return bool
     */
    public function isFinish()
    {
        return !!($this->status >= self::STATUS_CLOSED);
    }

    /**
     * 自身が評価済みか
     *
     * @return bool
     */
    public function isRated($user_id = null)
    {
        if (empty($user_id)) {
            $user_id = \Auth::id();
        }
        $rate = UserRating::getRate($this->id, $user_id);
        return !!$rate;
    }

    /**
     * ステータス表示名を取得する
     *
     * @return string
     */
    public function getStatus()
    {
        return self::STATUS_NAMES[$this->status];
    }

    /**
     * ステータスを対外的表記用。売魚一覧、詳細などで用いる
     *
     * @return string
     */
    public function getPublicStatus()
    {
        $status_name = $this->getStatus();
        if ($this->status > self::STATUS_PUBLISH
        && $this->status < self::STATUS_REJECT) {
            $status_name = '売却済み';
        }
        return $status_name;
    }

    /**
     * オーダー可能であるか。
     * ログインユーザのbuyer_idの一致とステータスを確認する
     *
     * @return bool
     */
    public function canOrder()
    {
        return !!($this->isBuyer() && $this->status == self::STATUS_PAYING);
    }

    /**
     * 編集可能であるか
     * ステータスが公開以下かつ購入希望者がいないこと
     *
     * @return bool
     */
    public function canEdit()
    {
        return !!($this->status <= self::STATUS_PUBLISH && !$this->hasWisher());
    }

    /**
     * 削除可能であるか
     * 取引中でないこと
     *
     * @return bool
     */
    public function canDelete()
    {
        return !!($this->isPublish() || $this->status == self::STATUS_EXPIRED);
    }

    /**
     * 取引をキャンセル可能か
     * ・受け取り後はどちらも実施不可
     * ・決済までは売主、買主が実施可能
     * ・評価前までは買主のみ実施可能
     *
     * @return bool
     */
    public function canCancelTransaction()
    {

        return !!($this->status < self::STATUS_EVALUATE
            && (
                ($this->isOwner() && $this->status == self::STATUS_PAYING)
                || $this->isBuyer()
            ));
    }

    /**
     * 購入希望者がいるか
     *
     * @return bool
     */
    public function hasWisher()
    {
        return !!(count($this->wishers->toArray()) > 0);
    }

    /**
     * フォーマットされた日時を取得
     *
     * @param  string $format
     *
     * @return string
     */
    public function getFormatedCreatedAt($format = 'Y/m/d H:i')
    {
        return date($format, strtotime($this->created_at));
    }

    public function message()
    {
        return $this->hasMany('App\Models\Message', 'fish_id', 'id');
    }

    /**
     * 新規登録
     *
     * @param  array $attributes
     *
     * @return mixed instance of Fish Model / bool false
     */
    public static function register(array $attributes)
    {
        \DB::beginTransaction();
        try {
            $attributes['fish_category_name'] = trim($attributes['fish_category_name']);
            $attributes['seller_id'] = \Auth::user()->id;
            $attributes['status'] = self::STATUS_PUBLISH;

            // category
            $category = Category::firstOrCreate([
                'name' => trim($attributes['fish_category_name']),
            ]);
            $attributes['fish_category_id'] = $category['id'];

            $fish = self::create($attributes);

            //photo DBへ挿入
            $img_paths =[];
            foreach ($attributes['photo'] as $order => $photo) {
                $_path = Photo::moveTempImage($photo, $fish->id, $order + 1);
                $img_paths[] = $_path;
                $rtn = Photo::create([
                    'fish_id' => $fish->id,
                    'file_name' => $_path['public_path'],
                    'order' => $order + 1,
                ]);
            }

            \DB::commit();

            //tmp画像は削除
            \File::delete(\File::glob(Photo::getTempDir4User().'*'));
            return $fish;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error(get_class().':register(): '.$e->getMessage());

            if (!empty($img_paths)) {
                $delete_file = [];
                foreach ($img_paths as $_path) {
                    $delete_file[] = $_path['target_path'];
                }
                \File::delete($delete_file);
            }
            return false;
        }
    }

    /**
     * 更新をかける
     *
     * @param  array $attributes
     *
     * @return Fish
     */
    public function userUpdater($attributes)
    {
        $before_func = (function ($attributes) {
            $category = Category::firstOrCreate([
                'name' => trim($attributes['fish_category_name']),
            ]);
            $attributes['fish_category_id'] = $category->id;
            return $attributes;
        });

        $img_paths = [];
        $delete_paths = [];
        $after_func = (function ($fish) use ($attributes, &$img_paths, &$delete_paths) {
            $photos = $fish->photos;


            $order = 0;
            foreach ($attributes['photo_id'] as $_id) {
                if (empty($attributes['photo'][$order])) {
                    continue;
                }

                if (empty($_id)) {
                    //新規登録
                    $_path = Photo::moveTempImage($attributes['photo'][$order], $fish->id, $order + 1);
                    $img_paths[] = $_path;
                    $rtn = Photo::create([
                        'fish_id' => $fish->id,
                        'file_name' => $_path['public_path'],
                        'order' => $order + 1,
                    ]);
                } else {
                    //orderの変更
                    foreach ($photos as $idx => $_photo) {
                        if ($_photo->id != $_id) {
                            continue;
                        }
                        $_photo->order = $order + 1;
                        $_photo->save();

                        unset($photos[$idx]);
                    }
                }
                $order++;
            }

            if (!empty($photos)) {
                //登録済み写真の削除
                $ids = [];
                foreach ($photos as $delete_photo) {
                    $delete_paths[] = FileHelper::getServerPath($delete_photo->file_name);
                    $ids[] = $delete_photo->id;
                }
                Photo::destroy($ids);
            }

            return $fish;
        });

        $success_function = (function ($fish) use (&$delete_paths) {
            //tmp画像は削除
            \File::delete(\File::glob(Photo::getTempDir4User().'*'));
            //削除選択した画像も削除
            \File::delete($delete_paths);
            return $fish;
        });
        $fail_function = (function () use (&$img_paths) {
            if (!empty($img_paths)) {
                $delete_file = [];
                foreach ($img_paths as $_path) {
                    $delete_file[] = $_path['target_path'];
                }
                \File::delete($delete_file);
            }
        });

        return $this->updater($attributes, $before_func, $after_func, $success_function, $fail_function);
    }

    /**
     * 削除を実行する
     * 画像ファイルは全て削除し、削除済み商品用の画像をorder1に当てはめる
     * 魚自体はsoftdelete実行
     *
     * @return bool
     */
    public function deleter()
    {
        \DB::beginTransaction();
        try {
            $photos = $this->photos;
            $img_paths = $photos->pluck('file_name')->toArray();

            $first_img = $photos[0];
            unset($photos[0]);
            $rtn = $first_img->updater(['file_name' => url(config('const.fish_img_deleted'))]);
            if (!$rtn) {
                throw new \Exception('売魚の編集に失敗しました。');
            }

            if (!empty($photos)) {
                $this->photos()->whereIn('order', [2,3])->delete();
            }

            //売魚へのコメントを削除
            $this->comments()->delete();

            $this->delete();
            \DB::commit();

            \File::delete(FileHelper::getServerPath($img_paths));
            return true;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error(get_class().':updater(): '.$e->getMessage());
            return false;
        }
    }

    /**
     * ストライプに仮払いを実行し、
     * DBにオーダーデータを保存
     * 魚は配達ステータスに。
     *
     * @return bool
     */
    public function execSuspencePay($token)
    {
        // MEMO: トランザクションは行わない。万一エラーが出ても、途中まで挿入されたDBデータがあったほうが良いため
        try {
            $buyer = \Auth::user();
            $seller = $this->seller;
            $charge = [];
            $stripe_charge_id = null;

            \Stripe\Stripe::setApiKey(config('stripe.secret_token'));
            $charge = \Stripe\Charge::create([
                'amount' => $this->price,
                'currency' => 'jpy',
                'description' => $buyer->name. 'さん出品の'. $this->fish_category_name,
                'source' => $token,
                'capture' => false,
                'metadata' => [
                    'user_id' => $buyer->id,
                    'fish_id' => $this->id,
                ],
            ]);
            $stripe_charge_id = $charge['id'];

            $order = [
                'user_id' => $buyer->id,
                'email' => $buyer->email,
                'item_id' => $this->id,
                'price' => $this->price,
                'stripe_charge_id' => $stripe_charge_id,
            ];
            $order = Order::create($order);

            //配達待ちステータスに変更
            $this->updater([
                    'status' => Fish::STATUS_DELIVERY,
                ]);

            //決済完了したメールを送信
            $seller->notify(new PayCompleteNotification($this, true));
            $buyer->notify(new PayCompleteNotification($this, false));

            //プッシュ通知
            $custom = ['url' => url('/mypage/fish/'. $this->id. '/wish')];
            \App\Models\User\DeviceToken::sendPushNotification($seller->id, "売魚の決済が確認できましたので、売り魚の配達を行なってください！", $custom);


            return true;
        } catch (\Throwable $e) {
            \Log::error(get_class().':getOrderOrCreate(): '.$e->getMessage());
            if ($stripe_charge_id !== null) {
                // 例外が発生すればオーソリを取り消す
                \Stripe\Refund::create(array(
                    'charge' => $stripe_charge_id,
                ));
            }
            return false;
        }
        return $order;
    }

    /**
     * 魚受け取り時の処理
     * ・Fishのステータスを評価待ち
     * ・ストライプの売り上げを確定
     *
     * @return bool
     */
    public function execRecieve()
    {
        \DB::beginTransaction();
        try {
            $order = $this->order;
            //stripeの売り上げを確定
            \Stripe\Stripe::setApiKey(config('stripe.secret_token'));
            $charge = \Stripe\Charge::retrieve($order->stripe_charge_id);
            $charge->capture();

            $order->updater(['billed_at' => now()]);

            //魚のステータスを評価待ちに
            $this->updater(['status' => Fish::STATUS_EVALUATE]);

            $custom = ['url' => url('/mypage/fish/'. $this->id. '/wish')];
            \App\Models\User\DeviceToken::sendPushNotification($this->seller_id, "売魚が受け取られました！取引相手の評価をお願いします。", $custom);

            \DB::commit();
            return true;
        } catch (\Throwable $e) {
            \Log::error(get_class().':execRecieve(): '.$e->getMessage());
            \DB::rollback();
            return false;
        }
    }

    /**
     * マイページの魚リストを取得
     *
     * @param  string $type
     * @param  int $limit
     *
     * @return void
     */
    public static function getMyList($type = "", $limit = 10)
    {
        $user_id = \Auth::id();
        switch ($type) {
            case "":
                $query = self::whereSellerId($user_id);
                break;
            case self::LIST_BUY:
                $query = self::whereBuyerId($user_id);
                break;
            case self::LIST_TRANSACTION:
                $query = self::where(function ($query) use ($user_id) {
                                $query->whereSellerId($user_id)
                                ->orWhere('buyer_id', '=', $user_id);
                })->where('status', '>=', self::STATUS_PAYING)
                ->where('status', '<=', self::STATUS_EVALUATE);
        }
        $rtn = $query->with('onePhoto')
            ->with('wishers')
            ->latest()
            ->paginate($limit);

        return $rtn;
    }

    /**
     * 検索結果の一覧を取得
     *
     * @param  array $data
     *
     * @return Fish paginated
     */
    public static function search($data)
    {
        $query = self::with('onePhoto');

        // キーワード 魚名と詳細のORライク検索
        if (!empty($data['keyword'])) {
            $keyword = $data['keyword'];
            $category_ids = category::search($keyword)->get()->pluck('id');

            $query->where(function ($query) use ($category_ids, $keyword) {
                $query->whereIn('fish_category_id', $category_ids)
                    ->OrSearch($keyword, 'description');
            });
        }

        // ユーザID指定
        if (!empty($data['user_id'])) {
            $query->whereSellerId($data['user_id']);
        }

        // カテゴリーID指定
        if (!empty($data['category_id'])) {
            $query->whereFishCategoryId($data['category_id']);
        }

        // エリア検索
        if (!empty($data['area'])) {
            $query->search($data['area'], 'destination');
        }

        // ステータス指定
        if (!empty($data['is_open'])) {
            $query->published();
        }

        // 取引中止のものは表示しない
        $query->where('status', '<>', self::STATUS_REJECT);

        //並び替え
        if (!empty($data['order'])) {
            switch ($data['order']) {
                case 'new':
                    $query->latest();
                    break;
                case 'low_price':
                    $query->orderBy('price', 'ASC');
                    break;
                case 'heigh_price':
                    $query->orderBy('price', 'DESC');
                    break;
                case 'name':
                    $query->orderBy('fish_category_name', 'ASC');
                    break;
            }
        } else {
            $query->latest();
        }

        // 表示件数
        if (!empty($data['limit'])) {
            $rtn = $query->paginate($data['limit']);
        } else {
            $rtn = $query->paginate(10);
        }

        return $rtn;
    }

    /**
     * ピックアップを取得する
     * ログインしているユーザとそうでないユーザで返却するリストが違う
     *
     * @param  int $limit
     *
     * @return Fish
     */
    public static function getPickup($limit = 18)
    {
        $rtn = [];
        $default_query = self::published()
                    ->with('onePhoto')
                    ->latest()
                    ->limit($limit);
        if (\Auth::check('user')) {
            $user = \Auth::user();
            $pref = $user->prefecture;
            $query = $default_query->where('seller_id', '<>', \Auth::id())
                            ->where(function ($_query) use ($pref) {
                                    $_query->search($pref, 'destination')
                                        ->orSearch($pref, 'destination');
                            });
            $rtn = $query->get();

            //取得した件数が指定したものより少ない場合、追加で最新を取得する
            if (count($rtn) < $limit) {
                $ids = $rtn->pluck('id')->toArray();
                $_limit = 18 - count($rtn);
                $other_rtn = self::published()
                    // ->where('seller_id', '<>', \Auth::id())
                    ->whereNotIn('id', $ids)
                    ->latest()
                    ->limit($_limit)
                    ->with('onePhoto')
                    ->get();

                    $rtn = $rtn->merge($other_rtn);
            }
        } else {
            //最新のみを取得する
            $rtn = $default_query->get();
        }

        return $rtn;
    }

    /**
     * 購入希望を出す。ただし、オファーがある場合は購入確定とする
     *
     * @return string(type)/false
     */
    public function execWish()
    {
        $rtn = 'wish';
        \DB::beginTransaction();
        try {
            if (!$this->hasOffer4User()) {
                Wisher::register([
                    'fish_id' => $this->id,
                    'user_id' => \Auth::id(),
                ]);
            } else {
                $rtn = 'buy';
                //fishにbuyer_idを設定
                //fishのstatusを決済待ちに
                $this->buyer_id = \Auth::id();
                $this->status = self::STATUS_PAYING;
                $this->save();

                //購入があった旨を通知
                $this->seller->notify(new OfferRecievedNotification($this, \Auth::user()));
            }
            \DB::commit();

            return $rtn;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error(get_class().':execWish(): '.$e->getMessage());
            return false;
        }
    }
    /**
     * 購入者選択処理
     *
     * @param  Wisher $wisher
     *
     * @return Fish/false
     */
    public function chooseWisher(Wisher $wisher)
    {
        \DB::beginTransaction();
        try {
            //fishにbuyer_idを設定
            //fishのstatusを決済待ちに
            $this->buyer_id = $wisher->user_id;
            $this->status = self::STATUS_PAYING;
            $this->save();

            //データを残しておく方が後々色々なものに利用できるかもなのでひとまず残しておく
            //wisherテーブルの掃除
            // Wisher::whereFishId($this->id)->delete();

            \DB::commit();

            //購入希望が通ったメールを購入者に通知
            $wisher->user->notify(new ChooseWisherNotification($this));
            return $this;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error(get_class().':register(): '.$e->getMessage());
            return false;
        }
    }

    public function getWisherList($limit = 10)
    {
        $rtn = [
            'rates' => null,
            'wishers' => null,
        ];
        $ids = [];

        $rtn['wishers'] = $this->wishers()
                        ->with(['user.photo'])->paginate($limit);

        if (!empty($rtn['wishers'])) {
            foreach ($rtn['wishers'] as $_w) {
                $ids[] = $_w['user_id'];
            }
        }
        if (!empty($ids)) {
            $user = User::whereIn('id', $ids)->with(['rate'])->get()->toArray();

            if (!empty($user)) {
                foreach ($user as $_u) {
                    $rtn['rates'][$_u['id']] = [
                        'good' => 0,
                        'normal' => 0,
                        'bad' => 0,
                    ];
                    if (empty($_u['rate'])) {
                        continue;
                    }
                    foreach ($_u['rate'] as $_r) {
                        switch ($_r['rate']) {
                            case UserRating::GOOD:
                                $rtn['rates'][$_u['id']]['good']++;
                                break;
                            case UserRating::NORMAL:
                                $rtn['rates'][$_u['id']]['normal']++;
                                break;
                            case UserRating::BAD:
                                $rtn['rates'][$_u['id']]['bad']++;
                                break;
                        }
                    }
                }
            }
        }

        return $rtn;
    }

    public function rate($rate_data)
    {
        \DB::beginTransaction();
        try {
            if ($this->isBuyer()) {
                $partner = $this->seller;
            } else {
                $partner = $this->buyer;
            }

            $data = [
                'source_user_id' => \Auth::id(),
                'rate' => $rate_data['rate'],
                'fish_id' => $this->id,
                'message' => $rate_data['rate_message'],
                'target_user_id' => $partner->id,
            ];
            $rate = UserRating::register($data);

            if ($this->isRated($partner->id)) {
                $this->updater([
                    'status' => self::STATUS_CLOSED,
                ]);
            }

            \DB::commit();
            return $rate;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error(get_class().':rate(): '.$e->getMessage());

            return false;
        }
    }

    public function execReject($reject_data)
    {
        \DB::beginTransaction();
        try {
            $data = [
                'reason' => $reject_data['reason'],
                'user_id' => \Auth::id(),
                'fish_id' => $this->id,
            ];
            $reject = Reject::register($data);

            $this->updater([
                    'status' => self::STATUS_REJECT,
                ]);
            \DB::commit();

            $this->buyer->notify(new TransactionRejectedNotification($this, $reject, \Auth::user()));
            $this->seller->notify(new TransactionRejectedNotification($this, $reject, \Auth::user()));

            // MEMO: これが失敗しても7日後には自動的にキャンセル扱いとなるのでDBコミット後に実施
            if ($this->order) {
                \Stripe\Stripe::setApiKey(config('stripe.secret_token'));
                \Stripe\Refund::create(array(
                    'charge' => $this->order->stripe_charge_id,
                ));
            }

            return $reject;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error(get_class().':reject(): '.$e->getMessage());

            return false;
        }
    }

    /**
     * fish_idから商品を複製する
     *
     * @param Fish $fish
     * @return bool
     */
    public function copy($fish) {
        \DB::beginTransaction();
        try {
            $fish_id = $fish->id;

            // fish
            $target_fish = Fish::find($fish_id);
            $new_fish = $target_fish->replicate();
            $new_fish->status = self::STATUS_PUBLISH;
            $new_fish->buyer_id = null;
            $new_fish->save();

            // fish photos
            $target_photos = Photo::where('fish_id', $fish_id)->get();
            foreach ($target_photos as $photo) {
                $new_photo = $photo->replicate();
                $new_photo->fish_id = $new_fish->id;
                $new_photo->save();
            }

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error(get_class().':reject(): '.$e->getMessage());

            return false;
        }
    }

    public static function getDataTable($attributes)
    {
        $rtn = self::getDataByReq($attributes);
        $result = [];
        $result['draw'] = !empty($attributes['draw']) ? intval($attributes['draw']) : null;
        $result['recordsTotal'] = self::count();
        $result['recordsFiltered'] = $rtn['filterd_cnt'];
        $result['data'] = $rtn['data'];
        return $result;
    }

    public static function getDataByReq($attributes)
    {
        $data = self::makeQueryByReq($attributes);
        $rtn = [];
        $collection = $data['query']->get();
        $rtn = ['data' => $collection, 'filterd_cnt' => intval($data['filterd_cnt'])];
        return $rtn;
    }

    private static function makeQueryByReq($data)
    {
        $limit = (!empty($data['length']) && $data['length'] != 0) ? intval($data['length']) : 10;
        $offset = (!empty($data['start']) && $data['start'] != 0) ? intval($data['start']) : 0;
        $query = \DB::table('fish AS F')
                    ->leftJoin('users as SU', function ($qry) {
                        $qry->on('SU.id', '=', 'F.seller_id');
                    })
                    ->leftJoin('users as BU', function ($qry) {
                        $qry->on('BU.id', '=', 'F.buyer_id');
                    })
                    ->join('fish_photos AS P', function ($qry) {
                        $qry->on('P.fish_id', '=', 'F.id')
                            ->on('P.order', '=', \DB::raw(1));
                    })
                ->select('F.*', 'P.file_name', 'SU.name as seller_name', 'BU.name as buyer_name');
        $query->whereNull('F.deleted_at');
        // WHERE
        //魚名の指定
        if (!empty($data['fish_category_name'])) {
            $category_ids = Category::search($data['fish_category_name'])->get()->pluck('id');
            $query->whereIn('F.fish_category_id', $category_ids);
        }
        //販売者の指定
        if (!empty($data['seller_id'])) {
            $query->where('F.seller_id', '=', $data['seller_id']);
        }
        //購入者の指定
        if (!empty($data['buyer_id'])) {
            $query->where('F.buyer_id', '=', $data['buyer_id']);
        }
        //ステータスの指定
        if (!empty($data['status']) || (isset($data['status']) && $data['status'] == 0)) {
            $query->where('F.status', '=', $data['status']);
        }
        // END WHERE
        //件数の取得
            $filterd_cnt = $query->count();
        //並び順
        if (!empty($data['order'])) {
            // Datatablesからのorder
            foreach ($data['order'] as $_o) {
                $query->orderBy($data['columns'][$_o['column']]['data'], $_o['dir']);
            }
        }
        if ($offset > 0) {
            $query->offset($offset);
        }
        $query->limit($limit);
        return ['query' => $query, 'filterd_cnt' => $filterd_cnt];
    }

    /**
     * バリデーションを実施
     *
     * @param integer $fish_id
     *
     * @return array
     */
    public static function validate($fish_id = null, $type = null)
    {
        $val = [
            'fish_category_name' => ['required', 'string', 'max:30'],
            'location' => ['required', 'string', 'max:100'],
            'destination' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:400'],
            'description' => ['required', 'string', 'max:1000'],
            'photo' => ['required', 'array', 'between:1,3'],
            'photo.*' => ['filled', 'url', 'active_storage_url'],
        ];

        if (!empty($fish_id)) {
            //編集の時
            if (empty($type)) {
                $val['photo_id.*'] = ['nullable', 'integer', 'min:1', 'valid_fish_photo_id:'. $fish_id];
            } else {
                unset($val['photo']);
                unset($val['photo.*']);
            }
        }

        return $val;
    }

    /**
     * 画面の初期表示などに用いるための
     * プロパティの配列をデフォルト値をセットして返却
     *
     * @return array
     */
    public static function getProperties()
    {
        return [
            'fish_category_name' => '',
            'seller_id' => '',
            'location' => '',
            'destination' => '',
            'price' => '',
            'description' => '',
            'photo' => ['', '', '',],
        ];
    }

    /**
     * Admin Functionality
     */
    public function adminDelete($fishID)
    {
        \DB::beginTransaction();
        try {
            $fish = $this->where('id', $fishID)->get()->toArray();
            $email = [];

            if (count($fish)) {
                $user = User::where('id', $fish[0]['seller_id'])->get()->toArray();

                $tmp_user = new User($user);
                $tmp_user['title'] = $fish[0]['fish_category_name'];
                $tmp_user['email'] = $user[0]['email'];
                $tmp_user['mail_title'] = "運営からのお知らせ";
                $tmp_user['template'] = "mails.admin.admin_fish";

                $mail['title'] = $fish[0]['fish_category_name'];
                $mail['email'] = $user[0]['email'];
            }

            $this->comments()->delete();
            $this->where('id', $fishID)->delete();
            Photo::where('fish_id', $fishID)->forcedelete();
            $rtn = $this;

            File::deleteDirectory(storage_path('app/public/img/fish/'. $fish[0]['seller_id'] . '/' .$fishID));

            \DB::commit();

            if ($mail['email'] != "") {
                $tmp_user->notify(new DeleteNotification($fish, false));
            }

            return $rtn;
        } catch (\Exception $e) {
            \Log::error(get_class().':AdminDelete(): '.$e->getMessage());
            \DB::rollback();
            return false;
        }
    }

    public function adminUpdater(array $attributes)
    {

        \DB::beginTransaction();
        try {
            // add category
            $category = Category::firstOrCreate([
                'name' => trim($attributes['fish_category_name']),
            ]);

            $attributes['fish_category_id'] = $category['id'];

            $this->where('id', $attributes['id'])
                ->update([
                    'fish_category_id' => $attributes['fish_category_id'],
                    'fish_category_name' => $category['name'],
                    'seller_id' => $attributes['seller_id'],
                    'buyer_id' => $attributes['buyer_id'],
                    'location' => $attributes['location'],
                    'destination' => $attributes['destination'],
                    'price' => $attributes['price'],
                    'description' => $attributes['description'],
                    'status' => $attributes['status'],
                ]);
            DB::commit();
            $rtn = $this;

            return $rtn;
        } catch (\Exception $e) {
            \Log::error(get_class().':adminUpdater(): '.$e->getMessage());
            \DB::rollback();
            return false;
        }
    }
}
