<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'db.php';

$feSql = "select * FROM " . DBT6 . ".fe_users";

$feRs = mysqli_query($GLOBALS['connectt6'], $feSql) or die(__LINE__.mysqli_error($GLOBALS['connectt6']));

$i=0;

while ($feRw = mysqli_fetch_assoc($feRs)) {
    $i++;
    $olduid = $feRw['uid'];
    
    $tx_ggdfw_address2 = mysqli_escape_string($GLOBALS['connectt6'], $feRw['tx_ggdfw_address2']);
    $tx_ggdfw_state = mysqli_escape_string($GLOBALS['connectt6'], $feRw['tx_ggdfw_state']);
    $tx_ggdfw_county = mysqli_escape_string($GLOBALS['connectt6'], $feRw['tx_ggdfw_county']);
    $tx_ggdfw_cell = mysqli_escape_string($GLOBALS['connectt6'], $feRw['tx_ggdfw_cell']);
    $tx_ggdfw_numempl = $feRw['tx_ggdfw_numempl'];
    $tx_ggdfw_numcdl = $feRw['tx_ggdfw_numcdl'];
    $tx_ggdfw_fein = mysqli_escape_string($GLOBALS['connectt6'], $feRw['tx_ggdfw_fein']);
    $tx_ggdfw_bustype = mysqli_escape_string($GLOBALS['connectt6'], $feRw['tx_ggdfw_bustype']);
    $tx_ggdfw_inscarrier = mysqli_escape_string($GLOBALS['connectt6'], $feRw['tx_ggdfw_inscarrier']);
    $tx_ggdfw_insagent = mysqli_escape_string($GLOBALS['connectt6'], $feRw['tx_ggdfw_insagent']);
    $tx_ggdfw_hearfrom = mysqli_escape_string($GLOBALS['connectt6'], $feRw['tx_ggdfw_hearfrom']);
    $tx_ggdfw_staffcomments = mysqli_escape_string($GLOBALS['connectt6'], $feRw['tx_ggdfw_staffcomments']);
    $tx_ggdfw_memcomments = mysqli_escape_string($GLOBALS['connectt6'], $feRw['tx_ggdfw_memcomments']);
    $extbase_type = 'Tx_Nkcadportal_CustomFrontendUser';
    
    //check whether the record already exists!
    $chkSql = "SELECT uid FROM  ".DBNEW.".fe_users WHERE deleted=0 AND t6uid=".$olduid;
    $chkRs = mysqli_query($GLOBALS['connect'], $chkSql) or die(__LINE__ . mysqli_error($GLOBALS['connect']));

    if (mysqli_num_rows($chkRs) == 0) {
        
        mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
        mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
        mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");
    
        $query = "INSERT INTO " . DBNEW . ".fe_users (pid, tx_extbase_type, crdate,tstamp, username, password, usergroup, disable, starttime, endtime, name, first_name, middle_name, last_name, address, telephone, fax, email, cruser_id, deleted, description, uc, title, zip, city, country, www, company, additionaladdress, state, county, cellphone, numberofemployees, numberofcdldrivers, fein, businesstype, insurancecarrier, insuranceagent, hearaboutus, staffcomments, membercomments, t6uid) ";
        $query .= "VALUES (".$GLOBALS['pid']['fe_user'].",'".$extbase_type."' ,".$feRw['crdate'].", ".$feRw['tstamp'].",'".mysqli_escape_string($GLOBALS['connectt6'],$feRw['username'])."', '".mysqli_escape_string($GLOBALS['connectt6'],$feRw['password'])."','".$feRw['usergroup']."',".$feRw['disable'].",".$feRw['starttime'].",".$feRw['endtime'].",'".mysqli_escape_string($GLOBALS['connectt6'],$feRw['name'])."','".mysqli_escape_string($GLOBALS['connectt6'],$feRw['first_name'])."', '".mysqli_escape_string($GLOBALS['connectt6'],$feRw['middle_name'])."','".mysqli_escape_string($GLOBALS['connectt6'],$feRw['last_name'])."','".mysqli_escape_string($GLOBALS['connectt6'],$feRw['address'])."','".$feRw['telephone']."', '".$feRw['fax']."', '".$feRw['email']."', '".$feRw['cruser_id']."', '".$feRw['deleted']."','".mysqli_escape_string($GLOBALS['connectt6'],$feRw['description'])."','".$feRw['uc']."','".mysqli_escape_string($GLOBALS['connectt6'],$feRw['title'])."','".$feRw['zip']."','".mysqli_escape_string($GLOBALS['connectt6'],$feRw['city'])."','".$feRw['country']."','".$feRw['www']."','".mysqli_escape_string($GLOBALS['connectt6'],$feRw['company'])."','".$tx_ggdfw_address2."','".$tx_ggdfw_state."','".$tx_ggdfw_county."','".$tx_ggdfw_cell."','".$tx_ggdfw_numempl."','".$tx_ggdfw_numcdl."','".$tx_ggdfw_fein."','".$tx_ggdfw_bustype."','".$tx_ggdfw_inscarrier."', '".$tx_ggdfw_insagent."','".$tx_ggdfw_hearfrom."','".$tx_ggdfw_staffcomments."','".$tx_ggdfw_memcomments."',".$olduid.")";
        mysqli_query($GLOBALS['connect'], $query) or die(__LINE__ ."\n================\n$olduid: ".mysqli_error($GLOBALS['connect']));
        // Get the new uid
        $newId = mysqli_insert_id($GLOBALS['connect']);
        
    } else {
        $chkRw = mysqli_fetch_row($chkRs);
        $newId = $chkRw[0];
        
        mysqli_query($GLOBALS['connect'], $GLOBALS['sql_enc']);
        mysqli_query($GLOBALS['connect'], "set character_set_server='utf8'");
        mysqli_query($GLOBALS['connect'], "SET NAMES 'utf8'");

        $query = "UPDATE " . DBNEW . ".fe_users SET tx_extbase_type='".$extbase_type."', tstamp=".$feRw['tstamp'].", username='".mysqli_escape_string($GLOBALS['connectt6'],$feRw['username'])."', password='".mysqli_escape_string($GLOBALS['connectt6'],$feRw['password'])."', usergroup='".$feRw['usergroup']."', disable=".$feRw['disable'].", starttime=".$feRw['starttime'].", endtime=".$feRw['endtime'].", name='".mysqli_escape_string($GLOBALS['connectt6'],$feRw['name'])."', first_name='".mysqli_escape_string($GLOBALS['connectt6'],$feRw['first_name'])."', middle_name= '".mysqli_escape_string($GLOBALS['connectt6'],$feRw['middle_name'])."', last_name='".mysqli_escape_string($GLOBALS['connectt6'],$feRw['last_name'])."', address='".mysqli_escape_string($GLOBALS['connectt6'],$feRw['address'])."', telephone='".$feRw['telephone']."', fax='".$feRw['fax']."', email='".$feRw['email']."', cruser_id=".$feRw['cruser_id'].", deleted=".$feRw['deleted'].", description='".mysqli_escape_string($GLOBALS['connectt6'],$feRw['description'])."', uc='".$feRw['uc']."', title='".mysqli_escape_string($GLOBALS['connectt6'],$feRw['title'])."', zip='".$feRw['zip']."', city='".mysqli_escape_string($GLOBALS['connectt6'],$feRw['city'])."', country='".mysqli_escape_string($GLOBALS['connectt6'],$feRw['country'])."', www='".$feRw['www']."', company='".mysqli_escape_string($GLOBALS['connectt6'],$feRw['company'])."', additionaladdress='".$tx_ggdfw_address2."', state='".$tx_ggdfw_state."', county='".$tx_ggdfw_county."', cellphone='".$tx_ggdfw_cell."', numberofemployees='".$tx_ggdfw_numempl."', numberofcdldrivers='".$tx_ggdfw_numcdl."', fein='".$tx_ggdfw_fein."', businesstype='".$tx_ggdfw_bustype."', insurancecarrier='".$tx_ggdfw_inscarrier."', insuranceagent='".$tx_ggdfw_insagent."', hearaboutus='".$tx_ggdfw_hearfrom."', staffcomments='".$tx_ggdfw_staffcomments."', membercomments='".$tx_ggdfw_memcomments."' WHERE uid=".$newId;
        mysqli_query($GLOBALS['connect'], $query) or die(__LINE__.': '. mysqli_error($GLOBALS['connect']));
                    
    }
}

echo "<br>Total $i records processed";