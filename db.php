<?php
/**
 * Database connection using PDO.
 *
 * This file returns a singleton PDO instance. Adjust the DSN, username and password
 * to match your local MySQL configuration.
 */

class Database
{
    /** @var \PDO|null */
    private static $pdo = null;

    /**
     * Get the PDO connection.
     *
     * @return \PDO
     */
    public static function getConnection(): \PDO
    {
        if (self::$pdo === null) {
            $host = 'localhost';
            $conn   = 'komputasi3_db';
            $user = 'root';
            $pass = '';
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$conn;charset=$charset";
            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            try {
                self::$pdo = new \PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                // In a real app you would log this error.
                throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>