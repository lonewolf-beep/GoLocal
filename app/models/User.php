<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function create($data) {
        $sql = "INSERT INTO users (username, email, password, full_name, country, phone) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $hashedPassword = password_hash($data['password'], HASH_ALGO);
        
        try {
            $stmt = $this->db->query($sql, [
                $data['username'],
                $data['email'],
                $hashedPassword,
                $data['full_name'],
                $data['country'],
                $data['phone']
            ]);
            return $this->db->getConnection()->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Registration failed: " . $e->getMessage());
        }
    }
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->query($sql, [$email]);
        return $stmt->fetch();
    }
    
    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->query($sql, [$username]);
        return $stmt->fetch();
    }
    
    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }
    
    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
    
    public function emailExists($email) {
        return $this->findByEmail($email) !== false;
    }
    
    public function usernameExists($username) {
        return $this->findByUsername($username) !== false;
    }
}
?>