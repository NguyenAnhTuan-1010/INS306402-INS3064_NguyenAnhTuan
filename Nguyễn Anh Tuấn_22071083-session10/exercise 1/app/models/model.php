abstract class BaseModel {
    protected string $table;
    protected Database $db;

    abstract public function validate($data): array {

    }

    public function all(): array {
        return $this->db->fetchAll("
            select
                *
            from {$this->table}
        ");
    }

    public function find($conditions): array {
        $keys = array_keys($conditions);
        $query = "
            select
                *
            from {$this->table}
            where

        ";
        foreach ($keys : $key) {
          $query .= "$key = $condtions['$key'] and";  
        }
        $query 
    }
}