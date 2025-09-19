-- Create USERS table (No profile edits, only password change allowed)
CREATE TABLE USERS (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    -- User won't be able to change username after account creation
    password_hash VARCHAR(255) NOT NULL,
    -- User can change password
    email VARCHAR(255) UNIQUE NOT NULL,
    role ENUM('admin', 'client') NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
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
    slug VARCHAR(255) UNIQUE NOT NULL,
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
    description VARCHAR(255),
    is_active TINYINT NOT NULL DEFAULT 1 COMMENT '1=active, 0=inactive',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create PRODUCTS table (no price field as products are only for recommendation, buy_url is provided to redirect users to the retailer's site)
CREATE TABLE PRODUCTS (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NOT NULL,
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
    FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE -- User must be registered to leave a comment
);

-- Create PRODUCT_RATINGS table
CREATE TABLE PRODUCT_RATINGS (
    rating_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    user_id INT,
    rating TINYINT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_product_rating (user_id, product_id),
    FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE
);

-- Create FEEDBACK table
CREATE TABLE FEEDBACK (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    -- Non-registered users can leave guest feedback and will be answered via email, so this must not be null
    subject VARCHAR(255) NOT NULL,
    status ENUM('pending', 'replied') DEFAULT 'pending',
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create product mapping table
CREATE TABLE ARTICLE_PRODUCT_CATEGORY_MAPPING (
    mapping_id INT AUTO_INCREMENT PRIMARY KEY,
    article_category_id INT,
    product_category_id INT,
    relevance_score TINYINT DEFAULT 5 CHECK (relevance_score >= 1 AND relevance_score <= 10),
    FOREIGN KEY (article_category_id) REFERENCES ARTICLE_CATEGORIES(category_id),
    FOREIGN KEY (product_category_id) REFERENCES PRODUCT_CATEGORIES(pcategory_id),
    UNIQUE KEY unique_mapping (article_category_id, product_category_id)
);

-- Add useful indexes
CREATE INDEX idx_articles_category ON ARTICLES(category_id);
CREATE INDEX idx_articles_slug ON ARTICLES(slug);
CREATE INDEX idx_products_category ON PRODUCTS(pcategory_id);
CREATE INDEX idx_feedback_created ON FEEDBACK(created_at);
CREATE INDEX idx_product_ratings_product ON PRODUCT_RATINGS(product_id);

-- Insert admin user
INSERT INTO USERS (username, password_hash, email, role)
VALUES ('admin', 'admin', 'admin@gmail.com', 'admin');

INSERT INTO USERS (username, password_hash, email, role)
VALUES ('user', 'user', 'user@gmail.com', 'client'), 
    ('user1', 'user1', 'user1@gmail.com', 'client'),
    ('user2', 'user2', 'user2@gmail.com', 'client'),
    ('user3', 'user3', 'user3@gmail.com', 'client');

-- Insert categories
INSERT INTO ARTICLE_CATEGORIES (category_id, name, description, is_active)
VALUES (1, 'Daily Oral Care', 'Guides on routine habits, brushing techniques, and simple ways to maintain oral hygiene in everyday life.', 1),
(2, 'Common Dental Concerns', 'Solutions for frequent issues like pain, sensitivity, or bad breath, including when to seek help.', 1),
(3, 'Oral Health Across Ages', 'Advice tailored to different life stages, from childrens dental care to senior wellness, including diet and habits.', 1),
(4, 'Dental Science and Research', 'Insights into recent studies, innovations, and evidence-based dental practices for better understanding.', 1),
(5, 'Not Active', 'Not active category.', 0);

-- Insert sample data for articles
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
),
(
    'Effective Brushing and Flossing Techniques',
    'effective-brushing-and-flossing-techniques',
    '<h1><span style="font-size: 30px;">Introduction</span></h1>
    <p>Mastering proper brushing and flossing is key to preventing plaque buildup and maintaining a healthy mouth. Many people brush incorrectly, missing areas that lead to issues like cavities. This guide covers effective techniques and their importance in daily routines.</p>
    <h2>Key Techniques</h2>
    <p>Use a soft-bristled brush with fluoride toothpaste. Hold at a 45-degree angle to gums and brush in short circular motions for two minutes, covering all surfaces. A 2024 <em>Oral Health Journal</em> study showed this removes 40% more plaque than back-and-forth brushing. For flossing, wrap 18 inches around fingers, slide gently between teeth, and curve into a C-shape to clean under the gumline. Water flossers are great for braces, per a 2025 <em>Dental Care Review</em>.</p>
    <h2>Benefits in Daily Life</h2>
    <p>These methods reduce decay risk by 25% and improve gum health, linking to better overall wellness like lower diabetes risk. Consistent use saves on dental visits. Educating families builds habits early, cutting pediatric caries by 15%, as in a 2025 <em>Pediatric Dentistry Review</em>.</p>
    <h2>Overcoming Common Mistakes</h2>
    <p>Hard brushing wears enamel; opt for gentle pressure. Skipping floss misses 35% of surfaces. Apps remind and guide techniques. Affordable tools make it accessible.</p>
    <h2>Conclusion</h2>
    <p>Adopting these techniques enhances oral health effortlessly. Use resources for guidance and enjoy a healthier smile.</p>',
    1,
    'Thinh Tran',
    'brushing-flossing.jpg',
    1
),
(
    'Managing Dental Anxiety: Tips for Patients',
    'managing-dental-anxiety-tips-for-patients',
    '<h1><span style="font-size: 30px;">Understanding the Issue</span></h1>
    <p>Dental anxiety affects up to 20% of patients, often leading to delayed treatments and worsening oral health, according to a 2024 <em>Journal of Dental Anxiety</em> study. Fear of pain, needles, or past negative experiences can deter visits, but manageable strategies can ease these concerns. This article provides practical tips to help patients overcome dental anxiety and maintain regular care.</p>
    <h2>Effective Strategies</h2>
    <p>Communication is key—discussing fears with your dentist allows tailored solutions, like shorter appointments or signal systems for breaks. Relaxation techniques, such as deep breathing or guided imagery, reduce stress; a 2025 <em>Oral Health Journal</em> study found that 10 minutes of pre-visit meditation lowered anxiety by 30%. Listening to music or podcasts during procedures can distract from discomfort. For severe cases, sedation options like nitrous oxide are safe and effective, used in 15% of anxious patients per a 2024 <em>Dental Care Review</em>. Scheduling visits during less busy times, like early mornings, can also create a calmer environment.</p>
    <h2>Benefits of Overcoming Anxiety</h2>
    <p>Addressing anxiety improves oral health outcomes by encouraging regular check-ups, reducing the risk of advanced decay or gum disease. It also enhances mental well-being, as patients gain confidence in managing fears. Dental education platforms can offer virtual tours of clinics or videos explaining procedures, demystifying the experience and building trust.</p>
    <h2>Challenges and Solutions</h2>
    <p>Access to sedation or specialized care can be costly, and not all patients know where to seek help. Dental websites can provide resources, such as anxiety management guides or lists of sedation-certified dentists. Support groups or online forums also allow patients to share experiences, reducing feelings of isolation. Practices offering patient-centered care, like pre-visit consultations, can further ease fears.</p>
    <h2>Final Thoughts</h2>
    <p>Overcoming dental anxiety is achievable with the right tools and support. By using relaxation techniques, open communication, and educational resources, patients can approach dental visits with confidence, ensuring better oral and overall health.</p>',
    2,
    'Thinh Tran',
    'dental-anxiety-tips.jpg',
    1
),
(
    'Addressing Tooth Sensitivity and Discomfort',
    'addressing-tooth-sensitivity-and-discomfort',
    '<h1><span style="font-size: 30px;">Why It Matters</span></h1>
    <p>Tooth sensitivity affects millions, causing pain from hot, cold, or sweet foods, often due to enamel erosion or gum recession. A 2024 <em>Dental Care Journal</em> report notes it impacts 40% of adults. This article explores causes and solutions for managing discomfort.</p>
    <h2>Common Causes and Solutions</h2>
    <p>Enamel wear from acidic drinks or hard brushing exposes dentin, triggering pain. Using sensitivity toothpaste with potassium nitrate blocks nerve signals, reducing sensitivity by 35% in two weeks, per a 2025 study. Gentle brushing with soft bristles prevents further erosion. Gum recession from over-brushing or disease exposes roots; fluoride rinses strengthen them. A 2024 <em>Oral Health Journal</em> found regular rinses cut sensitivity by 25%.</p>
    <h2>Benefits of Management</h2>
    <p>Reducing sensitivity improves quality of life, allowing enjoyment of foods without pain. It prevents avoidance of hygiene routines, lowering decay risk. Early intervention avoids costly treatments like fillings.</p>
    <h2>Challenges and Tips</h2>
    <p>Identifying triggers can be tricky; track diet and habits. Cost of specialized products is a barrier, but affordable options exist. Consult dentists for persistent issues.</p>
    <h2>Conclusion</h2>
    <p>Managing sensitivity enhances comfort and health. With proper techniques and products, enjoy a pain-free smile.</p>',
    2,
    'Hieu Hoang',
    'tooth-sensitivity.jpg',
    1
),
(
    'The Role of Diet in Preventing Gum Disease',
    'the-role-of-diet-in-preventing-gum-disease',
    '<h1><span style="font-size: 30px;">Why Diet Matters</span></h1>
    <p>Gum disease, affecting 40% of adults per a 2024 <em>Global Oral Health</em> report, is influenced by diet. Poor nutrition can exacerbate inflammation, while balanced diets support gum health. This article explores dietary choices that prevent gum disease and their practical application.</p>
    <h2>Key Dietary Choices</h2>
    <p>Foods rich in vitamin C, like citrus fruits and bell peppers, strengthen gums, reducing bleeding by 30%, per a 2025 <em>Journal of Periodontology</em> study. Omega-3 fatty acids in fish or flaxseeds combat inflammation, lowering gingivitis risk. Crunchy vegetables, like carrots, stimulate saliva, which neutralizes acids. Avoiding sugary snacks and sodas prevents plaque buildup. Green tea, with its antioxidants, reduced periodontal pocket depth in a 2024 <em>Oral Health Journal</em> trial.</p>
    <h2>Practical Tips</h2>
    <p>Incorporating these foods is simple—swap sugary snacks for apples or add salmon to weekly meals. Drinking water instead of soda aids saliva production. Dental education websites can offer recipes or meal plans to promote gum-friendly diets, making adherence easier for patients.</p>
    <h2>Challenges and Solutions</h2>
    <p>Busy lifestyles and food costs can limit healthy choices. Fast food, high in sugar, worsens gum health. Dental platforms can provide budget-friendly grocery lists or tips for quick, nutritious meals. Educating patients on reading food labels for hidden sugars also helps.</p>
    <h2>Conclusion</h2>
    <p>A gum-friendly diet is a powerful tool for preventing periodontal disease. By making informed food choices and using educational resources, patients can protect their gums and enhance overall health.</p>',
    3,
    'Thinh Tran',
    'gum-disease-diet.jpg',
    1
),
(
    'Dental Care for Children and Seniors',
    'dental-care-for-children-and-seniors',
    '<h1><span style="font-size: 30px;">Introduction</span></h1>
    <p>Oral health needs evolve with age, from teething toddlers to seniors with dry mouth. Tailored care prevents issues like early caries or gum recession. This article covers age-specific advice for lifelong healthy smiles.</p>
    <h2>Key Strategies by Age</h2>
    <p>For children, start brushing at first tooth with fluoride paste; supervise until age 6. A 2025 <em>Pediatric Dentistry Review</em> shows this cuts caries by 25%. Teach flossing at age 2. For seniors, dry mouth from medications increases decay risk; fluoride rinses help, per a 2024 <em>Oral Health Journal</em>. Soft brushes prevent gum injury, and regular check-ups catch issues early.</p>
    <h2>Benefits Across Life</h2>
    <p>Proper care builds habits in kids, reducing adult problems. For seniors, it maintains nutrition and confidence. Overall, it links to better health, like lower heart disease risk.</p>
    <h2>Challenges and Solutions</h2>
    <p>Kids resist routines; make it fun with timers. Seniors may have dexterity issues; electric tools aid. Education empowers caregivers.</p>
    <h2>Conclusion</h2>
    <p>Age-appropriate care ensures lasting oral health. Use resources for guidance and enjoy benefits at every stage.</p>',
    3,
    'Hieu Hoang',
    'age-specific-care.jpg',
    1
),
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
    4,
    'Hieu Hoang',
    'dental_caries_research.jpg',
    1
),
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
    4,
    'Thinh Tran',
    'dental-professionals-education.jpg',
    1
),
(
    'Choosing the Right Toothpaste for Your Needs',
    'choosing-the-right-toothpaste-for-your-needs',
    '<h1><span style="font-size: 30px;">Why It Matters</span></h1>
    <p>Selecting the right toothpaste can significantly impact oral health, yet many patients are overwhelmed by options. From whitening to sensitivity relief, toothpastes serve specific needs. This article guides patients on choosing the best toothpaste and highlights its role in daily care.</p>
    <h2>Types of Toothpastes</h2>
    <p>Fluoride toothpastes, recommended by 95% of dentists per a 2024 <em>Oral Health Survey</em>, strengthen enamel and prevent cavities. Whitening toothpastes with mild abrasives remove stains but should be used sparingly to avoid enamel wear. For sensitive teeth, potassium nitrate-based options reduce discomfort, with a 2025 <em>Dental Care Journal</em> study showing 35% pain reduction after two weeks. Anti-gingivitis toothpastes with stannous fluoride target gum inflammation, cutting bleeding by 20% in trials. Natural toothpastes, free of artificial flavors, suit eco-conscious patients but may lack fluoride.</p>
    <h2>How to Choose</h2>
    <p>Patients should prioritize fluoride for cavity prevention, especially children, as it reduces caries risk by 25%, per a 2024 <em>Pediatric Dentistry Review</em>. Those with sensitivity or gum issues should consult dentists for tailored options. Reading labels for ADA approval ensures efficacy. Dental education websites can offer comparison charts or quizzes to match toothpastes to needs, enhancing patient decision-making.</p>
    <h2>Common Pitfalls</h2>
    <p>Overusing whitening toothpastes or choosing non-fluoride options can harm enamel. Misleading marketing, like "all-natural" claims, may confuse patients. Cost can also deter—premium toothpastes cost $5–10—but budget-friendly ADA-approved options exist. Education on label reading and dentist consultations can address these issues.</p>
    <h2>Final Thoughts</h2>
    <p>Choosing the right toothpaste is a simple yet critical step for oral health. By understanding their needs and leveraging dental education resources, patients can make informed choices, ensuring effective daily care and healthier smiles.</p>',
    5,
    'Hieu Hoang',
    'toothpaste-selection.jpg',
    0
);

-- Insert sample product categories
INSERT INTO PRODUCT_CATEGORIES (name, description, is_active)
VALUES 
    ('Toothbrushes', 'Manual and electric toothbrushes for effective plaque removal.', 1),
    ('Toothpastes', 'Specialized toothpastes for various oral health needs.', 1),
    ('Interdental Care', 'Products for cleaning between teeth and hard-to-reach areas.', 1),
    ('Oral Rinses', 'Mouthwashes and rinses for fresh breath and oral hygiene.', 1),
    ('Specialty Products', 'Specialized oral care tools and accessories.', 1);

-- Insert sample products
INSERT INTO PRODUCTS (name, slug, description, pcategory_id, buy_url, image_url, is_active)
VALUES 
    -- TOOTHBRUSHES (3 manual, 3 electric)
    ('Oral-B Pro-Health Manual', 'oral-b-pro-health-manual', 'Soft-bristled manual toothbrush with angled bristles for effective plaque removal.', 1, 'https://www.amazon.com/Oral-B-Pro-Health-Clinical-Pro-Flex-Toothbrush/dp/B00763LZWQ', 'oral-b-manual.jpg', 1),
    ('Colgate 360° Manual Toothbrush', 'colgate-360-manual', 'Manual toothbrush with whole mouth cleaning including tongue and cheek cleaner.', 1, 'https://www.amazon.com/Colgate-Adult-Toothbrush-Medium-Count/dp/B00H88K9EE', 'colgate-360.jpg', 1),
    ('GUM Technique Pro Compact', 'gum-technique-pro', 'Compact head manual toothbrush with tapered bristles for precision cleaning.', 1, 'https://www.amazon.com/GUM-Technique-Toothbrush/dp/B0D54WNXHL', 'gum-technique.jpg', 1),
    ('Oral-B iO Series 9', 'oral-b-io-series-9', 'Premium electric toothbrush with AI-powered brushing tracking and multiple cleaning modes.', 1, 'https://www.amazon.com/Oral-B-iO-Electric-Toothbrush-Brush-Alabaster/dp/B0B5HSNPNH', 'oral-b-io9.jpg', 1),
    ('Philips Sonicare DiamondClean', 'philips-sonicare-diamondclean', 'High-performance sonic electric toothbrush for superior plaque removal and gum health.', 1, 'https://www.amazon.com/Philips-Sonicare-DiamondClean-Rechargeable-toothbrush/dp/B06XT19TYD', 'sonicare-diamondclean.jpg', 1),
    ('Oral-B Vitality Pro', 'oral-b-vitality-pro', 'Budget-friendly electric toothbrush with oscillating technology for daily cleaning.', 1, 'https://www.amazon.com/Oral-B-Vitality-Electric-Toothbrush-Rechargeable/dp/B0B1RJ8FDJ', 'vitality-pro.jpg', 1),

    -- TOOTHPASTES (3 regular, 2 sensitivity, 2 whitening)
    ('Colgate Total Original', 'colgate-total-original', 'Regular fluoride toothpaste for comprehensive oral health protection and cavity prevention.', 2, 'https://www.amazon.com/Colgate-Total-Toothpaste-Clean-ounce/dp/B07L5PDS11', 'colgate-total.jpg', 1),
    ('Crest Cavity Protection', 'crest-cavity-protection', 'Basic fluoride toothpaste providing essential cavity protection for daily use.', 2, 'https://www.amazon.com/Crest-Cavity-Protection-Toothpaste-Regular/dp/B07GZ7HQ2C', 'crest-cavity.jpg', 1),
    ('Oral-B Pro-Expert Deep Clean', 'oral-b-pro-expert', 'Regular toothpaste with deep cleaning formula for thorough plaque removal.', 2, 'https://www.amazon.com/Oral-B-Pro-Expert-All-Around-Protection-Toothpaste/dp/B00569I0NE', 'oral-b-expert.jpg', 1),
    ('Sensodyne Pronamel Gentle', 'sensodyne-pronamel', 'Fluoride toothpaste designed to protect enamel and relieve tooth sensitivity.', 2, 'https://www.amazon.com/Sensodyne-Pronamel-Gentle-Whitening-Toothpaste/dp/B00BIPJJBM', 'sensodyne-pronamel.jpg', 1),
    ('Colgate Sensitive Complete', 'colgate-sensitive-complete', 'Sensitivity relief toothpaste with fluoride for complete oral care protection.', 2, 'https://www.amazon.com/Colgate-Sensitive-Toothpaste-Complete-Protection/dp/B01LTHYWAQ', 'colgate-sensitive.jpg', 1),
    ('Crest 3D White Brilliance', 'crest-3d-white-brilliance', 'Advanced whitening toothpaste with fluoride for stain removal and enamel protection.', 2, 'https://www.amazon.com/Crest-Brilliance-Vibrant-Peppermint-Toothpaste/dp/B07CHP3FPQ', 'crest-3d-white.jpg', 1),
    ('Colgate Optic White Advanced', 'colgate-optic-white', 'Professional-level whitening toothpaste with hydrogen peroxide for visible results.', 2, 'https://www.amazon.com/Colgate-Advanced-Whitening-Toothpaste-Sparkling/dp/B082F1QH7S', 'colgate-optic-white.jpg', 1),

    -- INTERDENTAL CARE (2 regular floss, 2 water floss, 2 floss picks)
    ('Oral-B Glide Pro-Health', 'oral-b-glide-floss', 'Smooth, shred-resistant dental floss for comfortable cleaning between tight teeth.', 3, 'https://www.amazon.com/Oral-B-Glide-Pro-Health-Comfort-Dental/dp/B07FLBBWJR', 'glide-floss.jpg', 1),
    ('Johnson & Johnson Reach Floss', 'reach-dental-floss', 'Waxed dental floss with mint flavor for effective interdental plaque removal.', 3, 'https://www.amazon.com/Johnson-Reach-Waxed-Dental-Floss/dp/B00U2H1H8A', 'reach-floss.jpg', 1),
    ('Waterpik Cordless Advanced', 'waterpik-cordless-advanced', 'Portable water flosser for interdental cleaning, ideal for braces and sensitive gums.', 3, 'https://www.amazon.com/Waterpik-Cordless-Rechargeable-Portable-Irrigator/dp/B01GNVF8S8', 'waterpik-cordless.jpg', 1),
    ('Philips Sonicare AirFloss Ultra', 'philips-airfloss-ultra', 'Air-powered water flosser using micro-droplet technology for quick interdental cleaning.', 3, 'https://www.amazon.com/Philips-Sonicare-AirFloss-Interdental-Cleaning/dp/B00J5Z8O5A', 'airfloss-ultra.jpg', 1),
    ('GUM Soft-Picks Advanced', 'gum-soft-picks', 'Flexible interdental picks for gentle cleaning, suitable for sensitive gums.', 3, 'https://www.amazon.com/GUM-Soft-Picks-Advanced-Dental-Picks/dp/B08BSMDDS2', 'gum-picks.jpg', 1),
    ('Oral-B Complete Glide Picks', 'oral-b-glide-picks', 'Pre-threaded floss picks with shred-resistant floss for convenient on-the-go cleaning.', 3, 'https://www.amazon.com/Oral-B-Glide-Complete-Outlast-Dental/dp/B00UB7BO16', 'glide-picks.jpg', 1),

    -- ORAL RINSES (3 antibacterial, 2 fluoride, 2 breath freshening)
    ('Listerine Total Care Antibacterial', 'listerine-total-care', 'Antimicrobial mouthwash that kills 99% of germs and strengthens enamel.', 4, 'https://www.amazon.com/Listerine-Anticavity-Mouthwash-Fluoride-Packaging/dp/B00495Q5OW', 'listerine-total.jpg', 1),
    ('Colgate Total Advanced Pro-Shield', 'colgate-total-proshield', 'Antibacterial mouthwash with fluoride for 12-hour germ protection.', 4, 'https://www.amazon.com/Colgate-Total-Pro-Shield-Mouthwash-Peppermint/dp/B00EZWSBQ4', 'colgate-proshield.jpg', 1),
    ('Crest Pro-Health Multi-Protection', 'crest-pro-health-rinse', 'Alcohol-free antibacterial rinse for cavity prevention and gum health support.', 4, 'https://www.amazon.com/Crest-Pro-Health-Multi-Protection-Mouthwash-Gingivitis/dp/B003CP12O8', 'crest-rinse.jpg', 1),
    ('ACT Anticavity Fluoride Rinse', 'act-anticavity-rinse', 'Fluoride-based mouthwash designed to strengthen teeth and prevent cavities.', 4, 'https://www.amazon.com/ACT-Alcohol-Anticavity-Fluoride-Rinse/dp/B0012DX2VS', 'act-rinse.jpg', 1),
    ('Oral-B Pro-Expert Fluoride Rinse', 'oral-b-pro-expert-rinse', 'Professional fluoride mouthwash for enhanced cavity protection and enamel strengthening.', 4, 'https://www.amazon.com/Oral-B-Pro-Health-Clinical-Clean-Rinse/dp/B06ZYHNQ2D', 'oral-b-fluoride.jpg', 1),
    ('TheraBreath Fresh Breath Rinse', 'therabreath-rinse', 'Clinically proven mouthwash to combat bad breath with oxygenating formula.', 4, 'https://www.amazon.com/TheraBreath-Fresh-Breath-Rinse-Bottle/dp/B00IRKRK9O', 'therabreath-rinse.jpg', 1),
    ('Scope Outlast Fresh Mint', 'scope-outlast-mint', 'Long-lasting breath freshening mouthwash with up to 5x longer fresh feeling.', 4, 'https://www.amazon.com/Crest-Scope-Outlast-Mouthwash-33-8/dp/B019FGCP5C', 'scope-outlast.jpg', 1),

    -- SPECIALTY PRODUCTS (1 night guard, 1 tongue scraper)
    ('DenTek Comfort-Fit Night Guard', 'dentek-night-guard', 'Custom-fitting dental night guard for teeth grinding and TMJ relief.', 5, 'https://www.amazon.com/DenTek-Comfort-Fit-Protection-Nightime-Grinding/dp/B002WTCK4Q', 'dentek-guard.jpg', 1),
    ('Dr. Tungs Tongue Cleaner', 'dr-tungs-tongue-cleaner', 'Stainless steel tongue scraper for removing bacteria and freshening breath.', 5, 'https://www.amazon.com/DR-TUNGS-Tongue-Cleaner-Count/dp/B000ZM7MMW', 'tongue-scraper.jpg', 1);

-- Insert product categories mapping to article categories with relevance weight
INSERT INTO ARTICLE_PRODUCT_CATEGORY_MAPPING (article_category_id, product_category_id, relevance_score) VALUES
(1, 1, 10), -- Daily Oral Care -> Toothbrushes (perfect match)
(1, 2, 10), -- Daily Oral Care -> Toothpastes (perfect match)
(1, 3, 8),  -- Daily Oral Care -> Interdental Care (very relevant)
(1, 4, 6),  -- Daily Oral Care -> Oral Rinses (moderately relevant)

(2, 2, 9),  -- Common Dental Concerns -> Toothpastes (highly relevant)
(2, 4, 7),  -- Common Dental Concerns -> Oral Rinses (good relevance)
(2, 5, 5),  -- Common Dental Concerns -> Specialty Products (moderate)

(3, 1, 8),  -- Oral Health Across Ages -> Toothbrushes (very relevant)
(3, 2, 9),  -- Oral Health Across Ages -> Toothpastes (highly relevant)
(3, 3, 6),  -- Oral Health Across Ages -> Interdental Care (moderate)

(4, 1, 6),  -- Dental Science -> Toothbrushes (moderate)
(4, 2, 7),  -- Dental Science -> Toothpastes (good)
(4, 5, 4);  -- Dental Science -> Specialty Products (low but relevant)