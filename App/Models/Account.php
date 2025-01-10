<?php

namespace App\Models;

use Helpers\Database;

class Account
{
    private $id;
    private $userId;
    private $accountType;
    private $balance;
    private $status;
    private $createdAt;
    private $updatedAt;
    private $db;
    private $transactionModel;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->transactionModel = new Transaction($db);
    }


    public function hasAccountOfType($userId, $accountType)
    {
        $sql = "SELECT * FROM accounts WHERE user_id = ? AND account_type = ?";
        $data = $this->db->fetch($sql, [$userId, $accountType]);
        return $data ? true : false;
    }

    public static function create(Database $db, $userId, $accountType, $balance = 0.00)
    {
        if (!in_array($accountType, ['savings', 'current'])) {
            return false;
        }
        $sql = "INSERT INTO accounts (user_id, account_type, balance, status) VALUES (?, ?, ?, 'active')";
        if ($db->query($sql, [$userId, $accountType, $balance])) {
            $account = new self($db);
            $account->loadById($db->lastInsertId());
            return $account;
        }
        return false;
    }

    public function loadById($id)
    {
        $sql = "SELECT * FROM accounts WHERE id = ?";
        $data = $this->db->fetch($sql, [$id]);
        if ($data) {
            $this->hydrate($data);
            return $this;
        }
        return false;
    }

    public function deposit($amount)
    {
        if ($amount <= 0) return false;

        if ($this->updateBalance($this->balance + $amount)) {
            $this->transactionModel->create($this->id, 'deposit', $amount);
            return $this;
        }
        return false;
    }

    public function withdraw($amount)
    {
        if ($amount <= 0 || $amount > $this->balance) return 10;

        if ($this->updateBalance($this->balance - $amount)) {
            $this->transactionModel->create($this->id, 'withdrawal', $amount);
            return $this;
        }
        return false;
    }

    public function transfer($amount, $toAccountId)
    {
        $targetAccount = $this->loadById($toAccountId);

        if (!$targetAccount || !$this->validateTransfer($amount, $targetAccount)) {
            return false;
        }

        if ($this->updateBalance($this->balance - $amount)) {
            if ($targetAccount->updateBalance($targetAccount->getBalance() + $amount)) {
                $this->transactionModel->create($this->id, 'transfer', $amount);
                return $this;
            }
            $this->updateBalance($this->balance + $amount);
        }
        return false;
    }

    private function validateTransfer($amount, $targetAccount)
    {
        return $amount > 0 &&
            $amount <= $this->balance &&
            $targetAccount &&
            $targetAccount->getUserId() === $this->userId;
    }

    private function updateBalance($newBalance)
    {
        $sql = "UPDATE accounts SET balance = ? WHERE id = ?";
        if ($this->db->query($sql, [$newBalance, $this->id])) {
            $this->balance = $newBalance;
            return true;
        }
        return false;
    }

    private function hydrate($data)
    {
        $this->id = $data['id'];
        $this->userId = $data['user_id'];
        $this->accountType = $data['account_type'];
        $this->balance = $data['balance'];
        $this->status = $data['status'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getAccountType()
    {
        return $this->accountType;
    }
    public function getBalance()
    {
        return $this->balance;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function suspend()
    {
        $sql = "UPDATE accounts SET status = 'suspended' WHERE id = ?";
        if ($this->db->query($sql, [$this->id])) {
            $this->status = 'suspended';
            return true;
        }
        return false;
    }

    public function activate()
    {
        $sql = "UPDATE accounts SET status = 'active' WHERE id = ?";
        if ($this->db->query($sql, [$this->id])) {
            $this->status = 'active';
            return true;
        }
        return false;
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public static function loadByUserId(Database $db, $userId)
    {
        $sql = "SELECT * FROM accounts WHERE user_id = ?";
        $results = $db->fetchAll($sql, [$userId]);

        $accounts = [];
        foreach ($results as $data) {
            $account = new Account($db);
            $account->hydrate($data);
            $accounts[] = $account;
        }
        return $accounts;
    }

    public function getTransactionHistory()
    {
        return $this->transactionModel->getHistory($this->id);
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

}
