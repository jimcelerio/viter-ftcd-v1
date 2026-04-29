<?php

require '../../../core/header.php';
// use needed functions
require '../../../core/functions.php';
// use models
require '../../../models/developers/donors/Donors.php';
// check database connection
$conn = null;
$conn = checkDbConnection();
// make use of classes for save database
// store models into variable
$val = new Donors($conn);
// get payload from frontend
$body = file_get_contents("php://input");
$data = json_decode($body, true);

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (array_key_exists("id", $_GET)) {
        // check data if exist and data is required
        checkPayload($data);

        $val->donor_aid = $_GET['id'];
        $val->donor_is_active = trim($data['isActive']);
        $val->donor_updated = date('Y-m-d H:i:s');

        // validate is id
        checkId($val->donor_aid);

        $query = checkActive($val);
        http_response_code(200);
        returnSuccess($val, "Donor Active", $query);
    }

    checkEndpoint();
}

checkAccess();
