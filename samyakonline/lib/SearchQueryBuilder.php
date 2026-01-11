<?php
/**
 * Secure Search Query Builder
 * Replaces vulnerable direct SQL concatenation with prepared statements
 */

require_once __DIR__ . '/Security.php';

class SearchQueryBuilder
{
    private $connection;
    private $conditions = [];
    private $params = [];
    private $types = '';
    
    public function __construct($connection)
    {
        $this->connection = $connection;
    }
    
    /**
     * Add a simple equality condition
     */
    public function whereEquals(string $field, $value, string $type = 's'): self
    {
        if ($value !== null && $value !== '') {
            $field = $this->sanitizeFieldName($field);
            $this->conditions[] = "$field = ?";
            $this->params[] = $value;
            $this->types .= $type;
        }
        return $this;
    }
    
    /**
     * Add an IN condition with array of values
     */
    public function whereIn(string $field, $values, string $type = 's'): self
    {
        if (empty($values)) {
            return $this;
        }
        
        // Convert string to array if needed
        if (is_string($values)) {
            $values = array_filter(array_map('trim', explode(',', $values)));
        }
        
        if (!is_array($values) || count($values) === 0) {
            return $this;
        }
        
        $field = $this->sanitizeFieldName($field);
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $this->conditions[] = "$field IN ($placeholders)";
        
        foreach ($values as $value) {
            $this->params[] = $type === 'i' ? (int)$value : $value;
            $this->types .= $type;
        }
        
        return $this;
    }
    
    /**
     * Add a NOT IN condition
     */
    public function whereNotIn(string $field, $values, string $type = 's'): self
    {
        if (empty($values)) {
            return $this;
        }
        
        if (is_string($values)) {
            $values = array_filter(array_map('trim', explode(',', $values)));
        }
        
        if (!is_array($values) || count($values) === 0) {
            return $this;
        }
        
        $field = $this->sanitizeFieldName($field);
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $this->conditions[] = "$field NOT IN ($placeholders)";
        
        foreach ($values as $value) {
            $this->params[] = $type === 'i' ? (int)$value : $value;
            $this->types .= $type;
        }
        
        return $this;
    }
    
    /**
     * Add a LIKE condition (for search)
     */
    public function whereLike(string $field, $value): self
    {
        if ($value !== null && $value !== '') {
            $field = $this->sanitizeFieldName($field);
            $this->conditions[] = "$field LIKE ?";
            $this->params[] = '%' . $value . '%';
            $this->types .= 's';
        }
        return $this;
    }
    
    /**
     * Add multiple LIKE conditions with OR
     */
    public function whereAnyLike(array $fields, $value): self
    {
        if ($value === null || $value === '' || count($fields) === 0) {
            return $this;
        }
        
        $orConditions = [];
        foreach ($fields as $field) {
            $field = $this->sanitizeFieldName($field);
            $orConditions[] = "$field LIKE ?";
            $this->params[] = '%' . $value . '%';
            $this->types .= 's';
        }
        
        // Also check for exact matri_id match
        $orConditions[] = "matri_id = ?";
        $this->params[] = $value;
        $this->types .= 's';
        
        $this->conditions[] = '(' . implode(' OR ', $orConditions) . ')';
        return $this;
    }
    
    /**
     * Add a BETWEEN condition
     */
    public function whereBetween(string $field, $min, $max, string $type = 's'): self
    {
        if ($min !== null && $min !== '' && $max !== null && $max !== '') {
            $field = $this->sanitizeFieldName($field);
            $this->conditions[] = "$field BETWEEN ? AND ?";
            $this->params[] = $min;
            $this->params[] = $max;
            $this->types .= $type . $type;
        }
        return $this;
    }
    
    /**
     * Add an age range condition (calculated from birthdate)
     */
    public function whereAgeBetween($minAge, $maxAge): self
    {
        if ($minAge !== null && $minAge !== '' && $maxAge !== null && $maxAge !== '') {
            $minAge = (int)$minAge;
            $maxAge = (int)$maxAge;
            
            $this->conditions[] = "((
                (date_format(now(), '%Y') - date_format(birthdate, '%Y'))
                - (date_format(now(), '00-%m-%d') < date_format(birthdate, '00-%m-%d'))
            ) BETWEEN ? AND ?)";
            $this->params[] = $minAge;
            $this->params[] = $maxAge;
            $this->types .= 'ii';
        }
        return $this;
    }
    
    /**
     * Add a raw SQL condition (use sparingly and only with static SQL)
     */
    public function whereRaw(string $condition): self
    {
        if (!empty($condition)) {
            // Only allow specific known-safe conditions
            $allowedPatterns = [
                '/^photo1\s*!=\s*\'\'$/',
                '/^photo1_approve\s*=\s*\'APPROVED\'$/',
                '/^photo_protect\s*=\s*\'No\'$/',
                '/^status\s+NOT\s+IN\s*\([\'a-zA-Z,\s]+\)$/',
                '/^mobile_verify_status\s*=\s*\'Yes\'$/',
                '/^samyak_id\s*!=\s*\'\'$/',
            ];
            
            foreach ($allowedPatterns as $pattern) {
                if (preg_match($pattern, trim($condition))) {
                    $this->conditions[] = $condition;
                    return $this;
                }
            }
            
            // Log rejected condition for debugging
            error_log("SearchQueryBuilder: Rejected raw condition: " . $condition);
        }
        return $this;
    }
    
    /**
     * Add a subquery condition for blocked profiles
     */
    public function excludeBlockedBy(string $userId): self
    {
        if (!empty($userId)) {
            $userId = Security::sanitizeProfileId($userId);
            $this->conditions[] = "matri_id NOT IN (SELECT block_by FROM block_profile WHERE block_to = ?)";
            $this->params[] = $userId;
            $this->types .= 's';
        }
        return $this;
    }
    
    /**
     * Exclude specific user
     */
    public function excludeUser(string $userId): self
    {
        if (!empty($userId)) {
            $userId = Security::sanitizeProfileId($userId);
            $this->conditions[] = "matri_id != ?";
            $this->params[] = $userId;
            $this->types .= 's';
        }
        return $this;
    }
    
    /**
     * Get the WHERE clause SQL
     */
    public function getWhereClause(): string
    {
        if (count($this->conditions) === 0) {
            return '';
        }
        return 'AND ' . implode(' AND ', $this->conditions);
    }
    
    /**
     * Get the parameters array
     */
    public function getParams(): array
    {
        return $this->params;
    }
    
    /**
     * Get the types string
     */
    public function getTypes(): string
    {
        return $this->types;
    }
    
    /**
     * Execute a count query
     */
    public function count(string $table, string $distinctField = 'index_id'): int
    {
        $field = $this->sanitizeFieldName($distinctField);
        $table = $this->sanitizeFieldName($table);
        
        $sql = "SELECT COUNT(DISTINCT $field) as cnt FROM $table WHERE 1=1 " . $this->getWhereClause();
        
        $stmt = $this->connection->prepare($sql);
        
        if (!$stmt) {
            error_log("SearchQueryBuilder count prepare failed: " . $this->connection->error);
            return 0;
        }
        
        if (!empty($this->params)) {
            $stmt->bind_param($this->types, ...$this->params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return (int)($row['cnt'] ?? 0);
    }
    
    /**
     * Execute a SELECT query
     */
    public function select(string $table, string $fields, string $orderBy = '', int $limit = 0, int $offset = 0): ?mysqli_result
    {
        $table = $this->sanitizeFieldName($table);
        
        $sql = "SELECT $fields FROM $table WHERE 1=1 " . $this->getWhereClause();
        
        if (!empty($orderBy)) {
            // Validate order by field
            $allowedOrders = ['reg_date DESC', 'last_login DESC', 'pactive_dt DESC'];
            if (in_array($orderBy, $allowedOrders)) {
                $sql .= " ORDER BY " . $orderBy;
            }
        }
        
        if ($limit > 0) {
            $sql .= " LIMIT ?, ?";
            $this->params[] = $offset;
            $this->params[] = $limit;
            $this->types .= 'ii';
        }
        
        $stmt = $this->connection->prepare($sql);
        
        if (!$stmt) {
            error_log("SearchQueryBuilder select prepare failed: " . $this->connection->error);
            return null;
        }
        
        if (!empty($this->params)) {
            $stmt->bind_param($this->types, ...$this->params);
        }
        
        $stmt->execute();
        return $stmt->get_result();
    }
    
    /**
     * Sanitize field/table name to prevent injection
     */
    private function sanitizeFieldName(string $name): string
    {
        // Only allow alphanumeric, underscore, dot, and specific table prefixes
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*(\.[a-zA-Z_][a-zA-Z0-9_]*)?$/', $name)) {
            throw new InvalidArgumentException("Invalid field name: $name");
        }
        return $name;
    }
    
    /**
     * Reset the builder for reuse
     */
    public function reset(): self
    {
        $this->conditions = [];
        $this->params = [];
        $this->types = '';
        return $this;
    }
}

/**
 * Helper function to build search filters from POST data
 */
function buildSearchFilters(SearchQueryBuilder $builder, array $post, array $session): SearchQueryBuilder
{
    // Gender filter
    $gender = getFilterValue($post, $session, 'gender');
    $builder->whereEquals('gender', $gender);
    
    // Age range
    $fromAge = getFilterValue($post, $session, 't3', 'fromage');
    $toAge = getFilterValue($post, $session, 't4', 'toage');
    $builder->whereAgeBetween($fromAge, $toAge);
    
    // Religion filter
    $religion = getFilterValue($post, $session, 'religion');
    $builder->whereIn('religion', $religion, 'i');
    
    // Caste filter
    $caste = getFilterValue($post, $session, 'caste');
    $builder->whereIn('caste', $caste, 'i');
    
    // Country filter
    $country = getFilterValue($post, $session, 'country');
    $builder->whereIn('country_id', $country, 'i');
    
    // State filter
    $state = getFilterValue($post, $session, 'state');
    $builder->whereIn('state_id', $state, 'i');
    
    // City filter
    $city = getFilterValue($post, $session, 'city');
    $builder->whereIn('city', $city, 'i');
    
    // Marital status
    $mStatus = getFilterValue($post, $session, 'm_status');
    if ($mStatus && $mStatus !== 'Any') {
        $builder->whereIn('m_status', $mStatus);
    }
    
    // Education level
    $eduLevel = getFilterValue($post, $session, 'education_level');
    $builder->whereIn('e_level', $eduLevel);
    
    // Education field
    $eduField = getFilterValue($post, $session, 'education_field');
    $builder->whereIn('e_field', $eduField);
    
    // Occupation
    $occupation = getFilterValue($post, $session, 'occupation');
    $builder->whereIn('occupation', $occupation, 'i');
    
    // Height range
    $fromHeight = getFilterValue($post, $session, 'fromheight');
    $toHeight = getFilterValue($post, $session, 'toheight');
    $builder->whereBetween('height', $fromHeight, $toHeight);
    
    // Keyword search
    $keyword = getFilterValue($post, $session, 'keyword');
    if (!empty($keyword)) {
        $keyword = Security::sanitizeProfileId($keyword); // Basic sanitization
        $builder->whereAnyLike(
            ['ocp_name', 'firstname', 'lastname', 'religion_name', 'caste_name', 'city_name'],
            $keyword
        );
    }
    
    // Photo filter
    $photo = getFilterValue($post, $session, 'photo_search');
    if ($photo === 'Yes') {
        $builder->whereRaw("photo1 != ''");
        $builder->whereRaw("photo1_approve = 'APPROVED'");
        $builder->whereRaw("photo_protect = 'No'");
    }
    
    // Profile ID search
    $idSearch = getFilterValue($post, $session, 'id_search');
    if (!empty($idSearch)) {
        $idSearch = Security::sanitizeProfileId($idSearch);
        $builder->whereEquals('matri_id', $idSearch);
    }
    
    // Samyak ID search
    $samyakId = getFilterValue($post, $session, 'samyak_id', 'samyak_id_search');
    if (!empty($samyakId)) {
        $samyakId = Security::sanitizeProfileId($samyakId);
        $builder->whereEquals('samyak_id', $samyakId);
    }
    
    return $builder;
}

/**
 * Get filter value from POST or session
 */
function getFilterValue(array $post, array $session, string $postKey, ?string $sessionKey = null): mixed
{
    $sessionKey = $sessionKey ?? $postKey;
    
    if (!isset($post[$postKey]) || $post[$postKey] === '') {
        return $session[$sessionKey] ?? null;
    }
    
    if ($post[$postKey] === 'null') {
        return null;
    }
    
    $value = $post[$postKey];
    
    // Handle arrays
    if (is_array($value)) {
        $value = implode(',', $value);
    }
    
    return $value;
}
