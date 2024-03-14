<?php
session_start();

// Подключение к базе данных
$conn = mysqli_connect('localhost', 'root', 'root', 'social');

// Получение ID поста из параметра запроса post_id
$post_id = $_GET['post_id'];

// Удаление поста из базы данных
$sql = "DELETE FROM post WHERE id='$post_id'";
mysqli_query($conn, $sql);

// Перенаправление на страницу списка постов
header("Location: main.php?id=" . $_SESSION['user']['id']);
?>