    <?php
        class BaseController {
            protected function view(string $view, array $data = []): void {
                extract($data);
                $content = "../views/{$view}.php";
                require "../views/layouts/main.php";
            }

            protected function redirect(string $url): void {
                header("Location: {$url}");
                exit;
            }
        }
    ?>