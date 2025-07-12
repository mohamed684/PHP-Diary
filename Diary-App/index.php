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
                <a href="form.php" class="button">
                    <img src="images/plus.svg" alt="Add New Entry" class="button-icon">
                    New Entry
                </a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <h1 class="main-heading">Entries</h1>
    
            <div class="card">
                <div class="card-image-container">
                    <img src="images/pexels-canva-studio-3153199.jpg" alt="Entry 1" class="card-image">
                </div>
                <div class="card-desc-container">
                    <div class="card-desc-time">Week 1</div>
                    <h2 class="card-desc-heading">PHP is Amazing</h2>
                    <p class="card-desc-text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non qui, amet iste ipsum rerum cum doloremque assumenda nemo temporibus ad ducimus, repellendus earum corrupti illum nisi cumque, enim excepturi impedit?
                    </p>
                </div>
            </div>

            <!-- Pagination -->
             <ul class="pagination">
                <li class="pagination-item">
                    <a href="#" class="pagination-link">&laquo;</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="pagination-link active">1</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="pagination-link">2</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="pagination-link">3</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="pagination-link">&raquo;</a>
                </li>
            </ul>

        </div>
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