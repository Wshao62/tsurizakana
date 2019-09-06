<?php
namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class FileHelper
{
    /*
    * ディレクトリの有無を確認し、作成する
    */
    public static function addDirectory($directory, $mod)
    {
        //ディレクトリの有無を確認
        if (!File::exists($directory)) {
            //ディレクトリを作成
            File::makeDirectory($directory, $mod, true);
        }
    }

    /**
    * ファイルをリサイズし保存する
    */
    public static function storeResizeImg($file, $filepath, $width, $height)
    {
        $org_img = Image::make($file);
        $org_img->orientate();
        $org_img = $org_img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $org_img->save($filepath);
    }

    public static function makeUniqFileName($ext, $path)
    {
        $file_name = '';
        while (1) {
            $file_name = sha1(rand().microtime()).'.'.$ext;
            if (!File::exists($path. $file_name)) {
                break;
            }
        }
        return $file_name;
    }

    public static function getServerPath($path)
    {
        return str_replace(url('storage/'), storage_path('app/public'), $path);
    }

    public static function getPublicPath($path)
    {
        return str_replace(storage_path('app/public/'), url('storage').'/', $path);
    }
}
