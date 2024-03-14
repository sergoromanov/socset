<?php 	
session_start();
$userId = $_SESSION['userId'];
$id=$_POST['id'];
$full_name=$_POST['full_name'];
$email=$_POST['email'];
$login=$_POST['login'];
$password=$_POST['password'];
$con=mysqli_connect('localhost','root','root','social');
$path = 'uploads/'.time().$_FILES['avatar']['name'];
if(move_uploaded_file($_FILES['avatar']['tmp_name'], $path)) {
    mysqli_query($con, "UPDATE users SET full_name='$full_name', email='$email', login='$login', password='$password', avatar='$path' WHERE id='$id'");
    header('Location: main2.php?id='.$_POST['id'].'&updated=1');
} else {
    echo 'Ошибка при загрузке изображения.';
}
 ?>
