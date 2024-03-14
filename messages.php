<?php
session_start();

$userId = $_GET['id'];
$con = mysqli_connect('localhost', 'root', 'root', 'social');

// Получение списка друзей
$friendsQuery = mysqli_query($con, "SELECT * FROM friends WHERE user_id='$userId'");
$friends = [];
while ($friend = mysqli_fetch_assoc($friendsQuery)) {
    $friendId = $friend['friend_id'];
    $friendDataQuery = mysqli_query($con, "SELECT * FROM users WHERE id='$friendId'");
    $friendData = mysqli_fetch_assoc($friendDataQuery);
    $friends[] = $friendData;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Chatty - Сообщения</title>
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
            width: 60%;
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
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .messages-column {
            flex: 1;
            margin-right: 20px;
        }

        .messages-column h5,
        .messages-column p {
            text-align: center;
            margin-bottom: 15px;
        }

        .messages-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .message-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .message-item img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .message-item a {
            text-decoration: none;
            color: #333;
        }

        .send-message-link {
            color: green;
            cursor: pointer;
            text-decoration: none;
            margin-left: auto;
        }

        .go-to-dialog-link {
            color: blue;
            text-decoration: none;
            margin-left: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <!-- Середина -->
        <div class="col-12">
            <div class="bg-white rounded messages-container">
                <div class="messages-column">
                    <h5>Друзья</h5>
                    <?php if (count($friends) > 0) { ?>
                        <ul class="messages-list">
                            <?php foreach ($friends as $friend) { ?>
                                <li class="message-item">
                                    <img src="<?= $friend['avatar'] ?>" alt="<?= $friend['full_name'] ?>">
                                    <a href="#" class="head"><?= $friend['full_name'] ?></a>
                                    <!-- Отправить сообщение другу -->
                                    <a class="send-message-link"
                                       href="message_form.php?user_id=<?= $userId ?>&friend_id=<?= $friend['id'] ?>">Отправить сообщение</a>
                                    <!-- Перейти к диалогу -->
                                    <a class="go-to-dialog-link"
                                       href="dialog.php?user_id=<?= $userId ?>&friend_id=<?= $friend['id'] ?>">Перейти к диалогу</a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p>У вас пока нет друзей.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>