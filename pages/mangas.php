<?php
    // страница продукти
    $mangas = [];

    $search = $_GET['search'] ?? '';

    // правим заявка към базата данни
    $query = "SELECT * FROM mangas WHERE title LIKE :search";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':search' => "%$search%"]);
    while ($row = $stmt->fetch()) {
        $fav_query = "SELECT id FROM favorite_mangas_users WHERE user_id = :user_id AND manga_id = :manga_id";
        $fav_stmt = $pdo->prepare($fav_query);
        $fav_params = [
            ':user_id' => $_SESSION['user_id'] ?? 0,
            ':manga_id' => $row['id']
        ];
        $fav_stmt->execute($fav_params);
        $row['is_favorite'] = $fav_stmt->fetch() ? 1 : 0;

        $mangas[] = $row;
    }
?>

<div class="row">
    <form class="mb-4" method="GET">
        <div class="input-group">
            <input type="hidden" name="page" value="mangas">
            <input type="text" class="form-control" placeholder="Търси манга" name="search" value="<?php echo htmlspecialchars($search) ?>">
            <button class="btn btn-primary" type="submit">Търсене</button>
        </div>
    </form>

    <?php if (isset($_COOKIE['last_search'])): ?>
        <div class="alert alert-info" role="alert">
            Последно търсене: <?php echo htmlspecialchars($_COOKIE['last_search']); ?>
        </div>
    <?php endif; ?>
</div>

<?php
if (count($mangas) == 0) {
    echo '<div class="alert alert-warning" role="alert">Няма намерени манга</div>';
} else {
    echo '<div class="d-flex flex-wrap justify-content-between">';

    foreach ($mangas as $manga) {
        $fav_btn = '';
        $edit_delete_buttons = '';

        if (isset($_SESSION['user_name'])) {
            $fav_btn = $manga['is_favorite'] == 0
                ? '<div class="card-footer text-center"><button class="btn btn-primary btn-sm add-favorite" data-manga="' . $manga['id'] . '">Add to Favorites</button></div>'
                : '<div class="card-footer text-center"><button class="btn btn-danger btn-sm remove-favorite" data-manga="' . $manga['id'] . '">Remove from Favorites</button></div>';
        }

        if (is_admin()) {
            $edit_delete_buttons = '
                <div class="card-header d-flex flex-row justify-content-between">
                    <a href="?page=edit_manga&id=' . $manga['id'] . '" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="./handlers/handle_delete_manga.php">
                        <input type="hidden" name="id" value="' . $manga['id'] . '">
                        <button type="submit" class="btn btn-sm btn-danger">Изтрий</button>
                    </form>
                </div>';
        }

        echo '
            <div class="card mb-4" style="width: 18rem;">
                ' . $edit_delete_buttons . '
                <img src="uploads/' . htmlspecialchars($manga['image']) . '" class="card-img-top" alt="Manga Image">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($manga['title']) . '</h5>
                    <p class="card-text"><strong>Author:</strong> ' . htmlspecialchars($manga['author']) . '</p>
                    <p class="card-text"><strong>Genre:</strong> ' . htmlspecialchars($manga['genre']) . '</p>
                    <p class="card-text"><strong>Description:</strong> ' . htmlspecialchars($manga['description']) . '</p>
                    <p class="card-text"><strong>Price:</strong> ' . htmlspecialchars($manga['price']) . ' лв.</p>
                </div>
                ' . $fav_btn . '
            </div>';
    }

    echo '</div>';
}
?>
