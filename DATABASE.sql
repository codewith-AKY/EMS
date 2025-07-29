CREATE DATABASE IF NOT EXISTS employee_management;
USE employee_management;

-- Admin Table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Employee Table
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    gender VARCHAR(10),
    department VARCHAR(100),
    designation VARCHAR(100),
    salary DECIMAL(10,2),
    join_date DATE,
    photo VARCHAR(255)
);

-- Department Table
CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Designation Table
CREATE TABLE designations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Salary Table
CREATE TABLE salaries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    amount DECIMAL(10,2),
    paid_date DATE,
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

-- Leave Requests Table
CREATE TABLE leaves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    leave_type VARCHAR(100),
    from_date DATE,
    to_date DATE,
    reason VARCHAR(255),
    status VARCHAR(50),
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

-- Reset all tables and auto-increment counters for a clean demo
TRUNCATE TABLE salaries;
TRUNCATE TABLE leaves;
TRUNCATE TABLE employees;
TRUNCATE TABLE departments;
TRUNCATE TABLE designations;
TRUNCATE TABLE admin;

-- Admin
INSERT INTO admin (username, password) VALUES ('admin', MD5('admin123'));

-- Departments
INSERT INTO departments (id, name) VALUES
(1, 'IT'),
(2, 'HR'),
(3, 'Finance'),
(4, 'Marketing'),
(5, 'Operations');

-- Designations
INSERT INTO designations (id, name) VALUES
(1, 'Software Engineer'),
(2, 'HR Manager'),
(3, 'Accountant'),
(4, 'UI/UX Designer'),
(5, 'Operations Lead');

-- Employees (IDs 1,2,3,4,5 in order)
INSERT INTO employees (id, name, email, phone, gender, department, designation, salary, join_date, photo) VALUES
(1, 'Amit Sharma', 'amit.sharma@example.com', '9876543210', 'Male', 'IT', 'Software Engineer', 60000.00, '2023-01-15', ''),
(2, 'Priya Singh', 'priya.singh@example.com', '9123456780', 'Female', 'HR', 'HR Manager', 55000.00, '2022-11-01', ''),
(3, 'Rahul Verma', 'rahul.verma@example.com', '9988776655', 'Male', 'Finance', 'Accountant', 50000.00, '2023-03-10', ''),
(4, 'Sneha Patel', 'sneha.patel@example.com', '9871234567', 'Female', 'IT', 'UI/UX Designer', 58000.00, '2023-02-20', ''),
(5, 'Vikas Gupta', 'vikas.gupta@example.com', '9001122334', 'Male', 'Operations', 'Operations Lead', 48000.00, '2022-12-05', '');

-- Salaries (match employee_id to above)
INSERT INTO salaries (employee_id, amount, paid_date) VALUES
(1, 60000.00, '2023-07-01'),
(2, 55000.00, '2023-07-01'),
(3, 50000.00, '2023-07-01'),
(4, 58000.00, '2023-07-01'),
(5, 48000.00, '2023-07-01');

-- Leave Requests (match employee_id to above)
INSERT INTO leaves (employee_id, leave_type, from_date, to_date, reason, status) VALUES
(1, 'Sick Leave', '2023-07-10', '2023-07-12', 'Fever and cold', 'Approved'),
(2, 'Casual Leave', '2023-07-15', '2023-07-16', 'Family function', 'Pending'),
(3, 'Annual Leave', '2023-07-20', '2023-07-25', 'Vacation', 'Rejected'),
(4, 'Sick Leave', '2023-07-18', '2023-07-19', 'Medical checkup', 'Approved'),
(5, 'Casual Leave', '2023-07-22', '2023-07-23', 'Personal work', 'Pending');

-- Reset AUTO_INCREMENT for employees, departments, designations
ALTER TABLE employees AUTO_INCREMENT = 6;
ALTER TABLE departments AUTO_INCREMENT = 6;
ALTER TABLE designations AUTO_INCREMENT = 6;
