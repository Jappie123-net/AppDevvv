# 🧮 Mini Inventory System

A simple inventory management system built using **Laravel**, designed for small businesses or sari-sari stores to manage stock levels, suppliers, and product categories.

---

## ✨ Features

- Product Listing with:
  - Name, Category, Supplier, Price, Quantity
  - Sort & Search
- Admin Functions:
  - Add / Edit / Delete Products
  - Restock (Add Quantity)
  - Sell (Deduct Quantity)
- Role-based Authentication (Admin & Regular Users)

---

## 🛠️ Tech Stack

- Laravel 10
- Bootstrap 5 (for UI)
- MySQL (Database)

---

## 👤 User Roles

| Role   | Access                                   |
|--------|------------------------------------------|
| Admin  | Full access (CRUD, Sell, Add Quantity)   |
| User   | Can view product list only               |

---


## 🚀 How to Run

```bash
git clone https://github.com/Jappie123-net/AppDevvv.git
cd AppDevvv
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

