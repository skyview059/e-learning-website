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
	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/components/com_theorylibrary/css/style.css" type="text/css" />
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
					<div style="margin:30px 130px;">
						<img src="<?php echo JPATH_URL.$this->baseurl;?>/images/M_images/hung.jpg" alt="Hung">
					</div>
					<?php if ($this->countModules('breadcrumb') || artxHasMessages()) : ?>
					<div class="Post">
						<div class="Post-body">
							<div class="Post-inner">
								<div class="PostContent">
									<jdoc:include type="modules" name="breadcrumb" />
									<jdoc:include type="message" />
								</div>
								<div class="cleared"></div>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<jdoc:include type="component" />
				</div>
			<!--
			<div class="sidebar2">
			<jdoc:include type="modules" name="right" style="artblock" />

			</div>
			-->
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
	  <p class="page-footer"><a href="http://joomlacmstemplates.blogspot.com">Free Joomla 1.5 Templates</a> by JBTemplates.</p>

	</div>

</body> 
</html>