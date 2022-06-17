<?php
function appNotifyPushToUser($userId, $notiData, $appname='akina')
{
    $apiDomain = [
        'akina' => 'https://us-central1-vn-anika.cloudfunctions.net/widgets/'
    ];
    if (!isset($apiDomain[$appname])) return false;

    $api = $apiDomain[ $appname ] . 'api/v1/send_to_users';
    $desc = get_excerpt(get_plaintext($notiData['intro']), 100);
    $data = [
        'message' => [
            'notification' => [
                'title' => $notiData['title'],
                'body' => $desc
            ],
            'data' => [
                'type' => 'GO_TO_SYSTEM_MSG',
                'noti' => json_encode($notiData)
            ]
        ],
        'ids' => $userId
    ];
    $response = pushAppNotify($api, $data);
    return $response;
}

function appNotifyPushToAll($userId,$notiData)
{
    $api = 'https://us-central1-vn-anika.cloudfunctions.net/widgets/api/v1/send_to_all';
    $desc = get_excerpt(get_plaintext($notiData['intro']), 100);
    $data = [
        'message' => [
            'notification' => [
                'title' => $notiData['title'],
                'body' => $desc
            ],
            'data' => [
                'type' => 'GO_TO_SYSTEM_MSG',
                'noti' => json_encode($notiData)
            ]
        ],
        'ids' => $userId
    ];
    $response = pushAppNotify($api, $data);
    return $response;
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
    return json_decode($response, TRUE);
}