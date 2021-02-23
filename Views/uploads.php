<?php require 'template-parts/header.php'; ?>
<div class="container">
    <h2>Upload file</h2>
    <div class="alert alert-danger" role="alert" id="error-message" style="display: none">
        <?= $errorMessage ?? '' ?>
    </div>

    <div class="custom-file">
        <input type="file" class="custom-file-input" id="uploads" required>
        <label class="custom-file-label" for="uploads">Choose file...</label>
        <div class="invalid-feedback"><?= $error ?? '' ?></div>
    </div>

    <input id="uploadDoc" type="file" name="sortpic" />
    <button id="upload">Upload</button>
</div>

<?php require_once 'template-parts/footer.php';?>
