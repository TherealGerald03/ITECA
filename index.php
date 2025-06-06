<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--Scales to mobile-->
    <title>Afrimart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
        }

        /* Hero Section Styling */
        .hero {
            background: url(background1.png) center/cover no-repeat;
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Moves text higher */
            align-items: center;
            text-align: center;
            padding-top: 50px; /* Adjusts vertical positioning */
            padding-bottom: 30px;
        }
        /* Featured Products Section (Scrollable) */
        .featured-products {
            display: flex;
            overflow-x: auto; /* Enables horizontal scrolling */
            gap: 20px;
            padding: 20px;
            scroll-behavior: smooth;
        }

            .featured-products .card {
                min-width: 300px;
                flex: 0 0 auto;
            }

        .scroll-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .scroll-btn {
            cursor: pointer;
            font-size: 24px;
            border: none;
            background: none;
            padding: 10px;
        }
        .custom-navbar {
    background-color: #ffffff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    border-bottom: 2px solid #e0e0e0;
    padding: 10px 40px;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.navbar-brand {
    font-weight: bold;
    font-size: 1.25rem;
    color: #222 !important;
    display: flex;
    align-items: left;
    gap: 10px;
}

.navbar-brand img {
    height: 40px;
    width: auto;
}

.navbar-nav .nav-link {
    color: #333 !important;
    font-weight: 500;
    padding: 8px 15px;
    transition: color 0.3s ease;
}

.navbar-nav .nav-link:hover {
    color: #007bff !important;
}
.mybutton   {
  background-color: #f97316;
    color: white;
    border: none;
    padding: 12px 25px;
    font-weight: 600;
    border-radius: 6px;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    box-shadow: none;
    box-shadow: none;
    display: inline-block;
}
.mybutton:hover{
    background-color: #ea580c;
    box-shadow: 0 0 12px 2px rgba(249, 115, 22, 0.7);
}


    </style>
</head>

<!-- Navigation Bar -->
<?php session_start(); ?>
<nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src='africa.png' alt='Marketplace Icon'>
            Afrimart
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"> 
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="sales.php">Browse Listings</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Sell</a></li>
                <li class="nav-item"><a class="nav-link" href="login_demo.php">Login</a></li>
                

                <!-- Profile icon always visible -->
                <li class="nav-item">
                    <a class="nav-link" 
                       href="<?php echo isset($_SESSION['email']) ? 'user_page.php' : 'login_demo.php'; ?>" 
                       title="<?php echo isset($_SESSION['email']) ? 'Profile' : 'Login'; ?>">
                        <img src="profile.png" 
                             alt="Profile" 
                             style="width:30px; height:30px; border-radius:50%;">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>



    <!-- Hero Section -->
    <div class="hero">
        <h1>Buy & Sell with Confidence</h1>
        <p>Connect with trusted sellers & buyers in South Africa</p>
        <a href="#" class="mybutton">Start Selling</a>
    </div>

    <!-- Featured Listings Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Featured Products</h2>
        <div class="scroll-container">
            <!-- Scroll Left Button -->
            <button class="scroll-btn" onclick="scrollLeft()">&#9664;</button>
            <div class="featured-products" id="scrollable">
                <!-- Product Cards -->
                <div class="card">
                    <img src="product1.jpg" class="card-img-top" alt="Product 1">
                    <div class="card-body">
                        <h5 class="card-title">Product 1</h5>
                        <p class="card-text">R50</p>
                        <a href="#" class="mybutton">View</a>
                    </div>
                </div>
                <div class="card">
                    <img src="product2.jpg" class="card-img-top" alt="Product 2">
                    <div class="card-body">
                        <h5 class="card-title">Product 2</h5>
                        <p class="card-text">R30</p>
                        <a href="#" class="mybutton">View</a>
                    </div>
                </div>
                <div class="card">
                    <img src="product3.jpg" class="card-img-top" alt="Product 3">
                    <div class="card-body">
                        <h5 class="card-title">Product 3</h5>
                        <p class="card-text">R70</p>
                        <a href="#" class="mybutton">View</a>
                    </div>
                </div>
            </div>
                                                       <!-- Scroll Right Button -->
            <button class="scroll-btn" onclick="scrollRight()">&#9654;</button>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-3">
        <p>Eduvos 2025 C2C Afrimart : Ross Fitzgerald.</p>
    </footer>

    <!-- Scroll Functionality for Product Listings -->
    <script>
        function scrollLeft() {
            document.getElementById("scrollable").scrollBy({ left: -300, behavior: 'smooth' });
        }
        function scrollRight() {
            document.getElementById("scrollable").scrollBy({ left: 300, behavior: 'smooth' });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
