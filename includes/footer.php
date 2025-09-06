<div class="footer-area pt-4 pb-3 bg-white border-top">
    <div class="container-fluid">
        
        <!-- Logo Section -->
        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <a class="navbar-brand" href="index.php">
                    <img src="images/Belleville Dental logo transparent.png" height="100" alt="Belleville Dental">
                </a>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <nav class="footer-nav">
                    <a class="footer-link mx-3" href="index.php">Home</a>
                    <a class="footer-link mx-3" href="product.php">Products</a>
                    <a class="footer-link mx-3" href="about-us.php">About Us</a>
                    <a class="footer-link mx-3" href="contact-us.php">Contact Us</a>
                    <a class="footer-link mx-3" href="#">Gallery</a>
                    <a class="footer-link mx-3" href="#">Site Map</a>
                </nav>
            </div>
        </div>

        <!-- Live Info Section -->
        <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <div class="info-ticker bg-light rounded p-2 mb-2">
                    <div class="ticker-content">
                        <strong>Live Clock:</strong> <span id="liveClock"></span>
                    </div>
                </div>
                <div class="info-ticker bg-light rounded p-2">
                    <div class="ticker-content">
                        <strong>Your Location:</strong> <span id="locationInfo">Detecting...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="row justify-content-center">
            <div class="col-auto">
                <p class="text-muted small mb-0">Project bởi nhóm 2</p>
            </div>
        </div>

        <!-- Google Translate Element -->
        <div id="google_translate_element"></div>
    </div>
</div>

<!-- Google Translate -->
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({ pageLanguage: 'en' }, 'google_translate_element');
    }
</script>

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
    .footer-area {
        position: relative;
    }

    .footer-link {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .footer-link:hover {
        color: #1969c5;
        text-decoration: none;
    }

    .info-ticker {
        text-align: center;
        color: #1969c5;
        font-size: 14px;
        border: 1px solid #e9ecef;
    }

    .ticker-content {
        animation: none; /* Removed distracting marquee */
    }

    /* Google Translate Styling */
    .goog-logo-link {
        display: none !important;
    }

    .goog-te-gadget {
        color: transparent;
    }

    .goog-te-gadget .goog-te-combo {
        margin: 0;
        padding: 8px;
        color: #000;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }

    #google_translate_element {
        position: absolute;
        top: 15px;
        right: 20px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .footer-nav {
            text-align: center;
        }
        
        .footer-link {
            display: block;
            margin: 8px 0;
        }
        
        #google_translate_element {
            position: static;
            text-align: center;
            margin-top: 20px;
        }
    }
</style>