<?php

require '../../../../core/header.php';
require '../../../../core/functions.php';
require '../../../../models/developers/settings/system-users/SystemUsers.php';

$conn = null;
$conn = checkDbConnection();
$val = new SystemUsers($conn);

$body = file_get_contents("php://input");
$data = json_decode($body, true);

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (array_key_exists("id", $_GET)) {
        checkPayload($data);

        $val->system_users_aid = $_GET['id'];
        $val->system_users_is_active = trim($data['isActive']);
        $val->system_users_updated = date('Y-m-d H:i:s');

        checkId($val->system_users_aid);

        $query = checkActive($val);
        http_response_code(200);
        returnSuccess($val, "System User Active", $query);
    }

    checkEndpoint();
}

checkAccess();
