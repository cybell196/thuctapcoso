
<?php
include 'connect.php';

$type = $_GET['type'];

if ($type == 'province') {
    $sql = "SELECT * FROM province";
} elseif ($type == 'district') {
    $province_id = $_GET['province_id'];
    $sql = "SELECT * FROM district WHERE province_id = $province_id";
} elseif ($type == 'wards') {
    $district_id = $_GET['district_id'];
    $sql = "SELECT * FROM wards WHERE district_id = $district_id";
}

$result = $conn->query($sql);

$data = array();
while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>
