<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Register;
use App\Models\Traits\Updater;

class LinkedSocialAccount extends Model
{
    use Register;
    use Updater;

    protected $fillable = ['provider_name', 'provider_id', 'temp_regist_email', 'user_id' ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function tempRegist()
    {
        return $this->belongsTo('App\Models\TempRegist', 'temp_regist_email', 'email');
    }
}
