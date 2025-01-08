<?php

namespace App\Models;

use Helpers\Database;

class Account
{
    private $id;
    private $userId;
    private $accountType;
    private $balance;
    private $createdAt;
    private $updatedAt;
    private $db;
    private $transactionModel;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->transactionModel = new Transaction($db);
    }

    public function create($userId, $accountType, $balance = 0.00)
    {
        $sql = "INSERT INTO accounts (user_id, account_type, balance) VALUES (?, ?, ?)";
        if ($this->db->query($sql, [$userId, $accountType, $balance])) {
            $this->id = $this->db->lastInsertId();
            return $this->loadById($this->id);
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
        if ($amount <= 0 || $amount > $this->balance) return false;
        
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

        // Perform transfer
        if ($this->updateBalance($this->balance - $amount)) {
            if ($targetAccount->updateBalance($targetAccount->getBalance() + $amount)) {
                $this->transactionModel->create($this->id, 'transfer', $amount);
                return $this;
            }
            // Rollback if target update fails
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
        $this->id = (int)$data['id'];
        $this->userId = (int)$data['user_id'];
        $this->accountType = $data['account_type'];
        $this->balance = (float)$data['balance'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
        return $this;
    }

    // Getters
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

    public function loadByUserId($userId)
    {
        $sql = "SELECT * FROM accounts WHERE user_id = ?";
        $results = $this->db->fetchAll($sql, [$userId]);
        
        $accounts = [];
        foreach ($results as $data) {
            $account = new Account($this->db);
            $account->hydrate($data);
            $accounts[] = $account;
        }
        return $accounts;
    }

    public function getTransactionHistory()
    {
        return $this->transactionModel->getHistory($this->id);
    }
}
