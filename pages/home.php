<?php
?>
<div class="row align-items-center justify-content-center rounded-3">
    <div class="col-lg-7 p-4 p-lg-5 pt-lg-3">
        <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-4">Най-добрите оферти за манга!</h1>
        <p class="lead mb-4 fs-4">Изберете от нашата широка гама манга. Намерете нови заглавия и класики от любими жанрове. Открийте света на мангата днес!</p>
        <a href="index.php?page=mangas" class="btn btn-manga btn-lg px-4 py-3 rounded-pill">Разгледайте мангите</a>
    </div>
    <div class="col-12 p-0 shadow-lg rounded-lg">
        <img class="img-fluid rounded-lg-3" src="uploads\mangas.jpg" alt="Манга книги" style="object-fit: cover; height: 400px; width: 100%;">
    </div>
</div>

<style>
    .btn-manga {
        background-color: #ff6347;
        color: #fff;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-manga:hover {
        background-color: #e5533f; 
        color: #fff;
        text-decoration: none;
    }

    .btn-manga:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(255, 99, 71, 0.5);
    }

    @media (max-width: 992px) {
        .row {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
