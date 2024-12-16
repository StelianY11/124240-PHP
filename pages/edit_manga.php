<?php
    $manga_id = intval($_GET['id'] ?? 0);

    if ($manga_id > 0) {
        $query = "SELECT * FROM mangas WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $manga_id]);
        $manga = $stmt->fetch();
    }
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирай Манга</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Редактиране на Манга</h2>
        
        <!-- Display flash message -->
        <?php if (isset($_SESSION['flash']['message'])): ?>
            <div class="alert alert-<?php echo htmlspecialchars($_SESSION['flash']['message']['type']) ?>">
                <?php echo htmlspecialchars($_SESSION['flash']['message']['text']); ?>
            </div>
            <?php unset($_SESSION['flash']['message']); ?>
        <?php endif; ?>
        
        <form class="border rounded p-4 w-50 mx-auto" method="POST" action="./handlers/handle_edit_manga.php" enctype="multipart/form-data">
            <h3 class="text-center">Редактирай манга</h3>
            
            <div class="mb-3">
                <label for="title" class="form-label">Заглавие:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($manga['title'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">Автор:</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($manga['author'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Жанр:</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?php echo htmlspecialchars($manga['genre'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание:</label>
                <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($manga['description'] ?? '') ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Цена:</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($manga['price'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Изображение:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <div class="mb-3">
                <?php if (isset($manga['image']) && !empty($manga['image'])): ?>
                    <img class="img-fluid" src="uploads/<?php echo htmlspecialchars($manga['image']) ?>" alt="<?php echo htmlspecialchars($manga['title']) ?>">
                <?php else: ?>
                    <p>Няма изображение за тази манга.</p>
                <?php endif; ?>
            </div>

            <input type="hidden" name="id" value="<?php echo $manga['id'] ?>">

            <button type="submit" class="btn btn-success mx-auto">Редактирай</button>
        </form>
    </div>
    
    <script src="path/to/bootstrap.bundle.min.js"></script>
</body>
</html>
