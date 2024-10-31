<?php
include 'connect.php';
session_start();

// Check if the cart exists
$product_ids_string = "";

$product_ids = array();
// Check if the cart exists and is an array
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    // Get the product IDs from the cart
    $product_ids = $_SESSION['cart'];
    // Convert the array of IDs into a comma-separated string
    $product_ids_string = implode(',', $product_ids);
} else {
    echo "The cart is empty.";
}
$totalPrice = 0;
if (isset($_SESSION['totalPrice'])) {
    $totalPrice = $_SESSION['totalPrice'];
} else {
    echo "Total price not set.";
}

// lấy data address 
$city = $_POST['city'];
$district = $_POST['district'];
$town = $_POST['town'];

$cityName = $districtName = $townName = "";
// Get the city name
$cityQuery = "SELECT name FROM province WHERE province_id = $city";
$cityResult = $conn->query($cityQuery);
if ($cityResult->num_rows > 0) {
    $cityRow = $cityResult->fetch_assoc();
    $cityName = $cityRow['name'];
}

// Get the district name
$districtQuery = "SELECT name FROM district WHERE district_id = $district";
$districtResult = $conn->query($districtQuery);
if ($districtResult->num_rows > 0) {
    $districtRow = $districtResult->fetch_assoc();
    $districtName = $districtRow['name'];
}

// Get the town name
$townQuery = "SELECT name FROM wards WHERE wards_id = $town";
$townResult = $conn->query($townQuery);
if ($townResult->num_rows > 0) {
    $townRow = $townResult->fetch_assoc();
    $townName = $townRow['name'];
}
$home = $_POST['home'];

$address = $home . ", " . $townName . ", " . $districtName . ", " . $cityName;
$name = $_POST['name'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];
$note = $_POST['note'];


if (empty($name) || empty($phone) || empty($gender) || empty($address) || empty($product_ids_string) || empty($totalPrice)) {
    echo "<script>alert('Có lỗi xảy ra!');window.location.href = 'index.php';</script>";

} else {
    $sql = "INSERT INTO donhang (buyer_name, buyer_phone, buyer_gender, buyer_address, buyer_note, id_product, totalMoney)
    VALUES ('$name', '$phone', '$gender', '$address', '$note', '$product_ids_string', '$totalPrice')";

    if ($conn->query($sql) === TRUE) {
        unset($_SESSION['cart']);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function renderItem()
{
    if (isset($product_ids) && count($product_ids) > 0) {
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

        foreach ($product_ids as $product_id) {
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
        $output = "<p class='text-center'>.</p>";
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
    <!-- bill hiển thị -->
    <div class="container-fluid py-5 body-cart">
        <div class="btn-cart">
            <a href="index.php" class="mx-5 btn text-decoration-underline text-primary" type="button">Quay về trang chủ</a>
            <p class="lead fw-bold text-center text-red">Cảm ơn bạn đã mua hàng</p>
        </div>
        <div id="bill-render" class="container shadow mx-auto w-50">
            <h1 class="pt-4 text-center text-primary">Địa chỉ giao hàng</h1>
            <hr>
            <p><strong>Tên khách hàng:</strong> <?php echo $name ?></p>
            <p><strong>Số điện thoại:</strong> <?php echo $phone ?></p>
            <p><strong>Địa chỉ:</strong> Địa chỉ <?php echo $address ?></p>
            <?php echo renderItem() ?>
            <p class="pb-4"><strong>Tổng tiền:</strong> <?php echo $formattedPrice = number_format($totalPrice, 0, ',', '.'); ?>đ</p>
        </div>
    </div>
    <!-- bill end -->

</body>

</html>