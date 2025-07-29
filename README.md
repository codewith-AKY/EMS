# Employee Management System (EMS)

A complete Employee Management System built with core PHP, MySQL, HTML, CSS, and JavaScript (no frameworks). Designed for small to medium businesses to securely manage employees, departments, designations, salaries, and leave requests with a modern, responsive UI.

---

## Features

- **Secure Admin Authentication**
  - Session-based login/logout
  - Password validation and error feedback
  - Password visibility toggle

- **Employee Management**
  - Add, edit, delete employees
  - Photo upload for each employee
  - List and search employees
  - Employees always displayed in ascending order by ID (ID 1 at the top)

- **Department & Designation Management**
  - Add and delete departments/designations
  - Departments and designations always displayed in ascending order by ID

- **Salary Management**
  - Add and delete salary records
  - Assign salary to employees
  - Salaries always displayed in ascending order by ID
  - View total salaries paid

- **Leave Management**
  - Add leave requests for employees
  - Approve, reject, or delete leave requests
  - Leave requests always displayed in ascending order by ID
  - View all leave requests with status

- **Dashboard**
  - View total employees, departments, leave requests, and salaries paid
  - Quick navigation to all management pages

- **Modern, Responsive UI**
  - Clean and modern design using CSS
  - Responsive layout for desktop and mobile

- **Validation**
  - Client-side (JavaScript) and server-side (PHP) validation for all forms

- **Demo/Reset Functionality**
  - Easily reset the database to clean sample data with sequential IDs
  - Demo data for all tables (admin, employees, departments, designations, salaries, leaves)

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
│   ├── auth.php             # (Legacy) Auth logic
│   ├── db.php               # Database connection
│   ├── footer.php           # Footer include
│   └── header.php           # Header include (with company name)
├── js/
│   └── main.js              # Main JavaScript (validation, UI)
├── uploads/
│   └── ...                  # Employee photos
├── sample_data.sql          # Demo/sample data for quick reset
├── demo_sequential_ids.sql  # Demo data with sequential IDs
└── README.md                # This file
```

---

## Setup Instructions

1. **Requirements**
   - XAMPP or similar local server (PHP 7.4+ recommended)
   - MySQL
   - Web browser

2. **Database Setup**
   - Import `DATABASE.sql` into your MySQL server to create all required tables and demo data.
   - To reset/demo with sequential IDs, use `demo_sequential_ids.sql` or `sample_data.sql` as needed.
   - Update `includes/db.php` with your MySQL credentials if needed.

3. **Running the Application**
   - Place the EMS folder in your XAMPP `htdocs` directory.
   - Start Apache and MySQL from XAMPP control panel.
   - Visit `http://localhost/EMS/` in your browser.

4. **Default Admin Login**
   - The default admin credentials are set in the `admin` table (see `DATABASE.sql`).
   - Update the admin password as needed after first login.

---

## Usage

- **Login**: Use the admin credentials to log in.
- **Dashboard**: View stats and navigate to management pages.
- **Employees**: Add, edit, or delete employees. Upload photos. Data always shown in ascending order by ID.
- **Departments/Designations**: Add or remove as needed. Data always shown in ascending order by ID.
- **Salaries**: Assign and manage salary records for employees. Data always shown in ascending order by ID.
- **Leave**: Add leave requests, approve/reject/delete them. Data always shown in ascending order by ID.
- **Demo/Reset**: Use provided SQL files to reset the database to clean sample/demo data with sequential IDs.
- **Logout**: Use the logout link in the header to securely log out.

---

## Security Notes
- All database queries use prepared statements to prevent SQL injection.
- Sessions are used for authentication; logout destroys the session.
- Both client-side and server-side validation are implemented for all forms.

---

## Customization
- Change the company name in `includes/header.php` as needed.
- Update styles in `css/style.css` for branding.
- Extend features as required (e.g., add CSV export, search/filter, etc.).

---

## Credits
Developed by AK Tech Solution (or update as needed).

---

## License
This project is for educational and internal business use. For commercial use, please contact the author.
