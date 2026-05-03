<?php
// check database connection
$conn = null;
$conn = checkDbConnection();
$val = new Children($conn);

if (array_key_exists("id", $_GET)) {
    $birthDate = date('Y-m-d', strtotime($data['children_birth_date']));

    $val->children_aid = $_GET['id'];
    $val->children_name = trim($data['children_name']);
    $val->children_birth_date = $birthDate;
    $val->children_story = trim($data['children_story']);
    $val->children_age = calculateAge($birthDate);
    $val->children_residency = trim($data['children_residency']);
    $val->children_donation_limit = trim($data['children_donation_limit']) === "" ? 0 : trim($data['children_donation_limit']);
    $val->children_updated = date('Y-m-d H:i:s');

    $children_name_old = $data['children_name_old'];

    checkPayload($data);
    checkIndex($data, 'children_name');
    checkIndex($data, 'children_birth_date');
    checkIndex($data, 'children_story');
    checkId($val->children_aid);
    compareName($val, $children_name_old, $val->children_name);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Children Update", $query);
}

checkEndpoint();
