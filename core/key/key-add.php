<?php
// In the top frame, we use cookies for session.
define('COOKIE_SESSION', true);
require_once("../../config.php");
require_once($CFG->dirroot."/pdo.php");
require_once($CFG->dirroot."/lib/lms_lib.php");

header('Content-Type: text/html; charset=utf-8');
session_start();

if ( ! ( isset($_SESSION['id']) || isAdmin() ) ) {
    die('Must be logged in or admin');
}

$from_location = "keys.php";
$tablename = "{$CFG->dbprefix}lti_key";
if ( isAdmin() ) {
    $fields = array("key_key", "key_sha256", "secret", "created_at", "updated_at", "user_id");
} else {
    $fields = array("key_key", "key_sha256", "secret", "created_at", "updated_at");
}

$retval = crudInsertHandle($pdo, $tablename, $fields);
if ( $retval == CRUD_INSERT_SUCCESS || $retval == CRUD_INSERT_FAIL ) {
    header("Location: $from_location");
    return;
}

$OUTPUT->header();
$OUTPUT->bodyStart();
$OUTPUT->topNav();
$OUTPUT->flashMessages();

echo("<h1>Adding Key Entry</h1>\n<p>\n");

crudInsertForm($fields, $from_location);

echo("</p>\n");

$OUTPUT->footer();

