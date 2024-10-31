<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// số sản phẩm trong giỏ hàng
if (isset($_SESSION['cart'])) {
    $productCount = count($_SESSION['cart']);
} else {
    $productCount = 0;
}
if (isset($_SESSION['sortOption'])) {
    unset($_SESSION['sortOption']);
}
?>
<?php
include 'connect.php';
$totalProductsQuery = "SELECT COUNT(*) as total FROM product";
$totalProductsResult = $conn->query($totalProductsQuery);
$totalProductsRow = $totalProductsResult->fetch_assoc();
$totalProducts = $totalProductsRow['total'];

$totalPages = ceil($totalProducts / 6);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sản phẩm</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/main.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="bg-primary py-3 d-none d-lg-block">
            <div class="mx-5 d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Hà Đông, Hà Nội</a></small>
                    <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">Baitap2@example.com</a></small>
                </div>
                <div class="top-link pe-2">
                    <a href="#" class="text-white"><small class="text-white mx-2">Chính sách bảo mật</small>/</a>
                    <a href="#" class="text-white"><small class="text-white mx-2">Điều khoản sử dụng</small>/</a>
                    <a href="#" class="text-white"><small class="text-white ms-2">Đổi trả & hoàn tiền</small></a>
                </div>
            </div>
        </div>
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="index.php" class="navbar-brand">
                    <h1 class="m-0 text-primary display-6">Kung-guru</h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="shop.php" class="nav-item nav-link"><i class="bi bi-tv"></i> Tivi</a>
                        <a href="shop.php" class="nav-item nav-link"><i class="bi bi-droplet-half"></i> Máy lọc nước</a>
                        <a href="shop.php" class="nav-item nav-link"><i class="bi bi-wind"></i> Điều hòa</a>
                        <a href="#" class="nav-item nav-link"><i class="bi bi-tools"></i> Dịch vụ sửa chữa</a>
                        <a href="#" class="nav-item nav-link"><i class="bi bi-file-earmark-post"></i> Bảo hành</a>
                        <div class="nav-item dropdown" style="display: none;">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="cart.php" class="dropdown-item">Cart</a>
                                <a href="chackout.php" class="dropdown-item">Chackout</a>
                                <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                                <a href="404.php" class="dropdown-item">404 Page</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex m-3 me-0">
                        <button class="btn-search btn border border-primary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                        <a href="cart.php" class="position-relative me-4 my-auto">
                            <i class="bi bi-basket fa-2x"></i>
                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $productCount?></span>
                        </a>
                        <a href="login.php" class="my-auto">
                            <i class="bi bi-person-circle fa-2x"></i>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-1">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn cần tìm gì?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3 border-dark" placeholder="Máy lọc nước" aria-describedby="search-icon-1">
                        <!-- <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span> -->
                        <button class="btn btn-outline-dark" type="button"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->

    <div class="py-5 my-4"></div>


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">

            <div class="row g-4">
                <div class="col-lg-12">

                    <div class="row g-4">
                        <div class="col-xl-3">
                            <h1 class="mb-4 text-primary">Lọc sản phẩm</h1>
                        </div>

                        <div class="col-xl-9">
                            <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                <label for="sortOptions">Sắp xếp theo:</label>
                                <form id="sortOptionForm" action="renderShop.php" method="post">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sortOption" id="none" value="none" checked>
                                        <label class="form-check-label" for="none">
                                            Không
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sortOption" id="priceUp" value="priceUp">
                                        <label class="form-check-label" for="priceUp">
                                            Giá thấp đến cao
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sortOption" id="sold" value="sold">
                                        <label class="form-check-label" for="sold">
                                            Bán chạy
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="input-group w-100 mx-auto d-flex">
                                        <input id="search" type="search" class="form-control p-3" placeholder="Tìm kiếm" aria-describedby="search-icon-1">
                                    </div>
                                    <div id="output" class="list-group" style="width: 20%;"></div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3 d-flex align-items-center justify-content-center">
                                    </div>
                                </div>



                            </div>
                        </div>
                        <!-- render sản phẩm -->
                        <div class="col-xxl-9">
                            <div id="product-render" class="row g-4 justify-content-center">
                                <!-- php render -->

                                <!--  -->
                            </div>


                            <div class="row mt-5">

                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" value="1" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary" for="btnradio1">1</label>
                                    <?php
                                    for ($i = 2; $i <= $totalPages; $i++) {
                                        echo '<input type="radio" class="btn-check" name="btnradio" id="btnradio' . $i . '" value="' . $i . '" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="btnradio' . $i . '">' . $i . '</label>';
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <a href="#">
                            <h1 class="text-primary mb-0">Kung-guru</h1>
                            <p class="text-secondary mb-0">Máy lọc nước</p>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative mx-auto">
                            <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="number" placeholder="Email của bạn">
                            <button type="submit" class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0;">Gửi</button>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex justify-content-end pt-3">
                            <a class="btn btn-outline-light me-2 btn-md-square rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light me-2 btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Tại sao mọi người thích chúng tôi!</h4>
                        <p class="mb-4">typesetting, remaining essentially unchanged. It was
                            popularised in the 1960s with the like Aldus PageMaker including of Lorem Ipsum.</p>
                        <a href="#" class="btn border-light py-2 px-4 rounded-pill text-light">Xem thêm</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Thông tin cửa hàng</h4>
                        <a class="btn-link" href="">Về chúng tôi</a>
                        <a class="btn-link" href="">Liên hệ</a>
                        <a class="btn-link" href="">Chính sách bảo mật</a>
                        <a class="btn-link" href="">Điều khoản & điều kiện</a>
                        <a class="btn-link" href="">Chính sách đổi trả</a>
                        <a class="btn-link" href="">FAQs & Trợ giúp</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Tài khoản</h4>
                        <a class="btn-link" href="">Tài khoản của tôi</a>
                        <a class="btn-link" href="">Chi tiết gian hàng</a>
                        <a class="btn-link" href="">Giỏ hàng</a>
                        <a class="btn-link" href="">Danh sách ưu thích</a>
                        <a class="btn-link" href="">Lịch sử mua hàng</a>
                        <a class="btn-link" href="">Đơn hàng quốc tế</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Liên hệ</h4>
                        <p>Địa chỉ: 1429 Hà Đông, HN 48247</p>
                        <p>Email: Example@gmail.com</p>
                        <p>Phone: +0123 4567 8910</p>
                        <p>Phương thức thanh toán</p>
                        <img src="img/payment.png" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Baitap2</a>, 2024</span>
                </div>
                <div class="col-md-6 my-auto text-center text-md-end text-white">
                    Công ty cổ phần <a class="border-bottom" href="#">bài tập 2</a> Phân phối bởi <a class="border-bottom" href="#">HTML</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        $(document).ready(function() {
            $('#product-render').load('renderShop.php');

            function loadPage(page) {
                $('#product-render').load('renderShop.php?page=' + page);
            }

            $('input[name="sortOption"]').change(function() {
                var selectedValue = $(this).val();

                $.ajax({
                    url: 'setSortOption.php',
                    type: 'post',
                    data: {
                        sortOption: selectedValue
                    },
                    success: function(response) {

                        $('#product-render').load('renderShop.php');
                        $('input[name="btnradio"]').prop('checked', false);
                        $('#btnradio1').prop('checked', true);
                    }
                });

            });

            $('input[name="btnradio"]').change(function() {
                var page = $(this).val();
                loadPage(page);
            });
        });
    </script>



</body>

</html>