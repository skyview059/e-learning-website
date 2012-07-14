<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1
 * @license    GNU/GPL
*/
 
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 *
 * @package    HelloWorld
 */
 
class DientichViewDientich extends JView
{
    function display($tpl = null)
    {
/*
?>		
<script language="javascript">
confirm('<?php echo get_class($this); ?>');
</script>
<?php
*/
		$model = &$this->getModel();
		$dientich = $model->getDientich();
		$dai = $model->getDai();
		$rong = $model->getRong();
        $this->assignRef( 'dientich', $dientich );
		$this->assignRef( 'dai', $dai );
		$this->assignRef( 'rong', $rong );
        parent::display($tpl);
    }
}
?>