<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senderId = $_POST['sender_id'];
    $receiverId = $_POST['receiver_id'];
    $messageText = $_POST['message'];

    // Сохраняем сообщение в базе данных
    $con = mysqli_connect('localhost', 'root', 'root', 'social');

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$senderId', '$receiverId', '$messageText')";

    if (mysqli_query($con, $query)) {
        // После успешной вставки, перенаправляем на страницу dialog.php
        header("Location: dialog.php?user_id={$senderId}&friend_id={$receiverId}");
        exit();
    } else {
        echo "Ошибка при отправке сообщения: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>