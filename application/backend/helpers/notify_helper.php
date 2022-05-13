<?php
function appNotifyPushToUser($userId, $notiData, $appname='tsl')
{
    $apiDomain = [
        'tsl' => '', // 'https://us-central1-pgaapp-1762e.cloudfunctions.net/widgets/',
        'smartroom' => '', // 'https://us-central1-smartroom-fa3cc.cloudfunctions.net/widgets/'
    ];
    if (!isset($apiDomain[$appname])) return false;

    $api = $apiDomain[ $appname ] . 'api/v1/send_to_users';
    $desc = get_excerpt($notiData['content'], 100);
    $data = [
        'message' => [
            'notification' => [
                'title' => $notiData['title'],
                'body' => $desc
            ],
            'data' => [
                'type' => 'GO_TO_SYSTEM_MSG',
                'noti' => json_encode($notiData)
                // 'noti' => json_encode([
                // 	'content' => 'căng đét căng đét căng đét căng đét căng đét căng đét :P',
                // 	'id' => '69768',
                // 	'title' => 'Test thôi lgct',
                // 	'push_time' => '2020-09-07 11:54:00',
                // 	'url' => $url
                // ])
            ]
        ],
        'ids' => $userId
    ];

    $response = pushAppNotify($api, $data);
    return $response;
}

function appNotifyPushToAll($userId,$notiData)
{
    $api = ''; // 'https://us-central1-pgaapp-1762e.cloudfunctions.net/widgets/api/v1/send_to_all';
    $desc = get_excerpt($notiData['content'], 100);
    $data = [
        'message' => [
            'notification' => [
                'title' => $notiData['title'],
                'body' => $desc
            ],
            'data' => [
                'type' => 'GO_TO_SYSTEM_MSG',
                'noti' => json_encode($notiData)
                // 'noti' => json_encode([
                // 	'content' => 'căng đét căng đét căng đét căng đét căng đét căng đét :P',
                // 	'id' => '69768',
                // 	'title' => 'Test thôi lgct',
                // 	'push_time' => '2020-09-07 11:54:00',
                // 	'url' => $url
                // ])
            ]
        ],
        'ids' => $userId
    ];

    $response = pushAppNotify($api, $data);
    return json_decode($response, TRUE);
}

function pushAppNotify($api, $data)
{
    $CI =& get_instance();
//    $CI->load->library('mylog');
//    $CI->mylog->add_application_log('');
//    $CI->mylog->add_application_log('===== Send App Notify ====');
    // $CI->mylog->add_application_log('- sender: ' . getPgaId($CI->me->id));
//    $CI->mylog->add_application_log('- api: ' . $api);

    $fields = json_encode($data);
//    $CI->mylog->add_application_log($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
//    $CI->mylog->add_application_log($response);

    return json_decode($response, TRUE);
}