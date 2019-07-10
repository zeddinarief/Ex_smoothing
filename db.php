<?php
class db{
    private $conn;
    private $host;
    private $user;
    private $password;
    private $baseName;
    private $port;
    function __construct() {
        $this->conn = false;
        $this->host = 'localhost'; //hostname
        $this->user = 'root'; //username
        $this->password = ''; //password
        $this->db = 'exponential_smoothing'; //name of your database
        $this->connect();
    }
    function connect() {
        if (!$this->conn) {
            $this->conn = mysqli_connect($this->host, $this->user, $this->password,$this->db); 
            if (mysqli_connect_errno()){
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                die();
            } 
        }
        return $this->conn;
    }
    function getDataLatih(){
        $query="select * from dataLatih";
        $result = $this->conn->query($query);
        $dataLatih=[];
        if ($result->num_rows >= 0) {
            while($row = $result->fetch_assoc()) {
                array_push($dataLatih,$row);
            }
        }
        return $dataLatih; 
    }
    function getDataUji(){
        $query="select * from dataUji";
        $result = $this->conn->query($query);
        $dataUji=[];
        if ($result->num_rows >= 0) {
            while($row = $result->fetch_assoc()) {
                array_push($dataUji,$row);
            }
        }
        return $dataUji; 
    }

        function getDataL(){
        $query="select * from dataLatih";
        $result = $this->conn->query($query);
        $dataLatih=[];
        if ($result->num_rows >= 0) {
            while($row = $result->fetch_assoc()) {
                array_push($dataLatih,$row);
            }
        }
        return $dataLatih; 
    }
    function getDataU($bulan){
        // $query="select * from dataUji where bulan='$bulan'";
        $query="select * from dataUji";
        $result = $this->conn->query($query);
        $dataUji=[];
        if ($result->num_rows >= 0) {
            while($row = $result->fetch_assoc()) {
                array_push($dataUji,$row);
            }
        }
        return $dataUji;
    }

    function deleteData($table, $id){
        $query="DELETE FROM ".$table." WHERE id=".$id;
        $result = $this->conn->query($query);
        return $result;
    }

    function addData($table,$data){
        $query = "INSERT INTO ".$table." (tgl, hasil_penjualan) VALUES ('".$data['tgl']."', ".$data['hasil_penjualan'].")";
        $result = $this->conn->query($query);
        return $result;
    }
    function editData($table,$data,$id){
        $query = "UPDATE ".$table." SET tgl='".$data['tgl']."', hasil_penjualan=".$data['hasil_penjualan']." WHERE id=".$id;
        $result = $this->conn->query($query);
        return $result;
    }

}

?>