<?php

namespace App\Models\Fish;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Register;
use App\Models\Traits\Updater;
use \App\Helpers\FileHelper;

class Photo extends Model
{
    use Register;
    use Updater;

    protected $fillable = [
        'fish_id',
        'file_name',
        'order',
    ];

    protected $table = 'fish_photos';

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
        return storage_path(config('const.fish_img_temp_path_server'). \Auth::id(). '/');
    }


    /**
     * temporary画像を世紀ディレクトリに移動
     *
     * @param  string $url
     * @param  int $fish_id
     *
     * @return array
     */
    public static function moveTempImage($url, $fish_id)
    {
        $source_path = FileHelper::getServerPath($url);
        $target_dir = storage_path(config('const.fish_img_path_server'). \Auth::id(). '/'. $fish_id. '/');
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
