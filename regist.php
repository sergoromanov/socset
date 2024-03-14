<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Регистрация</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form action="vendor/signup.php" method="POST" enctype="multipart/form-data">
		<label>ФИО</label>
		<input type="text" placeholder="Введите свое полное имя" name="full_name">
		<label>Логин</label>
		<input type="text" placeholder="Введите свой логин" name="login">
		<label>Почта</label>
		<input type="email" placeholder="Введите адрес своей почты" name="email">
		<label>Изображение профиля</label>
		<input type="file" name="avatar">
		<label>Пароль</label>
		<input type="password" placeholder="Введите свой пароль" name="password">
		<label>Подтверждение пароля</label>
		<input type="password" placeholder="Подтвердите пароль" name="password_confirm">
		<button type="submit">Регистрация</button>
		<p>
			У вас уже есть аккаунт? - <a href="index.php">авторизируйтесь</a>
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
