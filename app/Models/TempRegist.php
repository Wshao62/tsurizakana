<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Models\Traits\Register;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ServiceMailNotification;

class TempRegist extends Model
{
    use Notifiable;
    use Register;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'token',
    ];

    protected $primaryKey = 'email';

    public $incrementing = false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function accounts()
    {
        return $this->hasMany('App\Models\LinkedSocialAccount', 'email', 'temp_regist_email');
    }

    /**
     * validate
     *
     * @param  mixed $data
     *
     * @return void
     */
    public static function validate()
    {
        $validate = [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:temp_regists', 'unique:users'],
        ];
        return $validate;
    }

    /**
     * ユニークなtokenを発行します
     *
     * @return void
     */
    public static function makeUniqToken()
    {
        while (1) {
            $_token = sha1(uniqid(rand(), true));

            $db_data = self::whereToken($_token)->first();
            if ($db_data == null) {
                break;
            }
        }
        return $_token;
    }

    /**
     * パスワードリセット通知の送信をオーバーライド.
     *
     * @param string $token
     */
    public function sendServiceNotification($token)
    {
        $this->notify(new ServiceMailNotification($token));
    }
}
