<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define('HOST', 'localhost');
// Local 

define('USR', 'root'); 
define('PWD', 'asna2010'); 
define('USRT6', 'root'); 
define('PWDT6', 'asna2010'); 
define('DBNEW', 'livedrugfree_newt8'); 
define('DBT6', 'livedrugfree_old'); 

/*
// Delphi server 
define('USR', 'delphipr_live');
define('PWD', 'EcypbZvxpDQx');
define('USRT6', 'delphipr_oldldfu');
define('PWDT6', 'NWp0dcQx@64y');
define('DBNEW', 'delphipr_live');
define('DBT6', 'delphipr_oldldf'); 
*/

$GLOBALS['sql_enc'] = 'SET CHARACTER SET utf8';

$GLOBALS['pid']['fe_user'] = 18;
$GLOBALS['pid']['tx_nkcadportal_domain_model_membership'] = 18;
$GLOBALS['pid']['tx_nkcadportal_domain_model_contact'] = 18;


if (!$GLOBALS['connect'] = mysqli_connect(HOST, USR, PWD)) {
    die('Failed to connect TYPO3 DB server');
}
if (!$GLOBALS['connectt6'] = mysqli_connect(HOST, USRT6, PWDT6)) {
    die('Failed to connect TYPO3 DB server');
}
mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");


