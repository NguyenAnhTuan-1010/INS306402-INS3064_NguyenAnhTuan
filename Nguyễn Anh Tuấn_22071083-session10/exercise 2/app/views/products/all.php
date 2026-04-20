<div class="container">
    <h1>Product List</h1>
    <?php $BASE_URL = "/INS306402-INS3064_NguyenAnhTuan/Nguyễn Anh Tuấn_22071083-session10/exercise 2/"; ?>
    <a href="<?= $BASE_URL ?>products/create" class="btn">+ Add Product</a>

    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Origin</th>
                <th>Distributor</th>
                <th>Company</th>
                <th>Manufactured Date</th>
                <th>Expired Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['category'] ?></td>
                        <td><?= $product['quantity'] ?></td>
                        <td><?= $product['origin'] ?></td>
                        <td><?= $product["distributor"] ?></td>
                        <td><?= $product["from_company"] ?></td>
                        <td><?= $product["manufactured_date"] ?></td>
                        <td><?= $product["expired_date"] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">No products found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>