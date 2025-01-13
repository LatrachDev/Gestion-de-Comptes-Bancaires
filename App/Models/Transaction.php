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

    public static function create(Database $db, $accountId, $type, $amount, $beneficiaryAccountId = null)
    {
        $sql = "INSERT INTO transactions (account_id, transaction_type, amount, beneficiary_account_id) VALUES (?, ?, ?, ?)";
        if ($db->query($sql, [$accountId, $type, $amount, $beneficiaryAccountId])) {
            $id = $db->lastInsertId();
            $transaction = self::loadById($db, $id);
            return $transaction;
        }
        return false;
    }


    public static function loadById(Database $db, $id)
    {
        $sql = "SELECT * FROM transactions WHERE id = ?";
        $data = $db->fetch($sql, [$id]);
        if ($data) {
            $transaction = new self($db);
            $transaction->hydrate($data);
            return $transaction;
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
            WHERE t.account_id = ?
            ORDER BY t.created_at DESC",
            [$accountId]
        );
    }

    public static function getAllHistory(Database $db)
    {
        return $db->fetchAll(
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
            ORDER BY t.created_at DESC"
        );
    }
    public static function getAllHistoryByFilters(Database $db, $filters)
    {
        $sql = "SELECT t.*,
                    a1.account_type as source_account_type,
                    a2.account_type as beneficiary_account_type,
                    u1.name as source_name,
                    u2.name as beneficiary_name
            FROM transactions t
            LEFT JOIN accounts a1 ON t.account_id = a1.id
            LEFT JOIN accounts a2 ON t.beneficiary_account_id = a2.id
            LEFT JOIN users u1 ON a1.user_id = u1.id
            LEFT JOIN users u2 ON a2.user_id = u2.id
            WHERE 1=1";
        $params = [];
        if (isset($filters['startDate'])) {
            $sql .= " AND t.created_at >= ?";
            $params[] = $filters['startDate'];
        }
        if (isset($filters['endDate'])) {
            $sql .= " AND t.created_at <= ?";
            $params[] = $filters['endDate'];
        }
        if (isset($filters['type'])) {
            $sql .= " AND t.transaction_type = ?";
            $params[] = $filters['type'];
        }
        if (isset($filters['userName'])) {
            $sql .= " AND (u1.name LIKE ? OR u2.name LIKE ?)";
            $params[] = "%{$filters['userName']}%";
            $params[] = "%{$filters['userName']}%";
        }
        if (isset($filters['amountStart'])) {
            $sql .= " AND t.amount >= ?";
            $params[] = $filters['amountStart'];
        }
        if (isset($filters['amountEnd'])) {
            $sql .= " AND t.amount <= ?";
            $params[] = $filters['amountEnd'];
        }
        if (isset($filters['accountType'])) {
            $sql .= " AND (a1.account_type = ? OR a2.account_type = ?)";
            $params[] = $filters['accountType'];
            $params[] = $filters['accountType'];
        }

        $sql .= " ORDER BY t.created_at DESC";
        return $db->fetchAll($sql, $params);
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

    public function getId()
    {
        return $this->id;
    }
    public function getAccountId()
    {
        return $this->accountId;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function getBeneficiaryAccountId()
    {
        return $this->beneficiaryAccountId;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public static function count(Database $db)
    {
        $sql = "SELECT COUNT(*) as total FROM transactions";
        $data = $db->fetch($sql);
        return $data['total'];
    }
}
