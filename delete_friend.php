<?php
session_start();

$userId = $_GET['user_id'];
$friendId = $_GET['friend_id'];

// Подключение к базе данных
$con = mysqli_connect('localhost', 'root', 'root', 'social');

// Проверка подключения
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Удаление друга из таблицы friends
$deleteQuery = "DELETE FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
$stmt = mysqli_prepare($con, $deleteQuery);

// Привязка параметров
mysqli_stmt_bind_param($stmt, 'iiii', $userId, $friendId, $friendId, $userId);

if (mysqli_stmt_execute($stmt)) {
    // Дополнительные действия или редирект
    header("Location: friends.php?id=$userId");
    exit();
} else {
    die('Ошибка выполнения запроса: ' . mysqli_error($con));
}

// Закрытие соединения с базой данных
mysqli_close($con);
?>