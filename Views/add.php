<?php require 'template-parts/header.php'; ?>
    <div class="container">
        <div class="alert alert-danger" role="alert" id="error-message" style="display: none">
            <?= $errorMessage ?? '' ?>
        </div>
        <section class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Add new film</h3>
            </div>
            <div class="panel-body">
                <form action="/movies/save" class="form-horizontal" id="add" method="post" role="form">
                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-9">
                            <input
                                type="text"
                                class="form-control"
                                name="title"
                                id="title"
                                placeholder="Title"
                                maxlength="100"

                            >
                        </div>
                    </div> <!-- form-group // -->
                    <div class="form-group">
                        <label for="release_date" class="col-sm-3 control-label">Release year</label>
                        <div class="col-sm-9">
                            <input
                                type="number"
                                class="form-control"
                                name="release_date"
                                id="release_date"
                                min="1901"
                                max="<?= date('Y') ?>"
                                placeholder="<?= date('Y') ?>"
                                required
                            >
                        </div>
                    </div> <!-- form-group // -->
                    <div class="form-group">
                        <label for="format" class="col-sm-3 control-label">Format</label>
                        <div class="col-sm-9">
                            <input
                                type="text"
                                class="form-control"
                                name="format"
                                id="format"
                                placeholder="Film format"
                                required
                                minlength="3"
                                maxlength="30"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="actors" class="col-sm-3 control-label">Actors list</label>
                        <div class="col-sm-9">
                            <input
                                type="text"
                                class="form-control"
                                name="actors" id="actors"
                                placeholder="Actors list, separated by comma"
                                required
                                minlength="1"
                                maxlength="300"
                            >
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div> <!-- form-group // -->
                </form>
            </div><!-- panel-body // -->
        </section><!-- panel// -->
    </div> <!-- container// -->
<?php require_once 'template-parts/footer.php';?>