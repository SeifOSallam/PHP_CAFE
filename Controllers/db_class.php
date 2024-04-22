<?php

require_once '../db_info.php';

class Database {

    private static $instance;
    private $connection;

    private function __construct() 
    {

    }

    public static function getInstance() 
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function connect($host, $username, $password, $database) 
    {
        try {
            $dsn = "mysql:host=$host;dbname=$database";
            $this->connection = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    public function insert($table, $columns, $values) {
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        $statement = $this->connection->prepare($query);

        try {
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error inserting record: " . $e->getMessage();
            return false;
        }
    }

    public function select($table) {
        $query = "SELECT * FROM $table";
        $statement = $this->connection->prepare($query);

        try {
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                return $result;
            } else {
                echo "No users found yet.";
            }
        } catch (PDOException $e) {
            echo "Error selecting records: " . $e->getMessage();
        }
    }

    public function update($table, $id, $fields) {
        $query = "UPDATE $table SET $fields WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        var_dump($statement);
        try {
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error updating record: " . $e->getMessage();
            return false;
        }
    }

    public function delete($table, $id) {
        $query = "DELETE FROM $table WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $statement->execute();
            echo "Record deleted successfully.";
            return true;
        } catch (PDOException $e) {
            echo "Error deleting record: " . $e->getMessage();
            return false;
        }
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM users";

        try
        {
            $statement = $this->connection->prepare($query);
            $res = $statement->execute();
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }
        catch(PDOException $e)
        {
            return "Error";
        }


    }

    public function findOneUser($email,$password)
    {
        $query = "SELECT * FROM users WHERE email= :email AND password= :password";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':email',$email);
        $statement->bindParam(':password',$password);

        try
        {
            $statement->execute();
            if($statement->rowCount() == 1)
            {
                echo "User found!";
                return true;
            }
            echo "User not found!";
            return false;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id',$id);

        try
        {
            $statement->execute();
            $user = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $user;
        }   
        catch (PDOException)
        {
            return "Error";
        }
    }
    public function __destruct() {
        $this->connection = null;
    }

}

$database = Database::getInstance();

$database->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

// $database->select(DB_TABLE);

// $database->insert(DB_TABLE,"name,password,email,room_number", "'Mohamed','123','Mohamed@gmail.com','Application1'");

// $database->update(DB_TABLE,7,"name='hamada',password='1234',room_number='Cloud'");

// $database->delete(DB_TABLE,7);

// $database->findOneUser('omarkhalil117@gmail.com','123');
?>