<?php
$newConnection = new Connection();
session_start();
class Connection
{
    private $server = "mysql:host=localhost;agua_db";
    private $username = "root";
    private $password = "";
    private $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ];
    protected $conn;

    public function openConnection(): PDO
    {
        try {
            $this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
            return $this->conn;
        } catch (PDOException $e) {
            echo "There is a problem is the connection: " . $e->getMessage();
        }
    }
    public function listOfCategories()
    {
        if (!$this->conn) {
            $this->openConnection();
        }

        $query = "SELECT category_id, category_name FROM category_table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $categories = $stmt->fetchAll();

        return $categories;
    }

    public function getCategoryNameById($id)
    {
        $query = "SELECT category_name FROM category_table WHERE category_id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        $category = $stmt->fetch(PDO::FETCH_OBJ);

        return $category ? $category->category_name : null;
    }

    public function addCategory()
    {
        if (isset($_POST['add_category'])) {
            $category_name = trim($_POST['category_name']);

            if (empty($category_name)) {
                $_SESSION["error"] = "Category name cannot be empty.";
                header("Location: index.php");
                exit();
            }

            try {
                $connection = $this->openConnection();
                $query = "INSERT INTO category_table (category_name) VALUES (:category_name)";
                $stmt = $connection->prepare($query);

                $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);

                $stmt->execute();

                $_SESSION["create"] = "Category added successfully";
                header("Location: index.php");
                exit();
            } catch (PDOException $e) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION["error"] = "Error: " . $e->getMessage();
                header("Location: index.php");
                exit();
            }
        }
    }

    public function addProduct()
    {
        if (isset($_POST['add_product'])) {

            $product_name = $_POST['product_name'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $created_at = $_POST['created_at'];
            isset($_POST['created_at']) && !empty($_POST['created_at']) ? $_POST['created_at'] : date('Y-m-d H:i:s');


            try {
                $connection = $this->openConnection();
                $query = "INSERT INTO products_table (`product_name`, `category_id`, `price`, `quantity`, `created_at`) VALUES (?, ?, ?, ?, ?)";
                $stmt = $connection->prepare($query);
                $stmt->execute([$product_name, $category, $price, $quantity, $created_at]);
                $_SESSION["create"] = "Product added successfully";
                header("Location: index.php");
                exit();
            } catch (PDOException $e) {
                session_start();
                $_SESSION["error"] = "Error: " . $e->getMessage();

                header("Location: index.php");
                exit();
            }
        }
    }

    public function editProduct()
    {
        if (isset($_POST['edit_product'])) {

            $product_id = $_POST['product_id'];

            $product_name = $_POST['product_name'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $created_at = $_POST['created_at'];

            try {
                $connection = $this->openConnection();
                $query = "UPDATE products_table SET product_name = ?, category_id = ?, price = ?, quantity = ?, created_at = ? WHERE product_id = ?";
                $stmt = $connection->prepare($query);
                $stmt->execute([$product_name, $category, $price, $quantity, $created_at, $product_id]);

                $_SESSION["create"] = "Product updated successfully";
                header("Location: index.php");
                exit();
            } catch (PDOException $e) {
                session_start();
                $_SESSION["error"] = "Error: " . $e->getMessage();

                header("Location: index.php");
                exit();
            }
        }
    }

    public function deleteProduct()
    {
        if (isset($_POST['delete_product'])) {
            $product_id = $_POST['delete_product'];

            try {
                $connection = $this->openConnection();
                $query = "DELETE FROM products_table WHERE product_id = :product_id";
                $stmt = $connection->prepare($query);
                $stmt->execute(["product_id" => $product_id]);

                $_SESSION["create"] = "Product id:$product_id deleted successfully";
                header("Location: index.php");
                exit();
            } catch (PDOException $e) {
                session_start();
                $_SESSION["error"] = "Error: " . $e->getMessage();

                header("Location: index.php");
                exit();
            }
        }
    }

    public function searchProducts()
    {
        if (isset($_POST['search_btn'])) {
            $searchTerm = trim($_POST['search_input']);

            if (empty($searchTerm)) {
                return $this->getAllProducts();
            }

            try {
                $connection = $this->openConnection();
                $searchTerm = "%" . $searchTerm . "%";
                $stmt = $connection->prepare('SELECT * FROM products_table WHERE product_id LIKE :searchTerm or product_name LIKE :searchTerm OR category LIKE :searchTerm OR price LIKE :searchTerm OR quantity LIKE :searchTerm OR created_at LIKE :searchTerm');
                $stmt->bindParam(':searchTerm', $searchTerm);
                $stmt->execute();
                $result = $stmt->fetchAll();

                if (empty($result)) {
                    return $this->getAllProducts();
                }

                return $result;
            } catch (PDOException $e) {
                session_start();
                $_SESSION["error"] = "Error: " . $e->getMessage();

                header("Location: index.php");
                exit();
            }
        }

        return $this->getAllProducts();
    }

    public function filterProducts()
    {
        if (isset($_POST['filter_btn'])) {
            $searchTerm = trim($_POST['filter_input']);

            if (empty($searchTerm)) {
                return $this->getAllProducts();
            }

            try {
                $connection = $this->openConnection();

                if ($searchTerm === "In Stock") {
                    $stmt = $connection->prepare('SELECT * FROM products_table WHERE quantity > 0');
                } elseif ($searchTerm === "Out Stock") {
                    $stmt = $connection->prepare('SELECT * FROM products_table WHERE quantity = 0');
                } elseif ($searchTerm === "All") {
                    return $this->getAllProducts();
                } else {
                    $searchTerm = "%" . $searchTerm . "%";
                    $stmt = $connection->prepare('SELECT * FROM products_table WHERE category LIKE :searchTerm');
                    $stmt->bindParam(':searchTerm', $searchTerm);
                }

                $stmt->execute();
                $result = $stmt->fetchAll();

                if (empty($result)) {
                    return $this->getAllProducts();
                }

                return $result;
            } catch (PDOException $e) {
                session_start();
                $_SESSION["error"] = "Error: " . $e->getMessage();
                header("Location: index.php");
                exit();
            }
        }

        return $this->getAllProducts();
    }

    public function filterByDate()
    {
        if (!isset($_POST['filterDate_btn'])) {
            return $this->getAllProducts();
        }

        $startDate = trim($_POST['start_date']);
        $endDate = trim($_POST['end_date']);

        if (empty($startDate) && empty($endDate)) {
            return $this->getAllProducts();
        }

        try {
            $connection = $this->openConnection();
            $query = 'SELECT * FROM products_table WHERE 1=1';

            if (!empty($startDate) && !empty($endDate)) {
                $query .= ' AND created_at BETWEEN :startDate AND :endDate';
                $stmt = $connection->prepare($query);
                $stmt->bindParam(':startDate', $startDate);
                $stmt->bindParam(':endDate', $endDate);
            } elseif (!empty($startDate)) {
                $query .= ' AND created_at >= :startDate';
                $stmt = $connection->prepare($query);
                $stmt->bindParam(':startDate', $startDate);
            } elseif (!empty($endDate)) {
                $query .= ' AND created_at <= :endDate';
                $stmt = $connection->prepare($query);
                $stmt->bindParam(':endDate', $endDate);
            }

            $stmt->execute();
            $result = $stmt->fetchAll();

            if (empty($result)) {
                return $this->getAllProducts();
            }

            return $result;
        } catch (PDOException $e) {
            session_start();
            $_SESSION["error"] = "Error: " . $e->getMessage();
            header("Location: index.php");
            exit();
        }
    }


    public function getAllProducts()
    {
        try {
            $connection = $this->openConnection();
            $stmt = $connection->prepare('SELECT * FROM products_table');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            session_start();
            $_SESSION["error"] = "Error: " . $e->getMessage();
            header("Location: index.php");
            exit();
        }
    }

    public function registerUser()
    {
        $connection = $this->openConnection();
        if (isset($_POST['register_user'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $address = $_POST['address'];
            $birthday = $_POST['bday'];
            $gender = $_POST['gender'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = 'user';

            $stmt = $connection->prepare('INSERT INTO user_table (first_name, last_name, address, birthdate, gender, username, password, role) VALUES (:first_name, :last_name, :address, :birthdate, :gender, :username, :password, :role)');

            $result = $stmt->execute([
                'first_name' => $firstname,
                'last_name' => $lastname,
                'address' => $address,
                'birthdate' => $birthday,
                'gender' => $gender,
                'username' => $username,
                'password' => $password,
                'role' => $role,
            ]);

            if ($result) {
                $_SESSION['name'] = $firstname;
                header('Location: index.php');
            } else {
                header('Location: login.php');
            }
        }
    }

    public function userLogin()
    {
        $connection = $this->openConnection();
        if (isset($_POST['user_login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $connection->prepare('SELECT * FROM user_table WHERE username=:username AND password=:password');
            $user->execute(['username' => $username, 'password' => $password]);
            $result = $user->fetch();
            if ($result) {
                $_SESSION['name'] = $username;
                header('Location: index.php');
            } else {
                header('Location: login.php');
            }
        }
    }

    public function useLogout()
    {
        if (isset($_POST['user_out'])) {
            session_destroy();
            header('Location: login.php');
        }
    }
}
