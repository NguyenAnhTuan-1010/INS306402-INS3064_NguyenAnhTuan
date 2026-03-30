<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Đào tạo - Anh Tuấn</title>
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #6366f1;
            --bg-color: #f9fafb;
            --text-dark: #1f2937;
            --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: var(--bg-color);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background: white;
            padding: 50px;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            max-width: 800px;
        }

        h1 { color: var(--text-dark); margin-bottom: 10px; }
        
        p { color: #6b7280; margin-bottom: 35px; }

        .menu { 
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px; 
        }

        .menu a { 
            text-decoration: none; 
            padding: 20px; 
            background: var(--primary-color); 
            color: white; 
            border-radius: 10px; 
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu a:hover { 
            background: var(--secondary-color); 
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        }

        .icon { font-size: 24px; }

        @media (max-width: 600px) {
            .menu { grid-template-columns: 1fr; }
            .container { margin: 20px; padding: 30px; }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Hệ thống Quản lý Đào tạo</h1>
        <p>Chọn một chức năng bên dưới để bắt đầu quản lý dữ liệu</p>

        <div class="menu">
            <a href="students/index.php">
                <span class="icon">👨‍🎓</span>
                Sinh viên
            </a>
            <a href="courses/index.php">
                <span class="icon">📚</span>
                Khóa học
            </a>
            <a href="enrollments/index.php">
                <span class="icon">📝</span>
                Đăng ký học
            </a>
        </div>
    </div>

</body>
</html>