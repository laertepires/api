<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "cadastros";
 
    // object properties
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $cpf;
    public $phone;
    public $date_of_birth;
    public $status;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read users
    function read(){
     
        // select all query
        $query = "SELECT * FROM cadastros";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
    // create user
    function create(){
     
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    id=:id, first_name=:first_name, last_name=:last_name, email=:email, cpf=:cpf, phone=:phone, date_of_birth=:date_of_birth, status=:status";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->id='';
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->cpf=htmlspecialchars(strip_tags($this->cpf));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->date_of_birth=htmlspecialchars(strip_tags($this->date_of_birth));
        $this->status=htmlspecialchars(strip_tags($this->status));
     
        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":cpf", $this->cpf);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":date_of_birth", $this->date_of_birth);
        $stmt->bindParam(":status", $this->status);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }
    // used when filling up the update user form
    function readOne(){
     
        // query to read single record
        $query = "SELECT * FROM cadastros  WHERE id = ? LIMIT 0,1";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of user to be updated
        $stmt->bindParam(1, $this->id);
     
        // execute query
        $stmt->execute();
     
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        // set values to object properties
        $this->id = $row['id'];
        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->email = $row['email'];
        $this->cpf = $row['cpf'];
        $this->phone = $row['phone'];
        $this->date_of_birth = $row['date_of_birth'];
        $this->status = $row['status'];
    }
    // update the user
    function update(){
     
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    id =:id,
                    first_name =:first_name,
                    last_name =:last_name,
                    email =:email,
                    cpf =:cpf,
                    phone =:phone,
                    date_of_birth =:date_of_birth,
                    status =:status
                WHERE
                    id =:id";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->id=$this->id;
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->cpf=htmlspecialchars(strip_tags($this->cpf));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->date_of_birth=date('Y-d-m', strtotime(str_replace('-', '/',$this->date_of_birth)));
        $this->status=htmlspecialchars(strip_tags($this->status));


     
        // bind new values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':cpf', $this->cpf);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':date_of_birth', $this->date_of_birth);
        $stmt->bindParam(':status', $this->status);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }
    // delete the user
    function delete(){
     
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
     
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }
    // search users
    function search($keywords){
     
        // select all query
        $query = "SELECT * FROM cadastros
                WHERE
                    first_name LIKE ? OR email LIKE ? OR status LIKE ?";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
     
        // bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

}
?>