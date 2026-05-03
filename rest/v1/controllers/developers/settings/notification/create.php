<?php

$conn = null;
$conn = checkDbConnection();
$val = new Notification($conn);

$val->notification_is_active = 1;
$val->notification_name = trim($data['notification_name']);
$val->notification_email = trim($data['notification_email']);
$val->notification_phone = trim($data['notification_phone']);
$val->notification_purpose = trim($data['notification_purpose']);
$val->notification_created = date('Y-m-d H:i:s');
$val->notification_updated = date('Y-m-d H:i:s');

checkPayload($data);
checkIndex($data, 'notification_name');
checkIndex($data, 'notification_email');
checkIndex($data, 'notification_phone');
checkIndex($data, 'notification_purpose');
isNameExist($val, $val->notification_name);

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "Notification Create", $query);

