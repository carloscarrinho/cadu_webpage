<?php
/**
* Copyright © CarlosCarrinho, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace Cadu\Infrastructure;

use PDO;
use PDOException;

class MySQLAdapter implements DAOInterface
{
    private static $instance;

    private $message;

    public function __construct()
    {
        $this->message = '';
    }

    private static function connect(): ?PDO
    {
        if(empty(self::$instance)) {
            self::$instance = new PDO(
                "mysql:dbname=" . CONF_DB_NAME . ";host=" . CONF_DB_HOSTNAME,
                CONF_DB_USERNAME,
                CONF_DB_PASSWORD
            );
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }

    /**
     * Create record on informed table.
     *
     * @param  string $table
     * @param  array|object $data
     * @return void
     */
    public function create($table, $data)
    {
        $columnsSet = [];
        $valuesSet = [];
        foreach ($data as $column => $value) {
            $columnsSet[] = "{$column}";
            $valuesSet[] = "'{$value}'";
        }

        $columns = implode(', ', array_values($columnsSet));
        $values = implode(', ', array_values($valuesSet));
        $query = "INSERT INTO {$table} ($columns) VALUES ({$values});";

        try {
            self::connect()->beginTransaction();
            $stmt = self::connect()->prepare($query);
            $stmt->execute();
            $this->message = $stmt->rowCount();
            self::connect()->commit();
            return $this->message;

        } catch (PDOException $e) {
            $this->message = $e->getMessage();
            return $this->message;
        }
    }

    public function read($table, $columns = '*', $params = null, $limit = null)
    {
        if (!$params && !$limit) {
            $query = "SELECT {$columns} FROM {$table};";
        }

        if (!$params && $limit) {
            $query = "SELECT {$columns} FROM {$table} LIMIT {$limit}";
        }

        if ($params && !$limit) {
            $keys = implode(', ', array_keys($params));
            $values = implode(', ', array_values($params));
            $query = "SELECT {$columns} FROM {$table} WHERE {$keys}='{$values}';";
        }

        if ($params && $limit) {
            $keys = implode(', ', array_keys($params));
            $values = implode(', ', array_values($params));
            $query = "SELECT {$columns} FROM {$table} WHERE {$keys}='{$values}' LIMIT {$limit};";
        }

        $stmt = self::connect()->query($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function update($table, $param, $data)
    {
        $update = [];
        foreach ($data as $column => $value) {
            $values = "{$column}='{$value}'";
            array_push($update, $values);
        }
        $update = implode(", ", $update);

        $key = implode(', ', array_keys($param));
        $value = implode(', ', array_values($param));

        $query = "UPDATE {$table} SET {$update} WHERE {$key}='{$value}';";

        try {
            self::connect()->beginTransaction();
            $stmt = self::connect()->prepare($query);
            $stmt->execute();
            $this->message = $stmt->rowCount();
            self::connect()->commit();
            return $this->message;

        } catch (PDOException $e) {
            $this->message = $e->getMessage();
            return $this->message;
        }
    }

    public function delete($table, $param)
    {
        $key = implode(', ', array_keys($param));
        $value = implode(', ', array_values($param));

        $query = "DELETE FROM {$table} WHERE {$key}='{$value}';";

        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $this->message = $stmt->rowCount();
            $this->conn->commit();
            return $this->message;

        } catch (PDOException $e) {
            $this->message = $e->getMessage();
            return $this->message;
        }
    }
}
