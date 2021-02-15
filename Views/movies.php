<?php require 'template-parts/header.php'; ?>
<body>
<div id="wrapper">
    <div class="overlay"></div>
    <?php require 'template-parts/sidebar.php'; ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <button type="button" class="hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
            <span class="hamb-top"></span>
            <span class="hamb-middle"></span>
            <span class="hamb-bottom"></span>
        </button>
        <div class="container">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    </tbody>
                </table>

                <table data-toggle="table">
                    <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Item Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Item 1</td>
                        <td>$1</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Item 2</td>
                        <td>$2</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->
<?php require_once 'template-parts/footer.php';?>
</body>
</html>



