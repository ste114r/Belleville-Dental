<div class="footer-area pt-5 pb-4 bg-white border-top">
    <div class="container-fluid">

        <!-- Logo Section -->
        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <a class="navbar-brand" href="index.php">
                    <img src="images/Belleville Dental logo transparent.png" height="75" alt="Belleville Dental"
                        class="footer-logo">
                </a>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <nav class="footer-nav">
                    <a class="footer-link mx-3" href="index.php">
                        <i class="fa fa-home me-1"></i>Home
                    </a>
                    <a class="footer-link mx-3" href="product.php">
                        <i class="fa fa-newspaper me-1"></i>Products
                    </a>
                    <a class="footer-link mx-3" href="about-us.php">
                        <i class="fa fa-info-circle me-1"></i>About Us
                    </a>
                    <a class="footer-link mx-3" href="contact-us.php">
                        <i class="fa fa-phone me-1"></i>Contact Us
                    </a>
                    <a class="footer-link mx-3" href="gallery.php">
                        <i class="fa fa-picture-o me-1"></i>Gallery
                    </a>
                    <a class="footer-link mx-3" href="sitemap.php">
                        <i class="fa fa-map me-1"></i>Site Map
                    </a>
                </nav>
            </div>
        </div>

        <!-- Live Info Section -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-6 col-md-8">
                <div class="info-section">
                    <div class="info-card mb-3">
                        <div class="info-content">
                            <marquee behavior="scroll" direction="left" onmouseover="this.stop();"
                                onmouseout="this.start();">
                                <i class="fa fa-clock me-2 text-primary"></i>
                                <strong>Live Clock:</strong> <span id="liveClock" class="ms-2"></span>
                            </marquee>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-content">
                            <marquee behavior="scroll" direction="left" onmouseover="this.stop();"
                                onmouseout="this.start();">
                                <i class="fa fa-map-marker-alt me-2 text-primary"></i>
                                <strong>Your Location:</strong> <span id="locationInfo" class="ms-2">Detecting...</span>
                            </marquee>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="row justify-content-center">
            <div class="col-auto">
                <div class="footer-credit text-muted mv-0">
                    <?php echo date('Y'); ?>
                    <p>Project bởi nhóm 2</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Clock & Location Scripts -->
<script>
    function updateClock() {
        const now = new Date();
        const date = now.toLocaleDateString();
        const time = now.toLocaleTimeString();
        document.getElementById("liveClock").textContent = `${date} ${time}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Location using LocationIQ Reverse Geocoding API
    function updateLocation() {
        const locationSpan = document.getElementById("locationInfo");

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    const apiKey = "pk.e3f8a5bbe457c25545e8768d6a41e4b4";

                    fetch(`https://us1.locationiq.com/v1/reverse?key=${apiKey}&lat=${lat}&lon=${lon}&format=json`)
                        .then(response => response.json())
                        .then(data => {
                            const address = data.address;
                            const locationText = `${address.suburb || ''}, ${address.city || address.town || address.village || ''}, ${address.country || ''}`;
                            locationSpan.textContent = locationText.trim().replace(/^,|,$/g, '') || "Location found";
                        })
                        .catch(() => {
                            locationSpan.textContent = "Unable to retrieve address.";
                        });
                },
                () => {
                    locationSpan.textContent = "Location access denied.";
                }
            );
        } else {
            locationSpan.textContent = "Geolocation not supported.";
        }
    }

    updateLocation();
</script>

<!-- Styling -->
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
        font-family: 'Merriweather', sans-serif;
        color: #444;
        line-height: 1.6;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Merriweather', serif;
        color: var(--dark);
    }

    .footer-area {
        position: relative;
        background: var(--light-blue);
        border-top: 1px solid rgba(11, 126, 200, 0.1);
        font-family: 'Merriweather', sans-serif;
    }

    .footer-logo {
        transition: all 0.3s ease;
        opacity: 0.95;
    }

    .footer-logo:hover {
        transform: scale(1.05);
        opacity: 1;
    }

    .footer-nav {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
    }

    .footer-link {
        color: var(--dark);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
    }

    .footer-link:hover {
        color: var(--primary);
        text-decoration: none;
        background-color: rgba(11, 126, 200, 0.1);
        transform: translateY(-2px);
    }

    .footer-link i {
        font-size: 0.9rem;
    }

    .info-section {
        max-width: 500px;
        margin: 0 auto;
    }

    .info-card {
        background: white;
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 8px;
        padding: 1rem 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .info-content {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        font-size: 0.95rem;
        color: var(--dark);
    }

    .info-content i {
        font-size: 1rem;
    }

    .footer-credit {
        text-align: center;
        padding-top: 1rem;
        border-top: 1px solid rgba(11, 126, 200, 0.1);
        margin-top: 1rem;
    }

    .footer-credit p {
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .footer-nav {
            flex-direction: column;
            align-items: center;
        }

        .footer-link {
            margin: 0.3rem 0;
            width: auto;
            text-align: center;
        }

        .marquee-container {
            margin-bottom: 1rem;
        }

        .marquee-header {
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
        }

        .marquee-content {
            padding: 0.6rem 0.8rem;
        }

        .marquee-content marquee {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .footer-area {
            padding-top: 3rem;
        }

        .footer-logo {
            max-height: 60px;
        }

        .marquee-header {
            flex-direction: column;
            gap: 0.2rem;
            text-align: center;
            padding: 0.7rem 0.8rem;
        }

        .marquee-header i {
            margin-right: 0 !important;
        }

        .marquee-content marquee {
            font-size: 0.85rem;
        }

        .info-section {
            max-width: 100%;
            padding: 0 0.5rem;
        }
    }
</style>