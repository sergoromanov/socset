<?php
session_start();
$userId = $_SESSION['userId'];
// Проверяем, есть ли `id` пользователя в GET-запросе
if(isset($_GET['id'])) {
    $userId = $_GET['id'];
    // Сохраняем `id` пользователя в сессии
    $_SESSION['userId'] = $userId;
} else {
    // Если `id` пользователя не передан, редиректим на страницу ошибки или на главную страницу
    header('Location: error.php');
    exit();
}
$connect = mysqli_connect('localhost', 'root', 'root', 'social');

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($connect, "SELECT * FROM users WHERE id='$id'");
    $user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Мой профиль</title>
</head>
<body>
    <h1>Мой профиль</h1>
    <img src="<?php echo $user['avatar']; ?>" alt="Мое изображение профиля" width="200px">
    <p>
        Имя: <?php echo $user['full_name']; ?><br>
        Электронная почта: <?php echo $user['email']; ?>
    </p>
    <?php
        if(isset($_GET['updated']) && $_GET['updated'] == 1) {
            echo "<p style='color:green;'>Данные профиля успешно обновлены!</p>";
        }
    ?>
    <form action="main.php?id=<?php echo $id; ?>&rand=<?php echo rand(); ?>" method="post">
    <input type="submit" value="Вернуться на главную" name="submit">
</form>

<?php
if(isset($_POST['submit'])) {
    header("Location: main.php?id=$id&updated=1");
    exit();
}
?>
</body>
</html>

<?php
} else {
    echo "ID пользователя не найден!";
}
?>