<?php

$conn = null;
$conn = checkDbConnection();
$val = new Category($conn);

$val->category_is_active = 1;
$val->category_name = trim($data['category_name']);
$val->category_description = trim($data['category_description']);
$val->category_created = date('Y-m-d H:i:s');
$val->category_updated = date('Y-m-d H:i:s');

checkPayload($data);
checkIndex($data, 'category_name');
checkIndex($data, 'category_description');
isNameExist($val, $val->category_name);

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "Category Create", $query);
