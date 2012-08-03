<?php
// Modulename: "SIMPLE MOOTICKER" for Joomla! 1.5.x
// Version: 1.5.4
// File: helper.php
// Copyright 2008 - 2009: medien.stroeme - agentur für multimediale werbung
// Online: www.medienstroeme.de
// License:	GNU/GPL, see LICENSE.php
// Last update: 05.03.2009

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

$tdir  = $params->get( 'tdir' );
$tstp  = $params->get( 'tstp' );
$tstpIE  = $params->get( 'tstpIE' );
$tpomo  = $params->get( 'tpomo' );
$tw  = $params->get( 'tw' );
$unityw  = $params->get( 'unityw' );
$th  = $params->get( 'th' );
$unityh  = $params->get( 'unityh' );
$tmgt  = $params->get( 'tmgt' );
$tmgr  = $params->get( 'tmgr' );
$tmgb  = $params->get( 'tmgb' );
$tmgl  = $params->get( 'tmgl' );
$tmgtie  = $params->get( 'tmgtie' );
$tmgrie  = $params->get( 'tmgrie' );
$tmgbie  = $params->get( 'tmgbie' );
$tmglie  = $params->get( 'tmglie' );
$unitymg  = $params->get( 'unitymg' );
$tbg  = $params->get( 'tbg' );
$tff  = $params->get( 'tff' );
$tfs  = $params->get( 'tfs' );
$unityfs  = $params->get( 'unityfs' );
$tfc  = $params->get( 'tfc' );
$tlc  = $params->get( 'tlc' );
$tlch  = $params->get( 'tlch' );
$tfli  = $params->get( 'tfli' );
$tfw  = $params->get( 'tfw' );
$tfv  = $params->get( 'tfv' );
$ttt  = $params->get( 'ttt' );
$tls  = $params->get( 'tls' );
$unityls  = $params->get( 'unityls' );
$tbst = $params->get( 'tbst' );
$tbw  = $params->get( 'tbw' );
$tbc = $params->get( 'tbc' );
$tns = $params->get( 'tns' );
$tccm = $params->get('tccm');
$mootools=$params->get('mootools',"0");

// load mootools
JHTML::_('behavior.mootools');

// load compressed mootools library
if ($mootools == 1){
$doc =& JFactory::getDocument();
$doc->addScript(JURI::base()."modules/mod_simplemooticker/scripts/mod_simplemooticker_mootools.js");
}

// load mooticker class  for mootools 1.11
$doc =& JFactory::getDocument();
$doc->addScript(JURI::base()."modules/mod_simplemooticker/scripts/mod_simplemooticker.js");

// load stylesheet
$document =& JFactory::getDocument();
$url = 'modules/mod_simplemooticker/stylesheet/mod_simplemooticker_css.php?tw='.$tw.'&amp;unityw='.$unityw.'&amp;th='.$th.'&amp;unityh='.$unityh.'&amp;tmgt='.$tmgt.'&amp;tmgr='.$tmgr.'&amp;tmgb='.$tmgb.'&amp;tmgl='.$tmgl.'&amp;tmgtie='.$tmgtie.'&amp;tmgrie='.$tmgrie.'&amp;tmgbie='.$tmgbie.'&amp;tmglie='.$tmglie.'&amp;unitymg='.$unitymg.'&amp;tbg='.$tbg.'&amp;tff='.$tff.'&amp;tfs='.$tfs.'&amp;unityfs='.$unityfs.'&amp;tfc='.$tfc.'&amp;tfw='.$tfw.'&amp;tfv='.$tfv.'&amp;ttt='.$ttt.'&amp;tls='.$tls.'&amp;unityls='.$unityls.'&amp;tbst='.$tbst.'&amp;tbw='.$tbw.'&amp;tbc='.$tbc.'&amp;tlc='.$tlc.'&amp;tlch='.$tlch.'&amp;tfli='.$tfli.'';
$document->addStyleSheet($url);

// original code from mod_latestnews
class modSimplemootickerHelper
{
	function getList(&$params)
	{
		global $mainframe;

		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$userId = (int) $user->get('id');

		$count = (int) $params->get('count', 5);
		$catid = trim( $params->get('catid') );
		$secid = trim( $params->get('secid') );
		$show_front	= $params->get('show_front', 1);
		$aid = $user->get('aid', 0);

		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access = !$contentConfig->get('show_noauth');

		$nullDate = $db->getNullDate();

		$date =& JFactory::getDate();
		$now = $date->toMySQL();

		$where = 'a.state = 1'
			. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
			. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
			;

		// User Filter
		switch ($params->get( 'user_id' ))
		{
			case 'by_me':
				$where .= ' AND (created_by = ' . (int) $userId . ' OR modified_by = ' . (int) $userId . ')';
				break;
			case 'not_me':
				$where .= ' AND (created_by <> ' . (int) $userId . ' AND modified_by <> ' . (int) $userId . ')';
				break;
		}

		// Ordering
		switch ($params->get( 'ordering' ))
		{
			case 'm_dsc':
				$ordering		= 'a.modified DESC, a.created DESC';
				break;
			case 'c_dsc':
			default:
				$ordering		= 'a.created DESC';
				break;
		}

		if ($catid)
		{
			$ids = explode( ',', $catid );
			JArrayHelper::toInteger( $ids );
			$catCondition = ' AND (cc.id=' . implode( ' OR cc.id=', $ids ) . ')';
		}
		if ($secid)
		{
			$ids = explode( ',', $secid );
			JArrayHelper::toInteger( $ids );
			$secCondition = ' AND (s.id=' . implode( ' OR s.id=', $ids ) . ')';
		}

		// Content Items only
		$query = 'SELECT a.*, ' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
			' FROM #__content AS a' .
			($show_front == '0' ? ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id' : '') .
			' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
			' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
			' WHERE '. $where .' AND s.id > 0' .
			($access ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
			($catid ? $catCondition : '').
			($secid ? $secCondition : '').
			($show_front == '0' ? ' AND f.content_id IS NULL ' : '').
			' AND s.published = 1' .
			' AND cc.published = 1' .
			' ORDER BY '. $ordering;
		$db->setQuery($query, 0, $count);
		$rows = $db->loadObjectList();

		$i = 0;
		$lists	= array();
		foreach ( $rows as $row )
		{
			if($row->access <= $aid)
			{
				$lists[$i]->link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
			} else {
				$lists[$i]->link = JRoute::_('index.php?option=com_user&amp;view=login');
			}
			$lists[$i]->text = htmlspecialchars( $row->title );
			$i++;
		}

		return $lists;
	}
}
?>