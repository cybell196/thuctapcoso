<?php
include 'connect.php';

session_start();
// if(!isset($_SESSION['loginSession'])){
//     header("location: login.php");
// }
if (isset($_SESSION['cart'])) {
    $productCount = count($_SESSION['cart']);
} else {
    $productCount = 0;
}

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // If the cart does not exist, create it
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Add the product to the cart
    array_push($_SESSION['cart'], $product_id);
}

$id = $name = $formattedPrice = $img = $sold = $note = "";
$totalPrice = 0;
$shipFee = 25000;

function renderItemCart()
{
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        global $conn;
        global $totalPrice;
        $output = '
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Giá</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($_SESSION['cart'] as $product_id) {
            $query = sprintf("SELECT * FROM product WHERE id = %s", $product_id);
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = $row["id"];
                $name = $row["name"];
                $price = $row["price"];
                $totalPrice += $price;
                $formattedPrice = number_format($price, 0, ',', '.');
                $img = $row["img"];

                $output .= '
                    <tr>
                        <th scope="row">
                            <div class="d-flex align-items-center">
                                <img src="img/' . $img . '" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                            </div>
                        </th>
                        <td>
                            <p class="mb-0 mt-4">' . $name . '</p>
                        </td>
                        <td>
                            <p class="mb-0 mt-4 text-red">' . $formattedPrice . 'đ</p>
                        </td>

                        <td>
                            <form action="remove_from_cart.php" method="post">
                                <input type="hidden" name="product_id" value="' . $id . '">
                                <button class="btn btn-md rounded-circle bg-light border mt-4">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                            </form>
                        </td>
                    </tr>';
            }
        }

        $output .= '
                </tbody>
            </table>';
    } else {
        $output = "<p class='text-center'>Giỏ hàng của bạn trống</p>";
    }
    return $output;
}


function renderItem()
{
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        global $conn;
        global $totalPrice;
        $output = '
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Tên</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($_SESSION['cart'] as $product_id) {
            $query = sprintf("SELECT * FROM product WHERE id = %s", $product_id);
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = $row["id"];
                $name = $row["name"];

                $img = $row["img"];

                $output .= '
                    <tr>
                        <th scope="row">
                            <div class="d-flex align-items-center">
                                <img src="img/' . $img . '" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                            </div>
                        </th>
                        <td>
                            <p class="mb-0 mt-4">' . $name . '</p>
                        </td>
                    </tr>';
            }
        }

        $output .= '
                </tbody>
            </table>';
    } else {
        $output = "<p class='text-center'>Giỏ hàng của bạn trống</p>";
    }
    return $output;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cart and Checkout</title>
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
                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $productCount ?></span>
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
    <div class="py-5 my-5"></div>

    <!-- Cart Page Start -->
    <div class="container-fluid py-5 body-cart">
        <div class="btn-cart">
            <a href="index.php" class="mx-5 btn text-decoration-underline text-primary" type="button">Quay về trang chủ</a>
            <p class="lead fw-bold text-center">Giỏ hàng của bạn</p>
        </div>
        <div class="container shadow py-5">
            <div class="table-responsive">
                <!-- php render here -->
                <?php echo renderItemCart(); ?>
            </div>

            <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) : ?>
                <div id="info-hide" class="row g-4">
                    <div class="col-lg-6 border-end text-dark border-bottom">
                        <p class="text-center fw-bold">THÔNG TIN KHÁCH HÀNG</p>
                        <!-- thông tin khachs hàng start -->
                        <form action="bill.php" method="post" >
                            <div class="mx-4 mb-3 row justify-content-start">
                                <div class="input-group p-0">
                                    <input id="name" type="text" class="form-control" placeholder="Họ và Tên" aria-label="name" name="name" required>
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                    <input id="phone" type="text" class="form-control" placeholder="Số điện thoại" aria-label="phone" name="phone" required>
                                </div>
                            </div>

                            <div class="mx-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Anh" required>
                                    <label class="form-check-label" for="inlineRadio1">Anh</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Chị">
                                    <label class="form-check-label" for="inlineRadio2">Chị</label>
                                </div>
                            </div>

                            <div class="m-4">
                                <p class="fw-bold ms-1">ĐỊA CHỈ NHẬN HÀNG</p>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <select id="city" class="form-select text-primary" aria-label="Default select example" name="city" required>
                                            <option value="">Chọn Tỉnh / Thành Phố</option>
                                            <!-- Các tỉnh sẽ được thêm vào đây bằng JavaScript -->
                                        </select>
                                    </div>

                                    <div class="col-6">
                                        <select id="district" class="form-select text-primary" aria-label="Default select example" name="district" required>
                                            <option value="">Chọn Quận / Huyện</option>
                                            <!-- Các quận/huyện sẽ được thêm vào đây bằng JavaScript -->
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <select id="town" class="form-select text-primary" aria-label="Default select example" name="town" required>
                                            <option value="">Chọn Phường / Xã</option>
                                            <!-- Các phường/xã sẽ được thêm vào đây bằng JavaScript -->
                                        </select>
                                    </div>

                                    <div class="col-6">
                                        <div class="input-group text-primary">
                                            <input id="home" type="text" class="form-control" placeholder="Số nhà/Địa chỉ cụ thể" aria-label="Số nhà/Địa chỉ cụ thể" aria-describedby="basic-addon1" name="home" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="input-group text-primary">
                                        <input id="note" type="text" class="form-control" placeholder="Yêu cầu khác (không bắt buộc)" aria-label="yeucau" aria-describedby="basic-addon1" name="note">
                                    </div>
                                </div>

                                <div class="row my-3 mx-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tôi đồng ý với Chính sách xử lý dữ liệu cá nhân của <a href="">Baitap2</a>
                                        </label>
                                    </div>
                                </div>

                                <div class="row g-1 justify-content-center ">
                                    <div class="col-xxl-8">
                                        <button id="submitButton" class="btn border-primary rounded px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="submit" disabled>Đặt hàng</button>
                                        <button class="btn border-primary rounded px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="reset"> Điền lại </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- Thông tin kkhacsh hàng end -->
                    <!-- bill start -->
                    <div class="col-lg-6">
                        <div class="bg-light rounded justify-content-center">
                            <div class="p-4">
                                <h1 class="display-6 mb-4 text-center">Tổng <span class="fw-normal">Tiền</span></h1>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Tạm tính:</h5>
                                    <p class="mb-0 text-red"><?php $tmp = number_format($totalPrice, 0, ',', '.');
                                                                echo $tmp; ?>đ</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Phí ship</h5>
                                    <p class="mb-0 text-red"><?php echo $shipFee; ?>đ</p>
                                </div>

                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Tổng</h5>
                                <p class="mb-0 pe-4 text-red"><?php $totalPrice += $shipFee;
                                                                $_SESSION['totalPrice'] = $totalPrice;
                                                                echo number_format($totalPrice, 0, ',', '.'); ?>đ</p>
                            </div>

                        </div>
                    </div>
                    <!-- bill end -->
                <?php endif; ?>
                </div>
        </div>
    </div>

    
    <!-- Cart Page End -->


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
    <!-- kiểm tra form đã nhập đủ chưa -->
    <script>
        const agreeCheckbox = document.getElementById('flexCheckDefault');
        const citySelect = document.getElementById('city');
        const districtSelect = document.getElementById('district');
        const townSelect = document.getElementById('town');
        const submitButton = document.getElementById('submitButton');

        townSelect.addEventListener('change', function() {
            updateSubmitButtonStatus();
        });

        citySelect.addEventListener('change', function() {
            updateSubmitButtonStatus();
        });

        districtSelect.addEventListener('change', function() {
            updateSubmitButtonStatus();
        });

        agreeCheckbox.addEventListener('change', function() {
            updateSubmitButtonStatus();
        });

        function updateSubmitButtonStatus() {
            if (townSelect.value !== '' && citySelect.value !== '' && districtSelect.value !== '' && agreeCheckbox.checked) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }
    </script>

    <!-- ajax đổ data vào ô địa chỉ -->
    <script>
        $(document).ready(function() {
            // Load provinces
            $.ajax({
                url: 'getDataVietNam.php',
                type: 'GET',
                data: {
                    type: 'province'
                },
                success: function(data) {
                    var provinces = JSON.parse(data);
                    provinces.forEach(function(province) {
                        $('#city').append('<option value="' + province.province_id + '">' + province.name + '</option>');
                    });
                }
            });
 
         
            $('#city').change(function() {
                var province_id = $(this).val();
                $.ajax({
                    url: 'getDataVietNam.php',
                    type: 'GET',
                    data: {
                        type: 'district',
                        province_id: province_id
                    },
                    success: function(data) {
                        var districts = JSON.parse(data);
                        $('#district').empty();
                        districts.forEach(function(district) {
                            $('#district').append('<option value="' + district.district_id + '">' + district.name + '</option>');
                        });
                    }
                });
            });

          
            $('#district').change(function() {
                var district_id = $(this).val();
                $.ajax({
                    url: 'getDataVietNam.php',
                    type: 'GET',
                    data: {
                        type: 'wards',
                        district_id: district_id
                    },
                    success: function(data) {
                        var wards = JSON.parse(data);
                        $('#town').empty();
                        wards.forEach(function(ward) {
                            $('#town').append('<option value="' + ward.wards_id + '">' + ward.name + '</option>');
                        });
                    }
                });
            });

            


        });

        // custom nút reset
        $('button[type="reset"]').click(function(e) {
            e.preventDefault(); // Prevent the default reset behavior

            // Reset the province select
            $('#city').empty();
            $('#city').append('<option value="">Chọn Tỉnh / Thành Phố</option>');
            // Load provinces again
            $.ajax({
                url: 'getDataVietNam.php',
                type: 'GET',
                data: {
                    type: 'province'
                },
                success: function(data) {
                    var provinces = JSON.parse(data);
                    provinces.forEach(function(province) {
                        $('#city').append('<option value="' + province.province_id + '">' + province.name + '</option>');
                    });
                }
            });

            // Reset the district and ward selects
            $('#district').empty();
            $('#district').append('<option value="">Chọn Quận / Huyện</option>');
            $('#town').empty();
            $('#town').append('<option value="">Chọn Phường / Xã</option>');
            $('#inlineRadio1').prop('checked', false);
            $('#inlineRadio2').prop('checked', false);
            $('#name').val('');
            $('#home').val('');
            $('#note').val('');
            $('#flexCheckDefault').prop('checked', false);
            $('#phone').val('');
        });
    </script>

    <!-- ajax gửi data tới bill.php mà ko cần tải lại trang -->
    
</body>

</html>