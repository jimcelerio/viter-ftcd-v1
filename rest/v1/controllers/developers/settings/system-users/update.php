<?php

$conn = null;
$conn = checkDbConnection();
$val = new SystemUsers($conn);

if (array_key_exists("id", $_GET)) {
    $val->system_users_aid = $_GET['id'];
    $val->system_users_first_name = trim($data['system_users_first_name']);
    $val->system_users_last_name = trim($data['system_users_last_name']);
    $val->system_users_email = trim($data['system_users_email']);
    $val->system_users_role_id = trim($data['system_users_role_id']);
    $val->system_users_updated = date('Y-m-d H:i:s');

    $system_users_email_old = $data['system_users_email_old'];

    checkPayload($data);
    checkIndex($data, 'system_users_first_name');
    checkIndex($data, 'system_users_last_name');
    checkIndex($data, 'system_users_email');
    checkIndex($data, 'system_users_role_id');
    checkId($val->system_users_aid);
    compareEmail($val, $system_users_email_old, $val->system_users_email);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "System User Update", $query);
}

checkEndpoint();
