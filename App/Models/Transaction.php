<?php

namespace App\Models;

use Helpers\Database;

class Transaction
{
    private $id;
    private $accountId;
    private $type;
    private $amount;
    private $createdAt;
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create($accountId, $type, $amount)
    {
        $sql = "INSERT INTO transactions (account_id, transaction_type, amount) VALUES (?, ?, ?)";
        if ($this->db->query($sql, [$accountId, $type, $amount])) {
            $this->id = $this->db->lastInsertId();
            return $this->loadById($this->id);
        }
        return false;
    }

    public function loadById($id)
    {
        $sql = "SELECT * FROM transactions WHERE id = ?";
        $data = $this->db->fetch($sql, [$id]);
        if ($data) {
            $this->hydrate($data);
            return $this;
        }
        return false;
    }

    public function getHistory($accountId)
    {
        return $this->db->fetchAll(
            "SELECT * FROM transactions WHERE account_id = ? ORDER BY created_at DESC",
            [$accountId]
        );
    }

    private function hydrate($data)
    {
        $this->id = (int)$data['id'];
        $this->accountId = (int)$data['account_id'];
        $this->type = $data['transaction_type'];
        $this->amount = (float)$data['amount'];
        $this->createdAt = $data['created_at'];
        return $this;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getAccountId() { return $this->accountId; }
    public function getType() { return $this->type; }
    public function getAmount() { return $this->amount; }
    public function getCreatedAt() { return $this->createdAt; }
}
