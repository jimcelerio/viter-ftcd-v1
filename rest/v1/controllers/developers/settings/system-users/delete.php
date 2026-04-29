<?php

require '../../../../core/header.php';
require '../../../../core/functions.php';
require '../../../../models/developers/settings/system-users/SystemUsers.php';

$conn = null;
$conn = checkDbConnection();
$val = new SystemUsers($conn);

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (array_key_exists("id", $_GET)) {
        $val->system_users_aid = $_GET['id'];

        checkId($val->system_users_aid);

        $query = checkDelete($val);
        http_response_code(200);
        returnSuccess($val, "System User Delete", $query);
    }

    checkEndpoint();
}

checkAccess();
