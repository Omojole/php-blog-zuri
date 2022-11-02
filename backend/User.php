<?php
// create user class and methods
include_once './Connection.php';
class User {
    private $conn;
    private $name;
    private $password;
    private $password_repeat;
    private $email;
    
    public function __construct() {
        $connection = connect();
        $this->conn = $connection;
    }
    
    public function logout(){
        //check if user is logged in
        if(isset($_SESSION['username'])){
            //unset session
            session_unset();
            session_destroy();
            //redirect to login page
            header('Location: ./login.php');
        }
        else{
            //redirect to login page
            header('Location: .');
        }
    }
  
    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE email = '$username'";
        $result = $this->conn->query($sql);
        $user = array();
        if ($result->num_rows > 0) {
            // check if password matches
            while($row = $result->fetch_assoc()) {
                $user = $row;
            }
            if(password_verify($password, $user['password'])){
                return true;
            }
            else{
                return false;
            }

        }
        else{
            return false;
        }

    }

    public function register($name, $email, $password,) {
        $hashed_password = $this->hashPassword($password);
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        $result = $this->conn->query($sql);
        if ($result) {
            return true;
        }
        else{
            return false;
        }
        }

    function passwordMatch($password, $password_repeat){
        if( $password == $password_repeat){
            return true;
        }
        else{
            return false;
        }
    }

    public function hashPassword($password){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $hashed_password;
    }



    // define setters and getters
    public function setUsername($name) {
        $this->username = $name;
    }
    public function getUsername() {
        return $this->name;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function getPassword() {
        return $this->password;
    }
    public function setPassword_repeat($password_repeat) {
        $this->password_repeat = $password_repeat;
    }
    public function getPassword_repeat() {
        return $this->password_repeat;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }

}


