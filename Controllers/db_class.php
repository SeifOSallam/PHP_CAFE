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
            return $this->connection->lastInsertId();
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
                return $statement->fetchAll(PDO::FETCH_ASSOC);
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
    public function addToCart($user_id,$product_id,$product_price)
    {
        try
        {
            $query = "INSERT INTO cart (user_id,product_id,quantity,product_price) VALUES ($user_id,$product_id,1,$product_price)";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            echo "success !!";
            return true;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
    }

    public function getUserItems($table,$user_id)
    {
        $user_id = (int)$user_id;

        $query = "SELECT * FROM $table c 
        INNER JOIN products p 
        ON c.product_id = p.id
        WHERE c.user_id = $user_id";

        $stmt = $this->connection->prepare($query);

        try
        {
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }
    }

    public function updateQty($table, $id, $fields) {
        $query = "UPDATE $table SET $fields WHERE product_id = :id";
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

    public function deleteItem($table, $product_id , $user_id) {
        echo "table {$table} product {$product_id}  user {$user_id}";
        $query = "DELETE FROM $table WHERE product_id = :id AND user_id = :user_id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $product_id, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        try {
            $statement->execute();
            echo "Record deleted successfully.";
            return true;
        } catch (PDOException $e) {
            echo "Error deleting record: " . $e->getMessage();
            return false;
        }
    }

    

    public function getChecks($page, $filters) {
        $query = "SELECT users.username, SUM(orders.total_amount) as total_amount, users.id
                  FROM orders 
                  INNER JOIN users ON orders.user_id = users.id
                  ";
    
        $whereClause = "";
        if (isset($filters['user'])) {
            $whereClause .= " WHERE users.username = '{$filters['user']}'";
        }
        if (isset($filters['date_from'])) {
            $whereClause .= ($whereClause ? " AND" : " WHERE") . " orders.order_date >= '{$filters['date_from']}'";
        }
        if (isset($filters['date_to'])) {
            $whereClause .= ($whereClause ? " AND" : " WHERE") . " orders.order_date <= '{$filters['date_to']}'";
        }
    
        $query .= $whereClause . "GROUP BY users.username LIMIT 6 OFFSET " . (($page - 1) * 6);
    
        $statement = $this->connection->prepare($query);
    
        try {
            $statement->execute();
            $checks = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $checks;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getUserCheckOrders($userId, $filters) {

        $query = "SELECT order_date, total_amount
                  FROM orders 
                  ";
    
        $whereClause = "";
        if (isset($filters['date_from'])) {
            $whereClause .= ($whereClause ? " AND" : " WHERE") . " orders.order_date >= '{$filters['date_from']}'";
        }
        if (isset($filters['date_to'])) {
            $whereClause .= ($whereClause ? " AND" : " WHERE") . " orders.order_date <= '{$filters['date_to']}'";
        }
        
        $whereClause .= ($whereClause ? " AND" : " WHERE") . " user_id = '$userId'";
        
        $query .= $whereClause;
    
        $statement = $this->connection->prepare($query);
    
        try {
            $statement->execute();
            $checks = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $checks;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    

    public function __destruct() {
        $this->connection = null;
    }
    public function getOrdersOnlyForUserDate($userId, $startDate, $endDate){ 
        $database = Database::getInstance();
        $query = 'SELECT id , order_date, total_amount, notes, room_id, status
                FROM orders 
                WHERE user_id = :userId
                AND order_date >= :startDate
                AND order_date <= :endDate';
        
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

    public function getOrdersOnlyForUserWithPage($userId, $page)
    {
        $database = Database::getInstance();
        $limit = 4;
        $offset = ($page - 1) * $limit;
    
        $query = 'SELECT id , order_date, total_amount, notes, room_id, status
                  FROM orders
                  WHERE user_id = :userId
                  LIMIT :limit
                  OFFSET :offset';
    
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    
        try {
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } catch (PDOException $e) {
            // Log the error instead of echoing
            error_log("Error fetching orders: " . $e->getMessage());
            return false; 
        }
    }
    public function getOrderDetailsByOrderId($orderId){
        $database = Database::getInstance();

        $query = 'SELECT o.id AS order_id, o.order_date, o.total_amount, o.notes, o.room_id, o.status, oi.quantity, p.name AS product_name, p.price AS product_price, p.image as image 
                FROM orders o 
                JOIN order_items oi ON o.id = oi.order_id 
                JOIN products p ON oi.product_id = p.id 
                WHERE o.id = :orderId';

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);

        try {
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } catch (PDOException $e) {

            error_log("Error fetching order details: " . $e->getMessage());
            return false; 
        }
     }
}

$database = Database::getInstance();

$database->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

// $res = $database->getUserCartItems(1);

// var_dump($database->getProductById(1));
// $database->select(DB_TABLE);

// $database->insert(DB_TABLE,"name,password,email,room_number", "'Mohamed','123','Mohamed@gmail.com','Application1'");

// $database->update(DB_TABLE,7,"name='hamada',password='1234',room_number='Cloud'");

// $database->delete(DB_TABLE,7);

// $database->findOneUser('omarkhalil117@gmail.com','123');
?>