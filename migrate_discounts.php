<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'db.php';
$GLOBALS['pid']['tx_nkcadportal_domain_model_discountcode'] = 24;
        
$feSql = "select * FROM " . DBT6 . ".tx_ggdfw_coupons";

$feRs = mysqli_query($GLOBALS['connectt6'], $feSql) or die(__LINE__.mysqli_error($GLOBALS['connectt6']));

$i=0;

while ($feRw = mysqli_fetch_assoc($feRs)) {
    $i++;
    $olduid = $feRw['uid'];
    
    $agency = mysqli_escape_string($GLOBALS['connectt6'], $feRw['agency']);
    $code = mysqli_escape_string($GLOBALS['connectt6'], $feRw['code']);    
    $description = mysqli_escape_string($GLOBALS['connectt6'], $feRw['descr']);
    $discount = $feRw['discount'];
    
    //check whether the record already exists!
    $chkSql = "SELECT uid FROM  ".DBNEW.".tx_nkcadportal_domain_model_discountcode WHERE deleted=0 AND t6uid=".$olduid;
    $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));

    if (mysqli_num_rows($chkRs) == 0) {
        
        mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
        mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
        mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");
    
        $query = "INSERT INTO " . DBNEW . ".tx_nkcadportal_domain_model_discountcode (pid, crdate, tstamp, cruser_id, deleted, hidden, agency, code, description, discount, t6uid) ";
        $query .= "VALUES (". $GLOBALS['pid']['tx_nkcadportal_domain_model_discountcode'] .",'". $feRw['crdate'] ."','". $feRw['tstamp'] ."','". $feRw['cruser_id'] ."','". $feRw['deleted'] ."','". $feRw['hidden'] ."','".$agency."','".$code."', '".$description."',".$discount.",". $olduid .")";
        mysqli_query($GLOBALS['connect'], $query) or die(__LINE__ ."<br>\n================\n<br>$olduid: $query<br> ".mysqli_error($GLOBALS['connect']));
        // Get the new uid
        $newId = mysqli_insert_id($GLOBALS['connect']);
        
    } else {
        $chkRw = mysqli_fetch_row($chkRs);
        $newId = $chkRw[0];
        
        mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
        mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
        mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");

        $query = "UPDATE " . DBNEW . ".tx_nkcadportal_domain_model_discountcode SET tstamp='".$feRw['tstamp']."', cruser_id=".$feRw['cruser_id'].", deleted=".$feRw['deleted'].", hidden='".$feRw['hidden']."', agency='".$agency."', code='".$code."', description='". $description."', discount=". $discount ." WHERE uid=".$newId;
        mysqli_query($GLOBALS['connect'], $query) or die(__LINE__.': '. mysqli_error($GLOBALS['connect']));           
    }

}

function getStateUid($code) {
    
    $chkSql = "SELECT uid FROM  ".DBNEW.".tx_nkcadportal_domain_model_state WHERE deleted=0 AND TRIM(stateshort)='".$code."' LIMIT 0,1";
    $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));
    $chkRw = mysqli_fetch_row($chkRs);
    
    return $chkRw[0];
}

echo "<br>Total $i records processed<br><a href='migration.php'>Back</a>";