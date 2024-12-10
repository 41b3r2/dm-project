-- Create the database
CREATE DATABASE sql_db;
USE sql_db;

-- Create User table
CREATE TABLE User (
    Userid INT PRIMARY KEY AUTO_INCREMENT,
    Fname VARCHAR(50) NOT NULL,
    Mname VARCHAR(50),
    Lname VARCHAR(50) NOT NULL,
    Gender VARCHAR(10) NOT NULL,
    Age INT NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    ConfirmPassword VARCHAR(255) NOT NULL,
    ContactNo VARCHAR(20) NOT NULL,
    Address TEXT NOT NULL,
    Profilepic VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Admin table
CREATE TABLE Admin (
    AdminId INT PRIMARY KEY AUTO_INCREMENT,
    Fname VARCHAR(50) NOT NULL,
    Mname VARCHAR(50),
    Lname VARCHAR(50) NOT NULL,
    Age INT NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    ConfirmPassword VARCHAR(255) NOT NULL,
    Profilepic VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Package table
CREATE TABLE Package (
    Locationid INT PRIMARY KEY AUTO_INCREMENT,
    LocationSpot VARCHAR(100) NOT NULL,
    Location TEXT NOT NULL,
    Imagespot VARCHAR(255),
    Price DECIMAL(10,2) NOT NULL,
    Reviews TEXT,
    Points INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Booking table
CREATE TABLE Booking (
    Bookid INT PRIMARY KEY AUTO_INCREMENT,
    Userid INT,
    Locationid INT,
    Fullname VARCHAR(50) NOT NULL,
    SpecialRequest VARCHAR(500) NOT NULL,
    NoVisitors VARCHAR(20) NOT NULL,
    Date DATE NOT NULL,
    Time TIME NOT NULL,
    Status ENUM('pending', 'accepted') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Userid) REFERENCES User(Userid) ON DELETE CASCADE,
    FOREIGN KEY (Locationid) REFERENCES Package(Locationid) ON DELETE CASCADE
);