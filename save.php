<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode($_POST['data']);
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents('data.json', $json);
    echo 'Dữ liệu đã được lưu trữ thành công!';
}
