<?php
session_start();
$userId = $_GET['id'];
$con = mysqli_connect('localhost', 'root', 'root', 'social');

// Получение всех пользователей, кроме текущего
$allUsersQuery = mysqli_query($con, "SELECT * FROM users WHERE id != '$userId'");
$allUsers = [];
while ($user = mysqli_fetch_assoc($allUsersQuery)) {
    $allUsers[] = $user;
}

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
    <title>Chatty - Друзья</title>
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

        .friends-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .friends-column {
            flex: 1;
            margin-right: 20px;
        }

        .friends-column h5,
        .friends-column p {
            text-align: center;
            margin-bottom: 15px;
        }

        .friends-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .friend-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .friend-item img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .friend-item a {
            text-decoration: none;
            color: #333;
        }

        .add-friend-link {
            color: green;
            cursor: pointer;
            text-decoration: none;
            margin-left: auto;
        }
        
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <!--левая колонка-->
        <div class="col-4">
            <div class="bg-white rounded">
                <!-- Отображение друзей -->
                <h5>Друзья</h5>
<?php if (count($friends) > 0) { ?>
    <ul class="friends-list">
        <?php foreach ($friends as $friend) { ?>
            <li class="friend-item">
                <img src="<?= $friend['avatar'] ?>" alt="<?= $friend['full_name'] ?>">
                <a href="#" class="head"><?= $friend['full_name'] ?></a>
                <!-- Удалить друга -->
                <a class="add-friend-link" href="delete_friend.php?user_id=<?= $userId ?>&friend_id=<?= $friend['id'] ?>">Удалить друга</a>
            </li>
        <?php } ?>
    </ul>
<?php } else { ?>
    <p>У вас пока нет друзей.</p>
<?php } ?>
<a href="main.php?id=<?= $userId ?>" class="btn btn-secondary">Назад</a>
            </div>
        </div>
        <!-- Вкладка "Возможные друзья" -->
        <div class="col-8">
            <div class="bg-white rounded friends-container">
                <div class="friends-column">
                    <h5>Возможные друзья</h5>
                    <?php if (count($allUsers) > 0) { ?>
                        <ul class="friends-list">
                            <?php foreach ($allUsers as $user) { ?>
                                <li class="friend-item">
                                    <img src="<?= $user['avatar'] ?>" alt="<?= $user['full_name'] ?>">
                                    <a href="#" class="head"><?= $user['full_name'] ?></a>
                                    <!-- Добавить в друзья -->
                                    <a class="add-friend-link"
                                       href="add_friend.php?user_id=<?= $userId ?>&friend_id=<?= $user['id'] ?>">Добавить в друзья</a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p>Нет возможных друзей.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>