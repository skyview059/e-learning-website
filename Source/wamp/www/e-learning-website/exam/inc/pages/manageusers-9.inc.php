<?php
$f_groupid = (int)readGetVar('groupid');
$f_ids = explode(SYSTEM_ARRAY_ITEM_SEPARATOR, readGetVar('ids'));
 
if($_GET["set"]) {
	foreach($f_ids as $i_id) {
	//9917//9917
 $g_db->Execute("INSERT INTO ".$srv_settings['table_prefix']."groups_users (groupid, id) VALUES ($f_groupid, $i_id)");
}
} else {
	$i_sql_where_addon = '';
reset($f_ids);
if(list(,$val) = each($f_ids))
 $i_sql_where_addon .= "id=".(int)$val;
while(list(,$val) = each($f_ids)) {
 $i_sql_where_addon .= " OR id=".(int)$val;
}
if($i_sql_where_addon)
 $i_sql_where_addon = ' AND ('.$i_sql_where_addon.')';
 //9917//9917
if($g_db->Execute("DELETE FROM ".$srv_settings['table_prefix']."groups_users WHERE groupid=$f_groupid".$i_sql_where_addon)===false)
 showDBError(__FILE__, 2);
}
 
gotoLocation('users.php'.getURLAddon('?action=groups', array('action')));
?>
