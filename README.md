# 🛒 PHP MVC E-commerce Web Application with AI

A full-stack E-commerce web application built with PHP using a custom MVC architecture and MySQL.  
The project simulates a real-world online shopping platform and integrates AI-assisted features such as product recommendations and an AI chatbox to enhance user experience.

This project demonstrates backend development skills, MVC design pattern, database-driven applications, and practical AI integration in a web system.

==================================================

🛠️ TECHNOLOGIES USED

Backend
- PHP (Custom MVC architecture)
- Composer (dependency management)
- PHPMailer (SMTP email service)
- PHP Session (authentication & authorization)

Database
- MySQL
- SQL schema design and relational data modeling

Frontend
- HTML
- CSS
- JavaScript (UI interactions, AI chatbox)

Architecture & Patterns
- MVC (Model – View – Controller)
- Separation of concerns
- Service & helper-based structure

AI Integration
- AI-powered product recommendation logic
- AI chatbox for product inquiry and user support
- Rule-based + AI-assisted logic integration

Server & Tools
- Apache Web Server
- .htaccess (SEO-friendly URL rewriting & routing)
- Git & GitHub (version control)

==================================================

✨ FEATURES

🧠 AI FEATURES
- AI-powered product recommendation system suggesting related products based on category, popularity, and user behavior
- AI chatbox for basic customer support, product inquiries, and shopping guidance

👤 USER & AUTHENTICATION
- User registration and login
- Session-based authentication
- User profile management
- Role-based access control (Admin / User)

🛍️ PRODUCT & SHOPPING
- Product listing and product detail pages
- Product search and category filtering
- Shopping cart management
- Checkout and order creation flow

📦 ORDER MANAGEMENT
- Order processing system
- Order history for users
- Order management dashboard for admin

⭐ REVIEW & INTERACTION
- Product reviews and ratings
- User feedback system

💸 DISCOUNT & PROMOTION
- Discount and voucher management
- Apply discount codes during checkout

📧 EMAIL SYSTEM
- SMTP email integration using PHPMailer
- Order confirmation and notification emails

⚙️ SYSTEM FEATURES
- SEO-friendly URLs using .htaccess
- Custom MVC architecture
- Clean separation between business logic and UI
- Support for VIP / sub-site module

==================================================

🗂️ PROJECT STRUCTURE

app/                Application core (MVC structure)  
app/config/         Application and database configuration  
app/controllers/    Controllers handling business logic  
app/models/         Database models  
app/views/          UI templates  
app/helpers/        Helper utilities (session, email, AI logic)  
public/js/          JavaScript files (UI, AI chatbox)  
uploads/            Uploaded product images  
images/             UI assets  
vendor/             Composer dependencies  
vip/                VIP / sub-site module  
index.php           Application entry point  
.htaccess           URL rewriting and routing  
data_nha.sql        Database schema  
composer.json       Composer configuration  
README.md           Project documentation  

==================================================

▶️ HOW TO RUN THE PROJECT (LOCAL)

REQUIREMENTS
- PHP 7.x or higher
- MySQL
- Apache (XAMPP / WAMP / Laragon recommended)
- Composer

SETUP STEPS
1. Clone the repository  
   git clone https://github.com/huydevhehe/php-mvc-ecommerce-web-AI.git

2. Move the project into your web server directory (e.g. htdocs)

3. Install dependencies  
   composer install

4. Create a MySQL database and import schema  
   Import file: data_nha.sql

5. Configure database credentials in app/config/

6. Start Apache and MySQL services

7. Open browser and access  
   http://localhost/php-mvc-ecommerce-web-AI

==================================================

🔐 SECURITY
- Sensitive credentials are not hard-coded
- Email and database credentials are configured locally
- Safe for public and academic demonstration

📌 PROJECT INFORMATION
- Project Type: Academic / Personal Project
- Domain: E-commerce Web Application
- AI Features: Product Recommendation, AI Chatbox
- Team Size: 3 members
- Role: Full-stack Developer
- Purpose: Demonstrate PHP MVC architecture, backend development, database design, and AI-assisted web features

👤 AUTHOR  
Nguyen Quoc Huy  
GitHub: https://github.com/huydevhehe
