<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 🛒 Laravel Ecommerce API

This is a robust Ecommerce API built with Laravel, designed to handle products, orders, users, and permissions. Follow the instructions below to set up and run the project locally.

## 🛠 Prerequisites

Before you begin, ensure you have the following installed on your system:

-   **PHP** (>= 8.2 recommended)
    
-   **Composer**
    
-   **MySQL** or **MariaDB**
    
-   **Git**
    

## 🚀 Installation Guide

Follow these steps carefully to set up the project locally:

### 1. Clone the Repository

Open your terminal and run the following command to clone the project:

```
git clone https://github.com/sohanthink/poradoor_backend.git
cd your-repo-name

```

### 2. Install Dependencies

Install all required PHP packages via Composer:

```
composer install

```

### 3. Setup Environment File

Copy the example environment file to create your own `.env` file:

```
cp .env.example .env

```

### 4. Database Configuration

1.  Create a database in your local SQL server (e.g., `ecommerce_api`).
    
2.  Open the `.env` file and update the database details to match your local setup:
    
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ecommerce_api
    DB_USERNAME=root
    DB_PASSWORD=
    
    ```
    

### 5. Generate Application Key

Run the following command to generate a unique encryption key:

```
php artisan key:generate

```

### 6. Run Migrations & Seeders

This will create all necessary tables and populate them with initial data (like roles and permissions):

```
php artisan migrate:fresh --seed

```

> **⚠️ Note:** If you encounter the "Specified key was too long" error, please ensure you have added `Schema::defaultStringLength(191);` in your `AppServiceProvider.php` file within the `boot()` method.

### 7. Link Storage (Optional)

If your project manages product images, link the storage folder to the public directory:

```
php artisan storage:link

```

## 🏃 Running the Project

Start the local development server:

```
php artisan serve

```

The API will be accessible at: `http://127.0.0.1:8000`

## 💡 Key Commands for Maintenance

-   **Clear Config Cache:** `php artisan config:clear`
    
-   **Clear Route Cache:** `php artisan route:clear`
    
-   **Clear Application Cache:** `php artisan cache:clear`
    

