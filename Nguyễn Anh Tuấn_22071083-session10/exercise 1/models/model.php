<?php
require_once "../config/config.php";

abstract class BaseModel {
    protected string $table;
    protected PDO $db;

    public function __construct(string $table_name) {
        // Giả sử Database class của bạn trả về đối tượng PDO
        $this->db = Database::getInstance()->getConnection();
        $this->table = $table_name;
    }

    /**
     * Thay đổi trả về array để chứa danh sách lỗi
     * Nếu không có lỗi, trả về mảng rỗng []
     */
    abstract public function validate(array $data): array;

    // Lấy tất cả bản ghi
    public function all(): array {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        // Nên dùng FETCH_ASSOC để dễ xử lý dữ liệu ở View
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tìm kiếm theo điều kiện (AND)
    public function find(array $conditions): array {
        if (empty($conditions)) {
            return [];
        }
        
        $columns = array_keys($conditions);
        $where = implode(" AND ", array_map(fn($col) => "$col = :$col", $columns));

        $query = "SELECT * FROM {$this->table} WHERE $where";
        $stmt = $this->db->prepare($query);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm bổ sung: Thêm dữ liệu động (Cần thiết cho store() của bạn)
    public function add(array $data): bool {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);

        return $stmt->execute($data);
    }

    protected function getDBConnection(): PDO {
        return $this->db;
    }
}