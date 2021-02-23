<?php require 'template-parts/header.php'; ?>
        <div class="container">
            <div class="alert alert-danger" role="alert" id="error-message" style="display: none">
                <?= $errorMessage ?? '' ?>
            </div>
        <div class="alert alert-info" role="alert" id="info-message" style="display: none"></div>
        <div class="form-group">
            <label class="filter-col" style="margin-right:0;" for="pref-search">Search:</label>
            <input
                    type="text"
                    class="form-control input-sm"
                    id="pref-search"
                    placeholder="type and press ENTER to search"
                    value="<?= $_GET['search'] ?? '' ?>"
            >
        </div>
        <div class="form-group">
                <label class="filter-col" style="margin-right:0;" for="pref-orderby">Order by:</label>
                <select id="pref-orderby" class="form-control">
                    <option value="title_asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'asc') ? 'selected' : '' ?>>Movie title (ASC)</option>
                    <option value="title_desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'desc') ? 'selected' : '' ?>>Movie title (DESC)</option>
                </select>
        </div>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Year</th>
                        <th scope="col">Format</th>
                        <th scope="col">Actors</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($data)): ?>
                        <?php foreach($data as $key => $movie): ?>
                            <tr id="movie-<?= $movie['id'] ?>">
                                <th scope="row"><?= $key + 1 ?></th>
                                <td><?= $movie['title'] ?></td>
                                <td><?= $movie['release_date'] ?></td>
                                <td><?= $movie['format'] ?></td>
                                <td><?= $movie['actors'] ?></td>
                                <td>
                                    <a href="/movies/show/<?= $movie['id'] ?>">
                                        <button type="button" class="btn btn-primary">Show</button>
                                    </a>
                                </td>
                                <td><button type="button" data-id="<?= $movie['id'] ?>" class="btn btn-danger delete">Delete</button></td>

                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
<?php require_once 'template-parts/footer.php';?>