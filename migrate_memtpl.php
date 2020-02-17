<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'db.php';

$GLOBALS['pid']['tx_nkcadportal_domain_model_membershiptemplate'] = 19;
$feSql = "select uid,newsname,fe_group,price,term,newstype FROM " . DBT6 . ".tx_ggdfw_certs GROUP BY newsname";

$feRs = mysqli_query($GLOBALS['connectt6'], $feSql) or die(__LINE__.mysqli_error($GLOBALS['connectt6']));

$i=0;

while ($feRw = mysqli_fetch_assoc($feRs)) {
    $i++;
    $olduid = $feRw['uid'];
    
    $membershiptype = $feRw['fe_group']; 
    $description  = trim(mysqli_escape_string($GLOBALS['connectt6'], $feRw['newsname']));
    $price = $feRw['price'];
    $term = $feRw['term'];
    $includednewsletters = $feRw['newstype'];
    
    //check whether the record already exists!
    $chkSql = "SELECT uid FROM  ".DBNEW.".tx_nkcadportal_domain_model_membershiptemplate WHERE deleted=0 AND description='".$description."'";
    $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));

    if (mysqli_num_rows($chkRs) == 0) {
        
        mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
        mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
        mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");
    
        $query = "INSERT INTO " . DBNEW . ".tx_nkcadportal_domain_model_membershiptemplate (pid, crdate, tstamp, cruser_id, description, membershiptype, price, term) ";
        $query .= "VALUES (". $GLOBALS['pid']['tx_nkcadportal_domain_model_membershiptemplate'] .",". time() .",". time() .",1,'". $description ."','". $membershiptype ."','".$price."','".$term."')";
        mysqli_query($GLOBALS['connect'], $query) or die(__LINE__ ."<br>\n================\n<br>$olduid: $query<br> ".mysqli_error($GLOBALS['connect']));
        // Get the new uid
        $newId = mysqli_insert_id($GLOBALS['connect']);
        
    } else {
        $chkRw = mysqli_fetch_row($chkRs);
        $newId = $chkRw[0];
        
        mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
        mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
        mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");

        $query = "UPDATE " . DBNEW . ".tx_nkcadportal_domain_model_membershiptemplate SET tstamp='".time()."', description='".$description."', membershiptype='".$membershiptype."', price='".$price."', term='".$term."' WHERE uid=".$newId;
        mysqli_query($GLOBALS['connect'], $query) or die(__LINE__.': '. mysqli_error($GLOBALS['connect']));
                    
    }
}

echo "<br>Total $i records processed<br><a href='migration.php'>Back</a>";