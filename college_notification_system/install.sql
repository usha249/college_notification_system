CREATE DATABASE IF NOT EXISTS college_notification_system;
USE college_notification_system;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  email VARCHAR(200) NOT NULL UNIQUE,
  role VARCHAR(50) NOT NULL,
  college_type VARCHAR(50) DEFAULT NULL,
  branch VARCHAR(50) DEFAULT NULL,
  year VARCHAR(10) DEFAULT 'All',
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender_id INT,
  sender_role VARCHAR(50),
  receiver_role VARCHAR(50) DEFAULT 'All',
  receiver_college VARCHAR(50) DEFAULT 'All',
  receiver_branch VARCHAR(50) DEFAULT 'All',
  receiver_year VARCHAR(10) DEFAULT 'All',
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  category VARCHAR(50) DEFAULT 'General',
  attachment VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Sample VC user (password: vc123)
INSERT INTO users (name,email,role,password) VALUES ('VC Admin','vc@iitchennai.edu','VC','$2y$10$wH2q9y1z7u9K7Qw3eZp4YuQp3Eo2a1bC6d7E8f9G0h1i2j3k4l5m.');
