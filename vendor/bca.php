<?php
session_start();
$userId = $_SESSION['userId'];
$connect = mysqli_connect('localhost', 'root', 'root', 'social');

if(isset($_POST['change'])) {
    $id = $_POST['change'];
    $result = mysqli_query($connect, "SELECT * FROM post WHERE id=$id");
    $post = mysqli_fetch_assoc($result);
    ?>

    <form action="bca.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <textarea name="text"><?php echo $post['text'] ?></textarea>
        <input type="submit" value="Сохранить">
    </form>

    <?php
} elseif(isset($_POST['id']) && isset($_POST['text'])) {
    $id = $_POST['id'];
    $text = $_POST['text'];
    mysqli_query($connect, "UPDATE post SET text='$text' WHERE id=$id");
    echo "Текст поста успешно изменен!";
}
?>

<a href="../main.php?id=<?php echo $userId; ?>">Вернуться на главную</a>

<?php
if(isset($_POST['submit'])) {
    header("Location: ../main.php?id=" . $userId);
    exit();
}
?> 