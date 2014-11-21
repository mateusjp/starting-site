<?php
  
	session_start();
	
	mysql_connect('localhost', 'root', '') or die(mysql_error());
	mysql_select_db('sistema') or die(mysql_error());
	
	if(!isset($_SESSION['userLog'])){
		echo '<script type="text/javascript">window.top.location.href = "login.php?class=' . $_GET['classid'] . '"; </script>';
		die();
	}
	
	$login = base64_decode($_SESSION['userInfo']['login']);
	$senha = base64_decode($_SESSION['userInfo']['senha']);
	
	$query = mysql_query("SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha' LIMIT 1") or die(mysql_error());
	
	if(mysql_num_rows($query) <= 0){
		unset($_SESSION['userLog'], $_SESSION['userInfo']);
		session_destroy();
		echo '<script type="text/javascript">window.top.location.href = "login.php?class=' . $_GET['classid'] . '"; </script>';
		die();
	}
	$infoUser = mysql_fetch_assoc($query);
	
	if(isset($_GET['acao']) && $_GET['acao'] == 'sair'){
		unset($_SESSION['userLog'], $_SESSION['userInfo']);
		session_destroy();
		echo '<script type="text/javascript">window.top.location.href = "login.php?class=' . $_GET['classid'] . '"; </script>';
		die();
	}
	
?>
