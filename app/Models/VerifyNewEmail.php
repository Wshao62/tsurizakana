<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Register;
use App\Models\User;

class VerifyNewEmail extends Model
{
    use Register;

    protected $fillable = [
        'user_id', 'token', 'new_email',
    ];
    protected $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public static function registOrUpdate($email, $id = null)
    {
        if ($id == null) {
            $id = \Auth::id();
        }

        $new_mail = self::find($id);
        if (!empty($new_mail)) {
            $new_mail->delete();
        }
        return self::register([
            'user_id' => $id,
            'token' => str_random(40),
            'new_email' => $email,
        ]);
    }

    public function verify()
    {
        $user = \Auth::user();
        \DB::beginTransaction();
        try {
            $user->email = $this->new_email;
            $user->save();

            $this->delete();

            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error(get_class().':verify(): '.$e->getMessage());
            return false;
        }
    }
}
