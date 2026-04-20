<?php
require_once "BaseController.php";
require_once "../../models/ProductModel.php";

class ProductController extends BaseController {
    protected ProductModel $productModel;
    
    public function __construct() {
        $this->productModel = new ProductModel("products");
    }

    // Hiển thị danh sách sản phẩm
    public function index(): void {
        $products = $this->productModel->all();
        $this->view("products/all", ["products" => $products]);
    }

    // Hiển thị form tạo mới (Chỉ dành cho GET)
    public function create(): void {
        $this->view("products/create");
    }

    // Xử lý lưu dữ liệu (Chỉ dành cho POST)
    public function store(): void {
        // Router đã lọc POST nên không cần if(POST) ở đây nữa
        $data = [
            "name"     => $_POST["productName"] ?? "",
            "category" => $_POST["productCategory"] ?? "",
            "quantity" => $_POST["productQuantity"] ?? 0,
            "origin"   => $_POST["productOrigin"] ?? ""
        ];

        $errors = $this->productModel->validate($data);

        if (!empty($errors)) {
            // Trả về view kèm lỗi và dữ liệu đã nhập
            $this->view("products/create", [
                "errors" => $errors,
                "old"    => $data
            ]);
            return; // Dừng lại không lưu
        }

        // Lưu vào DB
        $result = $this->productModel->add($data);

        if ($result) {
            // Chuyển hướng về trang danh sách để tránh F5 gửi lại form
            header("Location: /products"); 
            exit();
        } else {
            die("Đã có lỗi xảy ra khi lưu sản phẩm.");
        }
    }
}