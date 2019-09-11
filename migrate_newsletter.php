<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'db.php';
$GLOBALS['pid']['tx_nkcadportal_domain_model_newsletter'] = 22;
        
$feSql = "select * FROM " . DBT6 . ".tx_ggdfw_downloads";

$feRs = mysqli_query($GLOBALS['connectt6'], $feSql) or die(__LINE__.mysqli_error($GLOBALS['connectt6']));

$i=0;

while ($feRw = mysqli_fetch_assoc($feRs)) {
    $i++;
    $olduid = $feRw['uid'];
    
    $forperiod = $feRw['forthedate'];     
    $title = mysqli_escape_string($GLOBALS['connectt6'], $feRw['description']);
    $fe_group = $feRw['fe_group'];
    $newstype = getNewsletterUid($feRw['downtype']);
    
    
    //check whether the record already exists!
    $chkSql = "SELECT uid FROM  ".DBNEW.".tx_nkcadportal_domain_model_newsletter WHERE deleted=0 AND t6uid=".$olduid;
    $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));

    if (mysqli_num_rows($chkRs) == 0) {
        
        mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
        mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
        mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");
    
        $query = "INSERT INTO " . DBNEW . ".tx_nkcadportal_domain_model_newsletter (pid, crdate, tstamp, cruser_id, deleted, hidden, starttime, endtime, title, forperiod, newslettertype, t6uid) ";
        $query .= "VALUES (". $GLOBALS['pid']['tx_nkcadportal_domain_model_newsletter'] .",'". $feRw['crdate'] ."','". $feRw['tstamp'] ."','". $feRw['cruser_id'] ."','". $feRw['deleted'] ."','". $feRw['hidden'] ."','". $feRw['starttime'] ."','". $feRw['endtime'] ."','".$title."','".$forperiod."', '".$newstype."',". $olduid .")";
        mysqli_query($GLOBALS['connect'], $query) or die(__LINE__ ."<br>\n================\n<br>$olduid: $query<br> ".mysqli_error($GLOBALS['connect']));
        // Get the new uid
        $newId = mysqli_insert_id($GLOBALS['connect']);
        
    } else {
        $chkRw = mysqli_fetch_row($chkRs);
        $newId = $chkRw[0];
        
        mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
        mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
        mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");

        $query = "UPDATE " . DBNEW . ".tx_nkcadportal_domain_model_newsletter SET tstamp='".$feRw['tstamp']."', cruser_id=".$feRw['cruser_id'].", deleted=".$feRw['deleted'].", hidden='".$feRw['hidden']."', starttime='".$feRw['starttime']."', endtime='".$feRw['endtime']."', title='".$title."', forperiod='".$forperiod."', newslettertype='". $newstype."' WHERE uid=".$newId;
        mysqli_query($GLOBALS['connect'], $query) or die(__LINE__.': '. mysqli_error($GLOBALS['connect']));           
    }
    
    setSysRef($feRw['newsfile'], $newId);

}

function getNewsletterUid($type) {
    
//    $chkSql = "SELECT uid FROM  ".DBNEW.".tx_nkcadportal_domain_model_newslettertype WHERE deleted=0 AND LOWER(name)='".$type."' LIMIT 0,1";
//    $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));
//    $chkRw = mysqli_fetch_row($chkRs);
//    
//    return $chkRw[0];
    $return = 1;
    switch ($type) {
        case "employee":
            $return = 1;
            break;
        case "spanish":
            $return = 2;
            break;
        case "supervisor":
            $return = 3;
            break;
        case "dot":
            $return = 4;
    }
    
    return $return;
}

function setSysRef($file, $uid) {
//    echo $file.'|'.$uid.'|';
    //get the sys_file uid
    $chkSql = "SELECT uid FROM  ".DBNEW.".sys_file WHERE name='". $file."' LIMIT 0,1";
    $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));
    
    if (mysqli_num_rows($chkRs) > 0) {
        $chkRw = mysqli_fetch_row($chkRs);
        $sysfileuid = $chkRw[0];
        
        $chk2Sql = "SELECT uid FROM ".DBNEW.".sys_file_reference WHERE deleted=0 AND uid_local='".$sysfileuid."' AND uid_foreign='".$uid."' AND tablenames='tx_nkcadportal_domain_model_newsletter' AND fieldname='file' LIMIT 0,1";
//        echo "<br>$chk2Sql";
        $chk2Rs = mysqli_query($GLOBALS['connect'], $chk2Sql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));
        //var_dump($chk2Rs);
        
        if ($chk2Rs->num_rows == 0 || is_null($chk2Rs)) {
            $query = "INSERT INTO " . DBNEW . ".sys_file_reference (pid,tstamp,crdate,uid_local,uid_foreign,tablenames,fieldname,sorting_foreign,table_local) VALUES (". $GLOBALS['pid']['tx_nkcadportal_domain_model_newsletter'].",".time().",".time().",$sysfileuid,$uid,'tx_nkcadportal_domain_model_newsletter','file',1,'sys_file')";
            
            mysqli_query($GLOBALS['connect'], $query) or die(__LINE__.': '. mysqli_error($GLOBALS['connect']));  
        }
    } 
    
}

echo "<br>Total $i records processed<br><a href='migration.php'>Back</a>";