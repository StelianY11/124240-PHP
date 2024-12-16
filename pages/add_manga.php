<form class="border rounded p-4 w-50 mx-auto" method="POST" action="./handlers/handle_add_manga.php" enctype="multipart/form-data">
    <h3 class="text-center">Добави манга</h3>
    
    <div class="mb-3">
        <label for="title" class="form-label">Заглавие:</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    
    <div class="mb-3">
        <label for="author" class="form-label">Автор:</label>
        <input type="text" class="form-control" id="author" name="author" required>
    </div>
    
    <div class="mb-3">
        <label for="genre" class="form-label">Жанр:</label>
        <input type="text" class="form-control" id="genre" name="genre" required>
    </div>
    
    <div class="mb-3">
        <label for="description" class="form-label">Описание:</label>
        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
    </div>
    
    <div class="mb-3">
        <label for="price" class="form-label">Цена:</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
    </div>
    
    <div class="mb-3">
        <label for="image" class="form-label">Корица:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
    </div>
    
    <!-- Submit Button -->
    <button type="submit" class="btn btn-success mx-auto">Добави манга</button>
</form>
