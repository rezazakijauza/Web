<?php
class User{
    // Connection
    private $conn;
    // Table
    private $db_table = "user";
    // Columns
    public $id;
    public $full_name;
    public $email;
    public $password;
    public $role;
    public $created;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getUsers(){
        $sqlQuery = "SELECT id, full_name, email, password, role, created FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createUser(){
        $sqlQuery = "INSERT INTO ". $this->db_table ."
        SET
        full_name = :full_name, 
        email = :email,
        password = :password,
        role = :role,
        created = :created";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize
        $this->full_name=htmlspecialchars(strip_tags($this->full_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->role=htmlspecialchars(strip_tags($this->role));
        $this->created=htmlspecialchars(strip_tags($this->created));
        // bind data
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":created", $this->created);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleUser(){
        $sqlQuery = "SELECT
        id,
        full_name,
        email,
        password,
        role,
        created
        FROM
        ". $this->db_table ."
        WHERE
        id = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->full_name = $dataRow['full_name'];
        $this->email = $dataRow['email'];
        $this->password = $dataRow['password'];
        $this->role = $dataRow['role'];
        $this->created = $dataRow['created'];
    }
    // UPDATE
    public function updateUser(){
        $sqlQuery = "UPDATE
        ". $this->db_table ."
        SET
        full_name = :full_name,
        email = :email,
        password = :password,
        role = :role,
        created = :created
        WHERE
        id = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        
        $this->full_name=htmlspecialchars(strip_tags($this->full_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->role=htmlspecialchars(strip_tags($this->role));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->id=htmlspecialchars(strip_tags($this->id));
        // bind data
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // DELETE
    function deleteUser(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
?>