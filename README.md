# 📚 Library Management System

A full-stack **Library Management System** built with **Laravel 12**, designed to manage books, authors, categories, members, borrowing transactions, overdue books, fines, reports, authentication, and REST APIs through a centralized web application.

The system provides separate experiences for **administrators and library members**, with role-based access control and a responsive dashboard-oriented interface.

---

## 🚀 Features

### 👨‍💼 Admin Management

Administrators can manage the complete library operation from a centralized dashboard.

- 📊 Admin dashboard with library statistics
- 📚 Book management
- ✍️ Author management
- 🏷️ Category management
- 👥 Member management
- 🔄 Borrowing management
- ↩️ Book return management
- 💰 Fine management and fine payment
- 📈 Reports and inventory information
- 🔎 Search functionality
- 👤 Admin profile management
- 🔐 Role-based authorization

### 👤 Member Management

Members have access to their own library activity.

- Member dashboard
- Browse available books
- View borrowing history
- View currently borrowed books
- Track overdue books
- View fines
- Filter borrowing records
- Manage profile information

### 📖 Book & Inventory Management

The system maintains book inventory and availability.

- Book title and ISBN management
- Author association
- Category association
- Total quantity tracking
- Available quantity tracking
- Book availability status
- Book cover image support
- Search and filtering

### 🔄 Borrowing System

The borrowing workflow supports:

```text
Book Available
      ↓
Borrow Book
      ↓
Borrowing Record Created
      ↓
Due Date
      ↓
Returned / Overdue
      ↓
Fine Calculation
      ↓
Fine Payment
```

The system tracks:

- Issue date
- Due date
- Return date
- Borrowing status
- Overdue status
- Associated member
- Associated book
- Fine information

### 💰 Fine Management

The system supports:

- Automatic overdue identification
- Fine records
- Paid/unpaid fine status
- Fine totals
- Fine payment functionality
- Member fine history
- Admin fine management

### 📊 Reports

Administrators can monitor library activity through reports including:

- Borrowing records
- Overdue books
- Book inventory
- Available copies
- Issued copies
- Available titles
- Unavailable titles
- Search and filtering
- Date-based filtering
- Status-based filtering

### 🔔 Due-Date Reminders

The application includes a queued reminder system for upcoming due dates.

Borrowings approaching their due date can trigger a reminder notification through the application's notification/job system.

---

# 🔐 Authentication & Authorization

The application uses Laravel authentication and role-based authorization.

Supported roles include:

| Role | Access |
|---|---|
| Admin | Full library management |
| Member | Personal library activity and book access |

Administrative routes are protected using middleware so that member accounts cannot access administrator functionality.

---

# 🌐 REST API

The project also includes a RESTful API for interacting with library data programmatically.

### Authentication

```text
POST /api/login
POST /api/logout
GET  /api/user
GET  /api/status
```

### Authors

```text
GET /api/authors
GET /api/authors/{author}
```

### Categories

```text
GET /api/categories
GET /api/categories/{category}
```

### Books

```text
GET    /api/books
POST   /api/books
GET    /api/books/{book}
PUT    /api/books/{book}
DELETE /api/books/{book}
```

API authentication is handled using **Laravel Sanctum**.

Example authenticated request:

```http
Authorization: Bearer YOUR_API_TOKEN
```

The API was tested using **Postman** during development.

---

# 🛠️ Technology Stack

## Backend

- **PHP 8.2+**
- **Laravel 12**
- **Laravel Sanctum**
- **MySQL**
- REST API

## Frontend

- HTML5
- CSS3
- Bootstrap 5.3
- Bootstrap Icons
- JavaScript
- Blade Templates

## Development Tools

- Composer
- NPM
- Vite
- Git
- GitHub
- Postman
- XAMPP

---

# 🏗️ Project Architecture

The application follows Laravel's MVC architecture.

```text
library-management-system/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Api/
│   │   │   ├── Auth/
│   │   │   └── Member/
│   │   │
│   │   ├── Middleware/
│   │   └── Requests/
│   │
│   ├── Jobs/
│   ├── Models/
│   ├── Notifications/
│   ├── Policies/
│   ├── Providers/
│   └── Services/
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   ├── css/
│   ├── js/
│   └── index.php
│
├── resources/
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── layouts/
│       └── member/
│
├── routes/
│   ├── api.php
│   ├── console.php
│   └── web.php
│
├── storage/
│
├── tests/
│
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

---

# 🗄️ Database Structure

The main entities include:

```text
Users
  │
  ├── Admin
  │
  └── Member
        │
        └── Borrowings
                │
                ├── Book
                │    ├── Author
                │    └── Category
                │
                └── Fine
```

### Main Database Tables

- `users`
- `members`
- `authors`
- `categories`
- `books`
- `borrowings`
- `fines`
- `notifications`
- `personal_access_tokens`

Database structure is managed through Laravel migrations.

---

# ⚙️ Installation

## 1. Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/library-management-system.git
```

Move into the project:

```bash
cd library-management-system
```

---

## 2. Install PHP Dependencies

```bash
composer install
```

---

## 3. Install Frontend Dependencies

```bash
npm install
```

---

## 4. Create Environment File

Copy the example environment file:

### Windows

```bash
copy .env.example .env
```

### macOS/Linux

```bash
cp .env.example .env
```

---

## 5. Generate Application Key

```bash
php artisan key:generate
```

---

# 🗄️ Database Configuration

Create a MySQL database and configure the following values inside `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_management
DB_USERNAME=root
DB_PASSWORD=
```

Update the values according to your local environment.

---

## 6. Run Database Migrations

```bash
php artisan migrate
```

If you want to populate the database with development/sample data:

```bash
php artisan db:seed
```

Or:

```bash
php artisan migrate --seed
```

---

# ▶️ Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

The application will normally be available at:

```text
http://127.0.0.1:8000
```

For frontend assets, run:

```bash
npm run dev
```

For a production frontend build:

```bash
npm run build
```

---

# 🧪 API Testing

The REST API was tested using **Postman**.

Typical API workflow:

```text
Login
  ↓
Receive Sanctum Token
  ↓
Authenticate API Requests
  ↓
Access Books / Authors / Categories
  ↓
Create / Update / Delete Resources
```

Example:

```http
POST /api/login
```

Then use the returned token:

```http
Authorization: Bearer YOUR_TOKEN
```

---

# 🔒 Security

The project follows several Laravel security practices:

- Environment-based configuration
- Password hashing
- Authentication middleware
- Role-based authorization
- Laravel Sanctum API authentication
- CSRF protection for web forms
- Form request validation
- Protected admin routes
- Sensitive `.env` configuration excluded from Git

> **Important:** Never commit your `.env` file, API tokens, production credentials, database passwords, or other secrets to GitHub.

---

# 📁 Environment Files

The repository includes:

```text
.env.example
```

but intentionally excludes:

```text
.env
```

The `.env` file must be created locally after cloning the repository.

---

# 🧪 Testing

Laravel's testing infrastructure is included in:

```text
tests/
```

Run the test suite using:

```bash
php artisan test
```

---

# 📸 Screenshots

Add screenshots of your application here after uploading them to the repository.

Recommended screenshots:

### Admin Dashboard

```text
Add dashboard screenshot here
```

### Books Management

```text
Add books screenshot here
```

### Borrowing Management

```text
Add borrowing screenshot here
```

### Reports

```text
Add reports screenshot here
```

### Member Dashboard

```text
Add member dashboard screenshot here
```

---

# 📌 Current Project Scope

The system currently covers:

- Authentication
- Admin and member roles
- Book management
- Author management
- Category management
- Member management
- Borrowing management
- Book returns
- Overdue tracking
- Fine management
- Reports
- Search
- Due-date reminders
- REST API
- Sanctum authentication
- Dashboard statistics

---

# 🚀 Future Improvements

Potential future enhancements include:

- 📧 Email notifications
- 📱 Fully optimized mobile experience
- 📊 Advanced analytics
- 📈 Interactive charts
- 📚 Book reservation system
- 🔔 Real-time notifications
- 📷 Barcode/QR code scanning
- 📄 PDF report generation
- 📥 Export reports to Excel/CSV
- 🔍 Advanced global search
- ☁️ Production cloud deployment
- 🧪 Expanded automated test coverage
- 🔐 Two-factor authentication
- 📦 Docker-based development environment

---

# 👨‍💻 Development

This project was developed as a full-stack Laravel application with a focus on:

- MVC architecture
- RESTful API development
- Database relationships
- Authentication and authorization
- CRUD operations
- Form validation
- Business logic
- Inventory management
- Reporting
- Background jobs
- Notifications
- Responsive UI development

---

# 📄 License

This project is intended for educational, portfolio, and demonstration purposes.

If you plan to use this project commercially, add an appropriate open-source or proprietary license before distribution.

---

# ⭐ Support

If you find this project useful, consider giving the repository a ⭐ on GitHub.

---

## 📬 Contact

For questions, suggestions, or collaboration, please use the GitHub repository's Issues or Discussions section.

---

**Built with ❤️ using Laravel and PHP.**
