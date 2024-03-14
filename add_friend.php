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

// Проверка наличия записи в таблице friends
$query = "SELECT * FROM friends WHERE (user_id = $userId AND friend_id = $friendId) OR (user_id = $friendId AND friend_id = $userId)";
$result = mysqli_query($con, $query);

// Проверка успешности запроса
if (!$result) {
    die('Ошибка выполнения запроса: ' . mysqli_error($con));
}

// Проверка наличия записи в таблице friends
if (mysqli_num_rows($result) == 0) {
    // Если записи ещё нет, добавляем друзей в таблицу
    $insertQuery = "INSERT INTO friends (user_id, friend_id) VALUES ($userId, $friendId)";
    if (mysqli_query($con, $insertQuery)) {
        // Дополнительные действия или редирект
        header("Location: friends.php?id=$userId");
        exit();
    } else {
        die('Ошибка выполнения запроса: ' . mysqli_error($con));
    }
} else {
    // Если запись уже существует, вы можете предпринять необходимые действия
    echo "Эти пользователи уже друзья.";
}

// Закрытие соединения с базой данных
mysqli_close($con);
?>
