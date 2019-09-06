<?php

namespace App\Models\Fish;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Register;
use App\Models\Traits\CompositePrimaryKeyTrait;
use App\Notifications\Fish\WisherNotification;

class Wisher extends Model
{
    use CompositePrimaryKeyTrait;
    use Register;

    protected $fillable = [
        'fish_id',
        'user_id',
    ];

    protected $table = 'fish_wishers';
    protected $primaryKey = ['fish_id', 'user_id'];
    public $incrementing = false;

    const UPDATED_AT = null;

    public static function boot()
    {
        parent::boot();

        static::created(function (Wisher $item) {
            $wisher = \Auth::user();
            $fish = $item->fish;
            $seller = $fish->seller;
            $rtn = $seller->notify(new WisherNotification($wisher, $fish));

            $custom = ['url' => url('/mypage/fish/'. $fish->id. '/wish')];
            \App\Models\User\DeviceToken::sendPushNotification($seller['id'], "出品している魚に購入希望者が現れました！", $custom);
        });
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function fish()
    {
        return $this->belongsTo('App\Models\Fish', 'fish_id', 'id');
    }

    /**
     * 取得する
     *
     * @param  int $fish_id
     * @param  int $user_id
     *
     * @return Wisher
     */
    public static function find($fish_id, $user_id)
    {
        return self::whereFishId($fish_id)
                    ->whereUserId($user_id)
                    ->first();
    }

    /**
     * 削除する
     *
     * @param  int $fish_id
     * @param  int $user_id
     *
     * @return bool
     */
    public static function deleter($fish_id, $user_id)
    {
        try {
            $wish = self::find($fish_id, $user_id);
            $wish->delete();
            return true;
        } catch (\Exception $e) {
            \Log::error(get_class().':deleter(): '.$e->getMessage());
            return false;
        }
    }
}
