<?php
if(isset($_POST["box_users"])) {
	foreach($_POST["box_users"] as $f_id) {
 deleteUser((int)$f_id);
}
} else {
	$f_id = (int)readGetVar('id');
deleteUser($f_id);
}
 
gotoLocation('users.php'.getURLAddon('', array('action', 'confirmed')));
function deleteUser($i_id) {
global $g_db, $srv_settings;
if ($i_id > SYSTEM_USER_MAX_INDEX) {
  
 $g_db->Execute("DELETE FROM ".$srv_settings['table_prefix']."tests_attempts WHERE id=".$i_id);
 
 $i_rSet1 = $g_db->Execute("SELECT resultid FROM ".$srv_settings['table_prefix']."results WHERE id=".$i_id);
if(!$i_rSet1) {
 showDBError(__FILE__, 1);
} else {
 while(!$i_rSet1->EOF) {
 deleteResultRecord($i_rSet1->fields["resultid"]);
$i_rSet1->MoveNext();
}
$i_rSet1->Close();
}
if($g_db->Execute("DELETE FROM ".$srv_settings['table_prefix']."results WHERE id=".$i_id)===false)
 showDBError(__FILE__, 2);
 //9917//9917
 if($g_db->Execute("DELETE FROM ".$srv_settings['table_prefix']."groups_users WHERE id=".$i_id)===false)
 showDBError(__FILE__, 3);
 
 if($g_db->Execute("DELETE FROM ".$srv_settings['table_prefix']."users WHERE id=".$i_id)===false)
 showDBError(__FILE__, 4);
}
}
?>
