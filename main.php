<?php
session_start();
$id = $_GET['id'];
$con = mysqli_connect('localhost', 'root', 'root', 'social');
$query = mysqli_query($con, "SELECT * FROM users WHERE id='$id'");
$result = $query->fetch_assoc();
$_SESSION['user'] = [
    'id' => $result['id'],
    'full_name' => $result['full_name'],
    'email' => $result['email'],
    'avatar' => $result['avatar'],
];
$userId = $_GET['id'];
$_SESSION['userId'] = $userId;
$friendsCountQuery = mysqli_query($con, "SELECT COUNT(*) as friends_count FROM friends WHERE user_id='$userId'");
$friendsCountData = mysqli_fetch_assoc($friendsCountQuery);
$friendsCount = $friendsCountData['friends_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Chatty</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style type="text/css">
        body {
            background-color: #f8f9fa;
        }

        .container-fluid {
            padding-top: 20px;
            padding-bottom: 20px;
            background-color: #ffffff;
        }

        .profile-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 20px;
        }

        .profile-image {
            width: 100%;
            height: auto;
        }

        .profile-info {
            padding: 15px;
        }

        .profile-info a {
            text-decoration: none;
            color: #212529;
        }

        .topics {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 20px;
        }

        .tweet-form {
            margin-top: 20px;
        }

        .tweet-form button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .tweet-list {
            margin-top: 20px;
        }

        .tweet {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
            padding: 15px;
        }

        .tweet img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .tweet h5 a {
            text-decoration: none;
            color: #212529;
        }

        .tweet p {
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .tweet img.tweet-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .tweet .actions img {
            margin-right: 10px;
        }

        .friends {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 20px;
            padding: 15px;
        }

        .friend-list {
            margin-top: 20px;
        }

        .friend {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .friend img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .friend h5 a {
            text-decoration: none;
            color: #212529;
        }

        .friend .actions button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .right-column {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 20px;
            padding: 15px;
        }

        .right-column h2 {
            margin-bottom: 20px;
        }

        .right-column img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .right-column p {
            margin-top: 10px;
        }
        .profile-card {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .profile-image {
        width: 100%;
        border-radius: 50%;
    }

    .profile-info {
        margin-top: 15px;
    }

    .head {
        color: #333;
        font-weight: bold;
        text-decoration: none;
        font-size: 20px;
    }

    .topics {
        margin-top: 20px;
    }

    .topics a {
        display: block;
        margin-bottom: 10px;
        color: #333;
        text-decoration: none;
        font-size: 16px;
        transition: color 0.3s ease;
    }

    .topics a:hover {
        color: #007bff;
    }

    .log {
        color: red;
        font-size: 16px;
    }
    </style>
</head>
<body>
<div class="container-fluid">
</div>
<div class="container">
    <div class="row">
        <!--левая колонка-->
        <div class="col-lg-3">
            <div class="profile-card">
                <div>
                    <img src="<?= $_SESSION['user']['avatar'] ?>" class="profile-image">
                </div>

                <div class="profile-info">
                    <div>
                        <a href="#" class="head"><?= $_SESSION['user']['full_name'] ?></a>
                    </div>
                    <div>
                        <a href="#"><?= $_SESSION['user']['email'] ?></a>
                    </div>
                </div>
            </div>

            <!--topics-->
            <div class="topics">
                <a href="vendor/logout.php" class="log">Выход</a>
                <a href="update.php?id=<?php echo $userId; ?>">Редактирование профиля</a>
                <a href="friends.php?id=<?php echo $userId; ?>">Друзья (<?php echo $friendsCount; ?>)</a>
                <a href="messages.php?id=<?php echo $userId; ?>">Сообщения</a>
            </div>
        </div>

        <!---middle колонка--->
        <div class="col-lg-6">
            <div class="topics tweet-form">
                <div class="row">
                    <div class="col-2">
                        <img src="<?= $_SESSION['user']['avatar'] ?>" class="rounded-circle w-100">
                    </div>
                    <div class="col-10">
                        <form action="tweet.php" enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="nick" value="<?php echo $result['login'] ?>">
                            <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                            <input name="img" type="file">
                            <input type="text" name="text" placeholder="Что у вас нового?">
                            <button type="submit">Добавить</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="tweet-list">
    <?php
    $query = mysqli_query($con, 'SELECT * FROM post ORDER BY id DESC');
    ?>
    <?php while ($post = $query->fetch_assoc()) { ?>
        <?php
        $authorId = $post['author_id'];
        $postId = $post['id'];

        $userResult = mysqli_query($con, "SELECT * FROM users WHERE id=$authorId");
        $user = mysqli_fetch_assoc($userResult);
        $avatar = $user['avatar'];
        ?>

        <div class="tweet">
            <div class="row">
                <div class="col-2">
                    <img src="<?= $avatar ?>" class="rounded-circle w-100">
                </div>
                <div class="col-10">
                    <div class="row">
                        <h5>
                            <a href="#" class="text-dark"><?= $post['name'] ?></a>
                        </h5>
                    </div>

                    <?php if (!empty($post['img'])) { ?>
                        <div>
                            <img src="<?= $post['img'] ?>" class="w-100 rounded tweet-image">
                        </div>
                    <?php } ?>
                    <div>
                        <h3><?= $post['text'] ?></h3>
                    </div>
                    <div class="actions row">
                        <div class="col-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-heart" viewBox="0 0 16 16">
                                <path
                                    d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                            </svg>
                        </div>
                        <div class="col-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-chat" viewBox="0 0 16 16">
                                <path
                                    d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
                            </svg>
                        </div>
                        <div class="col-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-arrow-90deg-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                      d="M14.854 4.854a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 4H3.5A2.5 2.5 0 0 0 1 6.5v8a.5.5 0 0 0 1 0v-8A1.5 1.5 0 0 1 3.5 5h9.793l-3.147 3.146a.5.5 0 0 0 .708.708z"/>
                            </svg>
                        </div>
                        <!-- Добавленные кнопки для удаления и редактирования -->
                        <?php if ($userId == $authorId) { ?>
                            <div class="col-3">
                                <a href="delete.php?post_id=<?= $postId ?>" class="btn btn-danger btn-sm">Удалить</a>
                            </div>
                       <?php } ?>
                    </div>
                </div>
                
            </div>
        </div>
    <?php } ?>
</div>
        </div>

        <!---right колонка--->
        <div class="col-lg-3">
            <div class="right-column">
                <div class="row ml-2">
                    <h2>Chatty</h2>
                </div>
                <div class="row">
                    <div class="col-4">
                        <img src="images/1.jpeg" class="rounded-circle w-100 ">
                    </div>
                    <div class="col-8">
                        <h4>Welcome to Chatty</h4>
                        <p class="text-secondary">@chatty</p>
                    </div>
                </div>
            </div>
            <div class="right-column mt-1">
                The best social network...ever
            </div>
        </div>
    </div>
</div>
</body>
</html>
