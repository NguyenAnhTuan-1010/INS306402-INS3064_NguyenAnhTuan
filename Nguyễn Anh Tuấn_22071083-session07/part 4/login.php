<?php
    require_once "database.php";
    session_start();
    try {
        $db = Database::getInstance()->getConnection();
    } catch (PDOException $ex) {
        die("Connection failed: " . $ex->getMessage());
    }
    $userFirstName = "";
    $userLastName = "";
    $email = "";
    
    if (isset($_GET["firstName"])) $userFirstName = $_GET["firstName"];
    if (isset($_GET["lastName"])) $userLastName = $_GET["lastName"];
    if (isset($_GET["email"])) $email = $_GET["email"];

    $userName = "" . $userFirstName . " " . $userLastName . "";
    echo "<div>Username: " . $userName . "</div> ";
    try {
        $login_query = "
            select
                u.*
            from users u
            where u.name = :userName and u.email = :email
        ";
        $params = [
            ":userName" => $userName,
            ":email" => $email
        ];
        $statement = $db->prepare($login_query);
        $statement->execute($params);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            echo "<div>Found user!</div>";
            $_SESSION["username"] = $userName;
            $_SESSION["email"] = $email;
            header("Location: index.php");
        } else {
            echo "<div>User doesn't exist!</div>";
        }
        } catch (PDOException $ex) {
            echo "Query failed: " . $ex->getMessage();
        }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div>
        <div id="header">
            <h1>Login</h1>
        </div>

        <div id="body">
            <div id="register-navigator">
                <div>Don't have an account?</div>
                <div>
                    <a href="">Register</a>
                </div>
            </div>
            
            <div id="login-section">
                <form id="login-form" method="GET">
                    <div id="first_name">
                        <input type="text" name="firstName" placeholder="Enter first name" />
                    </div>
                    <div id="last_name">
                        <input type="text" name="lastName" placeholder="Enter last name" />
                    </div>
                    <div id="email">
                        <input type="text" name="email" placeholder="Enter email" />
                    </div>
                    <div>
                        <button type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>