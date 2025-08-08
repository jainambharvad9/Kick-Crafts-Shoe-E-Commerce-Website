# 👟 Kick & Crafts – Shoe E-Commerce Website

A fully functional, modern e-commerce platform for premium shoe sales, featuring a **custom-designed admin panel**, secure payments via **Razorpay API**, and a smooth user experience.  
Built with **PHP**, **MySQL**, and **Bootstrap**.

---

## 🌟 Features

- **Product Catalog** – List shoes with images, descriptions, prices, and categories.
- **Advanced Search & Filters** – Browse by brand, size, price range, or category.
- **Secure Payment Gateway** – Integrated **Razorpay API** for seamless transactions.
- **User Authentication** – Registration, login, and token-based **Forgot Password** system.
- **Admin Dashboard** – Manage products, orders, categories, and users.
- **Responsive UI** – Optimized for desktop, tablet, and mobile.
- **Custom Design** – Hand-crafted layouts for both user and admin panels.

---

## 🛠️ Technologies Used

| Category       | Technologies |
|----------------|--------------|
| Frontend       | HTML, CSS, Bootstrap |
| Backend        | PHP |
| Database       | MySQL |
| Payment Gateway| Razorpay API |
| Version Control| Git, GitHub |
| Hosting (Local)| XAMPP / WAMP |

---

## 📂 Project Structure

## 🚀 Getting Started

Follow these steps to set up the project locally:

### 1️⃣ Clone the Repository

git clone https://github.com/your-username/kick-crafts.git

2️⃣ Setup the Database
Open phpMyAdmin.

Create a new database named kickcrafts_db.

Import the provided kickcrafts_db.sql file from the sql/ folder.

3️⃣ Configure the Database Connection
Open config/db.php and update with your MySQL credentials:


<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "kickcrafts_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

4️⃣ Configure Razorpay API

Sign up at Razorpay.

Generate API Key and Secret.

Add them in config/razorpay.php:

php

<?php
define('RAZORPAY_KEY_ID', 'your_key_id');
define('RAZORPAY_KEY_SECRET', 'your_key_secret');
?>

5️⃣ Run the Project

Move the project folder to htdocs (XAMPP) or www (WAMP).

Start Apache and MySQL.

Open in browser:

arduino

http://localhost/kick-crafts
👥 User Roles
Admin
Manage products, categories, and orders.

View and update user details.

Track sales and payment history.

User
Browse products, search, and filter.

Add to cart and checkout with Razorpay.

Reset password via token-based email system.




📜 License
This project is licensed for educational and personal use only.
For commercial use, please contact the author.


💡 Author Jainam Saraiya

📧 Email: jainamsaraiya9@gmail.com

🌐 Portfolio: [your-portfolio-link]

💼 LinkedIn: [https://www.linkedin.com/in/jainam-bharvad]


If you want, I can now create **a second matching README.md for your SonicSonicTunes Laravel Music Player project** so your GitHub portfolio looks uniform and professional across all projects. That will make it look like a complete collection.


