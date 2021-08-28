<?php

function isActiveRoute($route, $output = 'active')
{
    if (Route::currentRouteName() == $route) {
        return $output;
    }
}

function sendNote($tokens = [], $contents, $data = [])
{
    //FCM api URL
    $url = 'https://fcm.googleapis.com/fcm/send';
    //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
    $server_key = 'AIzaSyDXqXLKAUN-moT5HOhIQ1oIzWXHIgUg__w';

    //header with content_type api key
    $headers = array(
        'Content-Type:application/json; charset=utf-8',
        'Authorization:key='.$server_key
    );

    $notification = [
        'body' => $contents,
        'click_action' => 'MAIN_ACTIVITY',
        'sound' => true,
    ];

    $extraNotificationData = $data;

    $fields = [
        'registration_ids' => $tokens, //multple token array
//        'to'        => $tokens, //single token
        'notification' => $notification,
        'data' => $extraNotificationData
    ];
    

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function paginate($items, $perPage)
{
    $pageStart = request('page', 1);
    $offSet = ($pageStart * $perPage) - $perPage;
    $itemsForCurrentPage = $items->slice($offSet, $perPage);

    return new LengthAwarePaginator(
        $itemsForCurrentPage, $items->count(), $perPage,
        Paginator::resolveCurrentPage(),
        ['path' => Paginator::resolveCurrentPath()]
    );
}


