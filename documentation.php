<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Afrimart Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f9f9f9;
            font-family: 'Poppins', sans-serif;
        }
        .accordion-button:not(.collapsed) {
            background-color: #f97316;
            color: white;
        }
        .accordion-button {
            font-weight: 500;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">📘 Afrimart Documentation</h2>

    <!-- User Documentation -->
    <div class="accordion mb-5" id="userDoc">
        <h4>🧑‍💻 User Documentation</h4>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#intro">
                    1. Introduction
                </button>
            </h2>
            <div id="intro" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    Afrimart is an online e-commerce platform that allows users to browse, buy, and sell a wide range of products. This manual serves as a guide for users, sellers, and admins to effectively use the platform.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#roles">
                    2. User Roles Overview
                </button>
            </h2>
            <div id="roles" class="accordion-collapse collapse">
                <div class="accordion-body">
                    - User: Can browse products, add items to cart, and make purchases.<br>
                    - Seller: Can upload products, manage listings, and track performance.<br>
                    - Admin: Manages system-wide data and monitors activity.<br>
                    - Courier: Assigned to deliver orders (optional for logistics).
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#register">
                    3. Registering and Logging In
                </button>
            </h2>
            <div id="register" class="accordion-collapse collapse">
                <div class="accordion-body">
                    1. Go to the homepage and choose to register.<br>
                    2. Fill in your name, email, password, and select a role.<br>
                    3. Login using your email and password.<br>
                    4. Depending on your role, you’ll be redirected to the appropriate dashboard.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#browse">
                    4. Browsing and Viewing Products
                </button>
            </h2>
            <div id="browse" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Once logged in, users can go to 'sales.php' or click 'Start' from their dashboard to browse available products.<br>
                    Each product displays:<br>
                    - Name and description<br>
                    - Category and price<br>
                    - Seller shop name and image
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#cart">
                    5. Adding Products to Cart
                </button>
            </h2>
            <div id="cart" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Logged-in users (role: user) can add products to their cart:<br>
                    1. On each product card, enter the quantity.<br>
                    2. Click 'Add to Cart'.<br>
                    3. This stores the product and quantity to your cart_items table.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#viewcart">
                    6. Viewing the Cart
                </button>
            </h2>
            <div id="viewcart" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Click ‘View Cart’ from your user dashboard to see:<br>
                    - Product name, image, quantity<br>
                    - Unit price and total price<br>
                    You can continue shopping or proceed to checkout (future feature).
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#seller">
                    7. Seller Features
                </button>
            </h2>
            <div id="seller" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Sellers have access to:<br>
                    - Adding products: Use 'Add Product' to upload images, description, category, price and stock.<br>
                    - Managing listings: Edit or remove products from the dashboard.<br>
                    - Profile management: Update store name, contact info, and address.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#admin">
                    8. Admin Panel
                </button>
            </h2>
            <div id="admin" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Admins can:<br>
                    - Access full database via phpMyAdmin.<br>
                    - Manage users, sellers, and product data.<br>
                    - Oversee platform activities to ensure safety and compliance.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#notes">
                    9. Notes and Limitations
                </button>
            </h2>
            <div id="notes" class="accordion-collapse collapse">
                <div class="accordion-body">
                    - Only registered users can interact with products.<br>
                    - Duplicate cart entries will increase quantity.<br>
                    - Checkout and payment integrations are not included yet.<br>
                    - System assumes valid product IDs and quantities.
                </div>
            </div>
        </div>
    </div>

    <!-- Backend Documentation -->
    <div class="accordion" id="backendDoc">
        <h4>🧠 Backend Documentation</h4>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#stack">
                    1. Technology Stack
                </button>
            </h2>
            <div id="stack" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    - Server: Ubuntu 24.04 LTS (accessed via SSH)<br>
                    - VPN: Fortinet VPN<br>
                    - Backend: PHP & MySQL<br>
                    - Frontend: HTML, Bootstrap 5<br>
                    - Hosting: Self-hosted on EvolutionAnywhere infrastructure
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#dbSchema">
                    2. Database Schema
                </button>
            </h2>
            <div id="dbSchema" class="accordion-collapse collapse">
                <div class="accordion-body">
                    Tables include `users`, `products`, `orders`, `cart_items`, `seller_profiles`, and `courier_assignments`. Relationships are mostly foreign-key based and normalized for modular growth.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#security">
                    3. Security Practices
                </button>
            </h2>
            <div id="security" class="accordion-collapse collapse">
                <div class="accordion-body">
                    - Input sanitization using `htmlspecialchars()` and `prepared statements`<br>
                    - Role-based access checks for each page<br>
                    - Sessions protected via PHP's `session_start()` and logout mechanisms<br>
                    - SSH and VPN-restricted access for deployment server
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
