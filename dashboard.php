<?php
session_start();
include 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION['username'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>ThoughtCloud - Dashboard</title>
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
      position: fixed;
      left: 50%;
      top: 15%;
      transform: translateX(-50%);
      width: 700px;
      height: 700px;
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

    h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 700;
      font-size: 2rem;
      color:rgb(161, 206, 243);
    }

    form {
      margin-bottom: 40px;
      width: 100%;
      max-width: 900px;
    }

    input[type=text], textarea {
      width: 100%;
      padding: 14px 15px;
      margin-bottom: 20px;
      border: 1px solid #2196F3;
      border-radius: 8px;
      font-size: 1rem;
      resize: vertical;
      background: rgba(26, 166, 247, 0.10);
      color:rgb(255, 255, 255);
      transition: border-color 0.3s ease;
    }

    input[type=text]:focus, textarea:focus {
      outline: none;
      border-color: #64b5f6;
      background: rgba(5, 24, 65, 0.1);
    }

    button {
            background-color: transparent;
            color: rgb(255, 255, 255);
            padding: 8px 16px;
            border-color:rgb(85, 114, 167);
            border-radius: 6px;
            cursor: pointer;
            width: 180px; /* Smaller fixed width */
            height: 35px;  /* Slightly smaller height */
            display: block; /* Required to center with margin auto */
            margin: 0 auto;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px; /* Slightly smaller text */
            transition: background-color 0.3s;
        }

    button:hover {
      background-color: rgb(81, 167, 207);
    }

    .entry {
      background: black;
      padding: 20px 25px;
      border-radius: 10px;
      margin-bottom: 25px;
      color:rgb(140, 192, 223);
      box-shadow: 0 2px 8px rgba(33, 150, 243, 0.4);
      word-wrap: break-word;
      width: 100%;
      max-width: 900px;
    }

    .entry h4 {
      margin: 0 0 8px 0;
      color:rgb(48, 96, 136);
      font-weight: normal;
      font-size: 1.25rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .entry h4 small {
      font-weight: 400;
      font-size: 0.85rem;
      color: #bbdefb;
      font-style: italic;
    }

    .entry p {
      margin: 0;
      line-height: 1.5;
      white-space: pre-wrap;
    }

    p.no-entries {
      text-align: center;
      font-style: italic;
      color:rgb(41, 106, 138);
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
      <a href="logout.php">Logout</a>
    </div>
  </nav>

  <h2>Your Thoughts</h2>

  <form method="POST" action="save_entry.php">
    <input type="text" name="title" placeholder="Title" required />
    <textarea name="content" rows="5" placeholder="Write your thoughts..." required></textarea>
    <button type="submit">Save</button>
  </form>

  <h3 style="max-width:900px; width:100%; color:#fff;">Past Entries</h3>

  <?php
    $stmt = $conn->prepare("SELECT title, content, date_created FROM diary_entries WHERE user_id = ? ORDER BY date_created DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0):
      while ($row = $result->fetch_assoc()):
  ?>
        <div class="entry">
          <h4>
            <?= htmlspecialchars($row['title']) ?>
            <small><?= htmlspecialchars(date("F j, Y, g:i a", strtotime($row['date_created']))) ?></small>
          </h4>
          <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
        </div>
        
  <?php
      endwhile;
    else:
  ?>
    <p class="no-entries">No diary entries found.</p>
  <?php endif; ?>

  <script>
    const toggle = document.getElementById('theme-toggle');
    const root = document.documentElement;
    const icon = document.getElementById('icon');

    const moonIconPath = "M21 12.79A9 9 0 0111.21 3a7 7 0 109.79 9.79z";
    const sunIconPath = "M12 4.354a1 1 0 110-2 1 1 0 010 2zm0 15.292a1 1 0 110-2 1 1 0 010 2zm7.778-7.778a1 1 0 110-2 1 1 0 010 2zm-15.556 0a1 1 0 110-2 1 1 0 010 2zm11.535 5.657a1 1 0 11-1.414-1.414 1 1 0 011.414 1.414zm-11.314-11.314a1 1 0 11-1.414-1.414 1 1 0 011.414 1.414zm11.314 0a1 1 0 11-1.414-1.414 1 1 0 011.414 1.414zm-11.314 11.314a1 1 0 11-1.414-1.414 1 1 0 011.414 1.414zM12 7a5 5 0 100 10 5 5 0 000-10z";

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
