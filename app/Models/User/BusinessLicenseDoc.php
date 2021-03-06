<?php

namespace App\Models\User;

use App\Notifications\BusinessLicenseJudgedNotification;
use App\Notifications\BusinessLicenseRecievedNotify;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\Traits\Register;
use App\Models\Traits\Updater;
use Illuminate\Validation\Rule;
use App\Helpers\FileHelper;
use App\Notifications\IdentificationJudgedNotification;

class BusinessLicenseDoc extends Model
{
    use Register;
    use Updater;

    protected $fillable = [
        'user_id', 'file_path1', 'file_path2', 'reject_reason'
    ];

    const UPDATED_AT = null;

    protected $table = 'user_business_license_docs';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id', 'user_id');
    }

    public function isRejected()
    {
        return !!(!empty($this->reject_reason));
    }

    public function getUrl($idx = 1)
    {
        list($user_id, $file_name) = explode('/', str_replace(storage_path(config('const.business_license_path')), '', $this->{"file_path".$idx}));
        return url("/admin/user/{$user_id}/business-license/{$file_name}");
    }

    public static function userRegister($data)
    {
        $user_id = \Auth::id();
        $img_paths = [];

        $before_func = (function ($attributes) use ($user_id) {
            $attributes['user_id'] = $user_id;
            $server_dir = storage_path(config('const.business_license_path').$user_id);
            $attributes['file_path1'] = $server_dir. '/'. FileHelper::makeUniqFileName($attributes['file_path1']->getClientOriginalExtension(), $server_dir);

            if (!empty($attributes['file_path2'])) {
                $attributes['file_path2'] = $server_dir. '/'. FileHelper::makeUniqFileName($attributes['file_path2']->getClientOriginalExtension(), $server_dir);
            }
            return $attributes;
        });


        $after_func = (function ($attributes) use (&$data, $user_id, &$img_paths) {
            $server_dir = storage_path(config('const.business_license_path').$user_id);
            FileHelper::addDirectory($server_dir, 0777);

            FileHelper::storeResizeImg($data['file_path1']->path(), $attributes['file_path1'], 800, null);
            $img_paths[] = $attributes['file_path1'];

            if (!empty($attributes['file_path2'])) {
                FileHelper::storeResizeImg($data['file_path2']->path(), $attributes['file_path2'], 800, null);
                $img_paths[] = $attributes['file_path2'];
            }
        });

        $success_func = (function ($attributes) {
            //担当者にメール通知、担当に送信するのはユーザーのデータ
            Admin::first()->notify(new BusinessLicenseRecievedNotify(\Auth::user()));
        });

        $fail_function = (function () use (&$img_paths) {
            if (!empty($img_paths)) {
                \File::delete($img_paths);
            }
        });
        return self::register($data, $before_func, $after_func, $success_func, $fail_function);
    }

    public function judgeAndNotify($user, $attributes)
    {
        \DB::beginTransaction();
        try {
            $is_done = false;
            $delete_files = [];
            $is_accepted = false;
            if (!empty($attributes['reject_reason'])) {
                // reject
                $is_accepted = false;

                $this->reject_reason = $attributes['reject_reason'];
                $this->save();
            } else {
                // accept
                $is_accepted = true;

                $user->business_identificated_at = now();
                $user->save();
                $_businessLicenses = $user->businessLicenses;
                foreach ($_businessLicenses as $_i) {
                    if ($_i->id == $this->id) {
                        continue;
                    }
                    $delete_files[] = $_i->file_path1;
                    if (!empty($_i->file_path2)) {
                        $delete_files[] = $_i->file_path2;
                    }
                }
                self::where('user_id', '=', $user->id)->where('id', '!=', $this->id)->delete();
            }
            $user->notify(new BusinessLicenseJudgedNotification($attributes['reject_reason']));

            \DB::commit();
            $is_done = true;
            if (!empty($delete_files)) {
                \File::delete($delete_files);
            }

            return true;
        } catch (\Exception $e) {
            \Log::error(get_class().':judgeAndNotify(): '.$e->getMessage());
            \DB::rollback();
            if ($is_done) {
                return true;
            }
            return false;
        }
    }

    public static function validate()
    {
        return [
            'file_path1' => ['required', 'image', 'max:10240'],
            'file_path2' => ['nullable', 'image', 'max:10240'],
        ];
    }

    public static function judgeValidate()
    {
        return [
            'judge' => ['required', Rule::in(['承認', '否認'])],
            'reject_reason' => ['required_unless:judge,承認'],
        ];
    }
}
