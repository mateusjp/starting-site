<?php	
	if(isset($_POST['cadastrar'])){
		
		$nome 		= mysql_real_escape_string(strip_tags(trim($_POST['nome'])));
		$login		= mysql_real_escape_string(strip_tags(trim($_POST['login'])));
		$senha		= mysql_real_escape_string(strip_tags(trim($_POST['senha'])));
		$confSenha	= mysql_real_escape_string(strip_tags(trim($_POST['confirmar-senha'])));
		
		if(empty($nome) && empty($login) && empty($senha) && empty($confSenha))
			echo 'Preencha todos os campos!';
		else if(empty($nome))
			echo 'Informe seu nome!';
		else if(empty($login))
			echo 'Informe seu login!';
		else if(empty($senha))
			echo 'Informe sua Senha!';
		else if(empty($confSenha))
			echo 'Confirme sua senha!';
		else if(strlen($senha) > 50)
			echo 'Senha muito extensa!';
		else if(strlen($senha) < 6)
			echo 'Senha muito curta!';
		else if(strlen($login) > 50)
			echo 'Login muito extenso!';
		else if(strlen($login) < 6)
			echo 'Login muito curto!';
		else if(strlen($nome) > 50)
			echo 'Nome muito extenso!';
		else if(strlen($nome) < 6)
			echo 'Nome muito curto!';
		else if($senha != $confSenha)
			echo 'As senhas não correspondem!';
		else {
			
			$query = mysql_query("SELECT login FROM usuarios WHERE login = '$login'") or die(mysql_error());
			
			if(mysql_num_rows($query) > 0)
				echo 'Este login já esta sendo utilizado!';
			else {
				
				$cadastrar = mysql_query("INSERT INTO usuarios ( nome, login, senha, id, money, bios ) VALUES ( '$nome', '$login', '".md5($senha)."', '".md5($login)."',0 ,0 ) ") or die(mysql_error());
				
				if($cadastrar)
					echo 'Você foi cadastrado com sucesso!';
				else
					echo 'Desculpe, ocorreu um erro...';
				
			}
			
		}
					
		echo '<hr size="1" color="#dfdfdf">';
		
	}
?>
