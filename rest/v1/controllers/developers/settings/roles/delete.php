<?php

require '../../../../core/header.php';
require '../../../../core/functions.php';
require '../../../../models/developers/settings/roles/Roles.php';

$conn = null;
$conn = checkDbConnection();
$val = new Roles($conn);

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (array_key_exists("id", $_GET)) {
        $val->role_aid = $_GET['id'];

        checkId($val->role_aid);

        $query = checkDelete($val);
        http_response_code(200);
        returnSuccess($val, "Role Delete", $query);
    }

    checkEndpoint();
}

checkAccess();
