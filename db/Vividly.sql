-- Create Database
DROP DATABASE IF EXISTS Vividly;
CREATE DATABASE Vividly;
USE Vividly;

-- Users Table
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(255) NOT NULL UNIQUE,
    lname VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` tinyint(4) DEFAULT 2,
    profile_picture VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Boards Table
CREATE TABLE Boards (
    board_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255) NOT NULL,
    `description` TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

-- Pins Table
CREATE TABLE Pins (
    pin_id INT AUTO_INCREMENT PRIMARY KEY, -- pin id number
    user_id INT , -- user id number
    board_id INT,   -- board id number
    image_url VARCHAR(255) NOT NULL,    -- image url
    caption VARCHAR(255) NOT NULL, -- title of the pos
    `description` TEXT, -- description of the post
    category_id INT,    -- category id number
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (board_id) REFERENCES Boards(board_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id)
);

-- Comments Table
CREATE TABLE Comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    pin_id INT,
    user_id INT,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pin_id) REFERENCES Pins(pin_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

-- Likes Table
CREATE TABLE Likes (
    like_id INT AUTO_INCREMENT PRIMARY KEY,
    pin_id INT,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pin_id) REFERENCES Pins(pin_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

-- Categories Table
CREATE TABLE Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    `name` tinyint(6)  NOT NULL, -- 6 categories (Art, Design, Fashion, Food, Photography, Travel)
    `description` TEXT -- Description of each category
);

-- User Statistics Table
-- CREATE TABLE User_Statistics (
--     stat_id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT,
--     total_pins INT DEFAULT 0,
--     total_boards INT DEFAULT 0,
--     total_likes INT DEFAULT 0,
--     total_comments INT DEFAULT 0,
--     FOREIGN KEY (user_id) REFERENCES Users(user_id)
-- );

-- Triggers for User Statistics (to update user statistics upon board, pin, comment, and like operations)
-- DELIMITER $$

-- CREATE TRIGGER after_board_insert
-- AFTER INSERT ON Boards
-- FOR EACH ROW
-- BEGIN
--     UPDATE User_Statistics
--     SET total_boards = total_boards + 1
--     WHERE user_id = NEW.user_id;
-- END$$

-- CREATE TRIGGER after_pin_insert
-- AFTER INSERT ON Pins
-- FOR EACH ROW
-- BEGIN
--     UPDATE User_Statistics
--     SET total_pins = total_pins + 1
--     WHERE user_id = NEW.user_id;
-- END$$

-- CREATE TRIGGER after_like_insert
-- AFTER INSERT ON Likes
-- FOR EACH ROW
-- BEGIN
--     UPDATE User_Statistics
--     SET total_likes = total_likes + 1
--     WHERE user_id = NEW.user_id;
-- END$$

-- CREATE TRIGGER after_comment_insert
-- AFTER INSERT ON Comments
-- FOR EACH ROW
-- BEGIN
--     UPDATE User_Statistics
--     SET total_comments = total_comments + 1
--     WHERE user_id = NEW.user_id;
-- END$$

-- DELIMITER ;