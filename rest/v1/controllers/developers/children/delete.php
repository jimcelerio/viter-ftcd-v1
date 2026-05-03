<?php

require '../../../core/header.php';
require '../../../core/functions.php';
require '../../../models/developers/children/Children.php';

// check database connection
$conn = null;
$conn = checkDbConnection();
// make use of classes for save database
$val = new Children($conn);

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (array_key_exists("id", $_GET)) {
        $val->children_aid = $_GET['id'];

        // VALIDATION
        checkId($val->children_aid);

        $query = checkDelete($val);
        http_response_code(200);
        returnSuccess($val, "Children Delete", $query);
    }

    checkEndpoint();
}

checkAccess();

