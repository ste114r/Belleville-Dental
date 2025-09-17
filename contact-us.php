<?php
include('includes/config.php');
// Initialize message variables
$msg = "";
$error = "";

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Prepare an insert statement to prevent SQL injection
    $stmt = mysqli_prepare($con, "INSERT INTO FEEDBACK(name, email, subject, message) VALUES(?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);

    // Execute the statement and set feedback message
    if (mysqli_stmt_execute($stmt)) {
        $msg = "Your message has been sent successfully! We will get back to you shortly.";
    } else {
        $error = "Something went wrong. Please try again.";
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/Belleville Dental logo transparent.png" type="image/x-icon">
    <title>Belleville Dental | Contact us</title>

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="css/modern-business.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #0B7EC8;
            --primary-dark: #064A8A;
            --secondary: #f8f9fa;
            --accent: #ff6b6b;
            --dark: #343a40;
            --light: #f8f9fa;
            --gray: #6c757d;
            --light-blue: #F0F8FF;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            color: #444;
            line-height: 1.6;
            background-color: #fff;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Merriweather', serif;
            color: var(--dark);
        }
        
        .contact-hero {
            padding: 50px 0 30px;
            text-align: center;
            background-color: var(--light-blue);
            margin-bottom: 30px;
            margin-top: 25px;
            border-bottom: 1px solid rgba(11, 126, 200, 0.1);
        }
        
        .contact-card {
            border: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            height: 100%;
            background: white;
            margin-bottom: 20px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.08);
        }
        
        .contact-icon {
            font-size: 2rem;
            margin-bottom: 15px;
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--light-blue);
        }
        
        .contact-info {
            background: var(--primary);
            padding: 40px 40px;
            border-radius: 8px;
            margin: 30px 0;
            color: white;
        }
        
        .contact-info .contact-card {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .contact-info .contact-icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .contact-info h4, .contact-info a {
            color: white !important;
        }
        
        .map-container {
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 25px;
            border: 1px solid rgba(0,0,0,0.08);
        }
        
        .contact-form {
            padding: 25px;
            background: white;
            border-radius: 8px;
            border: 1px solid rgba(0,0,0,0.08);
        }
        
        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 4px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        
        .section-title {
            margin-bottom: 25px;
            padding-bottom: 10px;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary);
        }
        
        .breadcrumb {
            background: var(--light-blue);
            border-radius: 4px;
            padding: 8px 15px;
            margin-bottom: 25px;
        }
        
        .form-control {
            border-radius: 4px;
            padding: 10px 12px;
            border: 1px solid #e2e2e2;
            transition: all 0.2s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(11, 126, 200, 0.1);
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>
    
    <div class="contact-hero">
        <div class="container-fluid">
            <h1 class="display-4 text-primary">Contact Belleville Dental</h1>
            <p class="lead">We're here to answer your questions and assist with your dental health needs</p>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-lg-12 text-center">
                <p class="lead" style="max-width: 800px; margin: 0 auto;">We're here to assist you with any questions or concerns about dental care! Whether you need advice on oral hygiene, want to learn more about our educational resources, or have feedback to share, please feel free to reach out.</p>
            </div>
        </div>
        
        <div class="contact-info">
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card text-center contact-card">
                        <div class="card-body p-4">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h4>Email Us</h4>
                            <p><a href="mailto:support@bellevilledental.com">support@bellevilledental.com</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card text-center contact-card">
                        <div class="card-body p-4">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h4>Call Us</h4>
                            <p><a href="tel:+8801608445456">+09 123 456 789</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card text-center contact-card">
                        <div class="card-body p-4">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h4>Visit Us</h4>
                            <p style="color: white;">Dental Care Education Center, 123 Smile Street, Health City, HC 12345</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card text-center contact-card">
                        <div class="card-body p-4">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h4>Office Hours</h4>
                            <p style="color: white;">Monday - Friday<br>9:00 AM - 5:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-lg-6 mb-4">
                <h3 class="text-primary mb-3 section-title">Find Us</h3>
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.9663095343008!2d-74.00425872426607!3d40.74076987932881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259bf5c8eef01%3A0x41c84c2d5b175b60!2s123%20Smile%20St%2C%20New%20York%2C%20NY%2010001%2C%20USA!5e0!3m2!1sen!2sbd!4v1714567890123!5m2!1sen!2sbd" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <h3 class="text-primary mb-3 section-title">Send Us a Message</h3>
                <div class="contact-form">
                    
                    <?php if ($msg) { ?>
                        <div class="alert alert-success" role="alert">
                            <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                        </div>
                    <?php } ?>
                    <?php if ($error) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Error!</strong> <?php echo htmlentities($error); ?>
                        </div>
                    <?php } ?>

                    <form name="feedback" method="post" action="">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="What is this regarding?" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="How can we help you?" required></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>

    <script src="js/foot.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>