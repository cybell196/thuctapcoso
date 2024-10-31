<?php
        include "connect.php";
        $name = $price = $note = $image = $tag = "";
        $error = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(!empty($_POST['name'])){
                $name = $_POST['name'];
            }
            if(!empty($_POST['tag'])){
                $tag = $_POST['tag'];
            }
            if(!empty($_POST['price'])){
                $price = $_POST['price'];
            }

            if(!empty($_POST['note'])){
                $note = $_POST['note'];
            }

            if(!empty($_FILES['image']['name'])){
                $image = $_FILES['image']['name'];
            }
            $sql = " INSERT INTO product (name, price, note, tag, img, sold) 
            VALUES ('$name', '$price', '$note', '$tag', '$image', 1) ";

            if($name != "" && $price != "" && $note != "" && $image != ""){
                mysqli_query($conn, $sql);
                header("Location: admin.php");
            }else{
                $error = "Hãy nhập đủ dữ liệu";
            }
        }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h4><?php echo $error?></h4>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
            <div class="row my-2">
                <div class="tensp">
                    <label for="name">Tên sản phẩm</label>
                    <input class="w-100" type="text" name="name" required>
                </div>
            </div>

            <div class="row my-2 g-2">
                <div class="gia col-4">
                    <label for="price">Giá sản phẩm</label><br>
                    <input type="text" name="price" required>
                </div>
                <div class="gia col-4">
                    <label for="price">Tag</label><br>
                    <input type="text" name="tag" required>
                </div>
                <div class="img col-4">
                    <label for="image">Ảnh minh họa</label>
                    <input type="file" name="image" required>
                </div>
            </div>
            <div class="row my-2 g-2">
                <div class="mota">
                    <label for="note">Mô tả sản phẩm</label>
                    <input name="note" class="w-100" required></input>
                </div>
            </div>
            
            <div class="row d-flex align-items-center justify-content-center">
                <button class="btn my-2 bg-primary w-50 text-light" type="submit">Thêm sản phẩm</button>
            </div>
    </form>
</body>
</html>