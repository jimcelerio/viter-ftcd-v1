<?php

$conn = null;
$conn = checkDbConnection();
$val = new SystemUsers($conn);

$val->system_users_is_active = 1;
$val->system_users_first_name = trim($data['system_users_first_name']);
$val->system_users_last_name = trim($data['system_users_last_name']);
$val->system_users_email = trim($data['system_users_email']);
$val->system_users_role_id = trim($data['system_users_role_id']);
$val->system_users_created = date('Y-m-d H:i:s');
$val->system_users_updated = date('Y-m-d H:i:s');

checkPayload($data);
checkIndex($data, 'system_users_first_name');
checkIndex($data, 'system_users_last_name');
checkIndex($data, 'system_users_email');
checkIndex($data, 'system_users_role_id');
isEmailExist($val, $val->system_users_email);

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "System User Create", $query);
