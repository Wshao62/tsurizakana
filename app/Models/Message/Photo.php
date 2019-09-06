<?php
namespace App\Models\Message;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Helpers\FileHelper;

class Photo extends Model
{

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    /**
    * ファイルを保存するパスを返却する
    *
    * @return array
    */
    public static function makePath($id, $extention)
    {
        $server_path = storage_path(config('const.message_img_path_server').$id.'/');
        FileHelper::addDirectory($server_path, 0777);
        $name = str_random(20).'.'.$extention;
        while (File::exists($server_path.$name)) {
            $name = str_random(20).'.'.$extention;
        }
        $server_path .= $name;
        $public_path = url(config('const.message_img_path_public').$id, $name);
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
        return str_replace(url(config('const.message_img_path_public')).'/', storage_path(config('const.message_img_path_server')), $server_path);
    }
}
