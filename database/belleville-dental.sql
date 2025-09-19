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

-- Create ARTICLE_PRODUCTS table
CREATE TABLE ARTICLE_PRODUCTS (
    article_products_id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT,
    product_id INT,
    FOREIGN KEY (article_id) REFERENCES ARTICLES(article_id),
    FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id)
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
VALUES (1, 'Patients', 'For patients and caregivers.', 1),
    (2, 'Doctor', 'For dental professionals.', 1),
    (
        3,
        'Research & Science',
        'For researchers and academics.',
        1
    ),
    (4, 'Not Active', 'Not active category.', 0);

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
    1,
    'Thinh Tran',
    'dental-anxiety-tips.jpg',
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
    2,
    'Thinh Tran',
    'dental-professionals-education.jpg',
    1
),
(
    'Leveraging Digital Dentistry for Improved Patient Outcomes',
    'leveraging-digital-dentistry-for-improved-patient-outcomes',
    '<h1><span style="font-size: 30px;">The Digital Revolution</span></h1>
    <p>Digital dentistry is transforming practices with tools like intraoral scanners, 3D printing, and AI diagnostics, enhancing precision and patient experience. These technologies streamline workflows and improve outcomes, aligning with the goals of modern dental education. This article explores how digital dentistry benefits professionals and patients alike.</p>
    <h2>Key Digital Tools</h2>
    <p>Intraoral scanners replace traditional impressions, offering faster, more accurate molds with 98% precision, per a 2024 <em>Journal of Prosthodontics</em> study. 3D printing enables same-day crowns, reducing patient visits by 30%. AI-driven diagnostics, like those detecting caries from radiographs, improve early detection by 25%, according to a 2025 <em>Dental Technology Review</em>. Teledentistry platforms also expand access, allowing consultations for rural patients, with 15% higher appointment adherence reported in a 2024 <em>Oral Health Journal</em>.</p>
    <h2>Impact on Practice</h2>
    <p>Digital tools save time and enhance patient trust through transparency—scans can be shown instantly to explain treatment needs. They also reduce errors; CAD/CAM restorations have a 20% lower remake rate than traditional methods. For professionals, mastering these tools via CE courses boosts efficiency and marketability. Patients benefit from faster treatments and less discomfort, increasing satisfaction and loyalty.</p>
    <h2>Challenges to Adoption</h2>
    <p>High costs—scanners and 3D printers can exceed $20,000—pose barriers, especially for smaller practices. Training staff to use new systems also takes time. However, leasing options and online training modules are making adoption easier. Dental education websites can offer tutorials or case studies to guide professionals, ensuring smoother transitions to digital workflows.</p>
    <h2>Looking Forward</h2>
    <p>Digital dentistry is redefining care delivery, offering precision, efficiency, and accessibility. By integrating these tools, professionals can elevate patient outcomes and stay competitive. Dental education platforms play a vital role in spreading knowledge, ensuring practitioners can harness digital advancements effectively.</p>',
    2,
    'Hieu Hoang',
    'digital-dentistry.jpg',
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
    3,
    'Hieu Hoang',
    'dental_caries_research.jpg',
    1
),
(
    'Nanotechnology in Restorative Dentistry',
    'nanotechnology-in-restorative-dentistry',
    '<h1><span style="font-size: 30px;">A New Frontier</span></h1>
    <p>Nanotechnology is revolutionizing restorative dentistry by enabling precise material delivery and enhanced durability of restorations. These advancements promise stronger, longer-lasting dental solutions. This article examines nanotechnology’s role, its applications, and its future in restorative care.</p>
    <h2>Key Innovations</h2>
    <p>Nanoparticles in composite resins improve strength and aesthetics, reducing wear by 30%, per a 2024 <em>Journal of Dental Materials</em> study. Nano-filled sealants penetrate enamel micro-cracks better, offering 40% better caries prevention than traditional sealants. Nanoceramics, used in crowns and veneers, mimic natural tooth translucency, improving cosmetic outcomes. A 2025 <em>Biomaterials Research</em> trial showed nano-enhanced adhesives increased bond strength by 25%, extending restoration lifespan.</p>
    <h2>Clinical Applications</h2>
    <p>Nanotechnology enables minimally invasive restorations, preserving more natural tooth structure. Nano-delivery systems for remineralizing agents target early caries, reducing drilling needs. These materials also resist bacterial adhesion, lowering secondary decay risk by 20%, per a 2024 <em>Clinical Oral Investigations</em> study. For patients, this means more durable, natural-looking restorations and fewer replacements, enhancing satisfaction.</p>
    <h2>Challenges Ahead</h2>
    <p>High production costs and regulatory hurdles slow nanotechnology’s adoption. Long-term clinical data is still limited, requiring further trials. Dental education platforms can address this by offering webinars or research summaries to keep professionals informed. Cost reductions through scalable manufacturing will be critical for widespread use, especially in underserved areas.</p>
    <h2>Conclusion</h2>
    <p>Nanotechnology is reshaping restorative dentistry with stronger, more precise materials. As research progresses, it promises to enhance patient outcomes and reduce treatment frequency. Dental education will play a pivotal role in guiding professionals to adopt these innovations effectively.</p>',
    3,
    'Thinh Tran',
    'nanotech-dentistry.jpg',
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
    4,
    'Hieu Hoang',
    'toothpaste-selection.jpg',
    0
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
    4,
    'Thinh Tran',
    'gum-disease-diet.jpg',
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
    ('Oral-B Pro-Health Manual', 'oral-b-pro-health-manual', 'Soft-bristled manual toothbrush with angled bristles for effective plaque removal.', 1, 'https://www.amazon.com/Oral-B-Pro-Health-Manual-Toothbrush/dp/B001234567', 'oral-b-manual.jpg', 1),
    ('Colgate 360° Manual Toothbrush', 'colgate-360-manual', 'Manual toothbrush with whole mouth cleaning including tongue and cheek cleaner.', 1, 'https://www.amazon.com/Colgate-360-Manual-Toothbrush/dp/B001234568', 'colgate-360.jpg', 1),
    ('GUM Technique Pro Compact', 'gum-technique-pro', 'Compact head manual toothbrush with tapered bristles for precision cleaning.', 1, 'https://www.amazon.com/GUM-Technique-Pro-Compact/dp/B001234569', 'gum-technique.jpg', 1),
    ('Oral-B iO Series 9', 'oral-b-io-series-9', 'Premium electric toothbrush with AI-powered brushing tracking and multiple cleaning modes.', 1, 'https://www.amazon.com/Oral-B-iO-Series-9/dp/B08P4W6Z7G', 'oral-b-io9.jpg', 1),
    ('Philips Sonicare DiamondClean', 'philips-sonicare-diamondclean', 'High-performance sonic electric toothbrush for superior plaque removal and gum health.', 1, 'https://www.amazon.com/Philips-Sonicare-DiamondClean/dp/B07Z7F5R1K', 'sonicare-diamondclean.jpg', 1),
    ('Oral-B Vitality Pro', 'oral-b-vitality-pro', 'Budget-friendly electric toothbrush with oscillating technology for daily cleaning.', 1, 'https://www.amazon.com/Oral-B-Vitality-Pro/dp/B00T9G9J2M', 'vitality-pro.jpg', 1),

    -- TOOTHPASTES (3 regular, 2 sensitivity, 2 whitening)
    ('Colgate Total Original', 'colgate-total-original', 'Regular fluoride toothpaste for comprehensive oral health protection and cavity prevention.', 2, 'https://www.amazon.com/Colgate-Total-Original/dp/B001234570', 'colgate-total.jpg', 1),
    ('Crest Cavity Protection', 'crest-cavity-protection', 'Basic fluoride toothpaste providing essential cavity protection for daily use.', 2, 'https://www.amazon.com/Crest-Cavity-Protection/dp/B001234571', 'crest-cavity.jpg', 1),
    ('Oral-B Pro-Expert Deep Clean', 'oral-b-pro-expert', 'Regular toothpaste with deep cleaning formula for thorough plaque removal.', 2, 'https://www.amazon.com/Oral-B-Pro-Expert-Deep-Clean/dp/B001234572', 'oral-b-expert.jpg', 1),
    ('Sensodyne Pronamel Gentle', 'sensodyne-pronamel', 'Fluoride toothpaste designed to protect enamel and relieve tooth sensitivity.', 2, 'https://www.amazon.com/Sensodyne-Pronamel-Gentle/dp/B07N1N5Q2R', 'sensodyne-pronamel.jpg', 1),
    ('Colgate Sensitive Complete', 'colgate-sensitive-complete', 'Sensitivity relief toothpaste with fluoride for complete oral care protection.', 2, 'https://www.amazon.com/Colgate-Sensitive-Complete/dp/B001234573', 'colgate-sensitive.jpg', 1),
    ('Crest 3D White Brilliance', 'crest-3d-white-brilliance', 'Advanced whitening toothpaste with fluoride for stain removal and enamel protection.', 2, 'https://www.amazon.com/Crest-3D-White-Brilliance/dp/B07Z7F5R1K', 'crest-3d-white.jpg', 1),
    ('Colgate Optic White Advanced', 'colgate-optic-white', 'Professional-level whitening toothpaste with hydrogen peroxide for visible results.', 2, 'https://www.amazon.com/Colgate-Optic-White-Advanced/dp/B001234574', 'colgate-optic-white.jpg', 1),

    -- INTERDENTAL CARE (2 regular floss, 2 water floss, 2 floss picks)
    ('Oral-B Glide Pro-Health', 'oral-b-glide-floss', 'Smooth, shred-resistant dental floss for comfortable cleaning between tight teeth.', 3, 'https://www.amazon.com/Oral-B-Glide-Pro-Health/dp/B001OOLF82', 'glide-floss.jpg', 1),
    ('Johnson & Johnson Reach Floss', 'reach-dental-floss', 'Waxed dental floss with mint flavor for effective interdental plaque removal.', 3, 'https://www.amazon.com/Johnson-Johnson-Reach-Floss/dp/B001234575', 'reach-floss.jpg', 1),
    ('Waterpik Cordless Advanced', 'waterpik-cordless-advanced', 'Portable water flosser for interdental cleaning, ideal for braces and sensitive gums.', 3, 'https://www.amazon.com/Waterpik-Cordless-Advanced/dp/B00T9G9J2M', 'waterpik-cordless.jpg', 1),
    ('Philips Sonicare AirFloss Ultra', 'philips-airfloss-ultra', 'Air-powered water flosser using micro-droplet technology for quick interdental cleaning.', 3, 'https://www.amazon.com/Philips-Sonicare-AirFloss-Ultra/dp/B00J5Z8O5A', 'airfloss-ultra.jpg', 1),
    ('GUM Soft-Picks Advanced', 'gum-soft-picks', 'Flexible interdental picks for gentle cleaning, suitable for sensitive gums.', 3, 'https://www.amazon.com/GUM-Soft-Picks-Advanced/dp/B000052YHA', 'gum-picks.jpg', 1),
    ('Oral-B Complete Glide Picks', 'oral-b-glide-picks', 'Pre-threaded floss picks with shred-resistant floss for convenient on-the-go cleaning.', 3, 'https://www.amazon.com/Oral-B-Complete-Glide-Picks/dp/B001234576', 'glide-picks.jpg', 1),

    -- ORAL RINSES (3 antibacterial, 2 fluoride, 2 breath freshening)
    ('Listerine Total Care Antibacterial', 'listerine-total-care', 'Antimicrobial mouthwash that kills 99% of germs and strengthens enamel.', 4, 'https://www.amazon.com/Listerine-Total-Care/dp/B07D7J4Z3S', 'listerine-total.jpg', 1),
    ('Colgate Total Advanced Pro-Shield', 'colgate-total-proshield', 'Antibacterial mouthwash with fluoride for 12-hour germ protection.', 4, 'https://www.amazon.com/Colgate-Total-Advanced-Pro-Shield/dp/B001234577', 'colgate-proshield.jpg', 1),
    ('Crest Pro-Health Multi-Protection', 'crest-pro-health-rinse', 'Alcohol-free antibacterial rinse for cavity prevention and gum health support.', 4, 'https://www.amazon.com/Crest-Pro-Health-Multi-Protection/dp/B07Z5G3Q4R', 'crest-rinse.jpg', 1),
    ('ACT Anticavity Fluoride Rinse', 'act-anticavity-rinse', 'Fluoride-based mouthwash designed to strengthen teeth and prevent cavities.', 4, 'https://www.amazon.com/ACT-Anticavity-Fluoride-Rinse/dp/B000052YHA', 'act-rinse.jpg', 1),
    ('Oral-B Pro-Expert Fluoride Rinse', 'oral-b-pro-expert-rinse', 'Professional fluoride mouthwash for enhanced cavity protection and enamel strengthening.', 4, 'https://www.amazon.com/Oral-B-Pro-Expert-Fluoride-Rinse/dp/B001234578', 'oral-b-fluoride.jpg', 1),
    ('TheraBreath Fresh Breath Rinse', 'therabreath-rinse', 'Clinically proven mouthwash to combat bad breath with oxygenating formula.', 4, 'https://www.amazon.com/TheraBreath-Fresh-Breath-Rinse/dp/B000O5IQOQ', 'therabreath-rinse.jpg', 1),
    ('Scope Outlast Fresh Mint', 'scope-outlast-mint', 'Long-lasting breath freshening mouthwash with up to 5x longer fresh feeling.', 4, 'https://www.amazon.com/Scope-Outlast-Fresh-Mint/dp/B001234579', 'scope-outlast.jpg', 1),

    -- SPECIALTY PRODUCTS (1 night guard, 1 tongue scraper)
    ('DenTek Comfort-Fit Night Guard', 'dentek-night-guard', 'Custom-fitting dental night guard for teeth grinding and TMJ relief.', 5, 'https://www.amazon.com/DenTek-Comfort-Fit-Night-Guard/dp/B001234580', 'dentek-guard.jpg', 1),
    ('Dr. Tungs Tongue Cleaner', 'dr-tungs-tongue-cleaner', 'Stainless steel tongue scraper for removing bacteria and freshening breath.', 5, 'https://www.amazon.com/Dr-Tungs-Tongue-Cleaner/dp/B001234581', 'tongue-scraper.jpg', 1);