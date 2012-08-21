<?php defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
function getChapter(subjectName)
{
	if (subjectName=="")
	{
		document.getElementById("chapter").innerHTML="";
		return;
	}
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("chapter").innerHTML="";
			document.getElementById("chapter").innerHTML=xmlhttp.responseText;
			document.getElementById("theory").innerHTML="";
			document.getElementById("theory").innerHTML="<select name=\"theoryName\" style=\"width: 310px\">"
														+"	<option value=\"\">Chọn một bài học</option>"
														+"</select>";
		}
	}
	xmlhttp.open("GET","index.php?option=com_exercises&view=exercises&task=getChapter&subjectName="+subjectName,true);
	xmlhttp.send();
}
function getTheory(chapterName)
{
	if (chapterName=="chapter")
	{
		document.getElementById("theory").innerHTML="";
		return;
	}
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("theory").innerHTML="";
			document.getElementById("theory").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","index.php?option=com_exercises&view=exercises&task=getTheory&chapterName="+chapterName,true);
	xmlhttp.send();
}
</script>
<div class="exerciseOptionLayout">
		<form id="subjectForm" name="subjectForm" method="post" action="<?php echo JRoute::_( 'index.php?option=com_exercises&view=exercises&task=displayFull'); ?>">
			<table><tr><td>
			<fieldset class="fieldsetSubject">
				<legend>Hãy chọn một môn học</legend>
				<table><tr>
<?php
				for($i=0;$i<count($this->subjectArray);$i++){
					if($i%2==0&&$i!=0)
						echo "</tr><tr>";
					if($i%2==1)
						echo "<td width=\"5px\"></td>";
?>			
					<td>
						<input type="radio" name="subjectName" value="<?php echo $this->subjectArray[$i];?>" onclick="getChapter(this.value)">&nbsp;<?php echo $this->subjectArray[$i];?>
					</td>
<?php
				}
?>			
				</tr></table>
			</fieldset>
			</td><td>
			<fieldset class="fieldsetChapter">
				<legend>Chọn chương và bài học</legend>
				<table width="100%">
					<tr>
						<td align="left"><span>Chương</span></td>
						<td align="left">
							<div id="chapter">
								<select name="chapterName" onchange="getTheory(this.value)" style="width: 330px">
									<option value="">Chọn một chương bất kì</option>
								</select>
							</div>
						</td>
					</tr>
					<tr><td height="5px"></td></tr>
					<tr>
						<td align="left"><span>Bài học</span></td>
						<td align="left">
							<div id="theory">							
								<select name="theoryName"style="width: 330px">
									<option value="">Chọn một bài học</option>
								</select>
							</div>
						</td>
					</tr>
				</table>
			</fieldset>
			</td></tr>
			<tr><td colspan="2" align="center">
				<button type="submit" class="startExercise" align="center">Làm bài</button>
			</td></tr></table>
		</form>
</div>
<div class="exerciseLayout">
<?php
	//Exercise per page
	$epp = 10;
	$numOfPages = ceil(count($this->exerciseArray)/$epp);
	//echo "num = ".$numOfPages." so bai = ".count($this->exerciseArray);
	if(!isset($_GET["page"])){
		$page = 1;
	}else{
		$page = $_GET["page"];
	}
	$start = ($page-1)*$epp;
	$end = ($page-1)*$epp+$epp;
	if($end>count($this->exerciseArray)){
		$end = count($this->exerciseArray);
	}
	for($i=$start;$i<$end;$i++){
		//echo "###".($i+1)."###";
		$this->exerciseArray[$i]->display();
	}
?>
<div class="pageLink" align=center>
<?php
	$style = "";
	for($i=1;$i<=$numOfPages&&$numOfPages!=1;$i++){
		if($page==$i){
			$style = "style = \"color:red; font-size=18;\"";
		}else{
			$style = "";
		}
?>	
		<a <?php echo $style;?> href="index.php?option=com_exercises&view=exercises&Itemid=27&page=<?php echo $i;?>"><b><?php echo $i;?></b>&nbsp;&nbsp;</a>
<?php
	}
?>
</div>
</div>
<!--
			<fieldset class=\"fieldsetQuestion\">
				<legend>Chọn số lượng câu hỏi và độ khó</legend>
				<table width=\"100%\">
					<tr>
						<td width=\"50%\">
							<span> Số lượng câu hỏi </span> <select name="numOfQues" width="50px"></select>
						</td>
						<td width=\"50%\">Độ khó </td>
					</tr>
				</table>
			<fieldset>
			 onchange="this.form.submit()" 
			-->