<?php

require '../../../../core/header.php';
require '../../../../core/functions.php';
require '../../../../models/developers/settings/designation/Designation.php';

$conn = null;
$conn = checkDbConnection();
$val = new Designation($conn);

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (array_key_exists("id", $_GET)) {
        $val->designation_aid = $_GET['id'];

        checkId($val->designation_aid);

        $query = checkDelete($val);
        http_response_code(200);
        returnSuccess($val, "Designation Delete", $query);
    }

    checkEndpoint();
}

checkAccess();

