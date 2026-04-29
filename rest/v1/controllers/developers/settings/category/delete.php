<?php

require '../../../../core/header.php';
require '../../../../core/functions.php';
require '../../../../models/developers/settings/category/Category.php';

$conn = null;
$conn = checkDbConnection();
$val = new Category($conn);

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (array_key_exists("id", $_GET)) {
        $val->category_aid = $_GET['id'];

        checkId($val->category_aid);

        $query = checkDelete($val);
        http_response_code(200);
        returnSuccess($val, "Category Delete", $query);
    }

    checkEndpoint();
}

checkAccess();
