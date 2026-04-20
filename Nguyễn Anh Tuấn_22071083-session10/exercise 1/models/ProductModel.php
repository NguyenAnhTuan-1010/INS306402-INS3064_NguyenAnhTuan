<?php
    require_once "model.php";

    class ProductModel extends BaseModel {
        public function __construct(string $table_name): void {
            parent::__construct($table_name);
        }

        private function isContainSpecialChar(string $str): bool {
            if (preg_match("/[^a-zA-Z0-9]/", $str)) return true;
            return false;
        }

        public function validate($data): bool {
            /*
                data = {productName: ?, productPrice: ?}
            */
            if (empty($data)) return false;

            $product_name = $data["productName"];
            $product_price = $data["productPrice"];
            if ((strlen($product_name) <= 1) || $this->isContainSpecialChar($product_name)) {
                return false;
            }
            if ($product_price < 0) return false;
            return true;
        }
    }
?>