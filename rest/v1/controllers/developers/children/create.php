<?php
// check database connection
$conn = null;
$conn = checkDbConnection();
$val = new Children($conn);

$birthDate = date('Y-m-d', strtotime($data['children_birth_date']));
$val->children_is_active = 1;
$val->children_name = trim($data['children_name']);
$val->children_birth_date = $birthDate;
$val->children_story = trim($data['children_story']);
$val->children_age = calculateAge($birthDate);
$val->children_residency = trim($data['children_residency']);
$val->children_donation_limit = trim($data['children_donation_limit']) === "" ? 0 : trim($data['children_donation_limit']);
$val->children_created = date('Y-m-d H:i:s');
$val->children_updated = date('Y-m-d H:i:s');

checkPayload($data);
checkIndex($data, 'children_name');
checkIndex($data, 'children_birth_date');
checkIndex($data, 'children_story');
isNameExist($val, $val->children_name);

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "Children Create", $query);
