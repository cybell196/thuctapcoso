<?php
include "connect.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["loginSession"]) || $_SESSION["loginSession"] != "admin") {
    header("Location: login.php");
    exit();
}
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <!-- gg font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">
    <!-- icon  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- lib -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- customized bootstrap -->
    <link href="css/main.min.css" rel="stylesheet">

    <!-- css -->
    <link href="css/style.css" rel="stylesheet">
    <!-- ajax  -->

</head>

<body>
    <div class="row">
        <div class="col-2 container-fluid p-0 bg-primary" style="min-height: 730px;">
            <div class="container border border-1 border-end-0 mb-3">
                <div class="name-admin d-flex align-items-center justify-content-center" style="height: 58px;">
                    <p class="text-center fw-bold text-light fs-4 my-auto"><?php echo $_SESSION["loginSession"]; ?></p>
                </div>
            </div>

            <ul class="nav flex-column d-flex align-items-center justify-content-center">
                <li class="nav-item text-center w-80 mb-1">
                    <a id="edit" href="#" class="nav-link mx-auto rounded active">
                        <button class="btn text-light">Sửa sản phẩm</button>
                    </a>
                </li>
                <li class="nav-item text-center w-80 mb-1">
                    <a id="view" href="#" class="nav-link mx-auto rounded">
                        <button class="btn text-light">Xem đơn hàng</button>
                    </a>
                </li>
            </ul>
        </div>


        <div class="col-10 p-0">
            <nav class="navbar navbar-expand-lg bg-body-tertiary border" style="height: 60px;">
                <div class="container-fluid">
                    <div class="mr-auto">
                        <a class="navbar-brand" href="#" id="addProductBtn"><i class="bi bi-plus-circle"></i> Thêm sản phẩm</a>
                        <a class="navbar-brand" href="admin.php"><i class="bi bi-arrow-repeat"></i> Reload</a>
                    </div>
                    <div class="ml-auto">
                        <a href="index.php">
                            <button class="btn" type="submit"><i class="bi bi-arrow-bar-left"></i> Quay về trang chủ</button>
                        </a>
                        <a href="logout.php">
                            <button class="btn" type="submit" name="logout"><i class="bi bi-box-arrow-left"></i> Đăng xuất</button>
                        </a>
                    </div>

                </div>
            </nav>


            <div class="login-register container-fluid p-0 ps-1">
                <div class="container">
                    <div id="content-add-product"></div>
                
                
                    <table id="product" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Đã bán</th>
                                <th scope="col">Hình minh họa</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $tmp_id = "";

                            $sql = "SELECT * FROM product";
                            $result = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $row['id'] ?></th>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['price'] ?>đ</td>
                                    <td><?php echo $row['sold'] ?></td>
                                    <td><img widtd="30" height="30" src="../img/<?php echo $row['img'] ?>" alt="img"></td>
                                    <td>
                                        <span><a href="edit_product.php?this_id=<?php echo $row['id'] ?>" >Sửa</a></span>
                                        <span>|</span>
                                        <span><a href="delete_product.php?this_id=<?php echo $row['id'] ?>">Xóa</a></span>
                                    </td>

                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    
                    
                    <table id="order" class="table table-striped hide">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Giới tính</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Id sản phẩm đã mua</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            
                            $tmp_id = "";

                            $sql_order = "SELECT * FROM donhang";
                            $result_order = mysqli_query($conn, $sql_order);

                            while ($row = mysqli_fetch_array($result_order)) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $row['id'] ?></th>
                                    <td><?php echo $row['buyer_name'] ?></td>
                                    <td><?php echo $row['buyer_gender'] ?></td>
                                    <td><?php echo $row['buyer_phone'] ?></td>
                                    <td><?php echo $row['buyer_address'] ?></td>
                                    <td><?php echo $row['id_product'] ?></td>
                                    <td><?php echo number_format($row['totalMoney'], 0, ',', '.') ?>đ</td>
                                    <td><?php echo $row['buyer_note'] ?></td>

                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>

    </div>









    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>
    <script>
        const tooltips = document.querySelector('.tt-cart')
        new bootstrap.Tooltip(tooltips)
    </script>

    <script>
    $(document).ready(function(){
    $("#addProductBtn").click(function(e){
        e.preventDefault();
        $("#content-add-product").load("add_product.php");
    });
    });
    // nút ấn sửa sp hoặc xem đơn hàng
    $(document).ready(function() {
        $('#edit').on('click', function() {
            // Remove the 'active' class from all links
            $('#view').removeClass('active');
            $('#product').removeClass('hide');
            $('#addProductBtn').removeClass('hide');
            // Add the 'active' class to the clicked link
            $(this).addClass('active');
            $('#order').addClass('hide');
        });

        $('#view').on('click', function() {
            // Remove the 'active' class from all links
            $('#edit').removeClass('active');
            $('#order').removeClass('hide');
            // Add the 'active' class to the clicked link
            $(this).addClass('active');
            $('#product').addClass('hide');
            $('#addProductBtn').addClass('hide');
        });
    });
    
    
    </script>
</body>

</html>