<?php

$conn = null;
$conn = checkDbConnection();
$val = new Designation($conn);

$val->designation_is_active = 1;
$val->designation_name = trim($data['designation_name']);
$val->designation_category_id = trim($data['designation_category_id']);
$val->designation_created = date('Y-m-d H:i:s');
$val->designation_updated = date('Y-m-d H:i:s');

checkPayload($data);
checkIndex($data, 'designation_name');
checkIndex($data, 'designation_category_id');
isNameExist($val, $val->designation_name);

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "Designation Create", $query);

