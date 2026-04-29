<?php

$conn = null;
$conn = checkDbConnection();
$val = new SystemUsers($conn);

$query = checkReadAll($val);
http_response_code(200);
getQueriedData($query);
