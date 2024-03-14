<?php
session_start();

$userId = $_GET['user_id'];
$friendId = $_GET['friend_id'];

$con = mysqli_connect('localhost', 'root', 'root', 'social');

// Получение данных пользователя
$userQuery = mysqli_query($con, "SELECT * FROM users WHERE id='$userId'");
$userData = mysqli_fetch_assoc($userQuery);

// Получение данных друга
$friendQuery = mysqli_query($con, "SELECT * FROM users WHERE id='$friendId'");
$friendData = mysqli_fetch_assoc($friendQuery);

// Получение сообщений для диалога
$messagesQuery = mysqli_query($con, "SELECT * FROM messages WHERE (sender_id='$userId' AND receiver_id='$friendId') OR (sender_id='$friendId' AND receiver_id='$userId') ORDER BY timestamp ASC");
$messages = [];
while ($message = mysqli_fetch_assoc($messagesQuery)) {
    $messages[] = $message;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Chatty - Диалог</title>
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
            width: 80%;
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

        .messages-container {
            margin-top: 20px;
        }

        .message-item {
            margin-bottom: 15px;
            overflow: hidden;
        }

        .sender,
        .receiver {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 5px;
            word-wrap: break-word;
        }

        .sender {
            background-color: #007bff;
            color: #fff;
            text-align: right;
        }

        .receiver {
            background-color: #f8f9fa;
            text-align: left;

        }

        .message-input {
            margin-top: 20px;
        }

        .btn-send {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="bg-white rounded messages-container">
                <h5>Диалог между <?= $userData['full_name'] ?> и <?= $friendData['full_name'] ?></h5>
                <div class="message-item">
                    <?php foreach ($messages as $message) { ?>
                        <?php if ($message['sender_id'] == $userId) { ?>
                            <div class="sender"><?= $message['message'] ?></div>
                        <?php } else { ?>
                            <div class="receiver"><?= $message['message'] ?></div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="message-input">
                    <form action="send_message.php" method="POST">
                        <input type="hidden" name="sender_id" value="<?= $userId ?>">
                        <input type="hidden" name="receiver_id" value="<?= $friendId ?>">
                        <textarea name="message" class="form-control" placeholder="Введите сообщение" required></textarea>
                        <button type="submit" class="btn btn-send">Отправить</button>
                    </form>
                </div>
                <a href="main.php?id=<?= $userId ?>" class="btn btn-secondary mt-3">Назад</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>