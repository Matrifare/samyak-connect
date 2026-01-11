<?php
/**
 * Base Model Class
 * Provides common database operations
 */

namespace App\Core;

abstract class Model
{
    protected Database $db;
    protected string $table = '';
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $hidden = [];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Find record by primary key
     */
    public function find($id): ?array
    {
        return $this->db->selectOne(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?",
            [$id]
        );
    }

    /**
     * Get all records
     */
    public function all(int $limit = 100): array
    {
        return $this->db->select(
            "SELECT * FROM {$this->table} LIMIT ?",
            [$limit]
        );
    }

    /**
     * Create new record
     */
    public function create(array $data): int
    {
        $data = $this->filterFillable($data);
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        return $this->db->insert(
            "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})",
            array_values($data)
        );
    }

    /**
     * Update record
     */
    public function update($id, array $data): bool
    {
        $data = $this->filterFillable($data);
        $sets = implode(' = ?, ', array_keys($data)) . ' = ?';
        $params = array_values($data);
        $params[] = $id;

        return $this->db->update(
            "UPDATE {$this->table} SET {$sets} WHERE {$this->primaryKey} = ?",
            $params
        ) > 0;
    }

    /**
     * Delete record
     */
    public function delete($id): bool
    {
        return $this->db->delete(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?",
            [$id]
        ) > 0;
    }

    /**
     * Find by column value
     */
    public function findBy(string $column, $value): ?array
    {
        return $this->db->selectOne(
            "SELECT * FROM {$this->table} WHERE {$column} = ?",
            [$value]
        );
    }

    /**
     * Get all by column value
     */
    public function getAllBy(string $column, $value, int $limit = 100): array
    {
        return $this->db->select(
            "SELECT * FROM {$this->table} WHERE {$column} = ? LIMIT ?",
            [$value, $limit]
        );
    }

    /**
     * Count records
     */
    public function count(string $where = '', array $params = []): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table}";
        if ($where) {
            $query .= " WHERE {$where}";
        }
        $result = $this->db->selectOne($query, $params);
        return (int) ($result['count'] ?? 0);
    }

    /**
     * Filter data to only fillable fields
     */
    protected function filterFillable(array $data): array
    {
        if (empty($this->fillable)) {
            return $data;
        }
        return array_intersect_key($data, array_flip($this->fillable));
    }

    /**
     * Hide sensitive fields from output
     */
    protected function hideFields(array $data): array
    {
        foreach ($this->hidden as $field) {
            unset($data[$field]);
        }
        return $data;
    }
}
