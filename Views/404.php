<?php require 'template-parts/header.php'; ?>
<link rel="stylesheet" href="/resources/css/404.css">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Oops!</h1>
                <h2>
                    404 Not Found</h2>
                <div class="error-details">
                    <?php if (isset($data['message']) && !empty($data['message'])) :?>
                        <?= $data['message'] ?>
                    <?php endif; ?>
                </div>
                <div class="error-actions">
                    <a href="/home/main" class="btn btn-primary btn-lg">
                        <span class="glyphicon glyphicon-home"></span>
                        Take Me Home
                    </a>
                    <a href="https://www.linkedin.com/in/illya-avdeyuk/" target="_blank" class="btn btn-default btn-lg">
                        <span class="glyphicon glyphicon-envelope"></span>
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'template-parts/footer.php';?>