<?php
    session_start();
    require_once "database.php";

    try {
        $db = Database::getInstance()->getConnection();
    } catch (PDOException $ex) {
        die("Connection failed: " . $ex->getMessage());
    }

    $statement = $db->prepare("
        select
            ot.id as id,
            p.name as name,
            c.category_name as category_name,
            p.price as price,
            ot.quantity as quantity,
            (p.price * ot.quantity) as VND,
            o.order_date as date
        from order_items ot
        left join products p on ot.product_id = p.id 
        left join orders o on ot.order_id = o.id
        left join users u on o.user_id = u.id
        left join categories c on p.category_id = c.id
        where u.name = :userName and u.email = :userEmail
    ");
    $params = [
        ":userName" => $_SESSION["username"],
        ":userEmail" => $_SESSION["email"]
    ];
    $statement->execute($params);
    $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping History</title>
</head>
<body>
    <div id="header">
        <h1>Check what you have bought!</h1>

        <div>
            <?php
                if (isset($_SESSION["username"])) {
                    echo "<div>Logged in as: {$_SESSION['username']}</div>";
                } 
            ?>
        </div>
    </div>

    <div id="body">
        <div>
            <table border="1">
                <thead>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total (unit VND1000)</th>
                    <th>Date</th>
                </thead>
                <tbody>
                    <?php
                        foreach ($orders as $order) {
                            echo "
                                <tr>
                                    <td>{$order['id']}</td>
                                    <td>{$order['name']}</td>
                                    <td>{$order['category_name']}</td>
                                    <td>{$order['price']}</td>
                                    <td>{$order['quantity']}</td>
                                    <td>{$order['VND']}</td>
                                    <td>{$order['date']}</td>
                                </tr>
                            ";
                        } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="tail">
        <a href="index.php">Going to the market</a>
    </div>
</body>
</html>