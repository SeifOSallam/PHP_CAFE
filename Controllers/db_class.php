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
            //echo "Record deleted successfully.";
            return true;
        } catch (PDOException $e) {
            //echo "Error deleting record: " . $e->getMessage();
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
    $query = 'SELECT p.id , p.image , p.name , p.stock , c.name as category , p.price 
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
        $query="SELECT COUNT(*) as count FROM $table";
        $stmt = $this->connection->prepare($query);
        try
        {
        $stmt -> execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function selectProducts($page) {
        $query = "SELECT *
                  FROM products 
                  GROUP BY id LIMIT 6 OFFSET "  . (($page - 1) * 6);
       
        $statement = $this->connection->prepare($query);
    
        try {
            $statement->execute();
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            return $products;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
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
    
        $query .= $whereClause . "GROUP BY users.id LIMIT 6 OFFSET " . (($page - 1) * 6);
    
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

        $query = "SELECT order_date, total_amount, id
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

    public function getAllUsersPaginated($offset, $limit) {
        $query = "SELECT * FROM users LIMIT :offset, :limit";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllUsers() {
        $query = "SELECT COUNT(*) FROM users";
        $statement = $this->connection->query($query);
        return $statement->fetchColumn();
    }
    public function getRoomNumbers() {
        $query = "SELECT id FROM rooms";
        $statement = $this->connection->prepare($query);
        try {
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching room numbers: " . $e->getMessage();
            return array(); // Return an empty array in case of an error
        }
    }
    public function resetPassword($email, $newPassword) {
        $query = "UPDATE users SET password = :newPassword WHERE email = :email";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':newPassword', $newPassword);
        $statement->bindParam(':email', $email);

        try {
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error updating password: " . $e->getMessage();
            return false;
        }
    }
        public function checkEmailExists($email) {
        try {
            $stmt = $this->connection->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $count = $stmt->fetchColumn();
            return ($count > 0); 
        } catch(PDOException $e) {
            return false;
        }
    }
    public function getCurrentPassword($email) {
        try {
            $stmt = $this->connection->prepare("SELECT password FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $password = $stmt->fetchColumn();
            return $password;
        } catch(PDOException $e) {
            return null;
        }
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
        $limit = 6;
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
   
    public function orderCount($userId)
      {
    $database = Database::getInstance();

    $query = 'SELECT COUNT(*) AS order_count
              FROM orders
              WHERE user_id = :userId';

    $stmt = $this->connection->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['order_count'];
    } catch (PDOException $e) {
        // Log the error instead of echoing
        error_log("Error fetching order count: " . $e->getMessage());
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

    public function getAllOrders($page, $filters) {
        $query = 
                "SELECT users.username, orders.total_amount, orders.id, users.id as user_id,
                rooms.room_number, orders.status, orders.order_date
                FROM orders 
                INNER JOIN users ON orders.user_id = users.id
                INNER JOIN rooms ON orders.room_id = rooms.id
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
    
        $query .= $whereClause . "LIMIT 6 OFFSET " . (($page - 1) * 6);
        $statement = $this->connection->prepare($query);
    
        try {
            $statement->execute();
            $checks = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $checks;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getOrdersCount($filters) {
        $query = 
                "SELECT COUNT(*) as count
                FROM orders 
                INNER JOIN users ON orders.user_id = users.id
                INNER JOIN rooms ON orders.room_id = rooms.id
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
    public function deleteOrdersForUser($user_id) {
        try {
  
            $stmt = $this->connection->prepare("DELETE FROM order_items WHERE order_id IN (SELECT id FROM orders WHERE user_id = ?)");
            $stmt->execute([$user_id]);
    
            $stmt = $this->connection->prepare("DELETE FROM orders WHERE user_id = ?");
            $stmt->execute([$user_id]);

        } catch (PDOException $e) {
            throw new Exception("Error deleting orders for user: " . $e->getMessage());
        }
    }
    public function comparePassword($email, $password)
    {
        try {
            $query = "SELECT password FROM users WHERE email = :email";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                if ($result['password'] === $password) {
                    return true; 
                } else {
                    return false; 
                }
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }    
    public function getUserByUsername($username) {
        $stmt = $this->connection->prepare("SELECT * FROM " . DB_TABLE . " WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getUserByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM " . DB_TABLE . " WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // public function checkEmailExists($email) {
    //     try {
    //         $stmt = $this->connection->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    //         $stmt->execute([$email]);
    //         $count = $stmt->fetchColumn();
    //         return ($count > 0); 
    //     } catch(PDOException $e) {
    //         return false;
    //     }
   // }
    // public function getCurrentPassword($email) {
    //     try {
    //         $stmt = $this->connection->prepare("SELECT password FROM users WHERE email = ?");
    //         $stmt->execute([$email]);
    //         $password = $stmt->fetchColumn();
    //         return $password;
    //     } catch(PDOException $e) {
    //         return null;
    //     }
    // }
    public function findOneUserByEmail($email) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
        }
        public function selectOne($table, $columns = '*', $where = '', $params = []) {
            $query = "SELECT $columns FROM $table";
            if (!empty($where)) {
                $query .= " WHERE $where";
            }
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function selectAllRooms() {
            try {
                $stmt = $this->connection->query("SELECT id, room_number FROM rooms");
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new Exception("Failed to fetch room numbers: " . $e->getMessage());
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
