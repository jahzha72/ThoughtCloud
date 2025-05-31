<?php
session_start();
include 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>ThoughtCloud - Contact</title>
    <style>
        <?php include 'style.php'; ?>
    </style>
    <style>
        :root {
            --bg-dark: #0b0c10;
            --text-dark: whitesmoke;
            --accent: #2196F3;
        }
        body {
            margin: 0;
            padding: 30px 40px;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background-color: var(--bg-dark);
            color: var(--text-dark);
            display: flex;
            top: 10px;
            flex-direction: column;
            align-items: center;
            backdrop-filter: blur(10px);
            margin-top: 0;
            margin-bottom: 0;
        }
        .background {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -1;
        }
        .stars {
            width: 100%; height: 100%;
            background: url('https://www.transparenttextures.com/patterns/stardust.png') repeat;
            animation: twinkle 20s linear infinite;
            opacity: 0.6;
        }
        @keyframes twinkle {
            from { background-position: 0 0; }
            to { background-position: 1000px 1000px; }
        }
        .moon {
            position: absolute;
            bottom: 0px;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle at 30% 30%, #0a1e5b, #000);
            border-radius: 50%;
            box-shadow: 0 0 40px 8px #0a3cff inset,
                        0 0 100px 30px #052666,
                        0 0 150px 50px #00144d;
            animation: moonGlow 4s ease-in-out infinite alternate;
        }
        @keyframes moonGlow {
            0% {
                box-shadow: 0 0 40px 8px #0a3cff inset,
                            0 0 100px 30px #052666,
                            0 0 150px 50px #00144d;
            }
            100% {
                box-shadow: 0 0 60px 12px #1e90ff inset,
                            0 0 120px 40px #0a4fff,
                            0 0 180px 70px #003399;
            }
        }
    nav {
        position: fixed;
        top: 15px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        right: 100px;
        display: flex;
        gap: 8px;
        align-items: center;
        font-weight: normal;
        font-size: 0.8rem;
        color: #64b5f6;
        z-index: 2;
        }

    nav .user {
      font-weight: 600;
      font-size: 1.1rem;
      color: #64b5f6;
    }

    .nav-links {
      display: flex;
      gap: 6px;
    }

    .nav-links a {
      color: #64b5f6;
      text-decoration: none;
      border: 1px solid #64b5f6;
      padding: 5px 8px;
      border-radius: 4px;
      transition: background-color 0.3s ease, color 0.3s ease;
      font-size: 0.9rem;
    }

    .nav-links a:hover {
      background-color: #2196F3;
      color: #fff;
    }

        h2 {
            margin-top: 80px;
            font-size: 2.5rem;
            color:rgb(167, 212, 250);
            text-align: center;
        }
        p {
            max-width: 700px;
            text-align: center;
            font-size: 1.1rem;
            color:rgb(179, 229, 250);
            margin-top: 20px;
        }
        form {
            max-width: 900px;
            margin: auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
            color: rgb(12, 115, 160);
            font-size: 1rem;
        }
        form input[type="text"],
        form input[type="email"],
        form textarea {
            width: 100%;
            padding: 14px 15px;
            margin-bottom: 20px;
            border: 1px solid #2196F3;
            border-radius: 8px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.05);
            color: rgb(26, 121, 161);
            transition: border-color 0.3s ease;
        }
        form input:focus,
        form textarea:focus {
            outline: none;
            border-color: #64b5f6;
            background: rgba(255,255,255,0.1);
        }
        form button {
            background-color: #2196F3;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: rgb(25, 35, 66);
        }
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
            color: var(--accent);
        }
        #theme-toggle:hover {
            color: #4da6ff;
        }
        #theme-toggle svg {
            width: 100%;
            height: 100%;
            fill: currentColor;
        }
        .light-mode body {
            background-color: #f4f4f4;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="stars"></div>
        <div class="moon"></div>
    </div>

    <button id="theme-toggle" aria-label="Toggle theme" title="Toggle theme">
        <svg id="icon" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M21 12.79A9 9 0 0111.21 3a7 7 0 109.79 9.79z" />
        </svg>
    </button>

    <nav>
        <div class="nav-links">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <h2>Contact Us</h2>
    <p>If you have any questions or feedback, feel free to reach out. We’re here to help!</p>

    <form method="POST" action="send_message.php">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Your Email" required />
        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
        <button type="submit">Send</button>
    </form>

    <script>
        const toggle = document.getElementById('theme-toggle');
        const root = document.documentElement;
        const icon = document.getElementById('icon');

        const moonIconPath = "M21 12.79A9 9 0 0111.21 3a7 7 0 109.79 9.79z";
        const sunIconPath = "M12 4.354a1 1 0 110-2 1 1 0 010 2zm0 15.292a1 1 0 110-2 1 1 0 010 2zm7.778-7.778a1 1 0 110-2 1 1 0 010 2zm-15.556 0a1 1 0 110-2 1 1 0 010 2z";

        function initTheme() {
            if (localStorage.getItem('theme') === 'light') {
                root.classList.add('light-mode');
                icon.querySelector('path').setAttribute('d', sunIconPath);
            } else {
                root.classList.remove('light-mode');
                icon.querySelector('path').setAttribute('d', moonIconPath);
            }
        }

        function toggleTheme() {
            const isLight = root.classList.contains('light-mode');
            root.classList.toggle('light-mode', !isLight);
            icon.querySelector('path').setAttribute('d', isLight ? moonIconPath : sunIconPath);
            localStorage.setItem('theme', isLight ? 'dark' : 'light');
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
