<?php

$conn = null;
$conn = checkDbConnection();
$val = new Roles($conn);

if (array_key_exists("id", $_GET)) {
    $val->role_aid = $_GET['id'];
    $val->role_name = trim($data['role_name']);
    $val->role_description = trim($data['role_description']);
    $val->role_updated = date('Y-m-d H:i:s');

    $role_name_old = $data['role_name_old'];

    checkPayload($data);
    checkIndex($data, 'role_name');
    checkIndex($data, 'role_description');
    checkId($val->role_aid);
    compareName($val, $role_name_old, $val->role_name);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Role Update", $query);
}

checkEndpoint();
