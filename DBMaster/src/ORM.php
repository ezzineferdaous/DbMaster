<?php
require_once './config/Database.php';
require_once './interfaces/ORMInterface.php';

// diffinition des methoded'un object
class ORM implements ORMInterface {
    // attribut dinamique
    protected static $table;
    protected $attributes = [];
    protected static $columns = [];

    public function __construct($attributes = []) {
        $this->attributes = $attributes;
    }

    public function save() {
        $columns = array_keys($this->attributes);//check table exist
        $placeholders = array_map(function($col) { return ":$col"; }, $columns);
        $sql = "INSERT INTO " . static::$table . " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";
        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute($this->attributes);
    }
    public function update() {
        $setClause = [];
        foreach ($this->attributes as $column => $value) {
            $setClause[] = "$column = :$column";
        }
        $sql = "UPDATE " . static::$table . " SET " . implode(", ", $setClause) . " WHERE id = :id";
        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute($this->attributes);
    }

    public function delete() {
        $sql = "DELETE FROM " . static::$table . " WHERE id = :id";
        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute([':id' => $this->attributes['id']]);
    }

    public static function find($id) {
        $sql = "SELECT * FROM " . static::$table . " WHERE id = :id";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findAll() {
        $sql = "SELECT * FROM " . static::$table;
        $stmt = Database::getInstance()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteAll() {
        $sql = "DELETE FROM " . static::$table;
        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute();
    }

    public static function createTable() {
        $columnsSql = [];
        foreach (static::$columns as $column => $type) {
            switch ($type) {
                case 'string':
                    $columnsSql[] = "$column VARCHAR(255)";
                    break;
                case 'integer':
                    $columnsSql[] = "$column INT";
                    break;
                case 'boolean':
                    $columnsSql[] = "$column TINYINT(1)";
                    break;
                case 'timestamp':
                    $columnsSql[] = "$column TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
                    break;
                default:
                    throw new Exception("Unsupported type: $type");
            }
        }
        // implode concatenet columes
        $columnsSql = implode(", ", $columnsSql);
        $sql = "CREATE TABLE IF NOT EXISTS " . static::$table . " (
            id INT AUTO_INCREMENT PRIMARY KEY, $columnsSql
        )";
        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute();
    }

    public static function updateSchema() {
        // For simplicity, this method will drop and recreate the table
        $sql = "DROP TABLE IF EXISTS " . static::$table;
        $stmt = Database::getInstance()->prepare($sql);
        if ($stmt->execute()) {
            return static::createTable();
        }
        return false;
    }
    public static function addColumn($column, $type) {
        switch ($type) {
            case 'string':
                $columnType = 'VARCHAR(255)';
                break;
            case 'integer':
                $columnType = 'INT';
                break;
            case 'boolean':
                $columnType = 'TINYINT(1)';
                break;
            case 'timestamp':
                $columnType = 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
                break;
            default:
                throw new Exception("Unsupported type: $type");
        }

        $sql = "ALTER TABLE " . static::$table . " ADD COLUMN $column $columnType";
        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute();
    }

    public static function dropColumn($column) {
        $sql = "ALTER TABLE " . static::$table . " DROP COLUMN $column";
        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute();
    }
}
?>
