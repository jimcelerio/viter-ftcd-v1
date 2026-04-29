<?php

require '../../../core/header.php';
require '../../../core/functions.php';
require '../../../models/developers/donors/Donors.php';

// check database connection
$conn = null;
$conn = checkDbConnection();
// make use of classes for save database
$val = new Donors($conn);

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (array_key_exists("id", $_GET)) {
        $val->donor_aid = $_GET['id'];

        // VALIDATION
        checkId($val->donor_aid);

        $query = checkDelete($val);
        http_response_code(200);
        returnSuccess($val, "Donor Delete", $query);
    }

    checkEndpoint();
}

checkAccess();
