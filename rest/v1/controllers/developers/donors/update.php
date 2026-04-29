<?php
// check database connection
$conn = null;
$conn = checkDbConnection();
// make use of classes for save database
$val = new Donors($conn);

if (array_key_exists("id", $_GET)) {
    $val->donor_aid = $_GET['id'];
    $val->donor_is_active = 1;
    $val->donor_first_name = trim($data['donor_first_name']);
    $val->donor_last_name = trim($data['donor_last_name']);
    $val->donor_birth_date = date('Y-m-d', strtotime($data['donor_birth_date']));
    $val->donor_age = trim($data['donor_age']);
    $val->donor_residency_status = trim($data['donor_residency_status']);
    $val->donor_donation = trim($data['donor_donation']);
    $val->donor_updated = date('Y-m-d H:i:s');

    $donor_first_name_old = $data['donor_first_name_old'];

    // VALIDATIONS
    checkPayload($data);
    checkIndex($data, 'donor_department_id');
    checkId($val->donor_aid);
    compareName(
        $val, // models
        $donor_first_name_old, // old record
        $val->donor_first_name
    ); // new record

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Donor Update", $query);
}

checkEndpoint();
