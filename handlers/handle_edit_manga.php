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
$price = trim($_POST['price'] ?? '');
$author = trim($_POST['author'] ?? '');
$description = trim($_POST['description'] ?? '');
$manga_id = intval($_POST['id'] ?? 0);

if (mb_strlen($title) == 0 || mb_strlen($price) == 0 || mb_strlen($author) == 0 || mb_strlen($description) == 0 || $manga_id <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Моля попълнете всички полета!';
    header('Location: ../index.php?page=edit_manga&id=' . $manga_id);
    exit;
}

$img_uploaded = false;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $new_filename = time() . '_' . $_FILES['image']['name'];
    $upload_dir = '../uploads/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0775, true);
    }

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = 'Възникна грешка при качването на файла!';
        header('Location: ../index.php?page=edit_manga&id=' . $manga_id);
        exit;
    } else {
        $img_uploaded = true;
    }
}

$query = '';
if ($img_uploaded) {
    $query = "
        UPDATE mangas
        SET title = :title, price = :price, author = :author, description = :description, image = :image
        WHERE id = :id
    ";
} else {
    $query = "
        UPDATE mangas
        SET title = :title, price = :price, author = :author, description = :description
        WHERE id = :id
    ";
}

$stmt = $pdo->prepare($query);
$params = [
    ':title' => $title,
    ':price' => $price,
    ':author' => $author,
    ':description' => $description,
    ':id' => $manga_id
];

if ($img_uploaded) {
    $params[':image'] = $new_filename;
}

if ($stmt->execute($params)) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = 'Манга е редактирана успешно!';
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Възникна грешка при редакцията на манга!';
}

header('Location: ../index.php?page=edit_manga&id=' . $manga_id);
exit;

?>
