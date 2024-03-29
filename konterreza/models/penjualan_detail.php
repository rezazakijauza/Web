<?php
class PenjualanDetail{
    // Connection
    private $conn;
    // Table
    private $db_table = "penjualan_detail";
    private $dbm_table = "brg";
    // Columns
    public $id;
    public $kd_brg;
    public $trxid;
    public $nama_brg;
    public $harga_jual;
    public $qty;
    public $sub_total;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getCellDetails(){
        $sqlQuery = "SELECT id, kd_brg, trxid, nama_brg, harga_jual, qty, sub_total FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createCellDetail(){
        if($this->checkStock()){
            $sqlQuery = "INSERT INTO ". $this->db_table ."
            SET
            kd_brg = :kd_brg,
            trxid = :trxid,
            nama_brg = :nama_brg,
            harga_jual = :harga_jual,
            qty = :qty,
            sub_total = :sub_total";
            $stmt = $this->conn->prepare($sqlQuery);
            // sanitize
            $this->kd_brg=htmlspecialchars(strip_tags($this->kd_brg));
            $this->trxid=htmlspecialchars(strip_tags($this->trxid));
            $this->nama_brg=htmlspecialchars(strip_tags($this->nama_brg));
            $this->harga_jual=htmlspecialchars(strip_tags($this->harga_jual));
            $this->qty=htmlspecialchars(strip_tags($this->qty));
            $this->sub_total=htmlspecialchars(strip_tags($this->sub_total));
            // bind data
            $stmt->bindParam(":kd_brg", $this->kd_brg);
            $stmt->bindParam(":trxid", $this->trxid);
            $stmt->bindParam(":nama_brg", $this->nama_brg);
            $stmt->bindParam(":harga_jual", $this->harga_jual);
            $stmt->bindParam(":qty", $this->qty);
            $stmt->bindParam(":sub_total", $this->sub_total);
            if($stmt->execute()){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }
    // READ single
    public function checkStock(){
        $sqlQuery = "SELECT
        id,
        kd_brg,
        stock 
        FROM
        ". $this->dbm_table ."
        WHERE
        kd_brg = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->kd_brg);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->kd_brg = $dataRow['kd_brg'];
        $stock = $dataRow['stock'];
        $saldo = $stock - $this->qty;
        if($saldo < 0 ){
            return false;
        }else{   
            $this->updateStock($saldo);
            return true;
        }
    }

    public function updateStock($saldo){
        $sqlQuery = "UPDATE
        ". $this->dbm_table ."
        SET
        stock = :stock 
        WHERE
        kd_brg = :kd_brg";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":kd_brg", $this->kd_brg);
        $stmt->bindParam(":stock", $saldo);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function setDecrease(){
        $sqlQuery = "SELECT
        id,
        kd_brg,
        trxid,
        nama_brg,
        harga_jual,
        qty,
        sub_total
        FROM
        ". $this->db_table ."
        WHERE
        trxid = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dataRow;
    }
    
}
?>