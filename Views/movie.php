<?php require 'template-parts/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="card" style="width: 70%;">
            <div class="card-header">
                <?= $data['title'] ?>
            </div>
            <div class="card-body">
                <h5 class="card-title">Year <?= $data['release_date'] ?></h5>
                <p class="card-text">Cast: <?= $data['actors'] ?></p>
                <p class="card-text">Format: <?= $data['format'] ?></p>
                <a href="/movies/list" class="btn btn-primary">List of all movies</a>
            </div>
        </div>
    </div>
</div>
<?php require_once 'template-parts/footer.php';?>