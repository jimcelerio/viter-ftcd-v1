<?php
// check database connection
$conn = null;
$conn = checkDbConnection();
// make use of classes for save database
$val = new Donors($conn);

$val->donor_is_active = 1;
$val->donor_first_name = trim($data['donor_first_name']);
$val->donor_last_name = trim($data['donor_last_name']);
$val->donor_birth_date = date('Y-m-d', strtotime($data['donor_birth_date']));
$val->donor_age = trim($data['donor_age']);
$val->donor_residency_status = trim($data['donor_residency_status']);
$val->donor_donation = trim($data['donor_donation']);
$val->donor_created = date('Y-m-d H:i:s');
$val->donor_updated = date('Y-m-d H:i:s');

// VALIDATIONS
checkPayload($data);
checkIndex($data, 'donor_first_name');
isNameExist($val, $val->donor_first_name);

// CREATE
$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "Donor Create", $query);
