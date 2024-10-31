<?php
include "connect.php";
session_start();
$error = "";
if (isset($_GET['this_id'])) {
    $this_id = $_GET['this_id'];
} else {
    $error = "Không có id";
}

$sql_check = " SELECT * FROM product WHERE id='$this_id' ";
$result = mysqli_query($conn, $sql_check);

$row = mysqli_fetch_assoc($result);

$name = $price = $note = $image = $tag = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['name'])) {
        $name = $_POST['name'];
    }

    if (!empty($_POST['price'])) {
        $price = $_POST['price'];
    }

    if (!empty($_POST['note'])) {
        $note = $_POST['note'];
    }

    if (!empty($_POST['tag'])) {
        $tag = $_POST['tag'];
    }

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
    }

    $sql = " UPDATE product SET name='$name', price='$price', note='$note', img='$image', tag='$tag' WHERE id='$this_id' ";

    if ($name != "" && $price != "" && $note != "" && $image != "") {
        mysqli_query($conn, $sql);
        
        header('location: admin.php');
    } else {
        $error = "Vui lòng điền đầy đủ thông tin";
    }
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
        <div class="col-2 container-fluid p-0 bg-primary" style="min-height: 750px;">
            <div class="container border border-1 border-end-0 mb-3">
                <div class="name-admin d-flex align-items-center justify-content-center " style="height: 58px;">
                    <p class="text-center fw-bold text-light fs-4"><?php echo $_SESSION["loginSession"]; ?></p>
                </div>
            </div>

            <ul class="nav flex-column d-flex align-items-center justify-content-center">
                <li class="nav-item text-center w-80 mb-1">
                    <a href="#" class="nav-link  mx-auto rounded active">
                        <button class="btn text-light">Sửa sản phẩm</button>
                    </a>
                </li>
                <li class="nav-item text-center w-80 mb-1">
                    <a href="#" class="nav-link mx-auto rounded">
                        <button class="btn text-light">Xem đơn hàng</button>
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-10 p-0">
            <nav class="navbar navbar-expand-lg bg-body-tertiary border" style="height: 60px;">
                <div class="container-fluid">
                    <div class="mr-auto">
                        <a href="admin.php">
                            <button class="btn bg-light text-primary" type="submit"><i class="bi bi-arrow-left"></i> Quay lại</button>
                        </a>
                    </div>
                    <div class="ml-auto">
                        <a href="logout.php">
                            <button class="btn" type="submit" name="logout"><i class="bi bi-box-arrow-left"></i> Đăng xuất</button>
                        </a>
                    </div>

                </div>
            </nav>

            <div class="container-fluid mt-5">
                <div class="container p-5 login-register">
                    <h1>Sửa sản phẩm</h1>
                    <div class="error"><?php echo $error ?></div>

                    <form method="post" enctype="multipart/form-data">
                        <div class="row my-2">
                            <div class="tensp">
                                <label for="name">Tên sản phẩm</label>
                                <input class="w-100" type="text" name="name" value="<?php echo $row['name'] ?>" required>
                            </div>
                        </div>
                        <div class="row my-2 g-2 d-flex align-items-center justify-content-center">
                            <div class="gia col-4">
                                <label for="price">Giá sản phẩm</label><br>
                                <input type="text" name="price" value="<?php echo $row['price'] ?>" required>
                            </div>
                            <div class="gia col-4">
                                <label for="price">Tag</label><br>
                                <input type="text" name="tag" value="<?php echo $row['tag'] ?>" required>
                            </div>
                            <div class="img col-4">
                                <label for="image">Ảnh minh họa</label>
                                <span><img width="50" height="50" src="../img/<?php echo $row['img'] ?>"></span>
                                <input type="file" name="image" required>
                            </div>
                        </div>
                        <div class="row my-2 g-2">
                            <div class="mota">
                                <label for="note">Mô tả sản phẩm</label>
                                <input name="note" class="w-100" value="<?php echo $row['note'] ?>" required></input>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center justify-content-center">
                            <button class="btn my-2 bg-primary w-50 text-light" type="submit">Sửa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>