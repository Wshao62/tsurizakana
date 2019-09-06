<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Traits\Register;
use App\Helpers\AWSHelper;

class DeviceToken extends Model
{
    use Register;

    protected $fillable = [
        'user_id',
        'device_token',
        'endpoint_arn',
        'subscription_arn',
    ];

    protected $table = 'user_devicetokens';

    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id', 'user_id');
    }

    /**
     * ユーザに通知を送る
     *
     * @param int $user_id
     * @param string $json
     * @param array $custom_data
     *
     * @return void
     */
    public static function sendPushNotification(int $user_id, string $message, array $custom_data = [])
    {
        $tokens = DeviceToken::whereUserId($user_id)->get();
        if (!empty($tokens)) {
            $json = AWSHelper::SNSMakeJson($message, $custom_data);
            foreach ($tokens as $_t) {
                try {
                    $rtn = AWSHelper::SNSSendNotify($_t->endpoint_arn, $json);
                    if ($rtn === 'disabled') { //無効なEndpoint、と返却があったら削除する
                        if (!empty($_t->subscription_arn)) {
                            AWSHelper::SNSUnsubscribeTopic($_t->subscription_arn);
                        }
                        AWSHelper::SNSDeleteEndpoint($_t->endpoint_arn);
                        $_t->delete();
                    }
                } catch (Exception $e) {
                    \Log::error(get_class().':sendPushNotification() 通知発信エラー> '. $e->getMessage());
                    continue;
                }
            }
        }
        return;
    }
}
