<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Traits\Register;
use App\Models\Traits\Updater;
use App\Models\Traits\FullTextSearch;

class Shop extends Model
{
    use Register;
    use Updater;
    use FullTextSearch;

    protected $fillable = [
        'user_id',
        'name',
        'zipcode',
        'prefecture',
        'address1',
        'address2',
        'full_address',
    ];

    protected $table = 'user_shops';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public static function search($data)
    {

        $query = self::with('user', 'user.photo');

        // キーワード 店名のlike検索
        if (!empty($data['keyword'])) {
            $query->search($data['keyword'], 'name');
        }

        // エリア検索
        if (!empty($data['area'])) {
            $query->search($data['area'], 'full_address');
        }

        $query->latest();

        // 表示件数
        if (!empty($data['limit'])) {
            $rtn = $query->paginate($data['limit']);
        } else {
            $rtn = $query->paginate(10);
        }

        return $rtn;
    }

}
