<?php

namespace App\Models;

use Helpers\Database;
use LDAP\Result;

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $profilePic;
    private $role;
    private $status;
    private $createdAt;
    private $updatedAt;
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    // load all clients
    public static function loadAllClients(Database $db)
    {
        $sql = "SELECT * FROM users WHERE role = 'client'";
        $data = $db->fetchAll($sql);

        $users = [];
        foreach ($data as $userData) {
            $user = new self($db);
            $user->hydrate($userData);
            $users[] = $user;
        }
        return $users;
    }

    public static function loadAll(Database $db)
    {
        $sql = "SELECT * FROM users";
        $data = $db->fetchAll($sql);

        $users = [];
        foreach ($data as $userData) {
            $user = new self($db);
            $user->hydrate($userData);
            $users[] = $user;
        }
        return $users;
    }

    public static function count(Database $db)
    {
        $sql = "SELECT COUNT(*) as total FROM users";
        $data = $db->fetch($sql);
        return $data['total'];
    }

    public static function create(Database $db, $name, $email, $password, $profilePic = null, $role = 'client')
    {
        $user = new self($db);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password, profile_pic, role, status) VALUES (?, ?, ?, ?, ?, 'active')";
        $result = $db->query($sql, [$name, $email, $hashedPassword, $profilePic, $role]);
        if ($result) {
            $user->id = $db->lastInsertId();
            $user->name = $name;
            $user->email = $email;
            $user->password = $hashedPassword;
            $user->profilePic = $profilePic;
            $user->role = $role;
            $user->status = 'active';
            return $user;
        }
        return false;
    }

    public static function loadById(Database $db, $id)
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

    public static function loadByEmail(Database $db, $email)
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

    public static function loadByName(Database $db, $name)
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
        // return $this->password == $password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function suspend()
    {
        $sql = "UPDATE users SET status = 'suspended' WHERE id = ?";
        if ($this->db->query($sql, [$this->id])) {
            $this->status = 'suspended';
            return true;
        }
        return false;
    }

    public function activate()
    {
        $sql = "UPDATE users SET status = 'active' WHERE id = ?";
        if ($this->db->query($sql, [$this->id])) {
            $this->status = 'active';
            return true;
        }
        return false;
    }

    private function hydrate($data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->profilePic = $data['profile_pic'];
        $this->role = $data['role'];
        $this->status = $data['status'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getProfilePic()
    {
        return $this->profilePic;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setProfilePic($profilePic)
    {
        $this->profilePic = $profilePic;
    }

    public function save()
    {
        $query = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $params = [
            'name' => $this->name,
            'email' => $this->email,
            'id' => $this->id
        ];

        return $this->db->query($query, $params);
    }
}
