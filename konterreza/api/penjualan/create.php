<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../models/penjualan.php';
include_once '../../models/penjualan_detail.php';
$database = new Database();
$db = $database->getConnection();
$item = new Penjualan($db);
$data = json_decode(file_get_contents("php://input"));
$item->trxid = $data->trxid;
$item->date_cell = $data->date_cell;
$item->nama_customer = $data->nama_customer;
$item->kasir = $data->kasir;
$item->grand_total = $data->grand_total;
$db->beginTransaction();
if($item->createCell()){
    $details = new PenjualanDetail($db);
    foreach($data->details as $brg){ 
        $details->kd_brg = $brg->kd_brg;
        $details->trxid = $data->trxid;
        $details->nama_brg = $brg->nama_brg;
        $details->harga_jual = $brg->harga_jual;
        $details->qty = $brg->qty;
        $details->sub_total = $brg->sub_total;
        if(!$details->createCellDetail()){
            $db->rollBack();
            echo json_encode('Produk '.$brg->nama_brg.' saldo tidak mencukupi.');
            return false;
        }
    }
    $db->commit();
    echo json_encode('Penjualan created successfully.');
} else{
    $db->rollBack();
    echo 'Penjualan could not be created.';
}
?>