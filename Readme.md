# Belleville Dental - Educational Article Website

Welcome to the **Belleville Dental** project — a complete, functional website created for a fictional dental clinic. This is a practical example of a dynamic website powered by **PHP** and **MySQL**, with both public-facing features and a secure admin panel.

---

## Project Overview

The website is divided into two main sections:

* **Client Side**: Visitors can explore the clinic, read articles, search for topics, and view products.
* **Admin Side**: Administrators can log in to a private backend to manage content, products, comments, and user accounts.

---

# Features

### Client Side

* Browse and read articles
* Search functionality for articles
* Filter content by categories
* View dental products

### Admin Side

* Secure login/authentication
* Admin dashboard with statistics
* Manage articles/posts
* Category management
* Product management
* Comment and feedback moderation
* User and administrator management
* Forgot/update password functionality

---

## Technology Stack

* **PHP**
* **MySQL**
* **HTML5 / CSS3**
* **Bootstrap**
* **jQuery**
* **Zircos Admin Template** (by Coderthemes)
* **JavaScript Plugins** (for enhanced UI/UX)

---

## Getting Started

### Prerequisites

1. Download or clone the project and place it inside your `htdocs` folder (`C:\xampp\htdocs`).
2. Start **Apache** and **MySQL** using the XAMPP control panel.
3. Create a MySQL database named `belleville-dental` using **phpMyAdmin**.
4. Import the provided SQL file to populate the database.
5. Open a browser and go to:
   `http://localhost/belleville-dental`

---

## Default Admin Credentials

```bash
Username: admin
Password: admin
```

> Be sure to change these credentials in a real-world deployment for security purposes.

---

## Configuration

Database connection settings can be found in:

* `includes/config.php`
* `admin/includes/config.php`

By default, they assume a standard XAMPP installation:

```php
$dbUsername = "root";
$dbPassword = ""; // leave empty if no password
```

> If your MySQL setup uses a password, be sure to update these files.

---