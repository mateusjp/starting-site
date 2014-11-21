<?php
	if(isset($_POST['logon'])){
			
		$login 		= mysql_real_escape_string(strip_tags(trim($_POST['login'])));
		$senha 		= mysql_real_escape_string(strip_tags(trim($_POST['senha'])));
		$lembrar	= (isset($_POST['lembrar'])) ? true : false;
			
		if(empty($login) && empty($senha))
			echo 'Informe seu login e sua senha!';
		else if(empty($login))
			echo 'Informe seu login!';
		else if(empty($senha))
			echo 'Informe sua senha!';
		else {
			
			// VERIFICA LOGIN
			$query 		= mysql_query("SELECT login FROM usuarios WHERE login = '$login' LIMIT 1") or die(mysql_error());
			$checkLogin	= mysql_num_rows($query);
			
			// VERIFICA SENHA
			$query		= mysql_query("SELECT * FROM usuarios WHERE login = '$login' AND senha = '".md5($senha)."' LIMIT 1")                 or die(mysql_error());
			$checkPass	= mysql_num_rows($query);
			
			if($checkLogin <= 0)
				echo 'Este usuário não existe!';
			else if($checkPass <= 0)
				echo 'Senha incorreta!';
			else {
				
				$infoUser = mysql_fetch_assoc($query);
				
				$_SESSION['userLog'] = true;
				$_SESSION['userInfo'] = array(
					'nome' 	=> base64_encode($infoUser['nome']),
					'login'	=> base64_encode($infoUser['login']),
					'senha'	=> base64_encode($infoUser['senha'])
				);
				
				if($lembrar){
					setcookie('lembrar', true, time() + 3600 * 24 * 30, '/');
					setcookie('lembrar-login', base64_encode($login), time() + 3600 * 24 * 30, '/');
					setcookie('lembrar-senha', base64_encode($senha), time() + 3600 * 24 * 30, '/');
				}else{
					setcookie('lembrar', '', time() - 3600 * 24 * 30, '/');
					setcookie('lembrar-login', '', time() - 3600 * 24 * 30, '/');
					setcookie('lembrar-senha', '', time() - 3600 * 24 * 30, '/');
				}
				
				if(isset($_SESSION['userLog']))
					echo '<script type="text/javascript">window.top.location.href = "main.html?class=' . $_GET['classid'] . '"; </script>';
				else
					echo 'Desculpe, ocorreu um erro...';
					
				
			}
			
		}
		
		echo '<hr size="1" color="#dfdfdf">';
			
	}
?>
