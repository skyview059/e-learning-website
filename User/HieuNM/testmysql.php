<html>
<body>

<?php
//error_reporting(E_ALL & ~E_NOTICE & -E_WARNING );
error_reporting(~E_NOTICE & ~E_WARNING );
include("getQuestion.php");

 //echo(getQuestion(1,1) );
 ?>
 
 <?php
 $subject = $_POST["subject"];
 $num = $_POST["num"];
 
 if($subject != "" && $num != ""){
	echo "<b>Ban dang lam bai tap mon ".$subject."</b><br />";
	$subject_id = get_subject_ID($subject) ;
	echo(getQuestion($subject_id[1],$num) );
 }else{
	echo "<form action=\"testmysql.php\" method=\"post\">";
	echo "Ma môn hoc :<select name=\"subject\">";
	echo "<option></option>";
	$all_subject =  get_subject_name() ;
	$i = 1;
	while($all_subject[$i]!= ""){
		echo "<option>".$all_subject[$i]."</option>";
		$i++;
	}	
	echo "		</select>";
	echo "So luong cau hoi :<select name=\"num\">";
	echo "<option></option>";
	echo "<option>1</option>";
	echo "<option>5</option>";
	echo "<option>10</option>";
	echo "<option>15</option>";
	echo "		</select>";
	echo "<input type=\"submit\" value=\"Lam  bai\"/>";
    echo "</form>";
 }
 ?>
 
 <?php
 function get_subject_name() 
{
	$result[] = " ";
	$host = "localhost"; 
	$user= "root"; 
	$pass = ""; 
	$connectserver = mysql_connect($host, $user, $pass);
	if ( $connectserver ) 
    {
		mysql_select_db("db_e_learning",$connectserver);
		$sql = "SELECT subject_name FROM `jos_subjects`";
		$query = mysql_query($sql);
		echo ($query);
		if(mysql_num_rows($query) == 0)
		{
			echo "Khong lay duoc subject name";
		}
		else
		{
			while($row=mysql_fetch_array($query))
			{
				$result [] = $row[subject_name];
			}
		}
		
    }
	
	mysql_close($connectserver);
	return $result;
} 
function get_subject_ID($subject) 
{
	$result[] = " ";
	$host = "localhost"; 
	$user= "root"; 
	$pass = ""; 
	$connectserver = mysql_connect($host, $user, $pass);
	if ( $connectserver ) 
    {
		mysql_select_db("db_e_learning",$connectserver);
		$sql = "SELECT subjectid FROM `jos_subjects` where subject_name  = '".$subject."'";
		$query = mysql_query($sql);
		echo ($query);
		if(mysql_num_rows($query) == 0)
		{
			echo "Khong lay duoc subject id";
		}
		else
		{
			while($row=mysql_fetch_array($query))
			{
				$result [] = $row[subjectid];
			}
		}
		
    }
	
	mysql_close($connectserver);
	return $result;
} 
 ?>
 
</body>
</html>

