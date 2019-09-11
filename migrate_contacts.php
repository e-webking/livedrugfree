<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'db.php';

$feSql = "select * FROM " . DBT6 . ".tx_ggdfw_contacts";

$feRs = mysqli_query($GLOBALS['connectt6'], $feSql) or die(__LINE__.mysqli_error($GLOBALS['connectt6']));

$i=0;

while ($feRw = mysqli_fetch_assoc($feRs)) {
    $i++;
    $olduid = $feRw['uid'];
    
    $first_name = mysqli_escape_string($GLOBALS['connectt6'], $feRw['first_name']);
    $last_name = mysqli_escape_string($GLOBALS['connectt6'], $feRw['last_name']);
    $email = mysqli_escape_string($GLOBALS['connectt6'], $feRw['email']);
    $title = mysqli_escape_string($GLOBALS['connectt6'], $feRw['title']);
    $phone = $feRw['phone'];
    $memberid = $feRw['memberid'];
    $cotype = mysqli_escape_string($GLOBALS['connectt6'], $feRw['cotype']);
    if(trim($cotype) == 'dfw') {
        $cotype = 'DFW';
    }
    if(trim($cotype) == 'dot') {
        $cotype = 'DOT';
    }
    
    //get the new DB feuser id
    $newfeuseruid = getFeuserid($memberid);
    
    //check whether the record already exists!
    $chkSql = "SELECT uid FROM  ".DBNEW.".tx_nkcadportal_domain_model_contact WHERE deleted=0 AND t6uid=".$olduid;
    $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));

    if (mysqli_num_rows($chkRs) == 0) {
        
        mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
        mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
        mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");
    
        $query = "INSERT INTO " . DBNEW . ".tx_nkcadportal_domain_model_contact (pid, crdate, tstamp, cruser_id, deleted, hidden, customfrontenduser, firstname, lastname, phone, email,title, contacttype, t6uid) ";
        $query .= "VALUES (". $GLOBALS['pid']['tx_nkcadportal_domain_model_contact'] .",'". $feRw['crdate'] ."','". $feRw['tstamp'] ."','". $feRw['cruser_id'] ."','". $feRw['deleted'] ."','". $feRw['hidden'] ."','".$newfeuseruid."','".$first_name."', '".$last_name."','".$phone."','".$email."','".$title."', '".$cotype."',".$olduid.")";
        mysqli_query($GLOBALS['connect'], $query) or die(__LINE__ ."<br>\n================\n<br>$olduid: $query<br> ".mysqli_error($GLOBALS['connect']));
        // Get the new uid
        $newId = mysqli_insert_id($GLOBALS['connect']);
        
    } else {
        $chkRw = mysqli_fetch_row($chkRs);
        $newId = $chkRw[0];
        
        mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
        mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
        mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");

        $query = "UPDATE " . DBNEW . ".tx_nkcadportal_domain_model_contact SET tstamp='".$feRw['tstamp']."', hidden='".$feRw['hidden']."', firstname='".$first_name."', lastname='".$last_name."', phone='".$phone."', email='".$email."', cruser_id=".$feRw['cruser_id'].", deleted=".$feRw['deleted'].",title='".$title."', contacttype='".$cotype."' WHERE uid=".$newId;
        mysqli_query($GLOBALS['connect'], $query) or die(__LINE__.': '. mysqli_error($GLOBALS['connect']));
                    
    }
}

function getFeuserid($t6uid) {
    $chkSql = "SELECT uid FROM  ".DBNEW.".fe_users WHERE deleted=0 AND t6uid=".$t6uid." LIMIT 0,1";
    $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));
    $chkRw = mysqli_fetch_row($chkRs);
    
    return $chkRw[0];
}

echo "<br>Total $i records processed<br><a href='migration.php'>Back</a>";