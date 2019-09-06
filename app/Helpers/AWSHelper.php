<?php
namespace App\Helpers;

use Aws\Common\Aws;
use Aws\Common\Enum\Region;
use Aws\Sns\SnsClient;
use Aws\Credentials\Credentials;

class AWSHelper
{
    /**
     * SNSAddDeviceToken
     * SNSの対象トピックにデバイストークンを登録
     *
     * @param string $device_token
     * @param string $os_type
     * @return string/boolean 処理に成功した場合はendpointarn 失敗した場合はfalseを返却
     * @author Nozomi Nakamura
     */
    public static function SNSAddDeviceToken($device_token, $os_type)
    {
        try {
            $sns_client = new SnsClient([
                'region' => 'ap-northeast-1',
                'version' => '2010-03-31',
                'credentials' => [
                    'key' => config('aws.access_key'),
                    'secret'  => config('aws.secret_access_key'),
                    ],
            ]);

            //devicetokenをendpointとしてAWSへ登録
            $application_arn = config('aws.application_arns')[$os_type];
            $params = [
                'PlatformApplicationArn' => $application_arn,
                'Token' => $device_token,
            ];
            $result = $sns_client->createPlatformEndpoint($params);

            $endpoint_arn = $result['EndpointArn'];
        } catch (\Exception $e) {
            \Log::error(get_class().':SNSAddDeviceToken(): '.'AWS_SNSエンドポイント登録エラー >' . $e->getMessage());
            return false;
        }

        return $endpoint_arn;
    }

    /**
     * SNSSubscribeTopic
     * エンドポイントにTopicを購読させる
     *
     * @param string $topic_arn
     * @param string $endpoint_arn
     * @return boolean
     * @author Nozomi Nakamura
     */
    public static function SNSSubscribeTopic($topic_arn, $endpoint_arn)
    {
        try {
            $sns_client = self::getSnsClient();

            $params = [
                'Endpoint' => $endpoint_arn,
                'Protocol' => 'Application',
                'TopicArn' => $topic_arn,
            ];

            $result = $sns_client->subscribe($params);
            return $result->get('SubscriptionArn');
        } catch (\Exception $e) {
            \Log::error(get_class().':SNSSubscribeTopic(): '.'AWS_SNSトピック購読エラー >' . $e->getMessage());
            return false;
        }
    }

    /**
     * SNSUnsubscribeTopic
     * Topicを購読を辞める
     *
     * @param string $subscribe_arn
     * @return boolean
     * @author Nozomi Nakamura
     */
    public static function SNSUnsubscribeTopic($subscribe_arn)
    {
        try {
            $sns_client = self::getSnsClient();

            $params = [
                'SubscriptionArn' => $subscribe_arn,
            ];

            $result = $sns_client->unsubscribe($params);
            return true;
        } catch (\Exception $e) {
            \Log::error(get_class().':SNSUnsubscribeTopic(): '.'AWS_SNSトピック購読ストップエラー >' . $e->getMessage());
            return false;
        }
    }

    /**
     * SNSSendNotify
     * 通知を送る
     *
     * @param string $topic_arn
     * @param string $json
     * @return boolean/string 対象のsubscriptionがenabled = falseとなっているとき'disabled'を返却
     * @author Nozomi Nakamura
     */
    public static function SNSSendNotify($target_arn, $json)
    {
        try {
            $sns_client = self::getSnsClient();
            $params = [
                'TargetArn' => $target_arn,
                'Message' => (string) $json,
                'MessageStructure' => 'json',
            ];

            $result = $sns_client->publish($params);
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'Endpoint is disabled') !== false
            || strpos($e->getMessage(), 'No endpoint found for the target arn specified') !== false) {
                return 'disabled';
            }

            \Log::error(get_class().':SNSSendNotify(): '.'AWS_SNS通知エラー >'. $e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * SNSMakeJson
     * 通知に乗せるjsonを生成する
     *
     * @param string $message
     * @param [$data SNSに乗せるカスタムパラメータ
     * @return string json
     * @author Nozomi Nakamura
     */
    public static function SNSMakeJson(string $message, array $data = [])
    {
        $android_param = (string) json_encode([
            'notification' => [
                // 'title' => config('app.name', '釣魚商店'),
                'body' => $message,
                'sound' => 'default',
                'icon'  => 'iconNotify',
                'data' => $data,
            ],
            'data' => $data,
        ]);

        //iOSのデータ作成
            $ios  = 'APNS_SANDBOX'; //これは開発・検証用
        if (config('app.env') === 'producation') {
            $ios  = 'APNS';//これは本番用
        }
        $ios_param = (string) json_encode(array_merge($data, [
            'aps' => [
                'alert' => $message,
                'sound' => 'default',
            ],
        ]));

        //iosとAndroidの値を合体させ、jsonを返却
        return json_encode([
            'default' => $message,
            $ios => $ios_param,
            'GCM' => $android_param,
        ]);
    }

    /**
     * SNSDeleteEndpoint
     * SNSからエンドポイントを削除する
     *
     * @param string $endpoint_arn
     * @return boolean
     * @author Nozomi Nakamura
     */
    public static function SNSDeleteEndpoint($endpoint_arn)
    {
        try {
            $sns_client = self::getSnsClient();

            $params = [
                'EndpointArn' => $endpoint_arn,
            ];
            $result = $sns_client->deleteEndpoint($params);
            return true;
        } catch (\Exception $e) {
            \Log::error(get_class().':SNSSendNotify(): '.'AWS_SNSエンドポイント削除エラー >' . $e->getMessage());
            return false;
        }
    }


    // -----------------------------------------
    private static function getSnsClient()
    {
        return new SnsClient([
                'region' => 'ap-northeast-1',
                'version' => '2010-03-31',
                'credentials' => [
                    'key' => config('aws.access_key'),
                    'secret'  => config('aws.secret_access_key'),
                ],
        ]);
    }
}
