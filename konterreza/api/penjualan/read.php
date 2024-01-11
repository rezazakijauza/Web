<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");

    include_once '../../config/database.php';
    include_once '../../models/barang.php';

    $database = new Database();
    $db = $database->getConnection();
    if(isset($_GET['id'])){
        $item = new barang($db);
        $item->id = isset($_GET['id']) ? $_GET['id'] : die();
        $item->getSinglebarang();
        if($item->name != null){
            // create array
            $emp_arr = array(
            "id" => $item->id,
            "kd_brg" => $item->kd_brg,
            "nama_brg" => $item->nama_brg,
            "harga_brg" => $item->harga_brg,
            "stock" => $item->stock,
            "jenis_brg" => $item->jenis_brg,
            "harga_beli" => $item->harga_beli
            );
            http_response_code(200);
            echo json_encode($emp_arr);
            }
            else{
            http_response_code(404);
            echo json_encode("user not found.");
            }
    }
    else {
        $items = new barang($db);
        $stmt = $items->getbarang();
        $itemCount = $stmt->rowCount();

        echo json_encode($itemCount);
        if($itemCount > 0){
            $barangArr = array();
            $barangArr["body"] = array();
            $barangArr["itemCount"] = $itemCount;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $b = array(
                "id" => $id,
                "kd_brg" => $kd_brg,
                "nama_brg" => $nama_brg,
                "harga_brg" => $harga_brg,
                "stock" => $stock,
                "jenis_brg" => $jenis_brg,
                "harga_beli" => $harga_beli
                );
                array_push($barangArr["body"], $b);
            }
            echo json_encode($barangArr);
        }
        else{
            http_response_code(404);
            echo json_encode(
                array("message" => "No record found.")
            );
        }   
    }
?>