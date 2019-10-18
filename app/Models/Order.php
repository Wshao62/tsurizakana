<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Register;
use App\Models\Traits\Updater;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Order extends Model
{
    use SoftDeletes;
    use Register;
    use Updater;

    protected $fillable = [
        'user_id',
        'email',
        'item_id',
        'price',
        'stripe_charge_id',
        'is_able_transfer',
        'billed_at',
    ];

    public function fish()
    {
        return $this->hasOne('App\Models\Fish', 'id', 'item_id');
    }

    public function receiptDates()
    {
        return self::select(['billed_at'])
            ->whereUserId(\Auth::user()->id)
            ->orderBy('billed_at', 'desc')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->billed_at)->format('Y');
            });
    }

    public static function receiptList($date)
    {
        return self::whereUserId(\Auth::user()->id)
            ->whereYear('billed_at', '=', $date->format('Y'))
            ->whereMonth('billed_at', '=', $date->format('m'))
            ->orderBy('billed_at', 'asc')
            ->get();
    }



    public static function getDataTable($attributes)
    {
        $rtn = self::getDataByReq($attributes);
        $result = [];
        $result['draw'] = !empty($attributes['draw']) ? intval($attributes['draw']) : null;
        $result['recordsTotal'] = self::count();
        $result['recordsFiltered'] = $rtn['filterd_cnt'];
        $result['data'] = $rtn['data'];
        return $result;
    }

    public static function getDataByReq($attributes)
    {
        $data = self::makeQueryByReq($attributes);
        $rtn = [];
        $collection = $data['query']->get();
        $rtn = ['data' => $collection, 'filterd_cnt' => intval($data['filterd_cnt'])];
        return $rtn;
    }

    private static function makeQueryByReq($data)
    {
        $limit = (!empty($data['length']) && $data['length'] != 0) ? intval($data['length']) : 10;
        $offset = (!empty($data['start']) && $data['start'] != 0) ? intval($data['start']) : 0;
        $query = \DB::table('orders AS O')->select(
            'F.seller_id as user_id',
            \DB::raw('SUM(O.price) as price'),
            'U.name',
            'U.bank_name',
            'U.bank_branch_code',
            'U.bank_type',
            'U.bank_number',
            'U.bank_user_name',
            \DB::raw('DATE_FORMAT(O.billed_at, "%Y%m") as bill_ym')
        )
        ->join('fish AS F', function ($qry) {
            $qry->on('F.id', '=', 'O.item_id');
        })
        ->join('users AS U', function ($qry) {
            $qry->on('U.id', '=', 'F.seller_id');
        })
        ->groupBy(
            'F.seller_id',
            \DB::raw('DATE_FORMAT(O.billed_at, "%Y%m")'),
            'U.name',
            'U.bank_name',
            'U.bank_branch_code',
            'U.bank_type',
            'U.bank_number',
            'U.bank_user_name'
        );
        // \DB::raw('DATE_FORMAT(orders.billed_at, "%m")'));

        $query->whereNull('O.deleted_at');
        $query->whereNotNull('O.billed_at');
        // WHERE
        //ユーザIDの指定
        if (!empty($data['user_id'])) {
            $query->where('F.seller_id', '=', \DB::raw($data['user_id']));
        }
        //年月の指定
        if (!empty($data['ym'])) {
            $last_day = new \DateTime('last day of ' . $data['ym']);
            $query->where('O.billed_at', '>=', \DB::raw('"'.$last_day->format('Y-m-').'01 00:00:00'.'"'));
            $query->where('O.billed_at', '<=', \DB::raw('"'.$last_day->format('Y-m-d').' 23:59:59'.'"'));
        }
        // END WHERE
        //件数の取得
        $filterd_cnt = $query->count();

        //GroupByとOrderByを同時に使うために上記までのクエリをサブクエリとする
        $query = \DB::query()->fromSub($query->toSql(), 'sub');

        //並び順
        if (!empty($data['order'])) {
            // Datatablesからのorder
            foreach ($data['order'] as $_o) {
                $query->orderBy($data['columns'][$_o['column']]['data'], $_o['dir']);
            }
        }
        if ($offset > 0) {
            $query->offset($offset);
        }
        $query->limit($limit);
        return ['query' => $query, 'filterd_cnt' => $filterd_cnt];
    }

    /*
     * 累計売上高を取得
     */
    public function getSaleTotal() {
        $res = 0;
        $orders = $this->query()->whereHas('fish', function ($query) {
            $query->where('seller_id', Auth::user()->id);
        })->get();
        foreach ($orders as $order) {
            $res += $order->price;
        }

        return $res;
    }

    /*
     * 現在の売上金残高を取得
     */
    public function getSaleRemain() {
        $res = $this->getSaleTotal();

        // TODO: 累計売上高 - 振込申請済み金額
        return $res;
    }


    /**
     * バリデーションを実施
     *
     * @return array
     */
    public static function validate()
    {
        $val = [
            'fish_id' => ['required', 'integer', 'exists:fish,id'],
            'buy_token' => ['required', 'string', 'regex:/^tok_/'],
        ];

        return $val;
    }

    public function scopeClosed($query)
    {
        return $query->whereHas('fish', function($query) {
            $query->where('fish.status', Fish::STATUS_CLOSED);
        });
    }

    public function scopeSellerOwn($query)
    {
        return $query->whereHas('fish', function($query) {
            $query->where('fish.seller_id', Auth::user()->id);
        });
    }
}
