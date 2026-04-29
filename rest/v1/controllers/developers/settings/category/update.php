<?php

$conn = null;
$conn = checkDbConnection();
$val = new Category($conn);

if (array_key_exists("id", $_GET)) {
    $val->category_aid = $_GET['id'];
    $val->category_name = trim($data['category_name']);
    $val->category_description = trim($data['category_description']);
    $val->category_updated = date('Y-m-d H:i:s');

    $category_name_old = $data['category_name_old'];

    checkPayload($data);
    checkIndex($data, 'category_name');
    checkIndex($data, 'category_description');
    checkId($val->category_aid);
    compareName($val, $category_name_old, $val->category_name);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Category Update", $query);
}

checkEndpoint();
