# 📚 Library Management System

> A production-ready full-stack library management application built with Laravel 12, featuring role-based access control, book and member management, borrowing workflows, fine management, reporting, REST APIs, Docker containerization, and cloud deployment.

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Production-4169E1?style=for-the-badge&logo=postgresql&logoColor=white)](https://www.postgresql.org/)
[![Docker](https://img.shields.io/badge/Docker-Containerized-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![GitHub](https://img.shields.io/badge/GitHub-Version%20Control-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/)

---

## 🌐 Live Demo

**Live Application:**  
https://library-management-system-zdy8.onrender.com

**Source Code:**  
https://github.com/kartik1532/library-management-system

> The application is deployed as a Dockerized Laravel application with PostgreSQL as the production database.

---

## 📌 Overview

The **Library Management System** is a full-stack web application designed to digitize and simplify common library operations.

It provides dedicated interfaces for **Administrators** and **Library Members**, allowing administrators to manage the library's core operations while members can browse books, monitor borrowings, view fines, receive notifications, and manage their profiles.

The project was developed to demonstrate practical experience with modern Laravel application development, relational databases, REST APIs, authentication, authorization, background processing, Docker, Git, and cloud deployment.

---

## ✨ Core Features

### 👨‍💼 Admin Dashboard

A centralized dashboard for managing library operations.

- Dashboard statistics
- Book management
- Author management
- Category management
- Member management
- Borrowing management
- Book issuing
- Book returns
- Overdue borrowing management
- Fine management
- Fine payment tracking
- Inventory reporting
- Borrowing reports
- Search functionality
- Admin profile management

---

### 👤 Member Portal

A dedicated interface for library members.

- Browse books
- Search books
- View book details
- View current borrowings
- View borrowing history
- Track overdue books
- View fines
- View notifications
- Manage profile

---

### 📚 Library Workflow

The system manages the complete borrowing lifecycle:

```text
Book
  │
  ▼
Member Borrows Book
  │
  ▼
Due Date
  │
  ├── Returned ──────────────► Borrowing Completed
  │
  └── Not Returned
          │
          ▼
       Overdue
          │
          ▼
        Fine
          │
          ▼
    Fine Payment
