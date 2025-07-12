<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/styles.css">
    <title>PHP-Diary</title>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav-bar">
                <a href="index.php" class="nav-brand">
                    <img src="images/logo.svg" alt="PHP-Diary Logo" class="nav-logo">
                    <span class="nav-title">PHP-Diary</span>
                </a>
                <a href="form.html" class="button">
                    <img src="images/plus.svg" alt="Add New Entry" class="button-icon">
                    New Entry
                </a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <h1 class="main-heading">Entries</h1>
    
            <form method="POST" action="form.php">
                <div class="form-group">
                    <label for="entry-title" class="form-label">Title:</label>
                    <input type="text" id="entry-title" name="title" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="entry-date" class="form-label">Date:</label>
                    <input type="date" id="entry-date" name="date" class="form-input" required>
                </div>
                <div class="form-group">
                    <!-- <label for="entry-content" class="form-label">Content:</label> -->
                    <textarea id="entry-content" name="content" class="form-textarea" rows="25" required></textarea>
                </div>

                <div class="form-submit">
                    <button type="submit" class="button">
                        <img src="images/send.svg" alt="Add New Entry" class="button-icon">
                        New Entry
                    </button>
                </div>
            </form>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="footer-heading">About Us</h3>
                    <p class="footer-text">PHP-Diary is a simple diary application built with PHP and MySQL. It allows users to create, read, update, and delete diary entries.</p>
                </div>
                <!-- vertical Divider -->
                 <div class="footer-divider">
                 </div>
                 <!-- Vertical Divider -->
                <div class="col">
                    <h3 class="footer-heading">Contact</h3>
                    <p class="footer-text">Email: <a href="mailto: example.com" class="footer-link">example.com</a></p>
                    <p class="footer-text">Phone: <a href="tel:+1234567890" class="footer-link">+1234567890</a></p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>