<?php require 'template-parts/header.php'; ?>
<div class="container">
    <h2>Upload file</h2>
    <pre><?php print_r($data); ?></pre>

    <div class="custom-file">
        <input type="file" class="custom-file-input" id="validatedCustomFile" required>
        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
        <div class="invalid-feedback">Example invalid custom file feedback</div>
    </div>
</div>

<?php require_once 'template-parts/footer.php';?>
