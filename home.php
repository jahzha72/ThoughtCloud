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
  <title>ThoughtCloud - Home</title>
  <style>
    :root {
      --bg-dark: #0b0c10;
      --text-dark: whitesmoke;
      --accent: #2196F3;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      min-height: 100vh;
      position: relative;
      background-color: var(--bg-dark);
      color: var(--text-dark);
      display: flex;
      flex-direction: column;
      align-items: center;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(5px);
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
      position: absolute;
      bottom: 0px;
      left: 50%;
      transform: translateX(-50%);
      width: 600px;
      height: 600px;
      background: radial-gradient(circle at 30% 30%, #0a1e5b, #000);
      border-radius: 50%;
      box-shadow:
        0 0 40px 8px #0a3cff inset,
        0 0 100px 30px #052666,
        0 0 150px 50px #00144d;
      animation: moonGlow 4s ease-in-out infinite alternate;
      z-index: 1;
    }

    @keyframes moonGlow {
      0% {
        box-shadow:
          0 0 40px 8px #0a3cff inset,
          0 0 100px 30px #052666,
          0 0 150px 50px #00144d;
      }
      100% {
        box-shadow:
          0 0 60px 12px #1e90ff inset,
          0 0 120px 40px #0a4fff,
          0 0 180px 70px #003399;
      }
    }

    nav {
      position: fixed;
      top: 15px;
      right: 100px;
      display: flex;
      gap: 8px;
      align-items: center;
      font-weight: normal;
      font-size: 0.8rem;
      color: #64b5f6;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      backdrop-filter: blur(6px);
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
      color:rgb(0, 134, 243);
      text-decoration: none;
      border: 1px solid #64b5f6;
      padding: 5px 8px;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      border-radius: 4px;
      transition: background-color 0.3s ease, color 0.3s ease;
      font-size: 0.9rem;
    }

    .nav-links a:hover {
      background-color: #2196F3;
      color: #fff;
    }

    h1 {
      margin-top: 80px;
      font-size: 2.5rem;
      color:rgb(192, 227, 255);
      text-align: center;
    }

    p {
      max-width: 700px;
      text-align: center;
      font-size: 1.1rem;
      color:rgb(181, 218, 253);
      margin-top: 20px;
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
  <nav>
    <div class="nav-links">
      <a href="home.php">Home</a>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
      <a href="index.php">Login</a>
    </div>
  </nav>

  <h1>Welcome to ThoughtCloud</h1>
  <p>Start reflecting on your thoughts, feelings, and daily experiences in your private diary. Click on your diary to begin writing.</p>
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
