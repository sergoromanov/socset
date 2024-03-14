<?php 
session_start();
 if(!isset($_SESSION["userId"])){
      header("Location: main.php");
      exit();
  }
$userId = $_SESSION['userId'];
$id=$_GET['id'];
$con=mysqli_connect('localhost','root','root','social');
$query=mysqli_query($con, "SELECT * FROM users WHERE id='$id'");
$query=mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Редактирование профиля</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form action="change.php" method="POST" enctype="multipart/form-data">
  	<input type="hidden" name="id" value="<?= $query['id']?>">
  	<label>ФИО</label>
  	<input type="text" name="full_name" value="<?= $query['full_name']?>">
  	<label>Почта</label>
  	<input type="email" name="email" value="<?= $query['email'] ?>">
  	<label>Логин</label>
  	<input type="text" name="login" value="<?= $query['login'] ?>">
  	<label>Пароль</label>
  	<input type="text" name="password" value="<?= $query['password'] ?>">
  	<label>Изображение профиля</label>
  	<input type="file" name="avatar">
  	<button type="submit">Редактировать</button>
</form>
</body>
</html>
