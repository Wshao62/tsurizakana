<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\Updater;
use App\Models\Traits\Register;
use App\Models\Fish\Category;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\File;
use App\Models\User;

class UserPhoto extends Model
{
    use SoftDeletes;
    use Updater;
    use Register;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'profile_photo',
        'cover_photo',
    ];

    public function getProfile()
    {
        return !empty($this->profile_photo) ? $this->profile_photo : url(config('const.profile_img_default_icon'));
    }

    public function getCover()
    {
        return !empty($this->cover_photo) ? $this->cover_photo : url(config('const.profile_img_default_cover'));
    }

     /**
      * Create/Update Profile Photo
      *
      * @param  array $paths
      * @param  int $user_id
      * @return bool
      */
    public static function createUpdate($paths, $user_id)
    {
        \DB::beginTransaction();
        try {

            $data = ['user_id' => $user_id];
            if(isset($paths['profile_photo']['public_path'])){
                $data['profile_photo'] = $paths['profile_photo']['public_path'];
                $img_paths[] = $paths['profile_photo']['server_path'];
            }

            if(isset($paths['cover_photo']['public_path'])){
                $data['cover_photo'] = $paths['cover_photo']['public_path'];
                $img_paths[] = $paths['cover_photo']['server_path'];
            }

            $photo = self::whereUserId($user_id)->first();
            if (empty($photo)) {
                $rtn = self::register($data);
            } else {
                $rtn = $photo->updater($data);
            }

            if ($rtn === false) {
                throw new \Exception('画像の保存に失敗しました');
            }

            \DB::commit();
            return true;
        } catch (\Throwable $e) {
            \DB::rollback();
            \Log::error(get_class().':createUpdate(): '.$e->getMessage());
            return false;
        }
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
            'user_id',
            'profile_photo',
            'cover_photo',
        ];
    }

    /**
    * Create local Directory
    *
    * @return array
    */
    public static function makePath($id, $extention)
    {
        $server_path = storage_path(config('const.profile_img_path_server').$id.'/');
        FileHelper::addDirectory($server_path, 0777);
        $name = str_random(20).'.'.$extention;
        while (File::exists($server_path.$name)) {
            $name = str_random(20).'.'.$extention;
        }
        $server_path .= $name;
        $public_path = url(config('const.profile_img_path_public').$id, $name);
        return [
            'server_path' => $server_path,
            'public_path' => $public_path,
            'name' => $name,
        ];
    }

    /*
    *ファイルの有無を返却する
    */
    public static function getLocalPath($server_path)
    {
        return str_replace(url(config('const.profile_img_path_public')).'/', storage_path(config('const.profile_img_path_server')), $server_path);
    }

    /**
     * Create temporary directories
     *
     * @param  $type, $request, $userID
     *
     */
    public static function createTempPath($type, $request, $userID)
    {
        $paths= $request->File($type);

        // create temporary photos
        $fileName = $type.'.'.$paths->getClientOriginalExtension();
        $path = $paths->storeAs('/public/img/tmp/'. $userID.'/', $fileName);

        // get temporary photos
        return [
            'tmp_path' => $paths->path(),
            'mime' => $paths->getClientMimeType(),
            'extension' => $paths->getClientOriginalExtension(),
        ];
    }

    /**
     * Clean temporary directories
     *
     * @param via $userID
     *
     */
    public static function cleanTempPath($userID)
    {
        $tmp_Path = storage_path(config('const.img_path_temp').$userID.'/');
        \File::deleteDirectory($tmp_Path);
    }
}