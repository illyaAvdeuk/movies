<?php require 'template-parts/header.php'; ?>

    <style>
        /*.container{*/
        /*    margin-top:30px;*/
        /*}*/

        .filter-col{
            padding-left:10px;
            padding-right:10px;
        }
    </style>

        <div class="container">


        <div class="form-group">
            <label class="filter-col" style="margin-right:0;" for="pref-search">Search:</label>
            <input
                    type="text"
                    class="form-control input-sm"
                    id="pref-search"
                    placeholder="press ENTER to search"
                    value="<?= $_GET['search'] ?>"
            >
        </div><!-- form group [search] -->
        <div class="form-group">
            <label class="filter-col" style="margin-right:0;" for="pref-orderby">Order by:</label>
            <select id="pref-orderby" class="form-control">
                <option value="title_asc" <?= $_GET['sort'] === 'asc' ? 'selected' : '' ?>>Movie title (ASC)</option>
                <option value="title_desc" <?= $_GET['sort'] === 'desc' ? 'selected' : '' ?>>Movie title (DESC)</option>
            </select>
        </div> <!-- form group [order by] -->


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
                            <tr>
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
                                <td><button type="button" class="btn btn-danger">Delete</button></td>

                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
<?php require_once 'template-parts/footer.php';?>