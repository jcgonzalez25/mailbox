<?php
include_once './mbox-class.php'; 
	echo "<div>".$mbox->printMailBody($_GET['mid'])."</div>";
?>
