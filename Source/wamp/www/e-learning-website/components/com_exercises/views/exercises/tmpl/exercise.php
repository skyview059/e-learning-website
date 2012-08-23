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
					if($i%2==0&&$i!=0){
						echo "</tr><tr>";
					}
					if($i%2==1){
						echo "<td width=\"5px\"></td>";
					}
					if($this->subjectArray[$i]==$this->subject){
?>			
						<td>
							<input type="radio" name="subjectName" checked="checked" value="<?php echo $this->subjectArray[$i];?>" onclick="getChapter(this.value)">&nbsp;<?php echo $this->subjectArray[$i];?>
						</td>
<?php					
					}else{
?>			
						<td>
							<input type="radio" name="subjectName" value="<?php echo $this->subjectArray[$i];?>" onclick="getChapter(this.value)">&nbsp;<?php echo $this->subjectArray[$i];?>
						</td>
<?php
					}
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
<?php
									if($this->subject==""){
?>
										<option value="">Chọn một chương bất kì</option>
<?php
									}else{
										if($this->chapter==""){
?>
											<option value="">Chọn một chương bất kì</option>
<?php
											for($chap=0;$chap<count($this->chapterArray);$chap++){
?>
												<option value="<?php echo $this->chapterArray[$chap]; ?>"><?php echo $this->chapterArray[$chap]; ?></option>
<?php
											}
										}else{
											for($chap=0;$chap<count($this->chapterArray);$chap++){
												if($this->chapterArray[$chap]==$this->chapter){
?>
													<option value="<?php echo $this->chapterArray[$chap]; ?>"  selected="selected"><?php echo $this->chapterArray[$chap]; ?></option>
<?php
												
												}else{
?>
													<option value="<?php echo $this->chapterArray[$chap]; ?>"><?php echo $this->chapterArray[$chap]; ?></option>
<?php
												}
											}
										}
									}
?>
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
<?php
									if($this->chapter==""){
?>
										<option value="">Chọn một bài học</option>
<?php
									}else{
										if($this->theory==""){
?>
											<option value="">Chọn một bài học</option>
<?php
											for($theo=0;$theo<count($this->theoryArray);$theo++){
?>
												<option value="<?php echo $this->theoryArray[$theo]; ?>"><?php echo $this->theoryArray[$theo]; ?></option>
<?php
											}
										}else{
											for($theo=0;$theo<count($this->theoryArray);$theo++){
												if($this->theoryArray[$theo]==$this->theory){
?>
													<option value="<?php echo $this->theoryArray[$theo]; ?>"  selected="selected"><?php echo $this->theoryArray[$theo]; ?></option>
<?php
												
												}else{
?>
													<option value="<?php echo $this->theoryArray[$theo]; ?>"><?php echo $this->theoryArray[$theo]; ?></option>
<?php
												}
											}
										}
									}
?>
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
	if(count($this->exerciseArray)==0){
?>
		<div align="center" style="color:red; font-size:20px;">Chưa có bài tập phù hợp yêu cầu bạn chọn</div>
<?php
	}
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
	/*
	for($i=$start;$i<$end;$i++){
		//echo "###".($i+1)."###";
		$this->exerciseArray[$i]->display();
	}
	*/
	for($i=0;$i<count($this->exerciseArray);$i++){
		$this->exerciseArray[$i]->display();
	}
?>
</div>