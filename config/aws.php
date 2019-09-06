<?php
return [
    'access_key' => env('AWS_ACCESS_KEY'),
    'secret_access_key' => env('AWS_SECRET_ACCESS_KEY'),

    'application_arns' => [
        'ios' => env('AWS_SNS_APPLICATION_ARN_IOS'),
        'android' => env('AWS_SNS_APPLICATION_ARN_ANDROID'),
    ],

    'topic_arn_all' => env('AWS_SNS_TOPIC_ARN_ALL'),
];
