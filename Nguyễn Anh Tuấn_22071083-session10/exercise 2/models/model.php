<?php
    require_once "../config/config.php";

    abstract class BaseModel {
        protected string $table;
        protected PDO $dbConnection;

        public function __construct(string $table_name): void {
            $this->dbConnection = Database::getInstance()->getConnection();
            $this->table = $table_name;
        }

        abstract public function validate($data): bool;

        public function all(): array {
            $query = "
                select
                    *
                from
                {$this->table}
            ";
            $stmt = ($this->dbConnection)->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        }

        public function find($conditions): array {
            if (count($conditions) == 0) return [];
            $keys = array_keys($conditions);
            $vals = array_values($conditions);
            $where = implode(" and ", array_map(function ($key) {
                return "{$key} = :{$key}";
            }, $keys));
            $query = "
                select
                    *
                from {$this->table}
                where {$where}
            ";
            $params = [];
            for ($i = 0; $i < count($keys); $i++) {
                $params[":{$keys[$i]}"] = $vals[$i];
            }
            $stmt = ($this->dbConnection)->prepare($query);
            $stmt->execute($params);
            $data = $stmt->fetchAll();
            return $data;
        }

        public function getTableName(): string {
            return $this->table;
        }

        protected function getDBConnection(): PDO {
            return $this->dbConnection;
        }
    }
?>