<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="http://localhost/thu%20vien%20ly%20thuyet/video-js/video-js.css" rel="stylesheet">
<script src="http://localhost/thu%20vien%20ly%20thuyet/video-js/video.js"></script>

</head>

<body onload="">

<?php

$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_query("SET character_set_results=utf8", $con);
mysql_select_db("test", $con);

$result = mysql_query("SELECT * FROM el_classes ");
$class = array(10);
$i = 0;
while($row = mysql_fetch_array($result))
  {
  $class[$i] =  $row['ClassName'];
  $i++;
  echo "<br />";
  }
mysql_close($con);
?>
<table width="956" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutDefaultTable-->
  <tr>
    <td width="115" height="17"></td>
    <td width="242"></td>
    <td width="26"></td>
    <td width="573"></td>
  </tr>
  <tr>
    <td height="87"></td>
    <td></td>
    <td></td>
    <td valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  <tr>
    <td height="19"></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td height="679">&nbsp;</td>
    <td valign="top"><ul id="”treemenu1″">
      <div align="center" id="wrapage">
            <div class="header"></div>
            <div class="menu">
                <ul>
<?php				
		$con = mysql_connect("localhost","root","");
		if (!$con){
			die('Could not connect: ' . mysql_error());
		}
		mysql_query("SET character_set_results=Calibri", $con);
		mysql_select_db("db_e_learning", $con);
		$query  = "SELECT * FROM el_subjects " ;
		$result = mysql_query($query);
		$subject_name= array(20);
		$subjectid = array (20);
		$j = 0;
		while($row = mysql_fetch_array($result)){
			$subject_name[$j] =  $row['subject_name'];
			$subjectid[$j] =  $row['subjectid'];		
			$j++; 
		}
		mysql_close($con);
		echo "<ul>";
		for ($j=0; $j<sizeof($subject_name); $j++) {
			if(isset($subject_name[$j])){
				echo "<li><a href=\"Ly%20thuyet.php?id=$subjectid[$j]\"\">" . $subject_name[$j] . "</a></li>";	
			}
		}
		echo "</ul>";		
?>                                                         
                </ul>
            </div>
    </div></td>
    <td>&nbsp;</td>
    <td valign="top">
    <?php
if(isset($_GET['id'])){
$id=$_GET['id'];}
function loadCourse($id)
{
	$con = mysql_connect("localhost","root","");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	mysql_query("SET character_set_results=utf8", $con);
	mysql_select_db("db_e_learning", $con);
	$result = mysql_query("SELECT * FROM el_theories WHERE  `subjectid` = $id");
	$theoryID;
	while($row = mysql_fetch_array($result))
	{
	  echo "<a href=\"Ly%20thuyet.php?id=$id&tid=" . $row['theoryid'] ."\">" .$row['theory_name'] . "</a>";
	  $theoryID = $row['theoryid'];
	  echo "<br />";
	}	  
	
}
if (isset($id)){
	loadCourse($id);}
if(isset($_GET['tid'])){	
$theoryID=$_GET['tid'];}
if (isset($id) && isset($theoryID)){
	loadTheory($theoryID);
}
function loadTheory($theoryID){
	$video = "";
	$con = mysql_connect("localhost","root","");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	mysql_query("SET character_set_results=utf8", $con);
	mysql_select_db("db_e-learning", $con);
	$result = mysql_query("SELECT * FROM el_theories WHERE  `theoryid` = $theoryID");
	$content = "";
	while($row = mysql_fetch_array($result))
	{
	  $content = $row['theory_body'];
	  $video = $row['theory_file_path'];
	}	  
	mysql_close($con);
		
	$file = fopen($content, "r") or exit("Unable to open file!");
	//Output a line of the file until the end is reached
	while(!feof($file)){
		  $buf = fgets($file);
          $output[] = $buf;
	}
	fclose($file);
	for($i=0; $i<sizeof($output); $i++)
	{
    			echo $output[$i] . "<br/>";
	}
	
	?>
	
	</p>
    </div>
    <video id="my_video_1" class="video-js vjs-default-skin" controls
  preload="auto" width="480" height="300" poster="my_video_poster.png"
  data-setup="{}">
      <source src="<?php echo $video ?>" type='video/flv'>
    </video>

    <br/>
-------------------------------------------<br/>
<?php
}
?></td>
  </tr>
</table>
   
</body>
</html>
