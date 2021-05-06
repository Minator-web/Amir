<?php


namespace Fira\Infrastructure\Database\Sql\MySql;


use Fira\Infrastructure\Database\Sql\AbstractSqlDriver;
use mysqli;
use RuntimeException;
use function PHPUnit\Framework\throwException;

class MySqlDriver extends AbstractSqlDriver
{
    public function __construct(string $host, string $username, string $password, string $dbName, int $port)
    {
        $this->connection = new mysqli($host, $username, $password, $dbName, $port);
        $this->connection->select_db($dbName);
    }

    public function getRowById(int $id, string $table): array
    {
        $rows = $this->select(['*'], $table, 'id = ' . $id);
        if (empty($rows) || !isset($rows[0])) {
            throw new RuntimeException('Row with Id ' . $id . ' not found.');
        }

        return $rows[0];
    }

    public function select(array $field, string $table, string $where): array
    {
        if (empty($field)) {
            throw new RuntimeException('Fields should not be empty');
        }

        if (isset($field[0]) && $field[0] === '*') {
            $fieldString = '*';
        } else {
            $fieldString = implode(',', $field);
        }

        $query = <<<sql
SELECT {$fieldString} FROM {$table} WHERE {$where}; 
sql;

        $mysqlResult = $this->connection->query($query);
        return $mysqlResult->fetch_array();
    }

    public function update(string $query): bool
    {
        if (empty($table_name)) {
            throw new RuntimeException('Table is empty');
        }
        if (empty($columns)) {
            throw new RuntimeException('No columns inserted');
        }
        if (empty($value)) {
            throw new RuntimeException('No values inserted');
        }
        if (empty($condition)) {
            throw new RuntimeException('Condition should not be empty');
        }
        $query = <<<sql
UPDATE {$table_name} SET {$condition} SET {$value} WHERE {$condition}
sql;
        $mysqlResult = $this->connection->query($query);
        if ($mysqlResult == true) {
            return true;
        }
    }
    public function delete(string $query): bool
    {
        if (empty($table_name)) {
            throw new RuntimeException('Table is empty');
        }
        if (empty($condition)) {
            throw new RuntimeException('Condition should not be empty');
        }
        $query = <<<sql
DELETE FROM {$table_name} WHERE {$condition};
sql;
        $mysqlResult = $this->connection->query($query);
        if ($mysqlResult == true) {
            return true;
        }
    }

    public function insert(string $query): bool
    {
        if (empty($values)) {
            throw new RuntimeException('No values inserted');
        }

        if (empty($columns)) {
            throw new RuntimeException('No columns inserted');
        }

        $query = <<<sql
INSERT INTO {$columns} VALUES {$values};
sql;
        $mysqlResult = $this->connection->query($query);
        if ($mysqlResult == true) {
            return true;
        }

    }
}