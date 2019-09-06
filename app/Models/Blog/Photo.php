<?php
namespace App\Models\Blog;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Helpers\FileHelper;

class Photo extends Model
{
    protected $fillable = [
        'blog_id',
        'file_name',
        'order',
    ];
    protected $table = 'blog_photos';

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }


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
            FileHelper::storeResizeImg($photo->path(), $save_path, null, 300); //w 980, h 300
            $public_path = FileHelper::getPublicPath($save_path);
            return $public_path;
        } catch (\Exeption $ex) {
            \Log::error(get_class().':uploadTmpImage(): '.$e->getMessage());
            return false;
        }
    }

    public static function getTempDir4User()
    {
        return storage_path(config('const.blog_img_temp_path_server'). \Auth::id(). '/');
    }


    /**
     * temporary画像を世紀ディレクトリに移動
     *
     * @param  string $url
     * @param  int $blog_id
     *
     * @return array
     */
    public static function moveTempImage($url, $blog_id)
    {
        $source_path = FileHelper::getServerPath($url);
        $target_dir = storage_path(config('const.blog_img_path_server'). \Auth::id(). '/'. $blog_id. '/');
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
            'photo' => ['image', 'max:5000'],
        ];
    }
}
