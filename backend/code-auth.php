<?php
// Load required libraries
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use \RobThree\Auth\TwoFactorAuth;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
// Include SHT CMS Core
include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

// Verify request method is POST
$sht->checkPOST();


?>
