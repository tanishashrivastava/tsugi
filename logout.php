<?php
define('COOKIE_SESSION', true);
require_once("config.php");
require_once("lib/lms_lib.php");
session_start();
session_unset();
deleteSecureCookie();

header('Location: index.php');
