<?php
// Connect to your database
include 'connect.php';
session_start();
// số sản phẩm trong giỏ hàng
if (isset($_SESSION['cart'])) {
    $productCount = count($_SESSION['cart']);
} else {
    $productCount = 0;
}

$sql_top = "SELECT * FROM product ORDER BY sold DESC LIMIT 8";
$result_top = $conn->query($sql_top);
// Check if id is set in URL
$id = $name = $formattedPrice = $img = $sold = $note = "";
$result = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare a select statement
    $sql = "SELECT * FROM product WHERE id = $id";

    // Execute the statement
    $result = $conn->query($sql);

    // Fetch the product data
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $name = $row["name"];
        $price = $row["price"];
        $formattedPrice = number_format($price, 0, ',', '.');
        $img = $row["img"];
        $sold = $row["sold"];
        $note = $row["note"];
    } else {
        echo "No product found with id: $id";
    }
} else {
    echo "No id provided in the URL";
}


function renderProduct($id, $name, $formattedPrice, $img, $sold, $note)
{
    echo '
        <div class="col-6">
            <div class="border rounded">
                <a href="#">
                    <img src="img/' . $img . '" class="img-fluid rounded w-100" alt="Image">
                </a>
            </div>
        </div>

        <div class="col-6">
            <h4 class="fw-bold mb-3">' . $name . '</h4>

            <h5 class="fw-bold mb-3 text-red">' . $formattedPrice . ' đ</h5>
            <div class="d-flex mb-4">
                <i class="fa fa-star text-secondary"></i>
                <i class="fa fa-star text-secondary"></i>
                <i class="fa fa-star text-secondary"></i>
                <i class="fa fa-star text-secondary"></i>
                <i class="fa fa-star"></i>
            </div>
            <p class="mb-4 text-primary">Đã bán: ' . $sold . '</p>
            <p class="mb-4">' . $note . '</p>
            <form action="cart.php" method="post">
                <input type="hidden" name="product_id" value="' . $id . '">
                <button type="submit" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm vào giỏ hàng
                </button>
            </form>
        </div>

        <div class="col-6">
            <nav>
                <div class="nav nav-tabs mb-3">
                    <button class="nav-link active border-white border-bottom-0" type="button" role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about" aria-controls="nav-about" aria-selected="true">Mô tả</button>
                    <button class="nav-link border-white border-bottom-0" type="button" role="tab" id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission" aria-controls="nav-mission" aria-selected="false">Đánh giá</button>
                </div>
            </nav>

            <div class="tab-content mb-5">
                <!-- tab mô tả start-->
                <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                    <p>' . $note . '</p>
                </div>
                
                <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                    <div class="d-flex">
                        <p class="lead fw-bold text-dark"><i class="fa fa-star text-secondary"></i> Chưa có đánh giá</p>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-6">
            <p class="lead fw-bold text-dark">Thông số kỹ thuật:</p>
                <div class="row g-4 ps-2">
                    <div class="col">
                        <div class="row align-items-center text-start justify-content-center py-2 bg-muted-fix">
                            <div class="col-6">
                                <p class="mb-0">Loại máy:</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-0">1 chiều (chỉ làm lạnh)</p>
                            </div>
                        </div>
                        <div class="row text-start align-items-center justify-content-center py-2">
                            <div class="col-6">
                                <p class="mb-0">Công suất làm lạnh:</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-0">1.5 HP - 11.000 BTU</p>
                            </div>
                        </div>
                        <div class="row  text-start align-items-center justify-content-center py-2 bg-muted-fix">
                            <div class="col-6">
                                <p class="mb-0">Tiêu thụ điện:</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-0">1.15 kW/h</p>
                            </div>
                        </div>
                        <div class="row text-start align-items-center justify-content-center py-2">
                            <div class="col-6">
                                <p class="mb-0">Hãng</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-0">LG.</p>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
    ';
}
function itemHighRate($id, $img, $name, $price, $sold)
{
    return '
            <div class="border rounded position-relative vesitable-item shadow">
                
                <div class="vesitable-img">
                    <img src="img/' . $img . '" class="img-fluid w-100 rounded-top" alt="">
                </div>
                
                <div class="text-dark bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Hot</div>
                
                <div class="p-4 rounded-bottom bg-muted-fix">
                    <p class="product-name fw-lighter fs-5 text-start text-primary">' . $name . '</p>
                    
                    <div class="d-flex justify-content-between flex-lg-wrap">
                        <p class="text-red fs-5 fw-bold mb-0">' . $price . ' đ</p>
                        <a href="shop-detail.php?id=' . $id . '" class="btn border btn-cybell rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Chi tiết</a>
                    </div>

                    <p class="text-start mt-1">
                        <span class="text-secondary">4.4 <i class="bi bi-star-fill"></i></span>
                        <span class="text-dark">(' . $sold . ')</span>
                    </p>
                </div>

            </div>
            ';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Kung-guru - Máy lọc nước</title>
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
                        <button class="btn btn-outline-dark" type="button"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->

    <!-- Single Page Header End -->
    <div class="py-5 "></div>

    <!-- chi tiết sản phẩm Start -->
    <div class="container-fluid py-5 ">
        <div class="container py-5 px-2 bg-light rounded-bottom">
            <div class="row g-5">
                
                <!-- php render -->
                <?php 
                    if($result === ""){
                        echo "Không tìm thấy sản phẩm";
                    }else{
                        echo renderProduct($id, $name, $formattedPrice, $img, $sold, $note);}
                ?>
                <!--            -->

            </div>

            <!-- sản phẩm tương tự start -->
            <h1 class="fw-bold mb-0">Sản phẩm tương tự</h1>
            <div class="vesitable bg-light">
                <div class="owl-carousel vegetable-carousel justify-content-center">
                <?php
                    if ($result_top->num_rows > 0) {
                        while ($row = $result_top->fetch_assoc()) {
                            $id = $row["id"];
                            $name = $row["name"];
                            $price = $row["price"];
                            $formattedPrice = number_format($price, 0, ',', '.');
                            $img = $row["img"];
                            $sold = $row["sold"];
                            echo itemHighRate($id, $img, $name, $formattedPrice, $sold);
                        }
                    } else {
                        echo "0 kết quả";
                    }
                ?> 
                </div>
            </div>
            <!-- sản phẩm tương tự end -->
        </div>
    </div>
    <!-- chi tiết sản phẩm End -->


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
</body>

</html>