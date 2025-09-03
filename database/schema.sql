-- GoLocal Database Schema
CREATE DATABASE IF NOT EXISTS golocal_db;
USE golocal_db;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    country VARCHAR(50),
    phone VARCHAR(20),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sessions table (for better session management)
CREATE TABLE user_sessions (
    id VARCHAR(128) PRIMARY KEY,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, email, password, full_name, role) VALUES 
('admin', 'admin@golocal.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'GoLocal Admin', 'admin');

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    short_description VARCHAR(300),
    city VARCHAR(100) NOT NULL,
    venue VARCHAR(200),
    event_date DATE NOT NULL,
    event_time TIME,
    end_date DATE,
    category ENUM('cultural', 'religious', 'sports', 'music', 'food', 'business', 'education', 'other') DEFAULT 'other',
    price DECIMAL(10,2) DEFAULT 0.00,
    image_url VARCHAR(500),
    organizer VARCHAR(200),
    contact_phone VARCHAR(20),
    contact_email VARCHAR(100),
    website_url VARCHAR(500),
    status ENUM('active', 'cancelled', 'completed') DEFAULT 'active',
    featured BOOLEAN DEFAULT FALSE,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_city (city),
    INDEX idx_date (event_date),
    INDEX idx_category (category),
    INDEX idx_status (status)
);

-- Insert sample events data
INSERT INTO events (title, description, short_description, city, venue, event_date, event_time, category, price, organizer, contact_phone, featured) VALUES 
('Pohela Boishakh Celebration', 'Traditional Bengali New Year celebration with cultural performances, traditional food, and festivities.', 'Celebrate Bengali New Year with music, dance, and traditional festivities', 'Dhaka', 'Ramna Park', '2025-04-14', '09:00:00', 'cultural', 0.00, 'Dhaka City Corporation', '+880-2-9556000', TRUE),

('Cox\'s Bazar Beach Festival', 'Annual beach festival featuring water sports, beach volleyball, live music, and local seafood.', 'Enjoy water sports, music, and seafood at the world\'s longest beach', 'Cox\'s Bazar', 'Cox\'s Bazar Beach', '2025-03-15', '10:00:00', 'sports', 500.00, 'Tourism Board', '+880-341-62121', TRUE),

('Shilpakala Academy Art Exhibition', 'Contemporary Bangladeshi art exhibition showcasing works by local and national artists.', 'Explore contemporary Bangladeshi art and cultural heritage', 'Dhaka', 'Bangladesh Shilpakala Academy', '2025-02-20', '10:00:00', 'cultural', 100.00, 'Shilpakala Academy', '+880-2-8619641', FALSE),

('Chittagong Food Festival', 'Traditional Chittagong cuisine festival featuring local delicacies, cooking competitions, and food stalls.', 'Taste authentic Chittagong cuisine and local specialties', 'Chittagong', 'Foy\'s Lake', '2025-03-01', '17:00:00', 'food', 200.00, 'Chittagong Restaurant Association', '+880-31-652847', TRUE),

('Sylhet Tea Festival', 'Explore the tea culture of Sylhet with tea tasting, plantation tours, and cultural shows.', 'Experience Sylhet\'s famous tea culture and scenic beauty', 'Sylhet', 'Srimangal Tea Gardens', '2025-04-01', '08:00:00', 'cultural', 800.00, 'Tea Board Bangladesh', '+880-821-61625', FALSE),

('Rajshahi Silk Fair', 'Annual silk and handicrafts fair featuring traditional Bangladeshi textiles and crafts.', 'Discover traditional silk products and local handicrafts', 'Rajshahi', 'Rajshahi College Ground', '2025-02-25', '09:00:00', 'business', 50.00, 'Rajshahi Chamber of Commerce', '+880-721-772860', FALSE),

('Rangpur Strawberry Festival', 'Celebration of Rangpur\'s famous strawberries with fruit picking, local music, and food stalls.', 'Enjoy fresh strawberries and local culture in northern Bangladesh', 'Rangpur', 'Rangpur Cantonment', '2025-01-30', '11:00:00', 'food', 150.00, 'Rangpur Agricultural Office', '+880-521-63347', TRUE),

('Barisal River Cruise Festival', 'Traditional boat races, river cruises, and cultural performances celebrating river heritage.', 'Experience traditional boat culture and river festivities', 'Barisal', 'Kirtankhola River', '2025-03-20', '14:00:00', 'cultural', 300.00, 'Barisal Tourism Committee', '+880-431-65322', FALSE);

-- Categories reference table (for future use)
CREATE TABLE event_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(100),
    color VARCHAR(7) DEFAULT '#00a86b',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert event categories
INSERT INTO event_categories (name, description, icon, color) VALUES 
('Cultural', 'Traditional festivals, art exhibitions, and cultural celebrations', 'fas fa-theater-masks', '#00a86b'),
('Religious', 'Religious festivals and spiritual gatherings', 'fas fa-praying-hands', '#6f42c1'),
('Sports', 'Sports events, tournaments, and recreational activities', 'fas fa-running', '#fd7e14'),
('Music', 'Concerts, music festivals, and musical performances', 'fas fa-music', '#e83e8c'),
('Food', 'Food festivals, culinary events, and cooking competitions', 'fas fa-utensils', '#20c997'),
('Business', 'Trade fairs, business conferences, and networking events', 'fas fa-briefcase', '#6c757d'),
('Education', 'Workshops, seminars, and educational programs', 'fas fa-graduation-cap', '#0dcaf0'),
('Other', 'Miscellaneous events and activities', 'fas fa-calendar-alt', '#adb5bd');