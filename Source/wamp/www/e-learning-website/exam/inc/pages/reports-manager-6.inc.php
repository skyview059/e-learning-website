<?php
$f_testid = (int)readGetVar('testid');
$f_id = (int)readGetVar('id');
 
if((int)readGetVar('set')) {
	$g_db->Execute("INSERT INTO ".$srv_settings['table_prefix']."tests_attempts (testid, id, test_attempt_count) VALUES (".$f_testid.", ".$f_id.", 0)");
$g_db->Execute("UPDATE ".$srv_settings['table_prefix']."tests_attempts SET test_attempt_count=999999 WHERE testid=".$f_testid." AND id=".$f_id);
} else {
	$g_db->Execute("DELETE FROM ".$srv_settings['table_prefix']."tests_attempts WHERE testid=".$f_testid." AND id=".$f_id);
}
 
gotoLocation('reports-manager.php'.getURLAddon('?action=', array('action', 'testid', 'id', 'set')));
?>
