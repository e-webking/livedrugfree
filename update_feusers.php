<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'db.php';

$feSql = "UPDATE " . DBNEW . ".fe_users SET tx_extbase_type='Tx_Nkcadportal_CustomFrontendUser'";
$feRs = mysqli_query($GLOBALS['connect'], $feSql) or die(__LINE__.mysqli_error($GLOBALS['connect']));
