<?php require 'template-parts/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="card" style="width: 70%;">
            <?php if(isset($data['title']) && !empty($data['title'])): ?>
                <div class="card-header">
                    <?= $data['title'] ?>
                </div>
            <?php endif; ?>
            <div class="card-body">
                <?php if(isset($data['release_date']) && !empty($data['release_date'])): ?>
                    <h5 class="card-title">Year: <?= $data['release_date'] ?></h5>
                <?php endif; ?>
                <?php if(isset($data['actors'])  && !empty($data['actors'])): ?>
                    <p class="card-text">Cast: <?= $data['actors'] ?></p>
                <?php endif; ?>
                <?php if(isset($data['format']) && !empty($data['format'])): ?>
                    <p class="card-text">Format: <?= $data['format'] ?></p>
                <?php endif; ?>
                <a href="/movies/list" class="btn btn-primary">List of all movies</a>
            </div>
        </div>
    </div>
</div>
<?php require_once 'template-parts/footer.php';?>