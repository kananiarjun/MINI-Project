CREATE DATABASE IF NOT EXISTS gym_user;
USE gym_user;

-- Create the workout_types table to store workout options
CREATE TABLE IF NOT EXISTS workout_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default workout types
INSERT INTO workout_types (name) VALUES 
    ('Boxing'),
    ('Yoga'),
    ('Cardio'),
    ('Fitness'),
    ('Weight Loss');

-- Create the schedules table to store user schedules
CREATE TABLE IF NOT EXISTS schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- In a real app, this would reference a users table
    name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create the schedule_items table to store individual workout slots
CREATE TABLE IF NOT EXISTS schedule_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    schedule_id INT NOT NULL,
    day_of_week TINYINT NOT NULL, -- 0 = Monday, 1 = Tuesday, etc.
    time_slot TIME NOT NULL,
    workout_type_id INT,
    FOREIGN KEY (schedule_id) REFERENCES schedules(id) ON DELETE CASCADE,
    FOREIGN KEY (workout_type_id) REFERENCES workout_types(id),
    UNIQUE KEY unique_schedule_slot (schedule_id, day_of_week, time_slot)
);