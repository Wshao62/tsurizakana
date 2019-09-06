<?php

namespace App\Models\Fish;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Register;
use App\Models\Traits\Updater;
use App\Models\Traits\FullTextSearch;

class Category extends Model
{
    use Register;
    use Updater;
    use FullTextSearch;

    protected $fillable = [
        'name',
    ];

    protected $searchable = [
        'name',
    ];

    protected $table = 'fish_categories';

    const UPDATED_AT = null;

    public function fish()
    {
        return $this->belongsTo('App\Models\Fish', 'id', 'fish_id');
    }

    /**
     * キーワードから名前検索し、一覧で返却する
     *
     * @param  string $keyword
     *
     * @return array
     */
    public static function searchNames(string $keyword)
    {
        $rtn = [];
        $categories = self::search($keyword)->get();
        if (empty($categories)) {
            return $rtn;
        }
        foreach ($categories as $_cat) {
            $rtn[] = [
                'id' => $_cat->id,
                'label' => $_cat->name,
                'value' => $_cat->name,
            ];
        }
        return $rtn;
    }
}
