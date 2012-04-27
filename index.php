<?php 
$pagetitle = "Hoàng Cái Blog"; 
$content = "Họ và tên"; 
$array = array( 
'a' => 'Ngô', 
'b' => 'Tiến', 
'c' => 'Hoàng' 
); 
$temp->assign("pagetitle", $pagetitle); 
$temp->assign("content", $content); 
$temp->assign("array",$array); 
?>