<?php

namespace App\Models\Fish;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Register;

class Reject extends Model
{
    use Register;

    protected $fillable = [
        'fish_id',
        'user_id',
        'reason',
    ];

    protected $table = 'fish_rejects';

    public static function validate()
    {
        return [
            'reason' => ['required', 'string', 'max:1000'],
        ];
    }
}
