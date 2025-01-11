<?php

namespace App\Models;

use Helpers\Database;

class Transaction
{
    private $id;
    private $accountId;
    private $type;
    private $amount;
    private $beneficiaryAccountId;
    private $createdAt;
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public static function create(Database $db,$accountId, $type, $amount, $beneficiaryAccountId = null)
    {
        $sql = "INSERT INTO transactions (account_id, transaction_type, amount, beneficiary_account_id) VALUES (?, ?, ?, ?)";
        if ($db->query($sql, [$accountId, $type, $amount, $beneficiaryAccountId])) {
            $id = $db->lastInsertId();
            $transaction = new Transaction($db);
            return $transaction->loadById($id);
        }
        return false;
    }

    public function transfer($fromAccountId, $toAccountId, $amount)
    {
        // Create transfer transaction
        if (!$this->create($fromAccountId, 'transfer', $amount, $toAccountId)) {
            return false;
        }

        // Update source account balance
        $fromAccount = new Account($this->db);
        $fromAccount = $fromAccount->loadById($fromAccountId);
        if (!$fromAccount || !$fromAccount->withdraw($amount)) {
            return false;
        }

        // Update beneficiary account balance
        $toAccount = new Account($this->db);
        $toAccount = $toAccount->loadById($toAccountId);
        if (!$toAccount || !$toAccount->deposit($amount)) {
            return false;
        }

        return true;
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
            "SELECT t.*,
                    a1.account_type as source_account_type,
                    a2.account_type as beneficiary_account_type,
                    u1.name as source_name,
                    u2.name as beneficiary_name
            FROM transactions t
            LEFT JOIN accounts a1 ON t.account_id = a1.id
            LEFT JOIN accounts a2 ON t.beneficiary_account_id = a2.id
            LEFT JOIN users u1 ON a1.user_id = u1.id
            LEFT JOIN users u2 ON a2.user_id = u2.id
            WHERE t.account_id = ? OR t.beneficiary_account_id = ?
            ORDER BY t.created_at DESC",
            [$accountId, $accountId]
        );
    }

    private function hydrate($data)
    {
        $this->id = (int)$data['id'];
        $this->accountId = (int)$data['account_id'];
        $this->type = $data['transaction_type'];
        $this->amount = (float)$data['amount'];
        $this->beneficiaryAccountId = $data['beneficiary_account_id'] ? (int)$data['beneficiary_account_id'] : null;
        $this->createdAt = $data['created_at'];
        return $this;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getAccountId() { return $this->accountId; }
    public function getType() { return $this->type; }
    public function getAmount() { return $this->amount; }
    public function getBeneficiaryAccountId() { return $this->beneficiaryAccountId; }
    public function getCreatedAt() { return $this->createdAt; }
}
