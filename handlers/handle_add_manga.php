<?php

require_once('../functions.php');
require_once('../db.php');

if (!is_admin()) {
    $_SESSION['flash']['message']['type'] = 'warning';
    $_SESSION['flash']['message']['text'] = 'Нямате достъп до тази страница!';
    header('Location: ../index.php?page=home');
    exit;
}

$title = trim($_POST['title'] ?? '');
$author = trim($_POST['author'] ?? '');  
$genre = trim($_POST['genre'] ?? '');  
$description = trim($_POST['description'] ?? ''); 
$price = trim($_POST['price'] ?? '');

if (mb_strlen($title) == 0 || mb_strlen($price) == 0 || mb_strlen($author) == 0 || mb_strlen($genre) == 0 || mb_strlen($description) == 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Моля попълнете всички полета!';
    header('Location: ../index.php?page=add_manga');
    exit;
}

if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Моля изберете изображение!';
    header('Location: ../index.php?page=add_manga');
    exit;
}

$new_filename = time() . '_' . $_FILES['image']['name'];
$upload_dir = '../uploads/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0775, true);
}

if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Възникна грешка при качването на файла!';
    header('Location: ../index.php?page=add_manga');
    exit;
} else {
    $query = "INSERT INTO mangas (title, author, genre, description, price, image) VALUES (:title, :author, :genre, :description, :price, :image)";
    $stmt = $pdo->prepare($query);
    $params = [
        ':title' => $title,
        ':author' => $author,
        ':genre' => $genre,
        ':description' => $description,
        ':price' => $price,
        ':image' => $new_filename
    ];

    if ($stmt->execute($params)) {
        $_SESSION['flash']['message']['type'] = 'success';
        $_SESSION['flash']['message']['text'] = 'Манга е добавена успешно!';
        header('Location: ../index.php?page=mangas');
        exit;
    } else {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = 'Възникна грешка при добавянето на манга!';
        header('Location: ../index.php?page=add_manga');
        exit;
    }
}
?>
