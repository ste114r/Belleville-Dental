-- Create USERS table
CREATE TABLE USERS (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    role ENUM('admin', 'client') NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO USERS (username, password_hash, email, role) VALUES ('admin', 'admin123', 'admin@gmail.com', 'admin');

-- Create ARTICLE_CATEGORIES table
CREATE TABLE ARTICLE_CATEGORIES (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    is_active TINYINT NOT NULL DEFAULT 1 COMMENT '1=active, 0=inactive',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO ARTICLE_CATEGORIES (category_id, name, description, is_active) VALUES
(1, 'Patients', 'For patients and caregivers.', 1),
(2, 'Doctor', 'For dental professionals.', 1),
(3, 'Science & Research', 'For researchers and academics.', 1),
(4, 'Kids', 'For children.', 0);


-- Create ARTICLES table
CREATE TABLE ARTICLES (
    article_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE,
    content TEXT NOT NULL,
    category_id INT,
    cover_image_url VARCHAR(500),
    author VARCHAR(255),
    view_counter INT DEFAULT NULL,
    is_active TINYINT NOT NULL DEFAULT 1 COMMENT '1=active, 0=inactive',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO ARTICLES (title, slug, content, category_id, author) VALUES ('AI in Life', 'ai-life', 'AI is changing everything.', 1, 'Hieu Hoang');
INSERT INTO ARTICLES (title, slug, content, category_id, author) VALUES ('Vietnam Beaches', 'vn-beaches', 'Hidden gems in Vietnam.', 2, 'Thinh Tran');
INSERT INTO ARTICLES (title, slug, content, category_id, author) VALUES ('Minimalism 101', 'minimalism-101', 'Live with less, enjoy more.', 3, 'Hieu Hoang');

-- Create GALLERY table
CREATE TABLE GALLERY (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    url VARCHAR(500) NOT NULL UNIQUE,
    uploaded_by INT NOT NULL,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    file_size INT,
    file_type VARCHAR(100)
);

-- Create ARTICLE_IMAGES table
CREATE TABLE ARTICLE_IMAGES (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    image_id INT NOT NULL,
    caption TEXT,
    display_order INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create PRODUCT_CATEGORIES table
CREATE TABLE PRODUCT_CATEGORIES (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Create PRODUCTS table
CREATE TABLE PRODUCTS (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category_id INT,
    buy_url VARCHAR(500),
    image_url VARCHAR(500),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create PRODUCT_COMMENTS table
CREATE TABLE PRODUCT_COMMENTS (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create ARTICLE_PRODUCTS table
CREATE TABLE ARTICLE_PRODUCTS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    product_id INT NOT NULL
);

-- Create FEEDBACK table
CREATE TABLE FEEDBACK (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    reply TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    replied_at DATETIME
);

-- Add useful indexes
CREATE INDEX idx_articles_category ON ARTICLES(category_id);
CREATE INDEX idx_articles_slug ON ARTICLES(slug);
CREATE INDEX idx_products_category ON PRODUCTS(category_id);
CREATE INDEX idx_feedback_created ON FEEDBACK(created_at);

-- -- Insert sample categories
-- INSERT INTO ARTICLE_CATEGORIES (name) VALUES 
-- ('Technology'), 
-- ('Health'), 
-- ('Education'), 
-- ('Research Methods');

-- INSERT INTO PRODUCT_CATEGORIES (name) VALUES 
-- ('Software'), 
-- ('Hardware'), 
-- ('Books'), 
-- ('Online Courses');