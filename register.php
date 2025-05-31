<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'config.php';
session_start();

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!$username || !$password) {
        $error = "Please fill all fields.";
    } else {
        // Check if user exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Username already taken.";
        } else {
            // Insert new user
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hash]);
            header('Location: index.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - ThoughtCloud</title>
    <style>
        :root {
            --bg-color: #000000;
            --text-color: whitesmoke;
            --container-bg: rgba(0, 0, 0, 0.8);
            --button-color: #2196F3;
            --hover-bg: rgb(27, 38, 48);
        }

        .light-mode {
            --bg-color: #f4f4f4;
            --text-color: #111;
            --container-bg: #ffffff;
            --button-color: #0d47a1;
            --hover-bg: #e0e0e0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
            transition: background-color 0.3s, color 0.3s;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Moon */
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
            z-index: 2;
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

        .container {
            max-width: 320px;
            color: white;
            margin: 130px auto 0;
            background: var(--container-bg-dark);
            padding: 25px 30px;
            box-shadow: 0 4px 10px var(--shadow-dark);
            border-radius: 10px;
            position: relative;
            z-index: 2;
            font-family: 'Times New Roman', Times, serif;
            transition: background 0.3s, box-shadow 0.3s;
        }

        .light-mode .container {
            background: var(--container-bg-light);
            box-shadow: 0 4px 10px var(--shadow-light);
        }

        h1 {
            text-align: center;
            color: var(--button-color);
        }

        input[type=text], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            background-color: var(--input-bg-dark);
            color: white   ;
        }

        button {
            background-color: transparent;
            color: rgb(255, 255, 255);
            padding: 8px 16px;
            border-color:rgb(80, 151, 184);
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
            color: white;
            background-color: #2196F3;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        p {
            text-align: center;
            margin-top: 15px;
        }

        a {
            color: var(--button-color);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Theme toggle icon container */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            cursor: pointer;
            z-index: 10;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
        }

        /* Icon styles */
        .theme-toggle svg {
            fill: var(--button-color);
            width: 28px;
            height: 28px;
            transition: fill 0.3s;
        }

        .light-mode .theme-toggle svg {
            fill: var(--button-color);
        }
        .background {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        h1 {
            margin-top: 166px;
            margin-bottom: 14px;
            padding: 0;
            color: #2196F3;
            font-family: 'Times New Roman', Times, serif;
        }
        h2 {
            margin-top: 75px;
            margin-bottom: 10px;
            padding: 0;
            position: inherit;
            color: #2196F3;
            font-family: 'Times New Roman', Times, serif;
        }
    </style>
</head>
<body>      
    <h1>ThoughtCloud</h1>
    <!-- Animated Moon Background -->
    <div class="background">
    <div class="stars"></div>
    <div class="moon"></div>

    <!-- Theme Toggle Icon -->
    <div class="theme-toggle" id="theme-toggle" title="Toggle Dark/Light Mode" aria-label="Toggle Dark/Light Mode" role="button" tabindex="0">
        <!-- Moon icon by default -->
        <svg id="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" >
            <path d="M21 12.79A9 9 0 0111.21 3a7 7 0 109.79 9.79z"/>
        </svg>
    </div>

    <div class="container">
        <h2>Register</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required value="<?= htmlspecialchars($username) ?>">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="index.php">Login</a></p>
    </div>

    <script>
        const toggle = document.getElementById('theme-toggle');
        const root = document.documentElement;
        const icon = document.getElementById('icon');

        const moonIconPath = "M21 12.79A9 9 0 0111.21 3a7 7 0 109.79 9.79z";
        const sunIconPath = "M12 4.354a1 1 0 110-2 1 1 0 010 2zm0 15.292a1 1 0 110-2 1 1 0 010 2zm7.778-7.778a1 1 0 110-2 1 1 0 010 2zm-15.556 0a1 1 0 110-2 1 1 0 010 2zm11.535 5.657a1 1 0 11-1.414-1.414 1 1 0 011.414 1.414zm-11.314-11.314a1 1 0 11-1.414-1.414 1 1 0 011.414 1.414zm11.314 0a1 1 0 11-1.414-1.414 1 1 0 011.414 1.414zm-11.314 11.314a1 1 0 11-1.414-1.414 1 1 0 011.414 1.414zM12 7a5 5 0 100 10 5 5 0 000-10z";

        // Load saved theme or default to dark
        if (localStorage.getItem('theme') === 'light') {
            root.classList.add('light-mode');
            icon.setAttribute('viewBox', '0 0 24 24');
            icon.querySelector('path').setAttribute('d', sunIconPath);
        } else {
            // Default is dark mode - moon icon
            root.classList.remove('light-mode');
            icon.setAttribute('viewBox', '0 0 24 24');
            icon.querySelector('path').setAttribute('d', moonIconPath);
        }

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
    </script>
</body>
</html>
