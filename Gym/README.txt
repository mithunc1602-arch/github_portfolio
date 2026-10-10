GYM MANAGEMENT SYSTEM - SIMPLE VERSION
=======================================
For: Dreamweaver 8 + PHP + MySQL + HeidiSQL + XAMPP

DATABASE TABLES (SIMPLE)
1. users       -> id, username, password
2. members     -> id, name, phone, gender, join_date, plan
3. trainers    -> id, name, phone, specialization
4. attendance  -> id, member_id, date, status
5. payments    -> id, member_id, amount, date

IMPORTANT: No foreign-key constraints are used. This keeps the tables simple and avoids
foreign-key/errno 150 problems while learning with HeidiSQL.

INSTALLATION
------------
1. Extract this folder into C:\xampp\htdocs\
2. Start Apache and MySQL in XAMPP.
3. Open HeidiSQL and connect to your MySQL server.
4. Open gym_management_simple.sql and execute it.
5. Check db.php. Default settings are:
   Host: localhost
   User: root
   Password: blank
   Database: gym_management_simple
6. Open in browser:
   http://localhost/Gym_Management_Simple_DW8/

LOGIN
-----
Username: admin
Password: admin123

PAGES
-----
index.php       Login
Dashboard.php   Dashboard
members.php     Members list
member_add.php  Add member
member_edit.php Edit member
member_delete.php Delete member
trainers.php    Trainers
attendance.php  Attendance
payments.php    Payments
logout.php      Logout

DREAMWEAVER 8
-------------
Open the project folder in Dreamweaver 8. The PHP files can be edited in Code View.
Use the live site through XAMPP, not the local preview, because PHP requires the server.
