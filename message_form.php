<?php
session_start();

if (!isset($_GET['user_id']) || !isset($_GET['friend_id'])) {
    // Перенаправляем на страницу с сообщениями, если не указаны необходимые параметры
    header("Location: messages.php?id={$_SESSION['userId']}");
    exit();
}

$userId = $_GET['user_id'];
$friendId = $_GET['friend_id'];

// Проверяем, является ли пользователь другом
$con = mysqli_connect('localhost', 'root', 'root', 'social');
$checkFriendQuery = mysqli_query($con, "SELECT * FROM friends WHERE user_id='$userId' AND friend_id='$friendId'");
if (mysqli_num_rows($checkFriendQuery) === 0) {
    // Перенаправляем на страницу с сообщениями, если пользователь не является другом
    header("Location: messages.php?id={$userId}");
    exit();
}

// Здесь можно добавить дополнительную логику, например, сохранение сообщения в базе данных

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Chatty - Написать сообщение</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style type="text/css">
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            width: 40%;
            margin-top: 20px;
        }

        .bg-white {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .log {
            color: red;
        }

        .head {
            color: #333;
            font-weight: bold;
            text-decoration: none;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="bg-white rounded">
        <h2>Написать сообщение</h2>
        <form action="send_message.php" method="post">
            <input type="hidden" name="sender_id" value="<?= $userId ?>">
            <input type="hidden" name="receiver_id" value="<?= $friendId ?>">

            <div class="form-group">
                <label for="message">Сообщение:</label>
                <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Отправить</button>
            </div>
        </form>

        <a href="messages.php?id=<?= $userId ?>" class="btn btn-secondary">Назад</a>
    </div>
</div>
</body>
</html>