<?php
  /*
    Defines routes -> hand over control -> router takes over
    The index.php should only boostrap app, defining routes, starting routes. Nothing else (no HTML, no echo, no logic)
    Views should be rendered inside controllers, not here
  */
  require_once "../core/router.php";

  $router = new Router();

  $base_path = "/INS306402-INS3064_LaNhatBaoDuy/session11/exercise 2";
  $request_uri = urldecode($_SERVER["REQUEST_URI"]);
  $url = str_replace($base_path, "", $request_uri);
  $url = rtrim($url, '/'); // Xóa dấu gạch chéo thừa ở cuối nếu có

  if ($url === "" || $url === "/") {
    header("Location: welcome.html");
    exit;
  }

  // Assign routes
  $router->get("/products", "ProductController@index");
  $router->get("/products/create", "ProductController@create");
  $router->post("/products/create", "ProductController@store");

  // Start processing
  $router->dispatch(
    $_SERVER["REQUEST_URI"],
    $_SERVER["REQUEST_METHOD"]
  );
?>

