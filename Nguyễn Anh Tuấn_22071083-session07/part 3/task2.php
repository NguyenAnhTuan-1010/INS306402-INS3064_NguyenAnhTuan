<?php
    require_once "task1.php";
    try {
        $db = Database::getInstance()->getConnection();
    } catch (PDOException $ex) {
        die("Connection failed: " . $ex->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <script>
        console.log($db);
    </script> -->
</head>
<body>
    <div>
        <table border=1>
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Registered Date</th>
            </thead>
            <tbody>
                <?php
                    $stmt = $db->prepare(
                        "select
                            *
                        from users"
                    );
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    foreach ($users as $user) {
                        echo "<tr>
                            <td>{$user['name']}</td>    
                            <td>{$user['email']}</td>
                            <td>{$user['created_at']}</td>
                        </tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>