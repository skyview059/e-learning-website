<?php
/**
 * Hello Model for Hello World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_2
 * @license    GNU/GPL
 */
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
require_once( 'C:\wamp\www\e-learning-website\components\com_dientich\dientich.php' );
/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class DientichModelDientich extends JModel
{
    private $dai = 0;
	private $rong = 0;
	private $dientich = 0;
	
	/*function __construct()
	{
		$this->dai = new JObject();
		$this->dai = "shit";
		$this->rong = new JObject();
		$this->rong = "fuck";
	}*/
	
    function getDai()
    {
		return $this->dai;
    }
	
	function getRong()
    {
		return $this->rong;
    }
	
	function getDientich()
    {
		if(isset($_POST["dai"]))
		{
			$this->dai = $_POST["dai"];
		}else
			$this->dai = "";
		if(isset($_POST["rong"]))
		{
			$this->rong = $_POST["rong"];
		}else
			$this->rong = "";	
/*
?>		
<script language="javascript">
confirm('<?php echo get_class($this); ?>');
</script>
<?php	
*/	
		$this->dientich = $this->dai*$this->rong;
        return $this->dientich;
    }
}