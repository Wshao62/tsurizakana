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
        'shop_type',
        'home_page_url',
    ];

    protected $table = 'user_shops';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany('App\Models\UserShopPhoto', 'user_shop_id', 'id')->orderBy('order', 'asc');
    }

    public function photo()
    {
        return $this->hasOne('App\Models\UserShopPhoto', 'user_shop_id', 'id')
            ->whereOrder(1)
            ->withDefault(
                ['file_name' => url(config('const.profile_img_default_icon'))]
            );
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

    /**
     * 全ユーザーの店舗一覧を取得
     *
     * @param int $limit
     * @param string $sort
     * @param null $search
     * @return mixed
     */
    public static function getListAll($limit = 10, $sort = 'created_at', $search = null)
    {
        $query = self::query()->orderBy($sort, 'desc');

        // 検索条件がある場合
        if (!empty($search['keyword'])) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search['keyword']}%");
            });
        }
        if (!empty($search['area'])) {
            $query->where('full_address', 'LIKE', "%{$search['area']}%");
        }
        return $query->paginate($limit);
    }
}
