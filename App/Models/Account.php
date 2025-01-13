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

    public static function count(Database $db)
    {
        $sql = "SELECT COUNT(*) as count FROM accounts";
        $data = $db->fetch($sql);
        return $data['count'];
    }


    public static function getTotals(Database $db)
    {
        $sql = "SELECT SUM(balance) as total FROM accounts";
        $data = $db->fetch($sql);
        return $data['total'];
    }

    public static function create(Database $db, $userId, $accountType, $balance = 0.00)
    {
        if (!in_array($accountType, ['savings', 'current'])) {
            return false;
        }
        $sql = "INSERT INTO accounts (user_id, account_type, balance, status) VALUES (?, ?, ?, 'active')";
        if ($db->query($sql, [$userId, $accountType, $balance])) {
            $id = $db->lastInsertId();
            $account = self::loadById($db, $id);
            return $account;
        }
        return false;
    }

    public static function loadById(Database $db, $id)
    {
        $sql = "SELECT * FROM accounts WHERE id = ?";
        $data = $db->fetch($sql, [$id]);
        if ($data) {
            $account = new self($db);
            $account->hydrate($data);
            return $account;
        }
        return false;
    }

    public function deposit($amount, $addTransaction = true)
    {
        if ($amount <= 0) return false;

        if ($this->updateBalance($this->balance + $amount)) {
            if ($addTransaction) {
                $transaction = Transaction::create($this->db, $this->id, 'deposit', $amount);
                return $transaction;
            }
            return true;
        }
        return false;
    }

    public function withdraw($amount, $addTransaction = true)
    {
        if ($amount <= 0 || $amount > $this->balance) {
            return 10;
        }

        if ($this->updateBalance($this->balance - $amount)) {
            if ($addTransaction) {
                $transaction = Transaction::create($this->db, $this->id, 'withdrawal', $amount);
                return $transaction;
            }
            return true;
        }
        return false;
    }

    public static function transferFromTo(Database $db, $fromAccountId, $toAccountId, $amount)
    {
        $fromAccount = self::loadById($db, $fromAccountId);
        $toAccount = self::loadById($db, $toAccountId);

        if (!$fromAccount || !$toAccount) {
            return false;
        }

        if (!$fromAccount->withdraw($amount, false)) {
            return false;
        }

        if (!$toAccount->deposit($amount, false)) {
            return false;
        }

        $transaction = Transaction::create($db, $fromAccountId, 'transfer', $amount, $toAccountId);
        return $transaction;
    }
    public function transfer($amount, $toAccountId)
    {
        $fromAccount = $this;
        $toAccount = Account::loadById($this->db, $toAccountId);

        if (!$toAccount) {
            return false;
        }

        if (!$fromAccount->withdraw($amount, false)) {
            return false;
        }

        if (!$toAccount->deposit($amount, false)) {
            return false;
        }

        $transaction = Transaction::create($this->db, $fromAccount->getId(), 'transfer', $amount, $toAccountId);
        return $transaction;
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

    public static function loadAccountById(Database $db, $id)
    {
        $sql = "SELECT * FROM accounts WHERE id = ?";
        $data = $db->fetch($sql, [$id]);
        return $data;
    }
    public static function validateTransferById($amount, $id, $balance, $userId)
    {
        return $amount > 0 &&
            $amount <= $balance &&
            $id === $userId;
    }

    public static function updateBalanceById($id, $balance, $db)
    {
        $sql = "UPDATE accounts SET balance = ? WHERE id = ?";
        if ($db->query($sql, [$balance, $id])) {
            return true;
        }
        return false;
    }
}
