<?php
/**
 * Base Model class providing generic CRUD operations.
 *
 * Child classes must define the protected static string $tableName
 * and optionally a protected static array $fields (list of column names
 * without the primary key). The primary key is assumed to be 'id'.
 */

require_once __DIR__ . '/db.php';

abstract class Model
{
    /** @var \PDO */
    protected $pdo;

    /** Name of the database table. Must be set in child class. */
    protected static string $tableName = '';

    /** Columns that are allowed to be mass‑assigned (excluding the primary key). */
    protected static array $fields = [];

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /** Create a new record.
     * @param array $data Associative array column => value.
     * @return int Inserted ID.
     */
    public function create(array $data): int
    {
        $fields = [];
        $placeholders = [];
        $values = [];
        foreach (static::$fields as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = $field;
                $placeholders[] = ':' . $field;
                $values[$field] = $data[$field];
            }
        }
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            static::$tableName,
            implode(', ', $fields),
            implode(', ', $placeholders)
        );
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return (int)$this->pdo->lastInsertId();
    }

    /** Retrieve a single record by primary key. */
    public function find(int $id): ?array
    {
        $sql = sprintf("SELECT * FROM %s WHERE id = :id", static::$tableName);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /** Retrieve all records. */
    public function all(): array
    {
        $sql = sprintf("SELECT * FROM %s", static::$tableName);
        return $this->pdo->query($sql)->fetchAll();
    }

    /** Update a record by primary key. */
    public function update(int $id, array $data): bool
    {
        $setParts = [];
        $values = [];
        foreach (static::$fields as $field) {
            if (array_key_exists($field, $data)) {
                $setParts[] = "$field = :$field";
                $values[$field] = $data[$field];
            }
        }
        if (empty($setParts)) {
            return false; // nothing to update
        }
        $values['id'] = $id;
        $sql = sprintf(
            "UPDATE %s SET %s WHERE id = :id",
            static::$tableName,
            implode(', ', $setParts)
        );
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    /** Delete a record by primary key. */
    public function delete(int $id): bool
    {
        $sql = sprintf("DELETE FROM %s WHERE id = :id", static::$tableName);
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>