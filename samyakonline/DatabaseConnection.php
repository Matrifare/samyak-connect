<?php
/**
 * Secure Database Connection Class
 * Uses environment variables for credentials
 * Implements prepared statements pattern
 */
session_start();
date_default_timezone_set("Asia/Kolkata");

class DatabaseConnection
{
    public $dbLink;
    public $sqlQuery;
    public $dbResult;
    public $dbRow;
    
    private static $instance = null;
    
    function __construct() {
        $this->dbLink = null;
        $this->sqlQuery = '';
        $this->dbResult = '';
        $this->dbRow = '';
        
        // Load credentials from environment or config file
        $config = $this->loadConfig();
        
        $this->dbLink = mysqli_connect(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['database']
        );
        
        if (!$this->dbLink) {
            error_log("Database connection failed: " . mysqli_connect_error());
            throw new RuntimeException("Database connection failed. Please try again later.");
        }
        
        $this->dbLink->query("SET character_set_results=utf8");
        mb_language('uni');
        mb_internal_encoding('UTF-8');
        $this->dbLink->query("set names 'utf8'");
    }
    
    /**
     * Load database configuration from environment or config file
     * IMPORTANT: Create a config/database.local.php file with your credentials
     */
    private function loadConfig(): array {
        // Try to load from config file first (should be gitignored)
        $configFile = __DIR__ . '/config/database.local.php';
        if (file_exists($configFile)) {
            return require $configFile;
        }
        
        // Try environment variables
        $host = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? null);
        $username = getenv('DB_USERNAME') ?: ($_ENV['DB_USERNAME'] ?? null);
        $password = getenv('DB_PASSWORD') ?: ($_ENV['DB_PASSWORD'] ?? null);
        $database = getenv('DB_DATABASE') ?: ($_ENV['DB_DATABASE'] ?? null);
        
        if ($host && $username && $database) {
            return [
                'host' => $host,
                'username' => $username,
                'password' => $password ?? '',
                'database' => $database
            ];
        }
        
        // Fallback for development only - should be replaced in production
        error_log("WARNING: Using default database credentials. Set DB_* environment variables for production.");
        return [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'samyak'
        ];
    }

    function convertToLocalHtml($localHtmlEquivalent) {
        $localHtmlEquivalent = mb_convert_encoding($localHtmlEquivalent, "HTML-ENTITIES", "UTF-8");
        return $localHtmlEquivalent;
    }

    /**
     * Execute a SELECT query with prepared statements
     * @param string $query SQL query with ? placeholders
     * @param array $params Parameters to bind
     * @param string $types Parameter types (s=string, i=integer, d=double, b=blob)
     * @return mysqli_result|false
     */
    function preparedSelect(string $query, array $params = [], string $types = ''): mysqli_result|false {
        $stmt = $this->dbLink->prepare($query);
        
        if (!$stmt) {
            error_log("Prepare failed: " . $this->dbLink->error);
            return false;
        }
        
        if (!empty($params)) {
            if (empty($types)) {
                $types = str_repeat('s', count($params));
            }
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        return $stmt->get_result();
    }
    
    /**
     * Execute an INSERT/UPDATE/DELETE query with prepared statements
     * @param string $query SQL query with ? placeholders
     * @param array $params Parameters to bind
     * @param string $types Parameter types
     * @return bool Success status
     */
    function preparedExecute(string $query, array $params = [], string $types = ''): bool {
        $stmt = $this->dbLink->prepare($query);
        
        if (!$stmt) {
            error_log("Prepare failed: " . $this->dbLink->error);
            return false;
        }
        
        if (!empty($params)) {
            if (empty($types)) {
                $types = str_repeat('s', count($params));
            }
            $stmt->bind_param($types, ...$params);
        }
        
        return $stmt->execute();
    }
    
    /**
     * Get last insert ID
     */
    function getLastInsertId(): int {
        return (int) $this->dbLink->insert_id;
    }
    
    /**
     * Escape string for legacy queries (use prepared statements instead when possible)
     */
    function escapeString(string $value): string {
        return mysqli_real_escape_string($this->dbLink, $value);
    }

    /**
     * @deprecated Use preparedSelect() instead
     */
    function getSelectQueryResult($selectQuery) {
        $this->dbLink->query("SET character_set_results=utf8");
        $this->sqlQuery = $selectQuery;
        $this->dbResult = $this->dbLink->query($this->sqlQuery);
        return $this->dbResult;
    }

    /**
     * @deprecated Use preparedExecute() instead
     */
    function updateData($updateQuery) {
        $this->dbLink->query("SET character_set_results=utf8");
        $this->sqlQuery = $updateQuery;
        $this->dbResult = $this->dbLink->query($this->sqlQuery);
        if ($this->dbResult)
            return true;
        else
            return false;
    }
}

if(!function_exists('base_url')) {
    function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), -1, PREG_SPLIT_NO_EMPTY);
            $core = $core[0] ?? '';

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/samyakonline.com/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }
}
