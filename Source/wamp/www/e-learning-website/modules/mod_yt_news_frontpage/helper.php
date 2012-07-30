<?php 

/*------------------------------------------------------------------------

 # Yt News FrontPage  - Version 1.0

 # ------------------------------------------------------------------------

 # Copyright (C) 2009-2010 The YouTech Company. All Rights Reserved.

 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

 # Author: The YouTech Company

 # Websites: http://addon.ytcvn.com

 -------------------------------------------------------------------------*/

 

 

defined('_JEXEC') or die('Restricted access');

if (! class_exists("modYtcNewsFrontPageHelper") ) { 

require_once (dirname(__FILE__) .DS. 'assets' .DS.'ytc_content.php');



class modYtcNewsFrontPageHelper {

	var $module_name = '';

	function process($params, $module) {

		$enable_cache 		=   $params->get('cache',1);

		$cachetime			=   $params->get('cache_time',0);

		$this->module_name = $module->module;

		if($enable_cache==1) {		

			$conf =& JFactory::getConfig();

			$cache = &JFactory::getCache($module->module);

			$cache->setLifeTime( $params->get( 'cache_time', $conf->getValue( 'config.cachetime' ) * 60 ) );

			$cache->setCaching(true);

			$cache->setCacheValidation(true);

			$items =  $cache->get( array('modYtcNewsFrontPageHelper', 'getList'), array($params, $module));
		} else {
			$items = modYtcNewsFrontPageHelper::getList($params, $module);
		}
		
		return $items;		
		
	}
	
	
	function getList ($params, $module) {

        $content = new YtcContent();
        
            $content->is_frontpage = $params->get('is_frontpage', 2);
            $content->is_cat_or_sec = $params->get('sec_or_cat', 1);
            if ($content->is_cat_or_sec == 0) {
                $content->cat_or_sec_ids = $params->get('sections', '');
    
            } else {
                $content->cat_or_sec_ids = $params->get('categories', '');
            }
            $content->featured = $params->get('featured', 2);
			$content->showtype = $params->get('showtype', 1);
            
			$content->category = $params->get('category', 0);
			$content->listIDs = $params->get('itemIds', '');
            
            $content->customUrl = $params->get('customUrl', '');
			$content->limit = $params->get('total');
			$content->sort_order_field = $params->get('sort_order_field', "created");
			$content->type_order = $params->get('sort_order', "ASC");
			$content->thumb_height = $params->get('thumb_height', "150px");
			$content->thumb_width = $params->get('thumb_width', "120px");
			
			$content->small_thumb_height = $params->get('small_thumb_height', "0");
			$content->small_thumb_width = $params->get('small_thumb_width', "0");
			
			$content->web_url = JURI::base();
			$content->max_title		=   $params->get('limittitle',25);
			$content->max_main_description		=   $params->get('limit_main_description',25);
            $content->max_normal_description		=   $params->get('limit_normal_description',25);            
			
			$content->resize_folder = JPATH_CACHE.DS. $module->module .DS."images";
			$content->url_to_resize = $content->web_url . "cache/". $module->module ."/images/";
			$content->cropresizeimage = $params->get('cropresizeimage', 1);

			$items = $content->getList();	
            //var_dump($items);die;	
			return $items;

	}

}

} 

if(!class_exists('Browser')){

	class Browser

	{

		private $props    = array("Version" => "0.0.0",

									"Name" => "unknown",

									"Agent" => "unknown") ;

	

		public function __Construct()

		{

			$browsers = array("firefox", "msie", "opera", "chrome", "safari",

								"mozilla", "seamonkey",    "konqueror", "netscape",

								"gecko", "navigator", "mosaic", "lynx", "amaya",

								"omniweb", "avant", "camino", "flock", "aol");

	

			$this->Agent = strtolower($_SERVER['HTTP_USER_AGENT']);

			foreach($browsers as $browser)

			{

				if (preg_match("#($browser)[/ ]?([0-9.]*)#", $this->Agent, $match))

				{

					$this->Name = $match[1] ;

					$this->Version = $match[2] ;

					break ;

				}

			}

		}

	

		public function __Get($name)

		{

			if (!array_key_exists($name, $this->props))

			{

				die("No such property or function {$name}");

			}

			return $this->props[$name] ;

		}

	

		public function __Set($name, $val)

		{

			if (!array_key_exists($name, $this->props))

			{

				SimpleError("No such property or function.", "Failed to set $name", $this->props);

				die;

			}

			$this->props[$name] = $val ;

		}

	

	} 

}	

?>



