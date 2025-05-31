<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();
include 'config.php';

$error = '';
$username = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hash);

    if ($stmt->fetch() && password_verify($password, $hash)) {
        $_SESSION["user_id"] = $id;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login - ThoughtCloud</title>
    <style>
        :root {
            --bg-dark: #0b0c10;
            --bg-light: #f5f7fa;
            --text-dark: whitesmoke;
            --text-light: #111;
            --accent: #2196F3;
            --input-bg-dark: transparent;
            --input-bg-light: transparent   ;
            --input-border-dark: #555;
            --input-border-light: #ccc;
            --container-bg-dark: transparent;
            --container-bg-light: transparent;
            
        }

        /* Base styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
            background-color: var(--bg-dark);
            color: var(--text-dark);
            transition: background-color 0.3s, color 0.3s;
        }

        /* Light mode */
        .light-mode body {
            background-color: var(--bg-light);
            color: var(--text-light);
        }

        .background {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .stars {
            width: 100%; height: 100%;
            background: url('https://www.transparenttextures.com/patterns/stardust.png') repeat;
            animation: twinkle 20s linear infinite;
            position: absolute;
            top: 0; left: 0;
            opacity: 0.6;
        }

        @keyframes twinkle {
            from { background-position: 0 0; }
            to { background-position: 1000px 1000px; }
        }

        .moon {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle at 40% 40%, #1e3a8a 5%, #000 20%, #1e40af 25%, #000 40%);
            border-radius: 50%;
            position: absolute;
            bottom: -0px;
            left: calc(50% - 250px);
            box-shadow: 0 0 80px rgba(0, 128, 255, 0.4);
            animation: moonPulse 4s ease-in-out infinite alternate;
            z-index: 0;
        }

        /* Subtle blue designs on moon using pseudo-elements */
        .moon::before, .moon::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(30, 58, 138, 0.3);
            box-shadow:
                10px 10px 15px rgba(30, 58, 138, 0.5),
                inset 0 0 10px rgba(30, 58, 138, 0.7);
            filter: blur(8px);
            animation: moonPulse 4s ease-in-out infinite alternate;
        }
        .moon::before {
            width: 150px; height: 150px;
            top: 100px; left: 140px;
        }
        .moon::after {
            width: 80px; height: 80px;
            top: 280px; left: 230px;
        }

        @keyframes moonPulse {
            0% { box-shadow: 0 0 50px rgba(0, 128, 255, 0.3); }
            100% { box-shadow: 0 0 90px rgba(0, 128, 255, 0.6); }
        }

        .container {
            max-width: 320px;
            color: inherit;
            font-family: 'Times New Roman', Times, serif;
            margin: 130px auto 0;
            background: transparent;
            padding: 25px 30px;
            box-shadow: 0 4px 10px var(--shadow-dark);
            border-radius: 10px;
            position: relative;
            z-index: 2;
            transition: background 0.3s, box-shadow 0.3s;
        }

        .light-mode .container {
            background: var(--container-bg-light);
            box-shadow: 0 4px 10px var(--shadow-light);
        }

        h1 {
            text-align: center;
            color: var(--accent);
            margin-top: 0;
        }

        input[type=text], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            background-color: var(--input-bg-dark);
        }

        .light-mode input[type=text], 
        .light-mode input[type=password] {
            background-color: var(--input-bg-light);
            border: 1px solid var(--input-border-light);
            color: var(--text-light);
        }

        button {
            background-color: transparent;
            color: rgb(255, 255, 255);
            padding: 8px 16px;
            border-color: var(--accent);
            border-radius: 6px;
            cursor: pointer;
            width: 150px; /* Smaller fixed width */
            height: 35px;  /* Slightly smaller height */
            display: block; /* Required to center with margin auto */
            margin: 0 auto;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px; /* Slightly smaller text */
            transition: background-color 0.3s;
        }


        button:hover {
            background-color: rgb(66, 129, 189);
            color: white;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        p {
            text-align: center;
            margin-top: 15px;
            color: white;
        }

        a {
            color: var(--accent);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Dark/light mode toggle button */
        #theme-toggle {
            position: fixed;
            top: 15px;
            right: 15px;
            background: transparent;
            border: none;
            cursor: pointer;
            z-index: 5;
            width: 36px;
            height: 36px;
            padding: 0;
            outline-offset: 2px;
            color: var(--accent);
            transition: color 0.3s;
        }

        #theme-toggle:hover,
        #theme-toggle:focus {
            color: #4da6ff;
        }

        #theme-toggle svg {
            width: 100%;
            height: 100%;
            fill: currentColor;
        }
        h1 {
            margin-top: 10px;
            margin-bottom: 5px;
            padding: 0;
            color: #2196F3;
            font-family: 'Times New Roman', Times, serif;
        }
        h2 {
            margin-top: 30px;
            margin-bottom: 10px;
            padding: 0;
            position: inherit;
            color: #2196F3;
            font-family: 'Times New Roman', Times, serif;
        }
    </style>
</head>
<body>
    
    <div class="background">
        <div class="stars"></div>
        <div class="moon"></div>
    </div>

    <button id="theme-toggle" aria-label="Toggle dark/light mode" title="Toggle dark/light mode" tabindex="0">
        <svg id="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M21 12.79A9 9 0 0111.21 3a7 7 0 109.79 9.79z" />
        </svg>
    </button>
    
    <div class="container">
        <h1>ThoughtCloud</h1>
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required value="<?= htmlspecialchars($username) ?>">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>

    <script>
        const toggle = document.getElementById('theme-toggle');
        const root = document.documentElement;
        const icon = document.getElementById('icon');

        const moonIconPath = "M21 12.79A9 9 0 0111.21 3a7 7 0 109.79 9.79z";
        const sunIconPath = "M12 4.354a1 1 0 110-2 1 1 0 010 2zm0 15.292a1 1 0 110-2 1 1 0 010 2zm7.778-7.778a1 1 0 110-2 1 1 0 010 2zm-15.556 0a1 1 0 110-2 1 1 0 010 2zm11.535 5.657a1 1 0 11-1.414-1.414 1 1 0 011.414 1.414zm-11.314-11.314a1 1 0 11-1.414-1.414 1 1 0 011.414 1.414zm11.314 0a1 1 0 11-1.414-1.414 1 1 0 011.414 1.414zm-11.314 11.314a1 1 0 11-1.414-1.414 1 1 0 011.414 1.414zM12 7a5 5 0 100 10 5 5 0 000-10z";

        // Initialize theme on page load
        function initTheme() {
            if (localStorage.getItem('theme') === 'light') {
                root.classList.add('light-mode');
                icon.querySelector('path').setAttribute('d', sunIconPath);
            } else {
                root.classList.remove('light-mode');
                icon.querySelector('path').setAttribute('d', moonIconPath);
            }
        }

        // Toggle theme function
        function toggleTheme() {
            if (root.classList.contains('light-mode')) {
                root.classList.remove('light-mode');
                icon.querySelector('path').setAttribute('d', moonIconPath);
                localStorage.setItem('theme', 'dark');
            } else {
                root.classList.add('light-mode');
                icon.querySelector('path').setAttribute('d', sunIconPath);
                localStorage.setItem('theme', 'light');
            }
        }

        toggle.addEventListener('click', toggleTheme);

        toggle.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleTheme();
            }
        });

        initTheme();
    </script>
</body>
</html>
