<?php
namespace myproject\model;

include_once __DIR__ . '/../config/connect.php';
class UsersModel
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB();
    }
    public function getAll()
    {
        $db = connectDB();
        $stmt = $db->prepare("SELECT * FROM product");
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $products;
    }
    public function addUser($email, $username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
        $stmt->execute([
            'email' => $email,
            'username' => $username,
            'password' => $hashedPassword
        ]);
        return true;
    }


    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }

    public function verifyUser($email, $password)
    {
        $user = $this->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}
?>
