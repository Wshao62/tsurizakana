<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Notifications\Notifiable;
use App\Models\Blog\Photo;
use App\Helpers\FileHelper;
use App\Notifications\DeleteNotification;

class Blog extends Model
{

    use Notifiable;

    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'user_id',
        'plane_description',
        'description',
        'status',
    ];

    const STATUS_PRIVATE = 0;
    const STATUS_PUBLISH = 1;

    const STATUS_NAMES = [
        self::STATUS_PRIVATE => '非公開',
        self::STATUS_PUBLISH => '公開中',
    ];

    /**
    * ステータス表示名を取得する
    *
    * @return string
    */
    public function getStatus() :string
    {
        return self::STATUS_NAMES[$this->status];
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function photos()
    {
        return $this->hasMany('App\Models\Blog\Photo', 'blog_id', 'id')->orderBy('order', 'asc');
    }

    public function onePhoto()
    {
        return $this->hasOne('App\Models\Blog\Photo', 'blog_id', 'id')
                    ->where('order', 1)
                    ->withDefault(function ($model) {
                        $model->photo_id = '';
                        $model->file_name = url(config('const.blog_img_defult'));
                        $model->order = 1;
                    });
    }

    public function scopePublished($query)
    {
        return $query->wherestatus(self::STATUS_PUBLISH);
    }

    /**
     * 抜粋を取得
     *
     * @param  int $length
     *
     * @return string
     */
    public function getExcerpt($length = 200)
    {
        $text = $this->plane_description;
        $excerpt = mb_substr($this->plane_description, 0, $length);
        if (mb_strlen($text) > $length) {
            $excerpt .= '...';
        }
        return $excerpt;
    }

    /**
     * フォーマットされた日時を取得
     *
     * @param  string $format
     *
     * @return string
     */
    public function getFormatedCreatedAt($format = 'Y/m/d H:i:s')
    {
        return date($format, strtotime($this->created_at));
    }

    /**
     * 本文のhtmlコードを一部を除きエスケープし、
     * タグを全て排除したテキストも生成
     *
     * @param  sstring $text
     *
     * @return array
     */
    public static function textshap($text)
    {
        $replace_target = '/&lt;(\/?)(h1|h2|h3|h4|h5)&gt;/i';
        $replace_string = '<$1$2>';
        $rtn['description'] = preg_replace($replace_target, $replace_string, htmlspecialchars($text));
        $rtn['plane_description'] = strip_tags($text);
        return $rtn;
    }

    /**
     * 新規登録
     *
     * @param  array $attributes
     *
     */
    public static function register(array $attributes)
    {
        \DB::beginTransaction();
        try {
            $attributes['status'] = $attributes['status'] == '1' ? true : false;

            //リクエストの整形
            $texts = self::textshap($attributes['description']);
            $attributes['plane_description'] = $texts['plane_description'];
            $attributes['description'] = $texts['description'];
            $attributes['user_id'] = \Auth::user()->id;

            //ブログの登録
            $blog = self::create($attributes);

            //画像の登録、保存
            if (!empty($attributes['photo'])) {
                //photo DBへ挿入
                $img_paths =[];
                foreach ($attributes['photo'] as $order => $photo) {
                    $_path = Photo::moveTempImage($photo, $blog->id, $order + 1);
                    $img_paths[] = $_path;
                    $rtn = Photo::create([
                        'blog_id' => $blog->id,
                        'file_name' => $_path['public_path'],
                        'order' => $order + 1,
                    ]);
                }
            }
            \DB::commit();

            //tmp画像は削除
            \File::delete(\File::glob(Photo::getTempDir4User().'*'));

            return $blog;
        } catch (\Exception $e) {
            \Log::error(get_class().':register(): '.$e->getMessage());
            \DB::rollback();
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
     * 更新
     *
     * @param  array $attributes
     *
     */
    public function updater(array $attributes)
    {
        \DB::beginTransaction();
        try {
            $texts = self::textshap($attributes['description']);
            $attributes['status'] = $attributes['status'] == '1' ? true : false;

            $this->title = $attributes['title'];
            $this->plane_description = $texts['plane_description'];
            $this->description = $texts['description'];
            $this->status = $attributes['status'];
            $this->save();

            $img_paths = [];
            $delete_paths = [];

            // 写真の更新
            $blog = $this;
            $photos = $blog->photos;
            $order = 0;
            if (!empty($attributes['photo_id'])) {
                foreach ($attributes['photo_id'] as $_id) {
                    if (empty($attributes['photo'][$order])) {
                        continue;
                    }

                    if (empty($_id)) {
                        //新規登録
                        $_path = Photo::moveTempImage($attributes['photo'][$order], $blog->id, $order + 1);
                        $img_paths[] = $_path;
                        $rtn = Photo::create([
                            'blog_id' => $blog->id,
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
            }

            \DB::commit();

            //tmp画像は削除
            \File::delete(\File::glob(Photo::getTempDir4User().'*'));
            //削除指定した画像も削除
            \File::delete($delete_paths);
            return $blog;
        } catch (\Exception $e) {
            \Log::error(get_class().':updater(): '.$e->getMessage());
            \DB::rollback();

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
     * ユーザごとの一覧を取得
     *
     * @param  User $user
     * @param  int $limit
     *
     * @return
     */
    public static function getPublishedList(User $user, $limit = 10)
    {
        return $user->blogs()
                    ->Published()
                    ->with('onePhoto')
                    ->latest('created_at')
                    ->paginate($limit);
    }

    /**
     * 全ユーザーのブログ一覧を取得
     *
     * @param int $limit
     * @param string $sort
     * @param null $search
     * @return mixed
     */
    public static function getPublishedListAll($limit = 10, $sort = 'created_at', $search = null)
    {
        $query = self::query()->Published()->with('onePhoto')->orderBy($sort, 'desc');

        // 検索条件がある場合
        if (!empty($search['keyword'])) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search['keyword']}%")
                    ->orWhere('description', 'LIKE', "%{$search['keyword']}%");
            });
        }
        if (!empty($search['area'])) {
            $query->whereHas('user', function ($query) use ($search) {
                $query->where('fishing_area', 'LIKE', "%{$search['area']}%");
            });
        }
        return $query->paginate($limit);
    }

    /**
     * 自分のblogリストをページネーション付きで返却
     *
     * @param  int $limit
     *
     * @return Blog
     */
    public static function getSelfList($limit = 10)
    {
        return \Auth::user()->blogs()
                    ->latest('created_at')
                    ->paginate($limit);
    }

    /**
     * Blogの削除を実施。photoも一緒に削除
     *
     * @return bool
     */
    public function execDelete()
    {
        \DB::beginTransaction();
        try {
            $photos = $this->photos;
            $images = [];
            if (!empty($photos)) {
                $ids = [];
                foreach ($photos as $_photo) {
                    $images[] = FileHelper::getServerPath($_photo->file_name);
                    $ids[] = $_photo->id;
                }
                Photo::destroy($ids);
            }

            $this->delete();

            \DB::commit();

            File::delete($images);

            return true;
        } catch (\Exception $e) {
            \Log::error(get_class().':execDelete(): '.$e->getMessage());
            \DB::rollback();
            return false;
        }
    }

    //次のブログ
    public function next()
    {
        return $this->where([
                ['id', '>', $this->id],
                ['user_id', $this->user_id],
            ])->Published()->first();
    }

    //前のブログ
    public function previous()
    {
        return $this->where([
                ['id', '<', $this->id],
                ['user_id', $this->user_id],
            ])->Published()->first();
    }

    /*
    * ブログの所有権
    */
    public function isOwner() :bool
    {
        return !!(\Auth::user()->id === $this->user_id);
    }

    /**
    * 公開中か
    *
    * @return bool
    */
    public function isPublish() :bool
    {
        return !!($this->status === self::STATUS_PUBLISH);
    }

    /**
     * バリデーション
     *
     * @param  int $blog_id
     *
     * @return array
     */
    public static function validate($blog_id = null)
    {
        $val = [
            'title' => ['required', 'string', 'max:50'],
            // 'photo' => ['nullable', 'array', 'between:0,5'],
            // 'photo.*' => ['nullable', 'image', 'max:5000'],
            'description' => ['required', 'string'],
            'status' => ['required', 'boolean'],
            'photo' => ['nullable', 'array', 'between:0,5'],
            'photo.*' => ['filled', 'url', 'active_storage_url'],
        ];

        if (!empty($blog_id)) {
            //編集時
            $val['photo_id.*'] = ['nullable', 'integer', 'min:1', 'valid_blog_photo_id:'. $blog_id];
        }

        return $val;
    }

    //プロパティの取得
    public static function getProperties() :array
    {
        return [
            'title' => '',
            'user_id' => '',
            'plane_description' => '',
            'description' => '',
            'status' => 1,
            'photo' => ['', '', '', '', ''],
        ];
    }

    //Admin blog Functionality
    public function adminDelete($blogID)
    {
        \DB::beginTransaction();
        try{
            $blog = $this->where('id', $blogID)->get()->toArray();

            $email = [];
            $userID = "";

            if(count($blog)){
                $userID = $blog[0]['user_id'];
                $user = User::where('id',$blog[0]['user_id'])->get()->toArray();
                $tmp_user = new User($user);
                $tmp_user ['title'] = $blog[0]['title'];
                $tmp_user ['email'] = $user[0]['email'];
                $tmp_user['mail_title'] = "運営からのお知らせ";
                $tmp_user['template'] = "mails.admin.admin_blog";

                $mail['title'] = $blog[0]['title'];
                $mail['email'] = $user[0]['email'];
            }

            $this->where('id', $blogID)->delete();
            Photo::where('blog_id', $blogID)->forcedelete();
            $rtn = $this;

            File::deleteDirectory(storage_path('app/public/img/blog/' . $userID .'/'. $blogID));

            \DB::commit();

            if($mail['email'] != ""){
                $tmp_user->notify(new DeleteNotification($blog, false));
            }

            return $rtn;

        } catch (\Exception $e) {
            \Log::error(get_class().':AdminDelete(): '.$e->getMessage());
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
        $query = \DB::table('blogs as B')
                    ->join('users as U', function ($qry) {
                        $qry->on('U.id', '=', 'B.user_id');
                    })
                    ->leftJoin('blog_photos as P', function ($qry) {
                        $qry->on('P.blog_id', '=', 'B.id')
                                ->on('order', '=', \DB::raw("1"));
                    })
                    ->whereNull('U.deleted_at')
                    ->select(
                        'B.*',
                        'U.name',
                        // 'blog_photos.file_name'
                        \DB::raw('ifnull(P.file_name, "'.url(config('const.blog_img_defult')).'") as file_name')
                    );

        $query->whereNull('U.deleted_at');
        // WHERE
        //ユーザIDの指定
        if (!empty($data['user_id'])) {
            $query->where('B.user_id', '=', $data['user_id']);
        }
        //タイトルの検索
        if (!empty($data['title'])) {
            $query->where('B.title', 'like', '%'.$data['title'].'%');
        }
        //ステータスの指定
        if (!empty($data['status']) || (isset($data['status']) && $data['status'] == 0)) {
            $query->where('B.status', '=', $data['status']);
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
