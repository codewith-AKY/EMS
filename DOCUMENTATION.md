# Employee Management System (EMS)

Welcome to the Employee Management System! This project is a complete solution for managing employees, departments, designations, salaries, and leave requests in a small or medium-sized business. Built with core PHP, MySQL, HTML, CSS, and JavaScript, it is easy to set up, use, and customize—no frameworks required.

---

## Table of Contents
1. [Features](#features)
2. [Setup Instructions](#setup-instructions)
3. [Usage Guide](#usage-guide)
4. [File Structure](#file-structure)
5. [Customization](#customization)
6. [Security Notes](#security-notes)
7. [Demo/Reset Functionality](#demoreset-functionality)
8. [Troubleshooting](#troubleshooting)
9. [Credits & License](#credits--license)

---

## Features
- **Secure Admin Authentication**: Only authorized admins can log in. Passwords are validated and never stored in plain text. You can toggle password visibility for convenience.
- **Employee Management**: Add, edit, and delete employees. Upload a photo for each employee. All employee data is always shown in ascending order by ID, so the first employee is always at the top.
- **Department & Designation Management**: Easily add or remove departments and designations. These lists are also sorted by ID for clarity.
- **Salary Management**: Assign salaries to employees, view salary records, and delete them if needed. Salaries are always shown in order.
- **Leave Management**: Employees can request leave, and admins can approve, reject, or delete requests. All leave requests are sorted by ID.
- **Dashboard**: See a quick overview of your organization—total employees, departments, leave requests, and salaries paid. Navigate to any management page with one click.
- **Modern, Responsive UI**: The interface is clean and works well on both desktop and mobile devices. All styling is handled in `style.css` for easy customization.
- **Validation**: Every form is validated both in the browser (JavaScript) and on the server (PHP) to prevent errors and keep your data safe.
- **Demo/Reset Functionality**: Want to start fresh or show a demo? Use the provided SQL files to reset your database with clean, sample data. All IDs are sequential for easy reference.

---

## Setup Instructions
### 1. Requirements
- XAMPP or similar local server (PHP 7.4+ recommended)
- MySQL
- Any modern web browser

### 2. Database Setup
- Import `DATABASE.sql` into your MySQL server to create all tables and sample data.
- To reset or demo, use `demo_sequential_ids.sql` or `sample_data.sql`.
- Update your MySQL credentials in `includes/db.php` if needed.

### 3. Running the Application
- Place the EMS folder in your XAMPP `htdocs` directory.
- Start Apache and MySQL from the XAMPP control panel.
- Open your browser and go to `http://localhost/EMS/`.

### 4. Default Admin Login
- The default admin username and password are set in the `admin` table (see `DATABASE.sql`).
- Change the password after your first login for security.

---

## Usage Guide
### Logging In
- Go to the login page and enter your admin credentials. If you forget your password, use the "Forgot Password?" link.

### Dashboard
- After logging in, you'll see the dashboard with key stats and quick links to all management pages.

### Managing Employees
- Add new employees with all details and a photo. Edit or delete existing employees. All employees are listed in order by their ID.

### Departments & Designations
- Add new departments and designations as your organization grows. Remove them if no longer needed. Lists are always sorted by ID.

### Salaries
- Assign salaries to employees, view all salary records, and delete records if necessary. Salaries are shown in order.

### Leave Requests
- Employees can request leave. Admins can approve, reject, or delete requests. All leave requests are sorted by ID.

### Demo/Reset
- Use the provided SQL files to reset your database to clean sample data. This is great for demos or starting fresh.

### Logging Out
- Click the logout link in the header to securely end your session.

---

## File Structure
```
EMS/
├── add_employee.php         # Add new employee
├── dashboard.php            # Admin dashboard (stats & navigation)
├── DATABASE.sql             # MySQL database schema & demo data
├── delete_employee.php      # Delete employee logic
├── departments.php          # Manage departments (CRUD)
├── designations.php         # Manage designations (CRUD)
├── edit_employee.php        # Edit employee details
├── employees.php            # List, edit, delete employees
├── index.php                # Admin login page
├── leave.php                # Manage leave requests (CRUD)
├── logout.php               # Logout logic
├── salary.php               # Manage salaries (CRUD)
├── css/
│   └── style.css            # Main stylesheet
├── includes/
│   ├── db.php               # Database connection
│   ├── footer.php           # Footer include
│   └── header.php           # Header include
├── js/
│   └── main.js              # Main JavaScript (validation, UI)
├── uploads/
│   └── ...                  # Employee photos
├── sample_data.sql          # Demo/sample data for quick reset
├── demo_sequential_ids.sql  # Demo data with sequential IDs
└── README.md                # Project overview
```

---

## Customization
- Change the company name in `includes/header.php`.
- Update colors, fonts, and layout in `css/style.css` to match your brand.
- Add new features as needed (CSV export, advanced search/filter, etc.).
- All UI changes can be made in the CSS and PHP files—no frameworks required.

---

## Security Notes
- All database queries use prepared statements to prevent SQL injection.
- Sessions are used for authentication; logging out destroys the session.
- Both client-side and server-side validation are implemented for all forms.
- Passwords are hashed in the database for security.

---

## Demo/Reset Functionality
- Use `demo_sequential_ids.sql` or `sample_data.sql` to reset your database.
- All demo data uses sequential IDs for clarity and easy reference.
- The reset process truncates tables and resets auto-increment counters, keeping only the admin account.

---

## Troubleshooting
- **Background image not showing?** Make sure `index.jpg` is in the `uploads` folder and the path is correct in your code.
- **Database connection issues?** Double-check your credentials in `includes/db.php` and ensure MySQL is running.
- **Login problems?** Make sure your admin credentials match those in the database. Reset the password if needed.
- **Demo data not loading?** Import the correct SQL file and check for errors in phpMyAdmin or the MySQL console.

---

## Credits & License
Developed by AK Tech Solution (update as needed).
This project is for educational and internal business use. For commercial use, please contact the author.
