<?php
require_once('./functions.php');
require_once('./db.php');

$page = $_GET['page'] ?? 'home';

$flash = [];
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

$admin_pages = ['add_manga', 'edit_manga'];

if (!is_admin() && in_array($page, $admin_pages)) {
    $_SESSION['flash']['message']['type'] = 'warning';
    $_SESSION['flash']['message']['text'] = 'You do not have access to this page!';
    header('Location: ./index.php?page=home');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="./index.css" rel="stylesheet">

</head>
<body >
    <script>
        $(function() {
            $(document).on('click', '.add-favorite', function() {
                let btn = $(this);
                let mangaId = btn.data('manga');

                $.ajax({
                    url: './ajax/add_favorite.php',
                    method: 'POST',
                    data: {
                        manga_id: mangaId
                    },
                    success: function(response) {

                        let res = JSON.parse(response);

                        if (res.success) {
                            Swal.fire({
                                title: 'Manga added to favorites!',
                                icon: 'success',
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 8000,
                                timerProgressBar: true
                            });
                            let removeBtn = $('<button class="btn btn-danger btn-sm remove-favorite" data-manga="' + mangaId + '">Remove from Favorites</button>');
                            btn.replaceWith(removeBtn);
                        } else {
                            Swal.fire({
                                title: 'Error: ' + res.error,
                                icon: 'error',
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 8000,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            $(document).on('click', '.remove-favorite', function() {
                let btn = $(this);
                let mangaId = btn.data('manga');

                $.ajax({
                    url: './ajax/remove_favorite.php',
                    method: 'POST',
                    data: {
                        manga_id: mangaId
                    },
                    success: function(response) {
                        let res = JSON.parse(response);

                        if (res.success) {
                            Swal.fire({
                                title: 'Manga removed from favorites!',
                                icon: 'success',
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 8000,
                                timerProgressBar: true
                            });
                            let addBtn = $(`<button class="btn btn-primary btn-sm add-favorite" data-manga="${mangaId}">Add to Favorites</button>`);
                            btn.replaceWith(addBtn);
                        } else {
                            Swal.fire({
                                title: 'Error: ' + res.error,
                                icon: 'error',
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 8000,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">Manga Store</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($page == 'home' ? 'active' : ''); ?>" aria-current="page" href="?page=home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($page == 'manga' ? 'active' : ''); ?>" href="?page=mangas">Manga</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($page == 'contacts' ? 'active' : ''); ?>" href="?page=contacts">Contacts</a>
                        </li>
                        <?php
                            if (is_admin()) {
                                echo '
                                    <li class="nav-item">
                                        <a class="nav-link ' . ($page == 'add_manga' ? 'active' : '') . '" href="?page=add_manga">Add Manga</a>
                                    </li>
                                ';
                            }
                        ?>
                    </ul>
                    <div class="d-flex flex-row gap-3">
                        <?php
                            if (isset($_SESSION['user_name'])) {
                                echo '<span class="text-white">Hello, ' . htmlspecialchars($_SESSION['user_name']) . '</span>';
                                echo '
                                    <form method="POST" action="./handlers/handle_logout.php" class="m-0">
                                        <button type="submit" class="btn btn-outline-light">Logout</button>
                                    </form>
                                ';
                            } else {
                                echo '<a href="?page=login" class="btn btn-outline-light">Login</a>';
                                echo '<a href="?page=register" class="btn btn-outline-light">Register</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="container py-4" style="min-height:80vh;">
        <?php
            if (isset($flash['message'])) {
                $type_icons = [
                    'success' => 'success',
                    'danger' => 'error',
                    'warning' => 'warning',
                ];

                echo '
                    <script>
                        Swal.fire({
                            title: "' . $flash['message']['text'] . '",
                            icon: "' . $type_icons[$flash['message']['type']] . '",
                            toast: true,
                            position: "top",
                            showConfirmButton: false,
                             timer: 8000,
                            timerProgressBar: true
                        });
                    </script>
                ';
            }

            $page_file = './pages/' . $page . '.php';
            if (file_exists($page_file)) {
                require_once($page_file);
            } else {
                echo '<h1 class="text-center">404 - Page not found</h1>';
            }
        ?>
    </main>
    <footer class="bg-dark text-white text-center py-3">
        <p class="m-0">© 2024 Manga Store. All rights reserved.</p>
    </footer>
</body>
</html>
