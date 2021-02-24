<?php require 'template-parts/header.php'; ?>
    <div class="container">
        <h2>Home</h2>
        <div class="row">
            <div class="list-group">
                <a href="/movies/list" class="list-group-item list-group-item-action flex-column align-items-start active">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List of all movies</h5>
                    </div>
                </a>
                <a href="/movies/add" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Add new movie</h5>
                    </div>
                </a>
                <a href="/movies/upload" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Upload movies</h5>

                    </div>
                    <p class="mb-1">Supported upload format - Microsoft Word .docx</p>
                </a>
            </div>
        </div>
    </div>


<?php require_once 'template-parts/footer.php';?>