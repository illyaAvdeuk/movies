<?php require 'template-parts/header.php'; ?>

<div class="container">
    <h2>Upload file</h2>
    <div class="alert alert-danger" role="alert" id="error-message" style="display: none">
        <?= $errorMessage ?? '' ?>
    </div>
    <div class="custom-file">
        <label class="custom-file-label" for="uploads">Choose file...</label>
        <input id="uploadDoc" class="custom-file-input" type="file" name="sortpic" />
        <div class="col text-center" style="height: 4rem;  line-height:4rem;">
            <button style="vertical-align: middle" class="btn btn-primary" id="upload">Upload</button>
        </div>
    </div>
</div>

<?php require_once 'template-parts/footer.php';?>
