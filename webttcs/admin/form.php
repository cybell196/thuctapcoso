<!DOCTYPE html>
<html>

<!-- Phần đầu -->

<head>
    <title>Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        section{
            padding: 60px 0;
        }
    </style>
</head>

<body>
<?php
    $errorHo = $errorTen = $errorPass = $errorEmail = $errorNgsinh = $errorGioitinh = $errorCity = $errorSothich = $errorMota = "";
    $ho = $ten = $fullName = $matkhau = $tmp = $email = $ngsinh = $gioitinh =  $city = $sothich = $mota = "";
    $eShow1 = "show";
    $eShow2 = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // kiểm tra họ tên
            if (empty($_POST["ho"])){
                $errorHo = "Điền họ";
            } else {
                $ho = testInput($_POST["ho"]);
            }
            if (empty($_POST["ten"])){
                $errorTen = "Điền Tên";
            } else {
                $ten = testInput($_POST["ten"]);
            }
            $fullName = "$ho $ten";
            // kiểm tra password
            if (empty($_POST["matkhau"])) {
                $errorPass = "Mật khẩu chưa được nhập";
            }
            else {
                $tmp = testInput($_POST["matkhau"]);
                if(strlen($tmp) < 6) {
                    $errorPass = "Mật khẩu phải dài hơn 6 ký tự";
                } else {
                    $matkhau = $tmp;
                }
            }
            //kiểm tra email
            if (empty($_POST["email"])) {
                $errorEmail = "Email không được để trống";
            } else {
                $email = testInput($_POST["email"]);
            }
            
            if(empty($errorHo) && empty($errorTen) && empty($errorPass) && empty($errorEmail)){
                $eShow1 = "";
                $eShow2 = "show";
            }
            //kiểm tra ngày sinh
            if (empty($_POST["ngsinh"])) {
                $errorNgsinh = "Ngày sinh không được để trống";
            } else {
                $ngsinh = testInput($_POST["ngsinh"]);
            }
            //kiểm tra giới tính
            if (empty($_POST["gioitinh"])) {
                $errorGioitinh = "Giới tính chưa được chọn";
            } else {
                $gioitinh = $_POST["gioitinh"];
            }
            // kiểm tra nơi ở
            if (empty($_POST["city"])) {
                $city = "";
            } else {
                $city = testInput($_POST["city"]);
            }
            // kiểm tra sở thích (mảng)
            if (empty($_POST["sothich"])) {
                $sothich = "";
            } else {
                $sothich = $_POST["sothich"];
            }
            // kiểm tra mô tả
            if (empty($_POST["mota"])) {
                $mota = "";
            } else {
                $mota = testInput($_POST["mota"]);
            }
        }
    // hàm xóa khoảng trắng, dấu \, chuyển các ký tự đặc biệt thành thực thể html
        function testInput($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

    // thêm class show
    
    
?>
    <!-- Phần HTML -->
    <div class="container-fluid px-5">
        <div class="container mt-5 mx-auto px-5 justify-content-center <?php echo $eShow1 ?>" style="max-width: 80%;">
            <h1 class="">Đăng ký thông tin</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <!-- Họ tên  -->
                <div class="row mb-3 g-2">
                    <div class="col-6">
                        <div class="hoten_input">
                            <label for="ho">Họ</label>  <!--<span class="text-danger"> * <?php echo $errorHo;?></span> <br> -->
                            <input type="text" class="w-100 p-1 mt-1" name="ho" placeholder="Nhập họ của bạn" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="hoten_input">
                            <label for="ten">Tên</label> <!--<span class="text-danger"> * <?php echo $errorTen;?></span> <br> -->
                            <input type="text" class="w-100 p-1 mt-1" name="ten" placeholder="Nhập tên của bạn" required>
                        </div>
                    </div>
                </div>

                <!-- Mật khẩu -->
                <div class="row mb-3 g-2">
                    <div class="col-12">
                        <label for="matkhau">Mật khẩu</label> <!--<span class="text-danger"> * <?php echo $errorPass;?></span> <br> -->
                        <input type="password" class="w-100 p-1 mt-1" name="matkhau" placeholder="Nhập mật khẩu của bạn" required minlength="6" minlength="15" pattern="[A-Za-z0-9]+" title="Chỉ được 6-15 ký tự, gồm chữ thường, in hoa hoặc số">
                    </div>
                </div>

                <!-- Email -->
                <div class="row mb-3 g-2">
                    <div class="col-12">
                        <label for="email">Email</label> <!--<span class="text-danger"> * <?php echo $errorEmail;?></span> <br> -->
                    <input type="email" class="w-100 p-1 mt-1" name="email" placeholder="Nhập email của bạn" required>
                    </div>
                </div>

                <!-- Ngày sinh, giới tính, Thành phố -->
                <div class="row mb-3 g-2">
                    <div class="col-4">
                        <label for="ngaysinh">Ngày sinh</label>
                        <input id="ngaysinh" type="date" name="ngsinh">
                    </div>
                    <div class="col-4">
                        <label for="gioitinh">Giới tính:</label>

                        <input type="radio" id="nam" name="gioitinh" value="Nam">
                        <label for="nam">Nam</label>

                        <input type="radio" id="nu" name="gioitinh" value="Nữ">
                        <label for="nu">Nữ</label>

                        <input type="radio" id="khac" name="gioitinh" value="Khác">
                        <label for="khac">Khác</label>
                    </div>
                    <div class="col-4">
                        <label for="City">Thành phố</label>
                        <select id="City" name="city">
                            <option value="">--Mời Chọn--</option>
                            <option value="Hà Nội">Hà Nội</option>
                            <option value="TP Hồ Chí Minh">TP Hồ Chí Minh</option>
                            <option value="Đà Nẵng">Đà Nẵng</option>
                        </select>
                    </div>
                </div>

                <!-- Sở thích -->
                <div class="mb-3">
                    <label for="sothich">Sở thích</label>
                    <input type="checkbox" id="docsach" name="sothich[]" value="Đọc sách">
                    <label for="docsach">Đọc sách</label>
                    <input type="checkbox" id="nghenhac" name="sothich[]" value="Nghe nhạc">
                    <label for="nghenhac">Nghe nhạc</label>
                    <input type="checkbox" id="xemphim" name="sothich[]" value="Xem phim">
                    <label for="xemphim">Xem phim</label>
                    <input type="checkbox" id="bongda" name="sothich[]" value="Bóng đá">
                    <label for="bongda">Bóng đá</label>
                    <input type="checkbox" id="bongchuyen" name="sothich[]" value="Bóng chuyền">
                    <label for="bongchuyen">Bóng chuyền</label>
                    <input type="checkbox" id="caulong" name="sothich[]" value="Cầu lông">
                    <label for="caulong">Cầu lông</label>
                </div>

                <!-- Mô tả bản thân -->
                <div class="mb-3">
                    <label class="mb-2" for="mota">Mô tả bản thân</label> <br>
                    <textarea id="mota" name="mota" rows="5" cols="30" placeholder=""></textarea>
                </div>

                <!-- Nút -->
                <div class="g-2">
                    <button class="btn btn-primary" type="submit">Đăng ký</button>
                    <button class="btn btn-primary" type="reset">Làm lại</button>
                </div>
            </form>
        </div>

        <!-- Form thông tin đã nhập -->
        <div class="container mt-5 mx-auto px-5 justify-content-center <?php echo $eShow2 ?>" style="max-width: 80%;">
            <h1>Đăng ký thành công</h1>
            <!-- Thông tin đã nhập -->
            <span class="list-inline">
                <h2 class="lead list-inline-item">Xin chào <p class="text-primary list-inline-item"><?php echo $fullName?></p></h2>
            </span>
            <p class="lead">Email: <?php echo $email?> </p>
            <p class="lead">Mật khẩu: <?php echo $matkhau?> </p>
            <p class="lead text-dark">
                <?php
                    if(!empty($ngsinh)) {
                        echo "Ngày sinh: " . $ngsinh . " (yyyy/mm/dd) <br>";
                    }
                    if(!empty($gioitinh)) {
                        echo "Giới tính: " . $gioitinh . "<br>";
                    }
                    if(!empty($city)) {
                        echo "Nơi ở: " . $city . "<br>";
                    }
                    if(!empty($sothich)) {
                        echo "Sở thích: ";
                        foreach ($sothich as $st){
                            echo $st . ", ";
                        }
                        echo "<br>";
                    }
                    if(!empty($mota)) {
                        echo "Mô tả: " . $mota . "<br>";
                    }
                ?>
            </p>
            <a href="form.php" class="btn btn-primary">Quay lại</a>        

        </div>
    </div>
    
    <style>
        .container{
            display: none;
        }
        .show{
            display: block;
        }
    </style>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    
</body>

</html>