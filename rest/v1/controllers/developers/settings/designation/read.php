<?php

$conn = null;
$conn = checkDbConnection();
$val = new Designation($conn);

$query = checkReadAll($val);
http_response_code(200);
getQueriedData($query);

