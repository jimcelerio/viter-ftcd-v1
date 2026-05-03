<?php

$conn = null;
$conn = checkDbConnection();
$val = new Notification($conn);

if (array_key_exists("id", $_GET)) {
    $val->notification_aid = $_GET['id'];
    $val->notification_name = trim($data['notification_name']);
    $val->notification_email = trim($data['notification_email']);
    $val->notification_phone = trim($data['notification_phone']);
    $val->notification_purpose = trim($data['notification_purpose']);
    $val->notification_updated = date('Y-m-d H:i:s');

    $notification_name_old = $data['notification_name_old'];

    checkPayload($data);
    checkIndex($data, 'notification_name');
    checkIndex($data, 'notification_email');
    checkIndex($data, 'notification_phone');
    checkIndex($data, 'notification_purpose');
    checkId($val->notification_aid);
    compareName($val, $notification_name_old, $val->notification_name);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Notification Update", $query);
}

checkEndpoint();

