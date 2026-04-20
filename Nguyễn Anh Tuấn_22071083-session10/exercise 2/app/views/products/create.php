<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Product</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="container">
    <h1>Create Product</h1>

    <form method="POST" action="/products" id="productForm">
        
        <label>Name</label>
        <input type="text" name="productName" 
            value="<?= $old['name'] ?? '' ?>">

        <label>Category</label>
        <input type="text" name="productCategory"
            value="<?= $old['category'] ?? '' ?>">

        <label>Quantity</label>
        <input type="number" name="productQuantity"
            value="<?= $old['quantity'] ?? '' ?>">

        <label>Origin</label>
        <input type="text" name="productOrigin"
            value="<?= $old['origin'] ?? '' ?>">

        <button type="submit">Save Product</button>
    </form>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="/products">Back to list</a>
</div>

<script src="/assets/js/app.js"></script>
</body>
</html>