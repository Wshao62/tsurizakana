<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use App\Notifications\PasswordResetNotification;
use App\Notifications\VerifyNewEmailNotification;
use App\Models\UserPhoto;
use App\Models\UserRating;
use App\Models\Fish;
use App\Models\VerifyNewEmail;
use App\Helpers\FileHelper;
use App\Helpers\AWSHelper;
use App\Models\Message;
use App\Models\User\IdentificationDoc;
use App\Models\User\Shop;
use App\Models\User\DeviceToken;
use DateTime;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'furigana',
        'zipcode',
        'prefecture',
        'public_address',
        'private_address',
        'mobile_tel',
        'tel',
        'identificated_at',
        'bank_name',
        'bank_branch_code',
        'bank_type',
        'bank_number',
        'bank_user_name',
        'introduction',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    const BANK_TYPE_F = 1; //普通
    const BANK_TYPE_T = 2; //当座
    const BANK_TYPE_C = 3; //貯蓄
    const BANK_TYPES = [
        self::BANK_TYPE_F,
        self::BANK_TYPE_T,
        self::BANK_TYPE_C,
    ];
    const BANK_TYPE_NAME = [
        self::BANK_TYPE_F => '普通口座',
        self::BANK_TYPE_T => '当座口座',
        self::BANK_TYPE_C => '貯蓄口座',
    ];

    public function tempRegistUser()
    {
        return $this->hasOne('App\Models\TempRegist', 'email', 'email');
    }

    public function photo()
    {
        return $this->hasOne('App\Models\UserPhoto', 'user_id', 'id')
                    ->withDefault([
                        'profile_photo' => url(config('const.profile_img_default_icon')),
                        'cover_photo' => url(config('const.profile_img_default_cover')),
                    ]);
    }

    public function rate()
    {
        return $this->hasMany('App\Models\UserRating', 'target_user_id', 'id');
    }

    public function sale()
    {
        return $this->hasMany('App\Models\Fish', 'seller_id', 'id');
    }

    public function fishPublished()
    {
        return $this->hasMany('App\Models\Fish', 'seller_id', 'id')->whereStatus(Fish::STATUS_PUBLISH);
    }

    public function accounts()
    {
        return $this->hasMany('App\Models\LinkedSocialAccount', 'temp_regist_email', 'email');
    }

    public function blogs()
    {
        return $this->hasMany('App\Models\Blog', 'user_id', 'id');
    }

    public function newEmail()
    {
        return $this->hasOne('App\Models\VerifyNewEmail');
    }

    public function identifications()
    {
        return $this->hasMany('App\Models\User\IdentificationDoc', 'user_id', 'id');
    }

    public function identification()
    {
        return $this->hasOne('App\Models\User\IdentificationDoc', 'user_id', 'id')->latest();
    }

    public function shop()
    {
        return $this->hasOne('App\Models\User\Shop', 'user_id', 'id');
    }

    public function deviceTokens()
    {
        return $this->hasOne('App\Models\User\DeviceToken', 'user_id', 'id')->latest();
    }

    public function notificationCount()
    {
        return Message::where('is_seen', Message::UNREAD)
                        ->whereReceiverId(\Auth::user()->id)
                        ->count();
    }

    public function getRateCounts()
    {
        return UserRating::getRateCounts($this->id);
    }

    /*
     * Profile ownership
     */
    public function isOwner()
    {

        return !!(\Auth::user()->id === $this->id);
    }

    /**
     * 本人確認済みか
     *
     * @return bool
     */
    public function isIdentified()
    {
        return !!(!empty($this->identificated_at));
    }

    /**
     * 本人確認待ちの状態であるか
     *
     * @return bool
     */
    public function isWaiting4Identification()
    {
        $latested_check = $this->identification;
        return !!(!$this->isIdentified() && !empty($latested_check) && empty($latested_check->reject_reason));
    }

    public function notificationList()
    {
        $notifications = Message::where('is_seen', Message::UNREAD)->whereReceiverId(\Auth::user()->id)
                       ->orderBy('created_at', 'desc')
                       ->limit(5)
                       ->get();

        $threads = [];
        foreach ($notifications as $key => $notification) {
            $profile_photo = UserPhoto::whereUserId($notification->user_id)->first();

            $collection              = (object) null;
            $collection->profile     = !empty($profile_photo) ? $profile_photo['profile_photo'] : url(config('const.profile_img_default_icon'));
            $collection->name        = User::whereId($notification->user_id)->first()->name;
            $collection->created_at  = User::makeTime($notification->created_at);
            $collection->fish_id     = $notification->fish_id;
            $threads[]               = $collection;
        }
        $threads = collect($threads);

        return $threads;
    }

    /**
     * Replaces datetime to time format
     *
     * @param datetime $datetime
     * @return time
     */
    public static function makeTime($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    /**
     * 全体に公開する住所を取得する
     *
     * @return string
     */
    public function getPublicAddress()
    {
        return $this->prefecture . $this->public_address;
    }

    public static function register(array $attributes)
    {
        DB::beginTransaction();
        try {
            $user = self::create($attributes);

            if (!empty($attributes['shop_name'])) {
                Shop::register([
                    'user_id' => $user->id,
                    'name' => $attributes['shop_name'],
                    'zipcode' => $attributes['shop_zipcode'],
                    'prefecture' => $attributes['shop_prefecture'],
                    'address1' => $attributes['shop_address1'],
                    'address2' => $attributes['shop_address2'],
                    'full_address' => $attributes['shop_prefecture'].$attributes['shop_address1'].$attributes['shop_address2'],
                ]);
            }

            $temp_user = $user->tempRegistUser;
            if (!empty($temp_user)) {
                $temp_user->delete();
            }

            $linked_accounts = $user->accounts();
            if (!empty($linked_accounts)) {
                $linked_accounts->update([
                    'temp_regist_email' => null,
                    'user_id' => $user->id,
                    ]);
            }

            DB::commit();
            return $user;
        } catch (\PDOException $e) {
            DB::rollBack();
            \Log::error(get_class().':regist(): '.$e->getMessage());
            return false;
        } catch (\Exception $e) {
            \Log::error(get_class().':regist(): '.$e->getMessage());
            return false;
        }
    }

    /**
     * 更新
     *
     * @param  array $attributes
     *
     */
    public function updater(array $attributes)
    {
        \DB::beginTransaction();
        try {
            $this->zipcode = $attributes['zipcode'];
            $this->prefecture = $attributes['prefecture'];
            $this->public_address = $attributes['public_address'];
            $this->private_address = $attributes['private_address'];
            $this->mobile_tel = $attributes['mobile_tel'];
            $this->tel = $attributes['tel'];
            $this->introduction = $attributes['introduction'];
            $this->bank_name = $attributes['bank_name'];
            $this->bank_branch_code = $attributes['bank_branch_code'];
            $this->bank_type = $attributes['bank_type'];
            $this->bank_number = $attributes['bank_number'];
            $this->bank_user_name = $attributes['bank_user_name'];
            $this->save();

            $shop = $this->shop ?: new Shop();
            if (!empty($shop->useer_id) && empty($attributes['shop_name'])) {
                $shop->delete();
            } elseif (!empty($attributes['shop_name'])) {
                $shop->user_id = $this->id;
                $shop->name = $attributes['shop_name'];
                $shop->zipcode = $attributes['shop_zipcode'];
                $shop->prefecture = $attributes['shop_prefecture'];
                $shop->address1 = $attributes['shop_address1'];
                $shop->address2 = $attributes['shop_address2'];
                $shop->full_address = $attributes['shop_prefecture'].$attributes['shop_address1'].$attributes['shop_address2'];
                $shop->save();
            }

            $rtn = $this;

            $paths = [];
            $deletefile = [];
            $paths_cover = "";
            $paths_profile = "";
            $tempPath = storage_path(config('const.img_path_temp').$this->id.'/');

            if (!empty($attributes['cover_photo'])) {
                $paths['cover_photo'] = UserPhoto::makePath($this->id, $attributes['cover_photo']['extension']);
                FileHelper::storeResizeImg($tempPath . 'cover_photo.' . $attributes['cover_photo']['extension'], $paths['cover_photo']['server_path'], 980, null);
                $paths_cover = $paths['cover_photo']['server_path'];
                if (!empty($this->photo()->where('user_id', $this->id)->first())) {
                    $deletefile[] = UserPhoto::getLocalPath($this->photo()->where('user_id', $this->id)->first()->cover_photo);
                }
            }

            if (!empty($attributes['profile_photo'])) {
                $paths['profile_photo'] = UserPhoto::makePath($this->id, $attributes['profile_photo']['extension']);
                FileHelper::storeResizeImg($tempPath . 'profile_photo.' . $attributes['profile_photo']['extension'], $paths['profile_photo']['server_path'], 300, null);
                $paths_profile = $paths['profile_photo']['server_path'];
                if (!empty($this->photo()->where('user_id', $this->id)->first())) {
                    $deletefile[] = UserPhoto::getLocalPath($this->photo()->where('user_id', $this->id)->first()->profile_photo);
                }
            }

            UserPhoto::createUpdate($paths, $this->id);


            $verify_email = null;
            if ($attributes['email'] != \Auth::user()->email) {
                $verify_email = VerifyNewEmail::registOrUpdate($attributes['email']);
                if ($rtn === false) {
                    throw new \Exception('VerifyNewEmail::registOrUpdate is Error');
                }
            }

            \DB::commit();
            \File::delete($deletefile);

            if (!empty($verify_email)) {
                $this->notify(new VerifyNewEmailNotification($verify_email['token']));
            }

            return $rtn;
        } catch (\Exception $e) {
            if (!empty($paths_cover)) {
                \File::delete($paths_cover);
            }
            if (!empty($paths_profile)) {
                \File::delete($paths_profile);
            }
            \Log::error(get_class().':updater(): '.$e->getMessage());
            \DB::rollback();
            return false;
        }
    }

    /**
     * DeviceTokenを追加する
     *
     * @param  string $os_type (ios/android)
     * @param  string $dt
     *
     * @return void
     */
    public function addDeviceToken(string $os_type, string $dt)
    {
        \DB::beginTransaction();
        try {
            if (!$token = DeviceToken::whereUserId($this->id)->whereDeviceToken($dt)->first()) {
                // SNSへ登録
                if (!$endpoint_arn = AWSHelper::SNSAddDeviceToken($dt, $os_type)) {
                    throw new \Exception('エンドポイント登録エラー');
                }

                // 全員入りのtopicへ登録
                if (!$subscription_arn = AWSHelper::SNSSubscribeTopic(config('aws.topic_arn_all'), $endpoint_arn)) {
                    throw new \Exception('トピック登録エラー');
                }

                // MEMO: 2度素早い通信が来た場合にチェックに漏れることがあるので、firstOrCreate
                $new = DeviceToken::firstOrCreate([
                    'user_id' => $this->id,
                    'device_token' => $dt,
                    'endpoint_arn' => $endpoint_arn,
                    'subscription_arn' => $subscription_arn,
                ]);
            }

            \DB::commit();
        } catch (\Exception $ex) {
            \Log::error(get_class().':addDeviceToken(): '.$ex->getMessage());
            \DB::rollback();
        }
    }

    /**
     * DeviceTokenを削除
     *
     * @param  string $os_type (ios/android)
     * @param  string $old_dt
     *
     * @return void
     */
    public function removeDeviceToken(string $os_type, string $old_dt = null)
    {
        \DB::beginTransaction();
        try {
            if ($old = DeviceToken::whereUserId($this->id)->whereDeviceToken($old_dt)->first()) {
                AWSHelper::SNSUnsubscribeTopic($old->subscription_arn);
                AWSHelper::SNSDeleteEndpoint($old->endpoint_arn);
                $old->delete();
            }
            \DB::commit();
        } catch (\Exception $ex) {
            \Log::error(get_class().':removeDeviceToken(): '.$ex->getMessage());
            \DB::rollback();
        }
    }

    /**
     * 会員登録のStepごとにバリデーションを返却。指定がない場合は全項目渡す
     *
     * @param  int $step
     *
     * @return void
     */
    public static function validate($step = null, $user_id = null)
    {
        $userID = 0;

        if ($user_id !== null) {
            $userID = $user_id;
        }

        $step1_validate = [
            'name' => ['required', 'string', 'max:50'],
            'furigana' => ['required', 'string', 'furigana'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        $step2_validate = [
            'zipcode' => ['required', 'zipcode'],
            'prefecture' => ['required', 'string', Rule::in(config('const.prefectures'))],
            'public_address' => ['required', 'string', 'max:100'],
            'private_address' => ['required', 'string', 'max:100'],
            'mobile_tel' => ['required', 'phone'],
            'tel' => ['nullable', 'phone'],
            'shop_name' => ['nullable', 'string', 'max:50', 'required_with:shop_zipcode,shop_prefecture,shop_address1,shop_address2'],
            'shop_zipcode' => ['nullable', 'zipcode', 'required_with:shop_name,shop_prefecture,shop_address1,shop_address2'],
            'shop_prefecture' => [ 'nullable',  Rule::in(config('const.prefectures')), 'required_with:shop_name,shop_zipcode,shop_address1,shop_address2'],
            'shop_address1' => ['nullable', 'max:100', 'required_with:shop_name,shop_zipcode,shop_prefecture,shop_address2'],
            'shop_address2' => ['nullable', 'max:100'],
        ];

        $profile_edit = [
            'cover_photo' => ['nullable','image', 'max:5000'],
            'profile_photo' => ['nullable','image', 'max:5000'],
            'introduction' => ['nullable', 'string', 'max:1000' ],
            'bank_name' => ['can_delete_bank:'.$userID, 'max:15', 'required_with:bank_branch_code,bank_branch_code,bank_type,bank_number,bank_user_name'],
            'bank_branch_code' => ['nullable', 'numeric', 'digits:3', 'required_with:bank_name,bank_type,bank_number,bank_user_name'],
            'bank_type' => ['nullable', 'numeric', Rule::in(self::BANK_TYPES), 'required_with:bank_name,bank_branch_code, bank_number,bank_user_name'],
            'bank_number' => ['nullable', 'numeric', 'digits_between:4,7', 'required_with:bank_name,bank_branch_code,bank_type,bank_user_name'],
            'bank_user_name' => ['nullable', 'string', 'bank_user_name', 'max:30', 'required_with:bank_name,bank_branch_code,bank_type,bank_number'],
        ];

        switch ($step) {
            case 1:
                $rtn = $step1_validate;
                break;
            case 2:
                $rtn = $step2_validate;
                break;
            case 'confirm':
                $rtn = $step1_validate + $step2_validate;
                // 確認画面のバリデーション時にconfirmed設定しているとエラーが出るので削除
                $rtn['password'] = ['required', 'string', 'min:6'];
                break;
            case 'edit':
                $rtn = $step1_validate + $step2_validate + $profile_edit;
                $rtn['password'] = [];
                $rtn['email'] = ['required', 'string', 'email', 'max:255', 'unique:temp_regists', Rule::unique('users')->ignore(\Auth::user()->id, 'id')];
                unset($rtn['name']);
                unset($rtn['furigana']);
                break;
            case 'admin_add':
                $rtn = $step1_validate + $step2_validate + $profile_edit;
                unset($rtn['password']);
                $rtn['password'] = ['required', 'string', 'min:6'];
                $rtn['email'] = ['required', 'string', 'email', 'max:255', 'unique:temp_regists', 'unique:users'];
                break;
            case 'admin_edit':
                $rtn = $step1_validate + $step2_validate + $profile_edit;
                $rtn['password'] = ['nullable','string', 'min:6'];
                $rtn['email'] = ['required', 'string', 'email', 'max:255', 'unique:temp_regists', Rule::unique('users')->ignore($userID, 'id')];
                break;
            default:
                $rtn = $step1_validate + $step2_validate;
                $rtn['email'] = ['required', 'string', 'email', 'unique:users'];
        }
        return $rtn;
    }

    public static function getProperties()
    {
        return [
            'email' => '',
            'password' => '',
            'name' => '',
            'furigana' => '',
            'zipcode' => '',
            'prefecture' => '',
            'public_address' => '',
            'private_address' => '',
            'mobile_tel' => '',
            'tel' => '',
            'bank_name' => '',
            'bank_branch_code' => '',
            'bank_type' => '',
            'bank_number' => '',
            'bank_user_name' => '',
            'shop_name' => '',
            'shop_zipcode' => '',
            'shop_prefecture' => '',
            'shop_address1' => '',
            'shop_address2' => '',
        ];
    }

    /**
     * パスワードリセット通知の送信をオーバーライド.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

     /**
      * Admin functionality
      */
    public function adminUpdater(array $attributes)
    {
        \DB::beginTransaction();
        try{

            $user = self::find($attributes['id']);
            $user->name = $attributes['name'];
            $user->furigana = $attributes['furigana'];
            $user->email = $attributes['email'];
            $user->password = $attributes['password'];
            $user->zipcode = $attributes['zipcode'];
            $user->prefecture = $attributes['prefecture'];
            $user->public_address = $attributes['public_address'];
            $user->private_address = $attributes['private_address'];
            $user->mobile_tel = $attributes['mobile_tel'];
            $user->tel = $attributes['tel'];
            $user->introduction = $attributes['introduction'];
            $user->bank_name = $attributes['bank_name'];
            $user->bank_branch_code = $attributes['bank_branch_code'];
            $user->bank_type = $attributes['bank_type'];
            $user->bank_number = $attributes['bank_number'];
            $user->bank_user_name = $attributes['bank_user_name'];

            if(empty($user->password)){
                unset($user->password);
            }
            $user->save();

            $shop = $this->shop ?: new Shop();
            if (!empty($shop->name) && empty($attributes['shop_name'])) {
                $shop->delete();
            } else {
                $shop->user_id = $this->id;
                $shop->name = $attributes['shop_name'];
                $shop->zipcode = $attributes['shop_zipcode'];
                $shop->prefecture = $attributes['shop_prefecture'];
                $shop->address1 = $attributes['shop_address1'];
                $shop->address2 = $attributes['shop_address2'];
                $shop->full_address = $attributes['shop_prefecture'].$attributes['shop_address1'].$attributes['shop_address2'];
                $shop->save();
            }

            $rtn = $user;

            $photo = UserPhoto::whereUserId($attributes['id'])->first();

            if (!empty($photo)) {
                if (($attributes['coverpreview'] == null || empty($attributes['coverpreview'])) && !empty($photo->cover_photo)) {
                    UserPhoto::where('user_id', $attributes['id'])
                                ->update([
                                    'cover_photo' => null,
                            ]);

                    $path = explode('storage', $photo['cover_photo'])[count(explode('storage', $photo['cover_photo']))-1];
                    unlink(storage_path('app/public/'. $path));
                }


                if (($attributes['profilepreview'] == null || empty($attributes['profilepreview'])) && !empty($photo->profile_photo)) {
                    UserPhoto::where('user_id', $attributes['id'])
                                ->update([
                                    'profile_photo' => null,
                                ]);
                    $path = explode('storage', $photo['profile_photo'])[count(explode('storage', $photo['profile_photo']))-1];
                    unlink(storage_path('app/public/'. $path));
                }
            }

            \DB::commit();

            return $rtn;
        } catch (\Exception $e) {
            \Log::error(get_class().':AdminUpdater(): '.$e->getMessage());
            \DB::rollback();
            return false;
        }
    }

    public function adminDelete($userID)
    {
        \DB::beginTransaction();
        try{
            $this->where('id', $userID)->delete();
            UserPhoto::where('user_id', $userID)->forcedelete();
            // TODO: 退会処理作成時に合わせて作成
            $rtn = $this;

            File::deleteDirectory(storage_path('app/public/img/profile/'. $userID));

            \DB::commit();
            return $rtn;

        } catch (\Exception $e) {
            \Log::error(get_class().':AdminDelete(): '.$e->getMessage());
            \DB::rollback();
            return false;
        }
    }

    public function adminRegister(array $attributes)
    {
        \DB::beginTransaction();
        try{

            $rtn = self::create([
                'email' => $attributes['email'],
                'password' => $attributes['password'],
                'name' => $attributes['name'],
                'furigana' => $attributes['furigana'],
                'zipcode' => $attributes['zipcode'],
                'prefecture' => $attributes['prefecture'],
                'public_address' => $attributes['public_address'],
                'private_address' => $attributes['private_address'],
                'mobile_tel' => $attributes['mobile_tel'],
                'tel' => $attributes['tel'],
                'bank_name' => $attributes['bank_name'],
                'bank_branch_code' => $attributes['bank_branch_code'],
                'bank_type' => $attributes['bank_type'],
                'bank_number' => $attributes['bank_number'],
                'bank_user_name' => $attributes['bank_user_name'],
            ]);

            if (!empty($attributes['shop_name'])) {
                $shop = new Shop();
                $shop->user_id = $rtn->id;
                $shop->name = $attributes['shop_name'];
                $shop->zipcode = $attributes['shop_zipcode'];
                $shop->prefecture = $attributes['shop_prefecture'];
                $shop->address1 = $attributes['shop_address1'];
                $shop->address2 = $attributes['shop_address2'];
                $shop->full_address = $attributes['shop_prefecture'].$attributes['shop_address1'].$attributes['shop_address2'];
                $shop->save();
            }

            \DB::commit();
            return $rtn;
        } catch (\Exception $e) {
            \Log::error(get_class().':AdminRegister(): '.$e->getMessage());
            \DB::rollback();
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
        $identification_subquery = \DB::table('user_identification_docs AS I2')
                                ->select('I2.user_id', 'I2.file_path1', 'I2.reject_reason')
                                ->join(\DB::raw('('.IdentificationDoc::select('user_id', \DB::raw('MAX(`created_at`) as newest_dt'))->groupBy('user_id')->toSql().') AS I3'), function ($qry) {
                                        $qry->on('I2.user_id', '=', 'I3.user_id')
                                            ->on('I2.created_at', '=', 'I3.newest_dt');
                                });
        $query = \DB::table('users AS U')
                    ->leftjoin('user_photos AS P', function ($qry) {
                        $qry->on('P.user_id', '=', 'U.id');
                    })
                    ->leftjoin(\DB::raw('('.$identification_subquery->toSql().') AS I'), function ($qry) {
                            $qry->on('I.user_id', '=', 'U.id');
                    })
                    ->select(
                        'U.*',
                        'I.file_path1',
                        'I.reject_reason',
                        \DB::raw('ifnull(P.profile_photo, "'.url(config('const.profile_img_default_icon')).'") as profile_photo')
                    );

        $query->whereNull('U.deleted_at');
        // WHERE
        //魚名の指定
        if (!empty($data['user_id'])) {
            $query->where('U.id', '=', $data['user_id']);
        }
        //本人確認の状態指定
        if (!empty($data['identification']) || (isset($data['identification']) && $data['identification'] == 0)) {
            switch ($data['identification']) {
                case 0: //未確認
                    $query->whereNull('identificated_at')
                        ->where(function ($q) {
                            $q->where(function ($_q) {
                                $_q->whereNull('file_path1')
                                ->whereNull('reject_reason');
                            })
                            ->orWhere(function ($_q) {
                                $_q->whereNotNull('reject_reason');
                            });
                        });
                    break;
                case 1: //確認待ち
                    $query->whereNull('identificated_at')
                            ->whereNotNull('file_path1')
                            ->whereNull('reject_reason');
                    break;
                case 9: //確認済み
                    $query->whereNotNull('identificated_at');
                    break;
            }
        }
        //都道府県の指定
        if (!empty($data['prefecture'])) {
            $query->where('U.prefecture', '=', $data['prefecture']);
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
}
