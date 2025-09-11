-- Create USERS table (No profile edits, only password change allowed)
CREATE TABLE USERS (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    -- User won't be able to change username after account creation
    password_hash VARCHAR(255) NOT NULL,
    -- User can change password
    email VARCHAR(255) UNIQUE NOT NULL,
    role ENUM('admin', 'client') NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create ARTICLE_CATEGORIES table
CREATE TABLE ARTICLE_CATEGORIES (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    is_active TINYINT NOT NULL DEFAULT 1 COMMENT '1=active, 0=inactive',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create ARTICLES table
CREATE TABLE ARTICLES (
    article_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE,
    content TEXT NOT NULL,
    category_id INT,
    author VARCHAR(255) NOT NULL,
    cover_image_url VARCHAR(500),
    is_active TINYINT NOT NULL DEFAULT 1 COMMENT '1=active, 0=inactive',
    view_counter INT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES ARTICLE_CATEGORIES(category_id)
);

-- Create GALLERY table (for fetching images from existing articles and display them)
CREATE TABLE GALLERY (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    url VARCHAR(500) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create PRODUCT_CATEGORIES table
CREATE TABLE PRODUCT_CATEGORIES (
    pcategory_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create PRODUCTS table (no price field as products are only for recommendation, buy_url is provided to redirect users to the retailer's site)
CREATE TABLE PRODUCTS (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    pcategory_id INT,
    buy_url VARCHAR(500),
    image_url VARCHAR(500),
    is_active TINYINT NOT NULL DEFAULT 1 COMMENT '1=active, 0=inactive',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pcategory_id) REFERENCES PRODUCT_CATEGORIES(pcategory_id)
);

-- Create PRODUCT_COMMENTS table
CREATE TABLE PRODUCT_COMMENTS (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    user_id INT,
    comment TEXT NOT NULL,
    status ENUM('pending', 'approved') DEFAULT 'pending',
    -- Admin must approve comment before it is visible on the site
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (product_id, user_id),
    -- Prevent users from leaving multiple comments on the same product
    FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) -- User must be registered to leave a comment
);

-- Create ARTICLE_PRODUCTS table
CREATE TABLE ARTICLE_PRODUCTS (
    article_products_id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT,
    product_id INT,
    FOREIGN KEY (article_id) REFERENCES ARTICLES(article_id),
    FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id)
);

-- Create FEEDBACK table
CREATE TABLE FEEDBACK (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    -- Non-registered users can leave guest feedback and will be answered via email, so this must not be null
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Add useful indexes
CREATE INDEX idx_articles_category ON ARTICLES(category_id);
CREATE INDEX idx_articles_slug ON ARTICLES(slug);
CREATE INDEX idx_products_category ON PRODUCTS(pcategory_id);
CREATE INDEX idx_feedback_created ON FEEDBACK(created_at);

-- Insert admin user
INSERT INTO USERS (username, password_hash, email, role)
VALUES ('admin', 'admin', 'admin@gmail.com', 'admin');

-- Insert categories
INSERT INTO ARTICLE_CATEGORIES (category_id, name, description, is_active)
VALUES (1, 'Patients', 'For patients and caregivers.', 1),
    (2, 'Doctor', 'For dental professionals.', 1),
    (
        3,
        'Science & Research',
        'For researchers and academics.',
        1
    ),
    (4, 'Not Active', 'Not active category.', 0);

-- Insert sample data
INSERT INTO ARTICLES (title, slug, content, category_id, author, cover_image_url, is_active) VALUES 
(
    'How to Maintain Optimal Oral Health at Home',
    'how-to-maintain-optimal-oral-health-at-home',
    '<h1><span style="font-size: 30px;">Why It’s Essential</span></h1>
    <p>Good oral health is the foundation of a confident smile and overall wellness, yet many overlook simple home care practices. Consistent habits can prevent cavities, gum disease, and costly treatments, aligning with dental education’s focus on prevention. This article outlines practical steps for maintaining oral health at home and their broader impact.</p>
    <h2>Key Home Care Practices</h2>
    <p>Brushing twice daily with fluoride toothpaste for two minutes removes plaque and strengthens enamel. Electric toothbrushes clear 25% more plaque, per a 2023 <em>Consumer Dental Reports</em> study. Flossing or using interdental brushes daily targets hard-to-reach areas. Limiting sugary snacks and acidic drinks, like soda, protects enamel, while drinking water after meals neutralizes acids. Tongue scraping reduces bacteria causing bad breath, and antimicrobial mouthwashes, used as directed, enhance hygiene. A 2024 <em>Oral Health Journal</em> study found consistent home care cut cavity rates by 30%.</p>
    <h2>Benefits for Everyday Life</h2>
    <p>These practices prevent dental issues and support overall health, as poor oral hygiene is linked to heart disease and diabetes. Regular home care reduces the need for professional interventions, saving time and money. Educating patients on these habits empowers them to take control of their health, fostering confidence. For example, teaching children proper brushing techniques early can instill lifelong habits, reducing caries risk by 20%, per a 2025 <em>Pediatric Dentistry Review</em>.</p>
    <h2>Overcoming Barriers</h2>
    <p>Busy schedules and lack of knowledge can hinder effective home care. Dental education websites can bridge this gap with tutorials or videos on proper techniques. Cost is another barrier—electric toothbrushes and quality floss can be expensive—but budget-friendly alternatives exist. Patients with dexterity issues may benefit from water flossers. Engaging patients through interactive tools, like oral health apps, can boost adherence and awareness.</p>
    <h2>Looking Ahead</h2>
    <p>Maintaining oral health at home is a simple yet powerful way to enhance well-being. By adopting consistent habits and leveraging educational resources, patients can prevent dental issues and support systemic health. Dental education websites play a key role in empowering individuals with the knowledge to maintain healthy smiles for life.</p>',
    1,
    'Hieu Hoang',
    'oral-health-home.jpg',
    1
);

INSERT INTO ARTICLES (title, slug, content, category_id, author, cover_image_url, is_active) VALUES 
(
    'The Importance of Continuing Education for Dental Professionals',
    'the-importance-of-continuing-education-for-dental-professionals',
    '<h1><span style="font-size: 30px;">Introduction</span></h1>
    <p>Continuing education (CE) is a vital component of dental practice, ensuring professionals remain at the forefront of a rapidly evolving field. As new technologies and techniques emerge, CE empowers dentists to deliver high-quality, patient-centered care. This article explores the role of CE, its key benefits, practical applications, and challenges for dental professionals striving to maintain excellence.</p>
    <h2>Key Benefits of Continuing Education</h2>
    <p>CE keeps dentists updated on advancements like CAD/CAM systems, laser dentistry, and biocompatible materials such as zirconia, which enhance restorative and implant outcomes. For example, training in 3D-printed prosthetics improves precision in crown fabrication. Beyond technical skills, CE programs teach soft skills, such as managing patient anxiety through behavioral techniques, which boost trust and compliance. Most dental boards mandate 20–40 CE hours annually, but the true value lies in staying competitive. A 2024 <em>Journal of Dental Education</em> study found that dentists engaging in regular CE reported 25% higher patient satisfaction due to improved skills and communication.</p>
    <h2>Practical Applications in Practice</h2>
    <p>CE directly impacts clinical workflows. Courses on minimally invasive techniques, like resin infiltration for early caries, allow dentists to offer less invasive treatments. Training in digital tools, such as intraoral scanners, streamlines workflows and improves restoration accuracy. CE also fosters collaboration through conferences and webinars, where professionals share insights on complex cases. For instance, learning about antimicrobial stewardship helps address antibiotic-resistant infections, enhancing patient safety. Practices that prioritize CE can market themselves as cutting-edge, attracting patients seeking modern care.</p>
    <h2>Challenges and Opportunities</h2>
    <p>The primary challenge of CE is the time and cost involved. Workshops and certifications can cost thousands, and busy schedules make attendance difficult. Online CE platforms, like those offered by the Academy of General Dentistry, provide flexibility but require self-discipline. Keeping pace with rapid advancements, such as AI diagnostics, demands ongoing commitment. However, these challenges present opportunities: practices that invest in CE differentiate themselves, attracting tech-savvy patients. A 2025 <em>Dental Economics</em> survey noted that CE-focused practices saw a 20% increase in case acceptance for cosmetic procedures.</p>
    <h2>Conclusion</h2>
    <p>Continuing education is essential for dental professionals to deliver exceptional care and remain competitive. By embracing CE, dentists master new technologies, enhance patient communication, and contribute to the field’s advancement. Despite challenges, the benefits—improved outcomes, patient trust, and professional growth—make CE a cornerstone of modern dentistry.</p>',
    2,
    'Thinh Tran',
    'dental-professionals-education.jpg',
    1
);

INSERT INTO ARTICLES (title, slug, content, category_id, author, cover_image_url, is_active) VALUES 
(
    'Recent Advances in Dental Caries Research',
    'recent-advances-in-dental-caries-research',
    '<h1><span style="font-size: 30px;">Why It Matters</span></h1>
    <p>Dental caries, a global health challenge affecting billions, drives significant research to improve prevention and treatment. New discoveries in materials and microbiology are reshaping how we address tooth decay, offering hope for less invasive solutions. This article highlights cutting-edge caries research and its potential to transform dental care.</p>
    <h2>Breakthrough Findings</h2>
    <p>Bioactive glass, which releases calcium and phosphate ions, is proving more effective than fluoride for enamel remineralization. A 2024 <em>Journal of Dental Research</em> study showed it reduced demineralization by 35% in lab tests, promising non-invasive treatments for early lesions. Microbiome research is also key, identifying how bacteria like <em>Streptococcus mutans</em> fuel caries. A 2025 <em>Nature Microbiology</em> trial found that a probiotic lozenge reduced <em>S. mutans</em> levels by 25% in six weeks, suggesting a future of personalized prevention based on oral microbial profiles.</p>
    <h2>Real-World Impact</h2>
    <p>These findings could shift caries management from reactive to preventive. Bioactive glass may lead to new toothpastes or sealants, reducing the need for fillings. Probiotics could be integrated into daily oral care, like chewing gums, to balance harmful bacteria. Researchers are also exploring nanotechnology to deliver remineralizing agents precisely, potentially revolutionizing pediatric dentistry. These innovations align with dental education goals, empowering patients with knowledge about preventive options.</p>
    <h2>Hurdles and Future Prospects</h2>
    <p>Scaling these solutions for clinical use remains a challenge, particularly in cost and accessibility. Bioactive materials are expensive, and probiotic therapies require further trials. A 2024 <em>Global Oral Health</em> report noted that caries disproportionately affects low-income communities, underscoring the need for affordable innovations. Collaborative research and funding will be key to bringing these advancements to clinics, educating both professionals and patients.</p>
    <h2>Closing Thoughts</h2>
    <p>Caries research is paving the way for smarter, less invasive dental care. By leveraging new materials and microbiome insights, researchers are redefining prevention, aligning with the mission of dental education to inform and empower. Continued innovation promises a future with fewer cavities and healthier smiles.</p>',
    3,
    'Hieu Hoang',
    'dental_caries_research.jpg',
    1
);

