<?php 
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Вход</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form action="vendor/signin.php" method="POST">
		<label>Логин</label>
		<input type="text" placeholder="Введите свой логин" name="login">
		<label>Пароль</label>
		<input type="password" placeholder="Введите свой пароль" name="password">
		<button type="submit">Войти</button>
		<p>
			У вас нет аккаунта? - <a href="regist.php">зарегистрируйтесь</a>
		</p>
		<?php 
			if($_SESSION['message']){
				echo '<p class="msg">'.$_SESSION['message'] .'</p>';
			}
			unset($_SESSION['message']);
		?>
	</form>
</body>
</html>