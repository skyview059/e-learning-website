<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once dirname(__FILE__) . DS . 'functions.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
 <head>
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<jdoc:include type="head" />
  <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/system.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/general.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/style.css" />
  <!--[if IE 6]><link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/style.ie6.css" type="text/css" media="screen" /><![endif]-->
  <script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/script.js"></script>
 </head>
<body>
<div class="PageBackgroundSimpleGradient">
</div>
<div class="PageBackgroundGlare">
    <div class="PageBackgroundGlareImage"></div>
</div>
<div class="Main">
<div class="Sheet">
    <div class="Sheet-tl"></div>
    <div class="Sheet-tr"><div></div></div>
    <div class="Sheet-bl"><div></div></div>
    <div class="Sheet-br"><div></div></div>
    <div class="Sheet-tc"><div></div></div>
    <div class="Sheet-bc"><div></div></div>
    <div class="Sheet-cl"><div></div></div>
    <div class="Sheet-cr"><div></div></div>
    <div class="Sheet-cc"></div>
    <div class="Sheet-body">
		<div class="Header">
			<div class="Header-jpeg"></div>
			<div class="logo">
				<h1 id="name-text" class="logo-name"><a href="<?php echo $this->baseurl ?>/">Onthi.com</a></h1>
				<div id="slogan-text" class="logo-text">Let passion lead your success</div>
			</div>
		</div>
		<jdoc:include type="modules" name="user3" />
		<div class="contentLayout">
			<div class="sidebar1">
				<jdoc:include type="modules" name="left" style="artblock" />
			</div>
			<div class="content">
<!-- MinhNT - Add new - Begin -->			
<?php 			if( JRequest::getVar('view') == 'frontpage') 
				{        ?>
				<!-- bạn đang ở trang chủ
				 thực hiện bất cứ công việc gì mà bạn muốn -->
<?php			
				echo "clgt ?";
?>		
<?php 			} else { ?>
				<!-- bạn không còn ở trang chủ
				 hiển thị mainbody như bình thường -->
				<jdoc:include type=”component” />
<?php 			} 		 ?>
<!-- MinhNT - Add new - End -->
			</div>
			<div class="cleared"></div>
			<div class="Footer">
				<div class="Footer-inner">
					<!-- MinhNT - Replace - Begin -->
					<div class="Footer-text"><p>Bản quyền &copy; 2012 <a href="#">Onthi.com</a></p>
					<!-- MinhNT - Replace - Begin -->
					</div>
				</div>
				<div class="Footer-background"></div>
			</div>

		</div>
	</div>
<!-- MinhNT - Remove - Begin -->
<!--  <p class="page-footer">Trang web học tập trực tuyến</p> -->
<!-- MinhNT - Remove - End -->
</div>
</div>
</body> 
</html>