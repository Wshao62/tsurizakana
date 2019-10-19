<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TransferRequest extends Model
{
    const STATUS_REQUEST = 1;
    const STATUS_COMPLETE = 2;

    const STATUS_NAMES = [
        self::STATUS_REQUEST => '申請中',
        self::STATUS_COMPLETE => '完了',
    ];

    protected $fillable = [
        'user_id',
        'price',
        'fee',
        'transfer_price',
        'requested_at',
        'transfer_at',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * ログイン中のユーザーの既振込申請額を取得
     *
     * @param $user_id
     * @return int
     */
    public static function getTotal() {
        $res = 0;
        $requests = self::query()->where('user_id', Auth::user()->id)->get();
        foreach ($requests as $request) {
            $res += $request->price;
        }
        return $res;
    }

    public function scopeOwn($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

}
