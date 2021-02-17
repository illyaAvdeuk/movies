<?php require 'template-parts/header.php'; ?>
    <link rel="stylesheet" href="/resources/css/404.css">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>Error</h1>
                    <div class="error-details">
                        <?php if (isset($data['message']) && !empty($data['message'])) :?>
                            <?= $data['message'] ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once 'template-parts/footer.php';?>