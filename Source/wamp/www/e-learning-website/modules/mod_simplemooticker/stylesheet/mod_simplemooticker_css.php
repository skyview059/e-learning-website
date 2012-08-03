<?php
// Modulename: "SIMPLE MOOTICKER" for Joomla! 1.5.x
// Version: 1.5.4
// File: mod_simplemooticker_css.php
// Copyright 2008 - 2009: medien.stroeme - agentur für multimediale werbung
// Online: www.medienstroeme.de
// License:	GNU/GPL, see LICENSE.php
// Last update: 05.03.2009

header("Content-Type: text/css");

$tmgt  = $_GET['tmgt'];
$tmgr  = $_GET['tmgr'];
$tmgb  = $_GET['tmgb'];
$tmgl  = $_GET['tmgl'];
$tmgtie  = $_GET['tmgtie'];
$tmgrie  = $_GET['tmgrie'];
$tmgbie  = $_GET['tmgbie'];
$tmglie  = $_GET['tmglie'];
$unitymg  = $_GET['unitymg'];
$tw  = $_GET['tw'];
$unityw  = $_GET['unityw'];
$th  = $_GET['th'];
$unityh  = $_GET['unityh'];
$tbg  = $_GET['tbg'];
$tff  = $_GET['tff'];
$tfs  = $_GET['tfs'];
$unityfs  = $_GET['unityfs'];
$tfc  = $_GET['tfc'];
$tlc  = $_GET['tlc'];
$tlch  = $_GET['tlch'];
$tfli  = $_GET['tfli'];
$tfw  = $_GET['tfw'];
$tfv  = $_GET['tfv'];
$ttt  = $_GET['ttt'];
$tls  = $_GET['tls'];
$unityls  = $_GET['unityls'];
$tbst = $_GET['tbst'];
$tbw  = $_GET['tbw'];
$tbc = $_GET['tbc'];
?>

.mooquee {
position:absolute;
overflow:hidden;
white-space:nowrap;
margin-top:<?php echo $tmgt; ?><?php echo $unitymg; ?>;
margin-right:<?php echo $tmgr; ?><?php echo $unitymg; ?>;
margin-bottom:<?php echo $tmgb; ?><?php echo $unitymg; ?>;
margin-left:<?php echo $tmgl; ?><?php echo $unitymg; ?>;
}
* html .mooquee {
position:relative;
overflow:hidden;
white-space:nowrap;
margin-top:<?php echo $tmgtie; ?><?php echo $unitymg; ?>;
margin-right:<?php echo $tmgrie; ?><?php echo $unitymg; ?>;
margin-bottom:<?php echo $tmgbie; ?><?php echo $unitymg; ?>;
margin-left:<?php echo $tmglie; ?><?php echo $unitymg; ?>;
}
* + html .mooquee {
position:relative;
overflow:hidden;
white-space:nowrap;
margin-top:<?php echo $tmgtie; ?><?php echo $unitymg; ?>;
margin-right:<?php echo $tmgrie; ?><?php echo $unitymg; ?>;
margin-bottom:<?php echo $tmgbie; ?><?php echo $unitymg; ?>;
margin-left:<?php echo $tmglie; ?><?php echo $unitymg; ?>;
}

.mooquee-text {
position:absolute;
}

.layer_one {
z-index:10000;
}
.layer_two {
z-index:50000;
}
.layer_one, .layer_two {
position:absolute;
width:<?php echo $tw; ?><?php echo $unityw; ?>;
height:<?php echo $th; ?><?php echo $unityh; ?>;
line-height:<?php echo $th; ?><?php echo $unityh; ?>;
font-family:<?php echo $tff; ?>;
font-size:<?php echo $tfs; ?><?php echo $unityfs; ?>;
color:#<?php echo $tfc; ?>;
font-weight:<?php echo $tfw; ?>;
font-variant:<?php echo $tfv; ?>;
text-transform:<?php echo $ttt; ?>;
letter-spacing:<?php echo $tls; ?><?php echo $unityls; ?>;
border:<?php echo $tbst; ?> <?php echo $tbw; ?>px #<?php echo $tbc; ?>;
background-color:#<?php echo $tbg; ?>;
}

.layer_one a:link, .layer_one a:active, .layer_one a:visited,
.layer_two a:link, .layer_two a:active, .layer_two a:visited {	
color:#<?php echo $tlc; ?>;
text-decoration:<?php echo $tfli; ?>;
}
.layer_one a:hover, .layer_two a:hover {	
color:#<?php echo $tlch; ?>;
text-decoration:<?php echo $tfli; ?>;
}

.smtclr {
clear:both;
margin-top:0;
}