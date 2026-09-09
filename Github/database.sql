CREATE DATABASE IF NOT EXISTS gym_project;
USE gym_project;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','member') NOT NULL DEFAULT 'member'
);

CREATE TABLE IF NOT EXISTS trainers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(150),
    specialization VARCHAR(150)
);

CREATE TABLE IF NOT EXISTS membership_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plan_name VARCHAR(100) NOT NULL,
    duration INT NOT NULL DEFAULT 30,
    price DECIMAL(10,2) NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(150),
    gender VARCHAR(20),
    trainer_id INT NULL,
    plan_id INT NULL,
    join_date DATE,
    status VARCHAR(30) DEFAULT 'Active',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (trainer_id) REFERENCES trainers(id) ON DELETE SET NULL,
    FOREIGN KEY (plan_id) REFERENCES membership_plans(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS exercises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    exercise_name VARCHAR(150) NOT NULL,
    muscle_group VARCHAR(100),
    description TEXT
);

CREATE TABLE IF NOT EXISTS workouts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    exercise_id INT NOT NULL,
    sets_count INT NOT NULL DEFAULT 0,
    reps INT NOT NULL DEFAULT 0,
    workout_date DATE,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (exercise_id) REFERENCES exercises(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS diet_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    meal_time VARCHAR(50),
    food VARCHAR(255),
    calories INT DEFAULT 0,
    notes VARCHAR(255),
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    attendance_date DATE NOT NULL,
    status ENUM('Present','Absent') NOT NULL,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date DATE,
    payment_method VARCHAR(50),
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    record_date DATE,
    weight DECIMAL(5,2),
    height DECIMAL(5,2),
    notes VARCHAR(255),
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
);

INSERT INTO trainers(name,phone,email,specialization)
SELECT 'John Trainer','9876543210','trainer@gmail.com','Fitness Training'
WHERE NOT EXISTS (SELECT 1 FROM trainers WHERE email='trainer@gmail.com');

INSERT INTO membership_plans(plan_name,duration,price)
SELECT 'Monthly Plan',30,1000
WHERE NOT EXISTS (SELECT 1 FROM membership_plans WHERE plan_name='Monthly Plan');

INSERT INTO exercises(exercise_name,muscle_group,description)
SELECT 'Push Up','Chest','Basic chest exercise'
WHERE NOT EXISTS (SELECT 1 FROM exercises WHERE exercise_name='Push Up');

INSERT INTO exercises(exercise_name,muscle_group,description)
SELECT 'Squats','Legs','Basic leg exercise'
WHERE NOT EXISTS (SELECT 1 FROM exercises WHERE exercise_name='Squats');

INSERT INTO exercises(exercise_name,muscle_group,description)
SELECT 'Bicep Curl','Biceps','Biceps strengthening exercise'
WHERE NOT EXISTS (SELECT 1 FROM exercises WHERE exercise_name='Bicep Curl');
