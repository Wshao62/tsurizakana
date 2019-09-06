<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\Updater;
use App\Models\Fish\Category;
use App\Models\Fish;
use Illuminate\Validation\Rule;


class FishRequests extends Model
{
    use SoftDeletes;
    use Updater;

    /**
     * Fields.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'category_name',
        'request_date',
        'status',
        'fish_id'
    ];

    protected $searchable = [
        'status',
        'category_name',
        'area',
        'username',
        'request_date'
    ];

    const STATUS_PRIVATE = 0;
    const STATUS_PUBLISH = 1;

    const STATUS_NAMES = [
        self::STATUS_PUBLISH => '公開中',
    ];

    public function offers()
    {
        return $this->hasMany('App\Models\Fish\Offer', 'request_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function isOwner()
    {
        return !!(\Auth::user()->id == $this->user_id);
    }

    public function isOpen()
    {
        return !!(self::STATUS_PUBLISH == $this->status);
    }

    public function isOffered()
    {
        return !!($this->offers()->whereOfferUserId(\Auth::id())->count() > 0);
    }

    /**
     * 新規登録
     *
     * @param  array $attributes
     *
     * @return mixed instance of FishRequest Model / bool false
     */
    public static function register(array $attributes)
    {
        \DB::beginTransaction();
        try {
            $attributes['category_name'] = trim($attributes['category_name']);
            $attributes['user_id'] = \Auth::user()->id;
            $attributes['status'] = self::STATUS_PUBLISH;

            // category
            $category = Category::firstOrCreate([
                'name' => trim($attributes['category_name']),
            ]);
            $attributes['category_id'] = $category['id'];

            // fish
            $fish =  Fish::where('fish_category_name', $attributes['category_name'])->first();
            $attributes['fish_id'] = ($fish['id'] == null ? 0 : $fish['id']);

            $fish_req = self::create($attributes);

            \DB::commit();
            return $fish_req;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error(get_class().':register(): '.$e->getMessage());
            return false;
        }
    }
    public static function fetch($data)
    {
        return Fish::where('fish_category_name', $data)->where('status', 1)->get();
    }

    /**
     * バリデーションを実施
     *
     * @return array
     */
    public static function validate()
    {
        $val = [
            'category_name' => ['required', 'string', 'max:30'],
            'request_date' => ['required', 'date'],
        ];

        return $val;
    }

    /**
     * 画面の初期表示などに用いるための
     * プロパティの配列をデフォルト値をセットして返却
     *
     * @return array
     */
    public static function getProperties()
    {
        return [
            'category_name' => '',
            'request_date' => '',
        ];
    }
}
