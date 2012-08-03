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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementCategoryK2 extends JElement
{
	/*
	 * Category name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'CategoryK2';
	
	var $_controlName = '';
	/**
	 * fetch Element 
	 */
	function fetchElement($name, $value, &$node, $control_name){
		if(!$this->checkComponent('com_k2')){
			return '<input type="hidden" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'"/> <span style="color:red">K2 component is not installed!</span>';
		}
		$this->_controlName = $name;
		$categories = JElementCategoryK2::_fetchElement(0, '', array());  
		
		$HTMLCats = '<select name="'.$control_name.'['.$name.'][]" id="'.$control_name.$name.'" class="inputbox" style="width:95%;" multiple="multiple" size="10">';
		$HTMLCats .= '<option value="">'.JText::_("SELECT CATEGORY").'</option>';
		
		foreach ( $categories as $item ) {
			$check = '';
			if( (is_array($value) && in_array($item->id, $value)) || (!is_array($value) && $item->id==$value) ){	
				$check = 'selected="selected"';
			}
			
			$class = '';
			if(!$item->haschild) $class = 'class="subcat"';
			
			$HTMLCats 	.= '<option value="'.$item->id.'" '.$check.' '.$class.'>'.'&nbsp;&nbsp;&nbsp;'. $item->treename. ' (ID: '.$item->id. ')' .'</option>';			
		}
		
		$HTMLCats .= '</select>';
        return $HTMLCats;
	}

    function fetchChild($parent) {
        $db = &JFactory::getDBO();
        $query = "SELECT * FROM #__k2_categories WHERE parent = '{$parent}' AND published=1";
		$db->setQuery( $query );
		$cats = $db->loadObjectList();

        return $cats;
    }

    function _fetchElement( $id, $indent, $list, $maxlevel=9999, $level=0, $type=1 )
	{
        $children = JElementCategoryK2::fetchChild($id);

		if (@$children && $level <= $maxlevel)
		{
			foreach ($children as $v)
			{
				$id = $v->id;

				if ( $type ) {
					$pre 	= '<sup>|_</sup>&nbsp;';
					$spacer = '.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				} else {
					$pre 	= '- ';
					$spacer = '&nbsp;&nbsp;';
				}

				if ($v->parent == 0) {
					$txt 	= $v->name;
				} else {
					$txt 	= $pre . $v->name;
				}
				$pt = $v->parent;
				$list[$id] = $v;
				$list[$id]->treename = "{$indent}{$txt}";
				$list[$id]->children = count( @$children);
				$list[$id]->haschild = true;
				$list = JElementCategoryK2::_fetchElement( $id, $indent . $spacer, $list, $maxlevel, $level+1, $type );
			}
		}
		else{
			$list[$id]->haschild = false;
		}
		return $list;
	}
	
	function checkComponent($component){
    	$db = JFactory::getDBO();
		$query =" SELECT Count(*) FROM #__components as c WHERE c.option ='$component' and c.parent=0"	;
		$db->setQuery($query);
		return $db->loadResult();
	}	
}
?>