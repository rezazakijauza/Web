<?php
class Penjualan{
    // Connection
    private $conn;
    // Table
    private $db_table = "penjualan";
    // Columns
    public $id;
    public $trxid;
    public $date_cell;
    public $nama_customer;
    public $kasir;
    public $grand_total;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getCells(){
        $sqlQuery = "SELECT id, trxid, date_cell, nama_customer, kasir, grand_total FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createCell(){
        $sqlQuery = "INSERT INTO ". $this->db_table ."
        SET
        trxid = :trxid,
        date_cell = :date_cell,
        nama_customer = :nama_customer,
        kasir = :kasir,
        grand_total = :grand_total";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize
        $this->trxid=htmlspecialchars(strip_tags($this->trxid));
        $this->date_cell=htmlspecialchars(strip_tags($this->date_cell));
        $this->nama_customer=htmlspecialchars(strip_tags($this->nama_customer));
        $this->kasir=htmlspecialchars(strip_tags($this->kasir));
        $this->grand_total=htmlspecialchars(strip_tags($this->grand_total));
        // bind data
        $stmt->bindParam(":trxid", $this->trxid);
        $stmt->bindParam(":date_cell", $this->date_cell);
        $stmt->bindParam(":nama_customer", $this->nama_customer);
        $stmt->bindParam(":kasir", $this->kasir);
        $stmt->bindParam(":grand_total", $this->grand_total);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleCell(){
        $sqlQuery = "SELECT
        id,
        trxid,
        date_cell,
        nama_customer,
        kasir,
        grand_total
        FROM
        ". $this->db_table ."
        WHERE
        id = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->trxid = $dataRow['trxid'];
        $this->date_cell = $dataRow['date_cell'];
        $this->nama_customer = $dataRow['nama_customer'];
        $this->kasir = $dataRow['kasir'];
        $this->grand_total = $dataRow['grand_total'];
    }
    
}
?>