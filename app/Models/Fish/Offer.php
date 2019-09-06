<?php

namespace App\Models\Fish;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\Fish\OfferNotification;
use App\Models\Fish;
use App\Models\FishRequests;

class Offer extends Model
{
    protected $fillable = [
        'request_id',
        'fish_id',
        'request_user_id',
        'offer_user_id',
        'message',
        'email'
    ];

    protected $table = 'fish_offers';

    const UPDATED_AT = null;

    public function fish()
    {
        return $this->hasOne('App\Models\Fish', 'id', 'fish_id');
    }

    public function offerUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'offer_user_id');
    }

    public function postOffer($data)
    {

        \DB::beginTransaction();
        try {
            $datas = [];
            $fish_req = FishRequests::find($data['request_id']);
            foreach ($data['fish_id'] as $fish) {
                $datas['request_id'] = $data['request_id'];
                $datas['fish_id'] = $fish;
                $datas['offer_user_id'] = \Auth::user()->id;
                $datas['request_user_id'] = $fish_req->user_id;
                $datas['message'] = $data['message'];

                self::create($datas);
            }
            $datas['fish_id'] = $data['fish_id'];

            //ユーザーにメール通知
            $fish_data = Fish::whereIn('id', $datas['fish_id'])->get();
            $fish_req->user->notify(new OfferNotification($datas['message'], $fish_data, $fish_req));

            \DB::commit();

            return $datas;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error(get_class().':offer(): '.$e->getMessage());
            return false;
        }
    }
}
