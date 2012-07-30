<?php
/*------------------------------------------------------------------------
 # Yt News FrontPage  - Version 1.0
 # ------------------------------------------------------------------------
 # Copyright (C) 2009-2010 The YouTech Company. All Rights Reserved.
 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Author: The YouTech Company
 # Websites: http://addon.ytcvn.com
 -------------------------------------------------------------------------*/

class JElementContent extends JElement {
  var   $_name = 'content';
  function fetchElement($name, $value, &$node, $control_name){
  		$document = &JFactory::getDocument();
  		$selected =  $this->_parent->get('sec_or_cat');
  		if(!$selected){
  			$selected = 0;
  		}
  		$db = &JFactory::getDBO();
  		$radiolist   = "<div style='height:160px;width:100%;overflow:hidden;'>";
  		/*SHOW SECTIONS*/
  		$radiolist  .= "<div id='sections'>";
  		$query = "SELECT title,id FROM `#__sections` WHERE `published`='1'";
  		$db->setQuery($query);
  		$sections = $db->loadObjectList();
  		
  		foreach ($sections as $s){
		$sec[]			= JHTML::_('select.option', $s->id, $s->title);//select.option tao ra 1 mang doi tuong
		}
		
		$lists['sections']	= JHTML::_('select.genericlist', $sec,$control_name."[sections][]", 'class="inputbox" size="12"  style="width:100%"  multiple="multiple"', 'value', 'text',$this->_parent->get('sections'));
  		$radiolist .= $lists['sections'];
  		$radiolist .= "</div>" ;
  		/*SHOW SECTIONS*/
  		
  		/*SHOW CATEGORYS*/
  		$radiolist  .= "<div id='categories'>";
  		$query = "SELECT c.title, c.id, s.title as section_title FROM `#__categories` c INNER JOIN `#__sections` s ON s.id = c.section WHERE c.published='1'";
  		$db->setQuery($query);
  		$categories = $db->loadObjectList();
  		
  		foreach ($categories as $c){
		$cats[]			= JHTML::_('select.option', $c->id, $c->section_title . ' -> ' . $c->title);//select.option tao ra 1 mang doi tuong
		}
		
		$lists['categories']	= JHTML::_('select.genericlist', $cats,$control_name."[categories][]", 'class="inputbox" size="12"  style="width:100%"  multiple="multiple"', 'value', 'text',$this->_parent->get('categories'));
  		$radiolist .= $lists['categories'];
  		$radiolist .= "</div>" ;
  		/*SHOW CATEGORYS*/
  		$radiolist .= "</div>" ;
        JHTML::_('behavior.mootools');
        $document->addScriptDeclaration("              
              window.addEvent('domready', function(){
                  var selected = $selected;
                  var sections   = document.getElementById('sections');
                  var categories = document.getElementById('categories');
                  if (selected==0){                      
                      $('paramssec_or_cat0').checked = true;
                      $('paramssec_or_cat1').checked = false;                      
                  } else {
                      $('paramssec_or_cat0').checked = false;
                      $('paramssec_or_cat1').checked = true;
                  }
                  var installed = false;
                  function setupSwitcher(){                  	                        
                      var selected = $('paramssec_or_cat0').checked ? 0 : 1;
                      if (selected==0){
                          sections.style.display = 'block';
                          categories.style.display = 'none';
                          $('paramssec_or_cat0').checked = true;
                     	  $('paramssec_or_cat1').checked = false;
                      } else {
                          sections.style.display = 'none';
                          categories.style.display = 'block';
                          $('paramssec_or_cat0').checked = false;
                      	  $('paramssec_or_cat1').checked = true;
                      }
                      if (!installed){
                          $('paramssec_or_cat0').addEvent('click', setupSwitcher);
                          $('paramssec_or_cat1').addEvent('click', setupSwitcher);
                          installed = true;                          
                      }
                  }
                  setupSwitcher();                  
              });              
          ");
    return  $radiolist;

  }
}
?>
		

				