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

class UserShopPhoto extends Model
{
    use Register;
    use Updater;

    protected $fillable = [
        'user_shop_id',
        'file_name',
        'order',
    ];

    const UPDATED_AT = null;

    /**
     * temporary画像をアップロード
     *
     * @param  file $photo
     * @param  int $user_id
     *
     * @return string(url) / false
     */
    public static function uploadTmpImage($photo)
    {
        try {
            $server_dir = self::getTempDir4User();
            FileHelper::addDirectory($server_dir, 0777);

            $file_name = FileHelper::makeUniqFileName($photo->getClientOriginalExtension(), $server_dir);

            // 画像の保存
            $save_path = $server_dir.$file_name;
            FileHelper::storeResizeImg($photo->path(), $save_path, 450, null);
            $public_path = FileHelper::getPublicPath($save_path);
            return $public_path;
        } catch (\Exeption $ex) {
            \Log::error(get_class().':uploadTmpImage(): '.$ex->getMessage());
            return false;
        }
    }

    public static function getTempDir4User()
    {
        return storage_path(config('const.user_shop_img_temp_path_server'). \Auth::id(). '/');
    }


    /**
     * temporary画像を世紀ディレクトリに移動
     *
     * @param $url
     * @return array
     * @throws \Exception
     */
    public static function moveTempImage($url)
    {
        $source_path = FileHelper::getServerPath($url);
        $target_dir = storage_path(config('const.user_shop_img_path_server'). \Auth::id(). '/');
        FileHelper::addDirectory($target_dir, 0777);

        $ext = substr($source_path, strrpos($source_path, '.') + 1);
        $file_name = FileHelper::makeUniqFileName($ext, $target_dir);
        $target_path = $target_dir.$file_name;

        if (!\File::copy($source_path, $target_path)) {
            throw new \Exception('ファイルの移動ができませんでした。');
        }

        return [
            'source_path' => $source_path,
            'target_path' => $target_path,
            'public_path' => FileHelper::getPublicPath($target_path),
        ];
    }

    public static function validate()
    {
        return [
            'photo' => ['image', 'max:10240'],
        ];
    }
}
