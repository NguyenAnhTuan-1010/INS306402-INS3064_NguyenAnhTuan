<?php
    require_once "database.php";
    session_start();

    // If user didn't login, coercing them to login before accessing the market
    if (!isset($_SESSION["username"]) && !isset($_SESSION["email"])) {
        header("Location: login.php");
    }

    try {
        $db = Database::getInstance()->getConnection();
    } catch (PDOException $ex) {
        die("Connection failed: " . $ex->getMessage());
    }
    $search = "";
    $selected_category = "";
    if (isset($_GET["search"])) {
        $search = $_GET["search"];
    }
    if (isset($_GET["category-options"])) {
        $selected_category = $_GET["category-options"];
    }

    $sql = "
        select
            p.id,
            p.name,
            p.price,
            c.category_name,
            p.stock 
        from products p
        left join categories c on p.category_id = c.id
    ";

    $params = [];

    if (!empty($search)) {
        $sql .= " where p.name like :product_name";
        $params[":product_name"] = "%$search%";
    }

    if (!empty($selected_category)) {
        $sql .= " and c.category_name = :category_name";
        $params[":category_name"] = $selected_category;
    }
    

    $statement = $db->prepare($sql);
    $statement->execute($params);
    $filteredDataRows = $statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div id="header">
        <h1>Product Admin</h1>

        <div>
            <?php
                if (isset($_SESSION["username"])) {
                    echo "<div>Logged in as : {$_SESSION['username']}</div>";
                }
            ?>
        </div>
    </div>

    <div id="body">
        <div id="dynamic-search">
            <form id="dynamic-search" method="GET" action="">
                <div id="input-text">
                    <input type="text" name="search" placeholder="Search products..."
                    value="<?= htmlspecialchars($search) ?>"/>
                </div>
                <div id="category-filter">
                    <select name="category-options">
                        <option value="">select</option>
                        <?php
                            $stmt1 = $db->prepare("
                                select
                                    distinct category_name as name
                                from categories
                            "); 
                            $stmt1->execute();
                            $category_list = $stmt1->fetchAll();
                        ?>
                        <?php foreach ($category_list as $category): ?>
                            <option value="<?= $category["name"] ?>">
                                <!-- <?= $selected_category == $category["name"] ? "selected" : "" ?> -->
                                <?= $category["name"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="btn1"> 
                    <button type="submit">Search</button>
                </div>
            </form>
        </div>
        
        

        <div id="data-fetched">
            <table border=1>
                <thead>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Stock</th>
                </thead>
                <tbody>
                    <?php
                        foreach ($filteredDataRows as $row) {
                            $stock_cell_bgColor = ($row["stock"] < 10) ? "red" : "#fff";
                            $stock_cell_color = ($row["stock"] < 10) ? "#fff" : "#000";
                            echo "
                                <tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['price']}</td>
                                    <td>{$row['category_name']}</td>
                                    <td style='background-color: $stock_cell_bgColor; color: $stock_cell_color'>{$row['stock']}</td>
                                </tr>
                            ";
                        } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="tail">
        <div id="view_history">
            <a href="purchase_history.php">Check what you have purchased!</a>
        </div>
    </div>
</body>
</html>