<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'db.php';

if ($_REQUEST['start'] == '') {
    
    migrateData(0);
    echo '<a href="migrate_mship.php?start=5001">Process 5001 to 10000</a>';
} else {
    if ($_REQUEST['start'] == 5001) {
        
        migrateData(5001);
        echo '<a href="migrate_mship.php?start=10001">Process 10001 to rest</a>';
        
    } else {
        migrateData(10001);
        echo "<br><a href='migration.php'>Back</a>";
    }
}

function migrateData($start) {
    $feSql = "select * FROM " . DBT6 . ".tx_ggdfw_certs LIMIT $start, 5000";

    $feRs = mysqli_query($GLOBALS['connectt6'], $feSql) or die(__LINE__.mysqli_error($GLOBALS['connectt6']));

    $i=0;

    while ($feRw = mysqli_fetch_assoc($feRs)) {
        $i++;
        $olduid = $feRw['uid'];

        $newsname  = mysqli_escape_string($GLOBALS['connectt6'], $feRw['newsname']);
        $certstate = $feRw['certstate'];
        $renew = $feRw['renew'];
        $expire = $feRw['expire'];        
        $transidorcheck = mysqli_escape_string($GLOBALS['connectt6'], $feRw['transidorcheck']);
        $dcertoriginal = $feRw['dcertoriginal'];
        $dcertrenewed = $feRw['dcertrenewed'];
        $memberid = $feRw['memberid'];

        //get the new DB feuser id
        $stateuid = getStateUid($certstate);
        $membershiptemplateuid = getMemTplUid($newsname);
        $newfeuseruid = getFeuserid($memberid);

        //check whether the record already exists!
        $chkSql = "SELECT uid FROM  ".DBNEW.".tx_nkcadportal_domain_model_membership WHERE deleted=0 AND t6uid=".$olduid;
        $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));

        if (mysqli_num_rows($chkRs) == 0) {

            mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
            mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
            mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");

            $query = "INSERT INTO " . DBNEW . ".tx_nkcadportal_domain_model_membership (pid, crdate, tstamp, cruser_id, deleted, hidden, customfrontenduser, membershiptemplate, state, starttimecustom, endtimecustom, statestarttimecustom, stateendtimecustom, t6uid) ";
            $query .= "VALUES (". $GLOBALS['pid']['tx_nkcadportal_domain_model_membership'] .",'". $feRw['crdate'] ."','". $feRw['tstamp'] ."','". $feRw['cruser_id'] ."','". $feRw['deleted'] ."','". $feRw['hidden'] ."','".$newfeuseruid."','".$membershiptemplateuid."', '".$stateuid."', '".$renew."', '".$expire."','". $dcertoriginal ."','". $dcertrenewed ."', ".$olduid.")";
            mysqli_query($GLOBALS['connect'], $query) or die(__LINE__ ."<br>\n================\n<br>$olduid: $query<br> ".mysqli_error($GLOBALS['connect']));
            // Get the new uid
            $newId = mysqli_insert_id($GLOBALS['connect']);

        } else {
            $chkRw = mysqli_fetch_row($chkRs);
            $newId = $chkRw[0];

            mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
            mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
            mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");

            $query = "UPDATE " . DBNEW . ".tx_nkcadportal_domain_model_membership SET tstamp='".$feRw['tstamp']."', cruser_id=".$feRw['cruser_id'].", deleted=".$feRw['deleted'].", hidden='".$feRw['hidden']."', customfrontenduser='".$newfeuseruid."', membershiptemplate='".$membershiptemplateuid."', state='".$stateuid."', starttimecustom='".$renew."', endtimecustom='".$expire."', statestarttimecustom='".$dcertoriginal."', stateendtimecustom='".$dcertrenewed."' WHERE uid=".$newId;
            mysqli_query($GLOBALS['connect'], $query) or die(__LINE__.': '. mysqli_error($GLOBALS['connect']));

        }
    }
}

function getStateUid($code) {
    
    $chkSql = "SELECT uid FROM  ".DBNEW.".tx_nkcadportal_domain_model_state WHERE deleted=0 AND TRIM(stateshort)='".$code."' LIMIT 0,1";
    $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));
    $chkRw = mysqli_fetch_row($chkRs);
    
    return $chkRw[0];
}

function getMemTplUid($desc) {
    $chkSql = "SELECT uid FROM  ".DBNEW.".tx_nkcadportal_domain_model_membershiptemplate WHERE deleted=0 AND TRIM(description)='".trim($desc)."' LIMIT 0,1";
    $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));
    $chkRw = mysqli_fetch_row($chkRs);
    
    return $chkRw[0];
}


function getFeuserid($t6uid) {
    $chkSql = "SELECT uid FROM  ".DBNEW.".fe_users WHERE deleted=0 AND t6uid=".$t6uid." LIMIT 0,1";
    $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));
    $chkRw = mysqli_fetch_row($chkRs);
    
    return $chkRw[0];
}
