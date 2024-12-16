<?php

require_once('../functions.php');
require_once('../db.php');

if (!is_admin()) {
    $_SESSION['flash']['message']['type'] = 'warning';
    $_SESSION['flash']['message']['text'] = 'Нямате достъп до тази страница!';
    header('Location: ../index.php?page=home');
    exit;
}

$manga_id = intval($_POST['id'] ?? 0); 

if ($manga_id == 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Невалидна манга!'; 

    header('Location: ../index.php?page=mangas');
    exit;
}

$query = "DELETE FROM mangas WHERE id = :id"; 
$stmt = $pdo->prepare($query);
if ($stmt->execute([':id' => $manga_id])) { 
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = 'Манга е изтрита успешно!'; 
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Възникна грешка при изтриването на манга!';
}

header('Location: ../index.php?page=mangas'); 
exit;

?>
