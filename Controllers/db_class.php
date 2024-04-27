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
    public function getProductById($id)
    {
        $query = "SELECT * FROM products WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id',$id);

        try
        {
            $statement->execute();
            $product = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $product;
        }   
        catch (PDOException)
        {
            return "Error";
        }
    }

    public function getProductsWithPage($page)
    {
    $database = Database::getInstance();

    $query = 'SELECT p.id , p.image , p.name , c.name as category , p.price 
            FROM products p
            INNER JOIN categories c 
            ON p.category_id = c.id
            limit 6
            OFFSET '.(($page-1)*6).'
            ;';

            $stmt = $this->connection->prepare($query);
            try
            {
                $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $res;
            }
            catch (PDOException $e)
            {
                echo $e->getMessage();
            }
    
    }

    public function getCount($table)
    {
        $query="SELECT COUNT(*) FROM $table";
        $stmt = $this->connection->prepare($query);
        try
        {
        $stmt -> execute();
        $res = $stmt->fetch();
        return $res;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }

    }
    public function getOrdersForUser($userId)
    {
        $database = Database::getInstance();
        $query = 'SELECT o.id AS order_id, o.order_date, o.total_amount, o.notes, o.room_id, o.status, oi.quantity, p.name AS product_name, p.price AS product_price, p.image as image 
                  FROM orders o 
                  JOIN order_items oi ON o.id = oi.order_id 
                  JOIN products p ON oi.product_id = p.id 
                  WHERE o.user_id = :userId';
        
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    
        try {
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false; // Handle the error as needed
        }
    }
    public function getChecks($page) {
        $query = "SELECT users.username, orders.total_amount 
        FROM orders, users WHERE orders.user_id = users.id 
        limit 6
        OFFSET ".(($page)*6)."
        ;";
        $statement = $this->connection->prepare($query);

        try
        {
            $statement->execute();
            $checks = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $checks;
        }   
        catch (PDOException)
        {
            return "Error";
        }
    }

    public function __destruct() {
        $this->connection = null;
    }

    public function getOrdersForUserDate($userId, $startDate, $endDate)
    {
    $database = Database::getInstance();
    $query = 'SELECT o.id AS order_id, o.order_date, o.total_amount, o.notes, o.room_id, o.status, oi.quantity, p.name AS product_name, p.price AS product_price, p.image as image 
              FROM orders o 
              JOIN order_items oi ON o.id = oi.order_id 
              JOIN products p ON oi.product_id = p.id 
              WHERE o.user_id = :userId
              AND o.order_date >= :startDate
              AND o.order_date <= :endDate';
    
    $stmt = $this->connection->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
    $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);

    try {
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false; 
    }
    }
}

$database = Database::getInstance();

$database->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

// var_dump($database->getProductById(1));
// $database->select(DB_TABLE);

// $database->insert(DB_TABLE,"name,password,email,room_number", "'Mohamed','123','Mohamed@gmail.com','Application1'");

// $database->update(DB_TABLE,7,"name='hamada',password='1234',room_number='Cloud'");

// $database->delete(DB_TABLE,7);

// $database->findOneUser('omarkhalil117@gmail.com','123');
?>