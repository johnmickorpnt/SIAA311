<?php
session_start();
if(session_destroy()){
	header("refresh:0;url=../../index.php");	
}
?>