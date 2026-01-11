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
    protected array $hidden = ['password'];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Find record by primary key
     */
    public function find($id): ?array
    {
        $result = $this->db->selectOne(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?",
            [$id]
        );
        return $result ? $this->hideFields($result) : null;
    }

    /**
     * Find record by column value
     */
    public function findBy(string $column, $value): ?array
    {
        $result = $this->db->selectOne(
            "SELECT * FROM {$this->table} WHERE {$column} = ?",
            [$value]
        );
        return $result ? $this->hideFields($result) : null;
    }

    /**
     * Get all records
     */
    public function all(string $orderBy = null, string $direction = 'ASC', int $limit = null): array
    {
        $query = "SELECT * FROM {$this->table}";
        
        if ($orderBy) {
            $query .= " ORDER BY {$orderBy} {$direction}";
        }
        
        if ($limit) {
            $query .= " LIMIT {$limit}";
        }

        $results = $this->db->select($query);
        return array_map([$this, 'hideFields'], $results);
    }

    /**
     * Get records with conditions
     */
    public function where(array $conditions, string $orderBy = null, string $direction = 'ASC', int $limit = null): array
    {
        $whereClause = [];
        $params = [];

        foreach ($conditions as $column => $value) {
            if (is_array($value)) {
                $whereClause[] = "{$column} {$value[0]} ?";
                $params[] = $value[1];
            } else {
                $whereClause[] = "{$column} = ?";
                $params[] = $value;
            }
        }

        $query = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $whereClause);

        if ($orderBy) {
            $query .= " ORDER BY {$orderBy} {$direction}";
        }

        if ($limit) {
            $query .= " LIMIT {$limit}";
        }

        $results = $this->db->select($query, $params);
        return array_map([$this, 'hideFields'], $results);
    }

    /**
     * Get single record with conditions
     */
    public function whereFirst(array $conditions): ?array
    {
        $results = $this->where($conditions, null, 'ASC', 1);
        return $results[0] ?? null;
    }

    /**
     * Create new record
     */
    public function create(array $data): int
    {
        $filteredData = $this->filterFillable($data);
        
        $columns = implode(', ', array_keys($filteredData));
        $placeholders = implode(', ', array_fill(0, count($filteredData), '?'));

        return $this->db->insert(
            "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})",
            array_values($filteredData)
        );
    }

    /**
     * Update record
     */
    public function update($id, array $data): int
    {
        $filteredData = $this->filterFillable($data);
        
        $setClause = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($filteredData)));
        $params = array_values($filteredData);
        $params[] = $id;

        return $this->db->update(
            "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?",
            $params
        );
    }

    /**
     * Delete record
     */
    public function delete($id): int
    {
        return $this->db->delete(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?",
            [$id]
        );
    }

    /**
     * Count records
     */
    public function count(array $conditions = []): int
    {
        if (empty($conditions)) {
            $result = $this->db->selectOne("SELECT COUNT(*) as count FROM {$this->table}");
        } else {
            $whereClause = [];
            $params = [];

            foreach ($conditions as $column => $value) {
                $whereClause[] = "{$column} = ?";
                $params[] = $value;
            }

            $result = $this->db->selectOne(
                "SELECT COUNT(*) as count FROM {$this->table} WHERE " . implode(' AND ', $whereClause),
                $params
            );
        }

        return (int) ($result['count'] ?? 0);
    }

    /**
     * Check if record exists
     */
    public function exists(array $conditions): bool
    {
        return $this->count($conditions) > 0;
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

    /**
     * Execute raw query
     */
    public function raw(string $query, array $params = []): array
    {
        return $this->db->select($query, $params);
    }

    /**
     * Execute raw query and get single result
     */
    public function rawOne(string $query, array $params = []): ?array
    {
        return $this->db->selectOne($query, $params);
    }
}
