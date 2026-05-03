<?php

$conn = null;
$conn = checkDbConnection();
$val = new Designation($conn);

if (array_key_exists("id", $_GET)) {
    $val->designation_aid = $_GET['id'];
    $val->designation_name = trim($data['designation_name']);
    $val->designation_category_id = trim($data['designation_category_id']);
    $val->designation_updated = date('Y-m-d H:i:s');

    $designation_name_old = $data['designation_name_old'];

    checkPayload($data);
    checkIndex($data, 'designation_name');
    checkIndex($data, 'designation_category_id');
    checkId($val->designation_aid);
    compareName($val, $designation_name_old, $val->designation_name);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Designation Update", $query);
}

checkEndpoint();

