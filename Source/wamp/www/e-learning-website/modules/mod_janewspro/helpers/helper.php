<?php
/*
# ------------------------------------------------------------------------
# Ja NewsPro
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
if (! defined ( '_JA_NEWSPRO_' )) {
	define ( '_JA_NEWSPRO_', 1 );
	require_once (dirname ( __FILE__ ) . DS . 'jaimage.php');
	require_once (JPATH_SITE . '/components/com_content/helpers/route.php');
	
	class modJaNewsProHelper extends JObject {
		var $_module = null;
		var $_params = null;		
		var $_categories = array();
		var $_section = null;
		var $articles = array();
		var $cat_link = null;
		var $cat_title = null;
		var $cat_desc = null;
		var $_categories_org = array();
		var $moduleid=0;
		var $_themes = array();
		var $_totalHits = 0;
		
		function __construct($module, $params = null) {
			$this->_module = $module;
			$this->moduleid = $module->id;
			$this->loadConfig($params);			
		}
		
		public function loadConfig($params, $modulename = "mod_janewspro")
		{
			global $mainframe;
			$use_cache = $mainframe->getCfg("caching");
			$this->mod_params = $params;
			if ( $params->get('cache') == "1" && $use_cache == "1") {
				$cache =& JFactory::getCache();
				$cache->setCaching( true );
				$cache->setLifeTime( $params->get( 'cache_time', 30 ) * 60 );
				$this->_params = $cache->get( array( (new modJaNewsProHelper() ) , 'loadProfile' ), array( $params, $modulename ) );
			} else {
				$this->_params = modJaNewsProHelper::loadProfile( $params, $modulename );
			}
		}
		
	 	public function loadProfile($params, $modulename= "mod_janewspro")
	 	{
			global $mainframe;
			$profilename = $params->get('profile','hallowen2');
			$params_new =  new JParameter( '' );
			
			if(!empty($profilename))
	 		{				
	 			$path = JPATH_ROOT.DS."modules".DS.$modulename.DS."admin".DS."config.xml";
	 			$ini_file = JPATH_ROOT.DS."modules".DS.$modulename.DS."profiles".DS.$profilename.".ini";
	 			$config_content = "";
	 			if(file_exists($ini_file))
	 			{
	 				$config_content = JFile::read($ini_file);
	 			}
	 			
				if(empty($config_content))
				{
					$config_content = '';
					$ini_file_in_temp = JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.$modulename.DS.$profilename.".ini";
					if (is_file($ini_file_in_temp)){
						$config_content = JFile::read($ini_file_in_temp);
					}					
				}
	
	 			if(file_exists($path)){
	 				$params_new = new JParameter( $config_content, $path);
	 			}
	 		}
	 		
			$cats = trim ( $params->get ( 'colors' ) );
			$themes = array ();
			if ($cats) {
				$cats = preg_split ( '/[\n,]|<br \/>/', $cats );
				for($i = 0; $i < count ( $cats ); $i ++) {
					$temp = preg_split ( '/:/', $cats [$i] );
					if (isset ( $temp [0] ))
						$catid = $temp [0];
					if ($catid) {
						$themes [$catid] = isset ( $temp [1] ) ? $temp [1] : '';
					}
				}
			}
	 		
			$this->_themes = $themes;
	 		$params_new->set('groupbysubcat', $params->get('groupbysubcat', 0));
	 		$params_new->set('source', $params->get('source', 'JANewsHelper'));	 			 					
			$params_new->set('ordering', $params->get('ordering', 'ordering'));	
			$params_new->set('JPlugins', $params->get('JPlugins', 1));	
			$params_new->set('K2Plugins', $params->get('K2Plugins', 1));
			$params_new->set('maxSubCats', $params->get('maxSubCats', -1));	
			$params_new->set('timerange', $params->get('timerange', ''));				
			
	 		return  $params_new;
	 	}
		
		function _load($params, $moduleid) {						
			global $mainframe;
			
			$source = $this->get('source', 'JANewsHelper');
			$source .= 'Pro';
			if (class_exists($source)){
				$obj = new $source;
				$obj->getDatas($this, $params);				
			}
		}		
		
		function generatTimeStamp($date){
			$timeStamp = strtotime($date);
			$Time_Left = (time() - $timeStamp);
			
			$d = floor($Time_Left/24/60/60);
			$Time_Left = $Time_Left % (60 * 60 * 24);
			$h = floor($Time_Left/60/60);
			$Time_Left = $Time_Left % (60 * 60);
			$m = floor($Time_Left/60);
			
			if($d==0){
				if($h>1)	$str = $h.' '.JText::_('HOURS'). ' '.JText::_('AGO');
				elseif($h==1) $str = $h.' '.JText::_('HOUR'). ' '.JText::_('AGO');
				elseif($m<2) $str = $m.' '.JText::_('MIN'). ' '.JText::_('AGO');
				else $str = $m.' '.JText::_('MINS'). ' '.JText::_('AGO');
			}
			elseif($d==1) $str = $d.' '.JText::_('DAY'). ' '.JText::_('AGO');
			elseif($d<30) $str = $d.' '.JText::_('DAYS'). ' '.JText::_('AGO');
			elseif($d==30) $str = '1 '.JText::_('MONTH'). ' '.JText::_('AGO');
			else{ 
				$months = floor($d/30);
				$years = floor($months/12);
				if($months<12)		$str = $months.' '.JText::_('MONTHS'). ' '.JText::_('AGO');
				elseif($months==12) $str = $years.' '.JText::_('YEAR'). ' '.JText::_('AGO');
				elseif($years<2) $str = $years.' '.JText::_('YEAR'). ' '.JText::_('AGO');
				else $str = $years.' '.JText::_('YEARS'). ' '.JText::_('AGO');
			}
			
			return $str;
		}
		
		function statistic($hit){
			static $totalHits;
			if(!isset($totalHits)){
				$source = $this->get('source', 'JANewsHelper');
				$source .= 'Pro';
				if (class_exists($source)){
					$obj = new $source;
					$totalHits = $obj->getTotalHits();
				}
			}
			
			if(!$totalHits) return 3;
			
			$percent = round(($hit/$totalHits)*100);
			return $percent>3?$percent:3;
		}
		
		function get($name, $default = null) {
			return $this->_params->get ( $name, $default );
		}
		
		function set($name, $value){
			return $this->_params->set ( $name, $value );
		}
		
		function replaceImage(&$row, $align, $autoresize, $maxchars, $showimage, $width = 0, $height = 0, $hiddenClasses = '') {			
			$regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
			
			preg_match ( $regex, $row->introtext, $matches );
			if (! count ( $matches ))
				preg_match ( $regex, $row->fulltext, $matches );
			$images = (count ( $matches )) ? $matches : array ();
			$image = '';
			if (count ( $images ))
				$image = trim ( $images [2] );
			$class = $align;
			$align = $align ? "align=\"$align\"" : "";
			if ($image && $showimage) {
				
				$thumbnailMode = $this->get( 'thumbnail_mode', 'crop' );
				$aspect 	   = $this->get( 'use_ratio', '1' );
				$crop = $thumbnailMode == 'crop' ? true:false;

				$jaimage = JAImage::getInstance();				
				
				if( $thumbnailMode != 'none' && $jaimage->sourceExited($image) ) {
					$imageURL = $jaimage->resize( $image, $width, $height, $crop, $aspect );
					$image = $imageURL ? "<img class=\"$class\" src=\"" . $imageURL . "\" alt=\"{$row->title}\" $align />" : "";
				} else {
					$width = $width ? "width=\"$width\"" : "";
					$height = $height ? "height=\"$height\"" : "";
					$image = "<img class=\"$class\" src=\"" . $image . "\" alt=\"{$row->title}\" $width $height $align />";
				}
				
			} else
				$image = '';
			
			$regex1 = "/\<img[^\>]*>/";
			$row->introtext = preg_replace ( $regex1, '', $row->introtext );
			$regex1 = "/<div class=\"mosimage\".*<\/div>/";
			$row->introtext = preg_replace ( $regex1, '', $row->introtext );
			$row->introtext = trim ( $row->introtext );
			$row->introtext1 = $row->introtext;
			if ($maxchars && strlen ( $row->introtext ) > $maxchars) {
				$doc = JDocument::getInstance ();
				if (function_exists ( 'mb_substr' )) {
					$row->introtext1 = SmartTrim::mb_trim ( $row->introtext, 0, $maxchars, $doc->_charset );
				} else {
					$row->introtext1 = SmartTrim::trim ( $row->introtext, 0, $maxchars );
				}
			}
			// clean up globals
			return $image;
		}
	}
}
if (! class_exists ( 'SmartTrim' )) {
	class SmartTrim {
		/*
      $hiddenClasses: Class that have property display: none or invisible.
    */
		function mb_trim($strin, $pos = 0, $len = 10000, $hiddenClasses = '', $encoding = 'utf-8') {
			mb_internal_encoding ( $encoding );
			$strout = trim ( $strin );
			
			$pattern = '/(<[^>]*>)/';
			$arr = preg_split ( $pattern, $strout, - 1, PREG_SPLIT_DELIM_CAPTURE );
			$left = $pos;
			$length = $len;
			$strout = '';
			for($i = 0; $i < count ( $arr ); $i ++) {
				$arr [$i] = trim ( $arr [$i] );
				if ($arr [$i] == '')
					continue;
				if ($i % 2 == 0) {
					if ($left > 0) {
						$t = $arr [$i];
						$arr [$i] = mb_substr ( $t, $left );
						$left -= (mb_strlen ( $t ) - mb_strlen ( $arr [$i] ));
					}
					
					if ($left <= 0) {
						if ($length > 0) {
							$t = $arr [$i];
							$arr [$i] = mb_substr ( $t, 0, $length );
							$length -= mb_strlen ( $arr [$i] );
							if ($length <= 0) {
								$arr [$i] .= '...';
							}
						
						} else {
							$arr [$i] = '';
						}
					}
				} else {
					if (SmartTrim::isHiddenTag ( $arr [$i], $hiddenClasses )) {
						if ($endTag = SmartTrim::getCloseTag ( $arr, $i )) {
							while ( $i < $endTag )
								$strout .= $arr [$i ++] . "\n";
						}
					}
				}
				$strout .= $arr [$i] . "\n";
			}
			//echo $strout;  
			return SmartTrim::toString ( $arr, $len );
		}
		
		function trim($strin, $pos = 0, $len = 10000, $hiddenClasses = '') {
			$strout = trim ( $strin );
			
			$pattern = '/(<[^>]*>)/';
			$arr = preg_split ( $pattern, $strout, - 1, PREG_SPLIT_DELIM_CAPTURE );
			$left = $pos;
			$length = $len;
			$strout = '';
			for($i = 0; $i < count ( $arr ); $i ++) {
				$arr [$i] = trim ( $arr [$i] );
				if ($arr [$i] == '')
					continue;
				if ($i % 2 == 0) {
					if ($left > 0) {
						$t = $arr [$i];
						$arr [$i] = substr ( $t, $left );
						$left -= (strlen ( $t ) - strlen ( $arr [$i] ));
					}
					
					if ($left <= 0) {
						if ($length > 0) {
							$t = $arr [$i];
							$arr [$i] = substr ( $t, 0, $length );
							$length -= strlen ( $arr [$i] );
							if ($length <= 0) {
								$arr [$i] .= '...';
							}
						
						} else {
							$arr [$i] = '';
						}
					}
				} else {
					if (SmartTrim::isHiddenTag ( $arr [$i], $hiddenClasses )) {
						if ($endTag = SmartTrim::getCloseTag ( $arr, $i )) {
							while ( $i < $endTag )
								$strout .= $arr [$i ++] . "\n";
						}
					}
				}
				$strout .= $arr [$i] . "\n";
			}
			//echo $strout;  
			return SmartTrim::toString ( $arr, $len );
		}
		
		function isHiddenTag($tag, $hiddenClasses = '') {
			//By pass full tag like img
			if (substr ( $tag, - 2 ) == '/>')
				return false;
			if (in_array ( SmartTrim::getTag ( $tag ), array ('script', 'style' ) ))
				return true;
			if (preg_match ( '/display\s*:\s*none/', $tag ))
				return true;
			if ($hiddenClasses && preg_match ( '/class\s*=[\s"\']*(' . $hiddenClasses . ')[\s"\']*/', $tag ))
				return true;
		}
		
		function getCloseTag($arr, $openidx) {
			$tag = trim ( $arr [$openidx] );
			if (! $openTag = SmartTrim::getTag ( $tag ))
				return 0;
			
			$endTag = "<$openTag>";
			$endidx = $openidx + 1;
			$i = 1;
			while ( $endidx < count ( $arr ) ) {
				if (trim ( $arr [$endidx] ) == $endTag)
					$i --;
				if (SmartTrim::getTag ( $arr [$endidx] ) == $openTag)
					$i ++;
				if ($i == 0)
					return $endidx;
				$endidx ++;
			}
			return 0;
		}
		
		function getTag($tag) {
			if (preg_match ( '/\A<([^\/>]*)\/>\Z/', trim ( $tag ), $matches ))
				return ''; //full tag
			if (preg_match ( '/\A<([^ \/>]*)([^>]*)>\Z/', trim ( $tag ), $matches )) {
				//echo "[".strtolower($matches[1])."]";
				return strtolower ( $matches [1] );
			}
			//if (preg_match ('/<([^ \/>]*)([^\/>]*)>/', trim($tag), $matches)) return strtolower($matches[1]);
			return '';
		}
		
		function toString($arr, $len) {
			$i = 0;
			$stack = new JAStack ( );
			$length = 0;
			while ( $i < count ( $arr ) ) {
				$tag = trim ( $arr [$i ++] );
				if ($tag == '')
					continue;
				if (SmartTrim::isCloseTag ( $tag )) {
					if ($ltag = $stack->getLast ()) {
						if ('</' . SmartTrim::getTag ( $ltag ) . '>' == $tag)
							$stack->pop ();
						else
							$stack->push ( $tag );
					}
				} else if (SmartTrim::isOpenTag ( $tag )) {
					$stack->push ( $tag );
				} else if (SmartTrim::isFullTag ( $tag )) {
					//echo "[TAG: $tag, $length, $len]\n";
					if ($length < $len)
						$stack->push ( $tag );
				} else {
					$length += strlen ( $tag );
					$stack->push ( $tag );
				}
			}
			
			return $stack->toString ();
		}
		
		function isOpenTag($tag) {
			if (preg_match ( '/\A<([^\/>]+)\/>\Z/', trim ( $tag ), $matches ))
				return false; //full tag
			if (preg_match ( '/\A<([^ \/>]+)([^>]*)>\Z/', trim ( $tag ), $matches ))
				return true;
			return false;
		}
		
		function isFullTag($tag) {
			//echo "[Check full: $tag]\n";
			if (preg_match ( '/\A<([^\/>]*)\/>\Z/', trim ( $tag ), $matches ))
				return true; //full tag
			return false;
		}
		
		function isCloseTag($tag) {
			if (preg_match ( '/<\/(.*)>/', $tag ))
				return true;
			return false;
		}
	}
}
if (! class_exists ( 'JAStack' )) {	
	class JAStack {
		var $_arr = null;
		function JAStack() {
			$this->_arr = array ();
		}
		
		function push($item) {
			$this->_arr [count ( $this->_arr )] = $item;
		}
		function pop() {
			if (! $c = count ( $this->_arr ))
				return null;
			$ret = $this->_arr [$c - 1];
			unset ( $this->_arr [$c - 1] );
			return $ret;
		}
		function getLast() {
			if (! $c = count ( $this->_arr ))
				return null;
			return $this->_arr [$c - 1];
		}
		function toString() {
			$output = '';
			foreach ( $this->_arr as $item ) {
				$output .= $item . "\n";
			}
			return $output;
		}
	}
}

