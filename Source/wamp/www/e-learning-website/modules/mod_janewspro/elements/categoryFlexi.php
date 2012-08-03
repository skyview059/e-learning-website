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
$cparams =& JComponentHelper::getParams('com_flexicontent');
if (!defined('FLEXI_SECTION'))	define('FLEXI_SECTION', $cparams->get('flexi_section'));
class JElementCategoryFlexi extends JElement
{
	/*
	 * Category name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'CategoryFlexi';
	
	var $_controlName = '';
	/**
	 * fetch Element 
	 */
	function fetchElement ( $name, $value, &$node, $control_name ){
		if(!$this->checkComponent('com_flexicontent')){
			return '<input type="hidden" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'"/> <span style="color:red">FLEXIContent component is not installed!</span>';
		}
		$categories = JElementCategoryFlexi::_fetchElement(0, '', array());  
		
		$HTMLCats = '<select name="'.$control_name.'['.$name.'][]" id="'.$control_name.$name.'" class="inputbox" style="width:95%;" multiple="multiple" size="10">';
		$HTMLCats .= '<option value="">'.JText::_("SELECT CATEGORY").'</option>';
		
		foreach ( $categories as $item ) 
		{
			//if(!$item->haschild) continue;
			$check = '';
			if( (is_array($value) && in_array($item->cat_id, $value)) || (!is_array($value) && $item->cat_id==$value) ){	
				$check = 'selected="selected"';
			}
			
			$class = '';
			if(!$item->haschild) $class = 'class="subcat"';
			
			$HTMLCats 	.= '<option value="'.$item->cat_id.'" '.$check.' '.$class.'>'.'&nbsp;&nbsp;&nbsp;'. $item->treename. ' (ID: '.$item->cat_id. ')' .'</option>';			
		}
		
		$HTMLCats .= '</select>';
        return $HTMLCats;
	}
	function fetchChild($parent) 
	{
        $db = &JFactory::getDBO();
        $query = "SELECT * FROM #__k2_categories WHERE parent = '{$parent}' AND published=1";
       	$query = 'SELECT c.section,c.parent_id,
						sec.title AS section_title,
						c.id AS cat_id,
						c.title AS cat_title '
					. ' FROM #__categories AS c'
					. ' LEFT JOIN #__flexicontent_cats_item_relations AS rel ON rel.catid = c.id'
					. ' LEFT JOIN #__groups AS g ON g.id = c.access'
					. ' LEFT JOIN #__sections AS sec ON sec.id = c.section'
					. ' WHERE c.section = ' . FLEXI_SECTION
					. ' AND sec.scope = ' . $db->Quote('content')
					. ' AND c.published = 1'
					. ' AND c.parent_id ='.$parent
					. ' GROUP BY parent_id, c.title	';
        
		$db->setQuery( $query );
		$cats = $db->loadObjectList();

        return $cats;
    }
	function _fetchElement( $id, $indent, $list, $maxlevel=9999, $level=0, $type=1 )
	{
        $children = $this->fetchChild($id);

		if (@$children && $level <= $maxlevel)
		{
			foreach ($children as $v)
			{
				$id = $v->cat_id;

				if ( $type ) {
					$pre 	= '<sup>|_</sup>&nbsp;';
					$spacer = '.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				} else {
					$pre 	= '- ';
					$spacer = '&nbsp;&nbsp;';
				}

				if ($v->parent_id == 0) {
					$txt 	= $v->cat_title;
				} else {
					$txt 	= $pre . $v->cat_title;
				}
				$pt = $v->parent_id;
				$list[$id] = $v;
				$list[$id]->treename = "{$indent}{$txt}";
				$list[$id]->children = count( @$children);
				$list[$id]->haschild = true;
				$list = $this->_fetchElement( $id, $indent . $spacer, $list, $maxlevel, $level+1, $type );
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