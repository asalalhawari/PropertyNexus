<?php
@define("HOST", "localhost");
@define("USER", "root");
@define("PW", "");
@define("DB", "PHP_project");

$db_conn = new mysqli(HOST, USER, PW, DB);

// Check connection
if ($db_conn->connect_error) {
    die("<b>Connection failed:</b> " . $db_conn->connect_error);
}
?>
