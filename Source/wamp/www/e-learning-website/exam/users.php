<?php
require_once('inc/init.inc.php');
if(isset($G_SESSION['id'])) {
 if($G_SESSION['access_users'] > 0) {
 
 $g_vars['page']['title'] = $lngstr['page_title_manageusers'];
switch(readGetVar('action')) {
 case 'create': 
 if($G_SESSION['access_users'] > 3) {
 
 include_once($DOCUMENT_PAGES.'manageusers-4.inc.php');
} else {
 gotoLocation('users.php'.getURLAddon('', array('action')));
}
break;
case 'delete': 
 if($G_SESSION['access_users'] > 3) {
 $f_confirmed = readGetVar('confirmed');
 
 if($f_confirmed==1) {
 if(isset($_GET['id']) || isset($_POST['box_users'])) {
 
 include_once($DOCUMENT_PAGES.'manageusers-5.inc.php');
} else {
 gotoLocation('users.php');
}
} else if($f_confirmed=='0') {
 gotoLocation('users.php');
} else {
 
 $i_confirm_header = $lngstr['page_manageusers_delete_user'];
$i_confirm_request = $lngstr['qst_delete_user'];
$i_confirm_url = 'users.php?id='.(int)$_GET['id'].'&action=delete';
include_once($DOCUMENT_PAGES.'confirm.inc.php');
}
} else {
 gotoLocation('users.php'.getURLAddon('', array('action', 'confirmed')));
}
break;
case 'edit': 
 $g_vars['page']['title'] = $lngstr['page_title_users_settings'].$lngstr['item_separator'].$g_vars['page']['title'];
if(($G_SESSION['access_users'] > 3) || (($G_SESSION['access_users'] > 2) && ((int)readGetVar('id') == $G_SESSION['id']))) {
 if(isset($_POST['bsubmit'])) {
 include_once($DOCUMENT_PAGES.'manageusers-3.inc.php');
} else if(isset($_POST['bcancel'])) {
 gotoLocation('users.php');
} else {
 include_once($DOCUMENT_PAGES.'manageusers-2.inc.php');
}
} else {
 gotoLocation('users.php'.getURLAddon('', array('action', 'id')));
}
break;
case 'enable': 
 if(($G_SESSION['access_users'] > 1) && ($G_SESSION['access_groups'] > 1)) {
 if(isset($_GET['id'])) {
 include_once($DOCUMENT_PAGES.'manageusers-6.inc.php');
}
} else {
 gotoLocation('users.php'.getURLAddon('', array('action', 'set')));
}
break;
case 'filter': 
 if(!empty($_POST['bsetfilter'])) {
 setCookieVar('filter_administration_users_id', readPostVar('id', readGetVar('id')));
setCookieVar('filter_administration_users_user_lastname', readPostVar('user_lastname', readGetVar('user_lastname')));
setCookieVar('filter_administration_users_user_department', readPostVar('user_department', readGetVar('user_department')));
gotoLocation('users.php'.getURLAddon('?action=', array('action')));
} else {
 setCookieVar('filter_administration_users_id', '');
setCookieVar('filter_administration_users_user_lastname', '');
setCookieVar('filter_administration_users_user_department', '');
gotoLocation('users.php'.getURLAddon('?action=', array('action', 'id', 'user_lastname', 'user_department')));
}
break;
case 'notes': 
 if(isset($_GET['id'])) {
 include_once($DOCUMENT_PAGES.'manageusers-7.inc.php');
}
break;
//case with groups
//9917
case 'groups': 
 $g_vars['page']['title'] = $lngstr['page_title_users_memberof'].$lngstr['item_separator'].$g_vars['page']['title'];
if(isset($_GET['id']) || isset($_POST['box_users']) || isset($_GET['ids'])) {
 include_once($DOCUMENT_PAGES.'manageusers-8.inc.php');
} else {
 gotoLocation('users.php');
}
break;
case 'memberof': 
 if(($G_SESSION['access_users'] > 1) && ($G_SESSION['access_groups'] > 1)) {
 if(isset($_GET['groupid']) && isset($_GET['ids'])) {
 include_once($DOCUMENT_PAGES.'manageusers-9.inc.php');
}
} else {
 gotoLocation('users.php'.getURLAddon('?action=groups', array('action')));
}
break;
default:
 if(($G_SESSION['access_users'] == 2) || ($G_SESSION['access_users'] == 4)) {
 include_once($DOCUMENT_PAGES.'manageusers-1.inc.php');
} else {
 gotoLocation('users.php'.getURLAddon('?action=edit&id='.$G_SESSION['id'], array('action', 'id')));
}
}
} else {
 
 $g_vars['page']['notifications'] = $lngstr['inf_cant_access_users'];
include_once($DOCUMENT_PAGES.'home.inc.php');
}
} else {
 
 $g_vars['page']['title'] = $lngstr['page_title_signin'];
include_once($DOCUMENT_PAGES.'signin-1.inc.php');
}
?>
