<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use App\Models\Traits\Register;

class UserRating extends Model
{
    use Register;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_user_id',
        'fish_id',
        'target_user_id',
        'rate',
        'comment'
    ];

    const GOOD = 1;
    const NORMAL = 0;
    const BAD = -1;
    const ALL = 2;

    public static function getRate(int $fish_id, int $user_id)
    {
        return self::whereSourceUserId($user_id)->whereFishId($fish_id)->first();
    }

    public static function makeRateCountsQuery(int $user_id)
    {
        return self::select(['rate', \DB::raw('COUNT(*) AS rate_count')])
                    ->whereTargetUserId($user_id)
                    ->groupBy('rate');
    }

    /**
     * １ユーザの評価件数リストを取得する
     *
     * @param  int $user
     *
     * @return array('good' => int, 'nomal' => int, 'bad' => int)
     */
    public static function getRateCounts(int $user_id)
    {
        $rtn = [
            'good' => 0,
            'normal' => 0,
            'bad' => 0,
        ];

        $result = self::makeRateCountsQuery($user_id)->get()->toArray();

        if (empty($result)) {
            return $rtn;
        }

        foreach ($result as $_r) {
            switch ($_r['rate']) {
                case self::GOOD:
                    $rtn['good'] = $_r['rate_count'];
                    break;
                case self::NORMAL:
                    $rtn['normal'] = $_r['rate_count'];
                    break;
                case self::BAD:
                    $rtn['bad'] = $_r['rate_count'];
                    break;
            }
        }

        return $rtn;
    }

    public static function validate()
    {
        return [
            'rate' => ['required', 'integer', Rule::in([self::GOOD, self::NORMAL, self::BAD])],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
