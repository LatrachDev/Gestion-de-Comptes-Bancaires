<?php

namespace App\Models;

use Helpers\Database;

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $profilePic;
    private $createdAt;
    private $updatedAt;
    private $role = 'client';
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public static function create($db, $name, $email, $password, $profilePic = null)
    {
        $user = new self($db);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (name, email, password, profile_pic) VALUES (?, ?, ?, ?)";
        $result = $db->query($sql, [$name, $email, $hashedPassword, $profilePic]);
        
        if ($result) {
            $user->id = $db->lastInsertId();
            $user->name = $name;
            $user->email = $email;
            $user->password = $hashedPassword;
            $user->profilePic = $profilePic;
            return $user;
        }
        return null;
    }

    public static function loadById($db, $id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $data = $db->fetch($sql, [$id]);
        
        if ($data) {
            $user = new self($db);
            $user->hydrate($data);
            return $user;
        }
        return null;
    }

    public static function loadByEmail($db, $email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $data = $db->fetch($sql, [$email]);
        
        if ($data) {
            $user = new self($db);
            $user->hydrate($data);
            return $user;
        }
        return null;
    }

    public static function loadByName($db, $name)
    {
        $sql = "SELECT * FROM users WHERE name = ?";
        $data = $db->fetch($sql, [$name]);
        
        if ($data) {
            $user = new self($db);
            $user->hydrate($data);
            return $user;
        }
        return null;
    }

    public function update()
    {
        $sql = "UPDATE users SET name = ?, email = ?, profile_pic = ? WHERE id = ?";
        return $this->db->query($sql, [$this->name, $this->email, $this->profilePic, $this->id]) !== false;
    }

    public function changePassword($newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if ($this->db->query($sql, [$hashedPassword, $this->id])) {
            $this->password = $hashedPassword;
            return true;
        }
        return false;
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    private function hydrate($data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->profilePic = $data['profile_pic'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }
    public function getProfilePic() { return $this->profilePic; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getUpdatedAt() { return $this->updatedAt; }

    public function setName($name) { $this->name = $name; }
    public function setEmail($email) { $this->email = $email; }
    public function setProfilePic($profilePic) { $this->profilePic = $profilePic; }
}