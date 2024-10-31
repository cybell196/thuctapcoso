<?php
include 'connect.php';
session_start();
if (isset($_SESSION['cart'])) {
    $productCount = count($_SESSION['cart']);
} else {
    $productCount = 0;
}
$sql_rand = "SELECT * FROM product ORDER BY RAND() LIMIT 8";
$result_rand = $conn->query($sql_rand);

$sql_top = "SELECT * FROM product ORDER BY sold DESC LIMIT 8";
$result_top = $conn->query($sql_top);

function createShopItem($id, $img, $name, $price, $sold)
{
    return '
            <div class="col-md-6 col-lg-4 col-xl-3">
                <a href="shop-detail.php?id=' . $id . '">
                    <div class="rounded position-relative fruite-item shadow">
                        
                        <div class="fruite-img">
                            <img src="img/' . $img . '" class=" img-fluid w-100 rounded-top" alt="">
                        </div>

                        <div class="text-light bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Trả góp 0%</div>

                        <div class="p-4  rounded-bottom bg-muted-fix">
                            <p class="product-name fw-lighter fs-5 text-start mb-5">' . $name . '</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="text-start text-red fs-5 fw-bold mb-0">' . $price . ' đ</p>
                                <a href="shop-detail.php?id=' . $id . '" class="btn border btn-cybell rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Chi tiết</a>
                                </div>
                                <p class="text-start mb-1 mt-2">
                                <span class="text-secondary">4.4 <i class="bi bi-star-fill"></i></span>
                                <span class="text-dark">(' . $sold . ')</span>
                            </p>  
                        </div>
                        
                    </div>
                </a>
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
    <!-- ajax  -->

</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="bg-primary py-3 d-lg-block d-none">
            <div class="mx-5 d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Hà Đông, Hà Nội</a></small>
                    <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">Baitap2@example.com</a></small>
                </div>
                <div class="top-link pe-2">
                    <a href="#" class="text-light"><small class="text-light mx-2">Chính sách bảo mật</small>/</a>
                    <a href="#" class="text-light"><small class="text-light mx-2">Điều khoản sử dụng</small>/</a>
                    <a href="#" class="text-light"><small class="text-light ms-2">Đổi trả & hoàn tiền</small></a>
                </div>
            </div>
        </div>
        <div class="container px-0">
            <nav class="navbar navbar-expand-xl navbar-light bg-white">
                <a href="index.php" class="navbar-brand">
                    <h1 class="m-0 text-primary display-6">Kung-guru</h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="shop.php" class="nav-item btn-cybell nav-link"><i class="bi bi-tv"></i> Tivi</a>
                        <a href="shop.php" class="nav-item btn-cybell nav-link"><i class="bi bi-droplet-half"></i> Máy lọc nước</a>
                        <a href="shop.php" class="nav-item btn-cybell nav-link"><i class="bi bi-wind"></i> Điều hòa</a>
                        <a href="#" class="nav-item btn-cybell nav-link"><i class="bi bi-tools"></i> Dịch vụ sửa chữa</a>
                        <a href="#" class="nav-item btn-cybell nav-link"><i class="bi bi-file-earmark-post"></i> Bảo hành</a>

                    </div>
                    <div class="d-flex m-3 me-0">
                        <button class="btn-search btn border border-primary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                        <a href="cart.php" class="position-relative me-4 my-auto">
                            <i class="bi bi-basket fa-2x"></i>
                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $productCount?></span>
                        </a>

                        <a href="login.php" class="my-auto"><i class="bi bi-person-circle fa-2x"></i></a>
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

    <!-- First Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">Máy lọc nhập khẩu</h4>
                    <h1 class="mb-5 display-3 text-primary">Kung-guru Máy lọc nước</h1>

                    <div class="position-relative mx-auto">
                        <input class="form-control border-2 border-light w-75 py-3 px-4 rounded-pill" type="text" id="search" placeholder="Bạn cần gì...">
                        <div id="output" class="list-group"></div>
                        <button type="submit" class="btn btn-primary border-2 border-light py-3 px-4 position-absolute rounded-pill text-white h-100" style="top: 0; right: 25%;">Tìm kiếm</button>
                    </div>

                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="img/h-img-1.png" class="img-fluid w-100 h-100  rounded" alt="First slide">
                            </div>
                            <div class="carousel-item rounded">
                                <img src="img/h-img-2.png" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- First End -->


    <!-- Cam kết Start -->
    <div class="container-fluid featurs py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-primary mb-5 mx-auto">
                            <i class="fas fa-car-side fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Giao hàng miễn phí</h5>
                            <p class="mb-0">Miễn phí cho hóa đơn từ 200k</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-primary mb-5 mx-auto">
                            <i class="fas fa-user-shield fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Thanh toán an toàn</h5>
                            <p class="mb-0">100% Thanh toán an toàn</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-primary mb-5 mx-auto">
                            <i class="fas fa-exchange-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>30 ngày trả hàng</h5>
                            <p class="mb-0">30 ngày đổi trả miễn phí</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-primary mb-5 mx-auto">
                            <i class="fa fa-phone-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Hỗ trợ 24/7</h5>
                            <p class="mb-0">Hỗ trợ mọi lúc nhanh chóng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cam kết End -->


    <!-- shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5 text-center">
            <div class="col-lg-4 text-start">
                <h1 class="text-primary mb-5"> <i class="bi bi-bar-chart-steps"></i> Sản phẩm Đề xuất</h1>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4 product-container">
                        <?php
                        if ($result_rand->num_rows > 0) {
                            while ($row = $result_rand->fetch_assoc()) {
                                $id = $row["id"];
                                $name = $row["name"];
                                $price = $row["price"];
                                $formattedPrice = number_format($price, 0, ',', '.');
                                $img = $row["img"];
                                $sold = $row["sold"];
                                echo createShopItem($id, $img, $name, $formattedPrice, $sold);
                            }
                        } else {
                            echo "0 kết quả";
                        }
                        ?>
                    </div>
                </div>

                <div class="col-lg-12 mt-5">
                    <a href="shop.php">
                        <button class="btn bg-primary border-light w-50 text-light">Xem thêm</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop End-->


    <!-- Banner thuong hieu Start-->
    <div class="container-fluid brandible">
        <div class="container py-5 ">
            <h2 class="mb-5">Chuyên trang thương hiệu</h2>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                <div class="rounded position-relative vesitable-item">
                    <img src="img/brand-1.png" class="d-block mx-auto rounded" alt="brand">
                </div>

                <div class="rounded position-relative vesitable-item">
                    <img src="img/brand-2.png" class="d-block mx-auto rounded" alt="brand">
                </div>

                <div class="rounded position-relative vesitable-item">
                    <img src="img/brand-3.png" class="d-block mx-auto rounded" alt="brand">
                </div>

                <div class="rounded position-relative vesitable-item">
                    <img src="img/brand-4.png" class="d-block mx-auto rounded" alt="brand">
                </div>
            </div>
        </div>
    </div>
    <!-- Banner  End -->


    <!-- Shop 2 xu huong mua sam Start-->
    <div class="container-fluid vesitable py-5">
        <div class="container py-5 px-0">
            <h1 class="mb-0">Xu hướng mua sắm</h1>
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
    </div>
    <!-- Shop 2 End -->


    <!-- Sự thật về web Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="bg-light p-5 rounded">
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>Khách hàng hài lòng</h4>
                            <h1>1963</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>Chất lượng phục vụ</h4>
                            <h1>99%</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>Chứng nhận chất lượng</h4>
                            <h1>33</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>Sản phẩm có sẵn</h4>
                            <h1>789</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- sự thật về Start -->


    <!-- Tastimonial Start -->
    <div class="container-fluid testimonial py-5">
        <div class="container py-5">
            <div class="testimonial-header text-center">
                <h4 class="text-primary">Đánh giá từ khách hàng</h4>
                <h1 class="display-5 mb-5 text-dark">Khách hàng đã nói gì?</h1>
            </div>
            <div class="owl-carousel testimonial-carousel">
                <div class="testimonial-item img-border-radius bg-light rounded p-4">
                    <div class="position-relative">
                        <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                        <div class="mb-4 pb-4 border-bottom border-secondary">
                            <p class="mb-0">đây là bình luận của khách hàng, đây là bình luận của
                            </p>
                        </div>
                        <div class="d-flex align-items-center flex-nowrap">
                            <div class="bg-secondary rounded">
                                <img src="img/testimonial-1.jpg" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                            </div>
                            <div class="ms-4 d-block">
                                <h4 class="text-dark">Tên khách hàng</h4>
                                <p class="m-0 pb-3">@khachhang</p>
                                <div class="d-flex pe-5">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item img-border-radius bg-light rounded p-4">
                    <div class="position-relative">
                        <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                        <div class="mb-4 pb-4 border-bottom border-secondary">
                            <p class="mb-0">đây là bình luận của khách hàng, đây là bình luận của
                            </p>
                        </div>
                        <div class="d-flex align-items-center flex-nowrap">
                            <div class="bg-secondary rounded">
                                <img src="img/testimonial-1.jpg" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                            </div>
                            <div class="ms-4 d-block">
                                <h4 class="text-dark">Tên khách hàng</h4>
                                <p class="m-0 pb-3">@khachhang</p>
                                <div class="d-flex pe-5">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item img-border-radius bg-light rounded p-4">
                    <div class="position-relative">
                        <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                        <div class="mb-4 pb-4 border-bottom border-secondary">
                            <p class="mb-0">đây là bình luận của khách hàng, đây là bình luận của
                            </p>
                        </div>
                        <div class="d-flex align-items-center flex-nowrap">
                            <div class="bg-secondary rounded">
                                <img src="img/testimonial-1.jpg" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                            </div>
                            <div class="ms-4 d-block">
                                <h4 class="text-dark">Tên khách hàng</h4>
                                <p class="m-0 pb-3">@khachhang</p>
                                <div class="d-flex pe-5">
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                    <i class="fas fa-star text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tastimonial End -->


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

    <script src="js/main.js"></script>
    <script>
        const tooltips = document.querySelector('.tt-cart')
        new bootstrap.Tooltip(tooltips)
    </script>
</body>

</html>