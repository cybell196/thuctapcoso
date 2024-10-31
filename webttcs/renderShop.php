<?php
include "connect.php";
session_start();

$productsPerPage = 6;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $productsPerPage;

// Sắp xếp sản phẩm theo giá tăng dần hoặc số lượng bán được giảm dần
$sortOption = isset($_SESSION['sortOption']) ? $_SESSION['sortOption'] : 'none';
// lọc sản phẩm theo tag


if ($sortOption === 'priceUp') {
    $sql = "SELECT * FROM product ORDER BY price ASC LIMIT $productsPerPage OFFSET $offset";
} elseif ($sortOption === 'sold') {
    $sql = "SELECT * FROM product ORDER BY sold DESC LIMIT $productsPerPage OFFSET $offset";
} else {
    $sql = "SELECT * FROM product LIMIT $productsPerPage OFFSET $offset";
}

$result = $conn->query($sql);

// Function to render a shop item

function renderShopItem($id, $img, $name, $price, $sold)
{
    return '
        <div class="col-md-6 col-lg-4 col-xl-4">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $name = $row["name"];
        $price = $row["price"];
        $formattedPrice = number_format($price, 0, ',', '.');
        $img = $row["img"];
        $sold = $row["sold"];
        echo renderShopItem($id, $img, $name, $formattedPrice, $sold);
    }
} else {
    echo "0 kết quả";
}

?>

