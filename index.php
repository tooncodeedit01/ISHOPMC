<?php
// News Design by maime
require('act.php');
$protect = "___MAIME___";
if(isset($_SESSION['username'])) {
	require('_page/page.main.php');
}else {
	if(@$_GET['page'] == "register") {
		require('_page/page.register.php');
	}else {
		require('_page/page.login.php');
	}
}
?>