<HTML> 
<HEAD> 
<TITLE>::Welcome to PHP</TITLE> 

</HEAD> 
<BODY> 
<h4>Function get Question</h4> 
<?php 

function getQuestion($subject,  $num) //$subject : mon  hoc ,  $num  : so luong cau hoi
{
	$result = " ";
	$host = "localhost"; // host server
	$user= "root"; // t�n truy c?p MySQL
	$pass = ""; // m?t kh?u truy c?p MySQL
	$connectserver = mysql_connect($host, $user, $pass);
	if ( $connectserver ) 
    {
		mysql_select_db("db_tracnghiem",$connectserver);
		$sql = "SELECT * FROM `tracnghiem_questions` WHERE subjectiD = '".$subject."'ORDER BY RAND( ) LIMIT ".$num;
		$query = mysql_query($sql);
		echo ($query);
		if(mysql_num_rows($query) == 0)
		{
			echo "Chua co du lieu";
		}
		else
		{
			$i  = 1  ;
			while($row=mysql_fetch_array($query))
			{
			?>
				<script type="text/javascript">
					function ans_<?php echo($row[questionid]);?>()
					{
					alert("Ans for question \"<?php echo($row[question_text]);?>\" is : \"<?php echo(get_answer_correct($row[questionid])) ;?>\"");
					
					}
				</script>
			<?php
				$all_ans =  get_answer($row[questionid]);
				
				$tmp = "<br>".$i++.".";
				$tmp .=$row[question_text]." <a onclick=\"ans_".$row[questionid]."()\" ><u>Hint</u></a>";
				
				$tmp .= "<br><label>";
				$tmp .= "<input type=\"radio\" name=\"question_".$row[questionid]."\" value=\"A\" id=\"question_".$row[questionid]."_A\" />";
				$tmp .="A. ".$all_ans[1];
				$tmp .= "</label><br><label>";
				$tmp .= "<input type=\"radio\" name=\"question_".$row[questionid]."\" value=\"B\" id=\"question_".$row[questionid]."_B\" />";
				$tmp .="B. ".$all_ans[2];
				$tmp .= "</label><br><label>";
				$tmp .= "<input type=\"radio\" name=\"question_".$row[questionid]."\" value=\"C\" id=\"question_".$row[questionid]."_C\" />";
				$tmp .="C. ".$all_ans[3];
				$tmp .= "</label><br><label>";
				$tmp .= "<input type=\"radio\" name=\"question_".$row[questionid]."\" value=\"D\" id=\"question_".$row[questionid]."_D\" />";
				$tmp .="D. ".$all_ans[4];
				$tmp .= "</label>";
				
				$tmp .="<br><input name=\"question_".$row[questionid]."\" type=\"hidden\" value=\"".get_answer_correct($row[questionid])."\" />";
				
				
				
				$result = $result."<br>".$tmp;
			}
			$i  =  1;
		}
    }
	mysql_close($connectserver);
	return $result;
} 
function get_answer_correct($ID) 
{
	$result = " ";
	$host = "localhost"; // host server
	$user= "root"; // t�n truy c?p MySQL
	$pass = ""; // m?t kh?u truy c?p MySQL
	$connectserver = mysql_connect($host, $user, $pass);
	if ( $connectserver ) 
    {
		mysql_select_db("db_tracnghiem",$connectserver);
		$sql = "SELECT * FROM `tracnghiem_answers` WHERE `questionid` = '".$ID."' AND `answer_correct` = 1";
		$query = mysql_query($sql);
		echo ($query);
		if(mysql_num_rows($query) == 0)
		{
			echo "Chua co du lieu";
		}
		else
		{
			while($row=mysql_fetch_array($query))
			{
				$result = $row[answer_text];
			}
		}
    }
	
	mysql_close($connectserver);
	return $result;
} 

function get_answer($ID) 
{
	$result[] = " ";
	$host = "localhost"; // host server
	$user= "root"; // t�n truy c?p MySQL
	$pass = ""; // m?t kh?u truy c?p MySQL
	$connectserver = mysql_connect($host, $user, $pass);
	if ( $connectserver ) 
    {
		mysql_select_db("db_tracnghiem",$connectserver);
		$sql = "SELECT * FROM `tracnghiem_answers` WHERE `questionid` = '".$ID."'";
		$query = mysql_query($sql);
		echo ($query);
		if(mysql_num_rows($query) == 0)
		{
			echo "Chua co du lieu";
		}
		else
		{
			while($row=mysql_fetch_array($query))
			{
				$result [] = $row[answer_text];
			}
		}
		
    }
	
	mysql_close($connectserver);
	return $result;
} 


  
?>  
</BODY> 
</HTML> 