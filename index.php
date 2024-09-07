<?php
include 'db.php';

// Fetch the latest jobs from the database
$query = "SELECT id, company_logo, job_title, company_name, company_location FROM jobs ORDER BY created_at DESC LIMIT 4";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="JobGhana is the leading job portal in Ghana. Discover the latest job opportunities and connect with top employers.">
    <meta name="keywords" content="jobs in Ghana, job opportunities, Ghana jobs, employment in Ghana, careers in Ghana, JobGhana">
    <meta name="robots" content="index, follow">
    <meta name="author" content="JobGhana">
    <title>JobGhana - Home</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/home.css">
</head>

<body>

    <?php include 'home_navbar.php'; ?>

    <section class="hero">
        <div class="hero-content">
            <h1>Find Your Dream Job in Ghana</h1>
            <p>
                Be a part of the JobGhana Community, where more than half of Ghanaian professionals
                come to land their next job.
            </p>

        </div>
        <div class="hero_image">
            <img src="./images/hero.png" alt="">
        </div>
    </section>




    <!-- Featured Jobs Section -->
    <section class="featured-jobs">
        <div class="feature_title">
            <h2>Featured Jobs</h2>
        </div>
        <form id="job-search-form" class="search-form">
            <input type="text" id="search-keyword" placeholder="Job title, keyword, or location" oninput="searchJobs()" required>
        </form>
        <div class="job-listings" id="job-listings">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="job-card">
                        <img src="<?php echo htmlspecialchars($row['company_logo']); ?>" alt="Company Logo">
                        <div class="job_details">
                            <h3><?php echo htmlspecialchars($row['job_title']); ?></h3>
                            <p><?php echo htmlspecialchars($row['company_name']); ?></p>
                            <p>Location: <?php echo htmlspecialchars($row['company_location']); ?></p>
                            <div class="btn">
                                <button>
                                    <a href="view_job.php?id=<?php echo $row['id']; ?>">View Job</a>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No featured jobs available at the moment.</p>
            <?php endif; ?>
        </div>
        <p class="no-jobs-message" id="no-jobs-message" style="display:none;">No jobs found. Please try a different search.</p>
    </section>

    <section>
        <div class="partners_all">
            <div class="partners_title">
                <h1>Partners &amp; Sponsors</h1>
            </div>
            <div class="partners_swiper">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper logos_swipers">
                        <div class="swiper-slide">
                            <img src="./images/nhis.jpg" alt="Nhis">
                        </div>
                        <div class="swiper-slide">
                            <img src="./images/GHACEM.png" alt="Ghacem">
                        </div>
                        <div class="swiper-slide">
                            <img src="./images/Gtv.png" alt="GTV">
                        </div>
                        <div class="swiper-slide">
                            <img src="./images/Gmc.png" alt="GMC">
                        </div>

                        <div class="swiper-slide">
                            <img src="./images/gtp.png" alt="GTP">
                        </div>

                        <div class="swiper-slide">
                            <img src="./images/total.png" alt="Total">
                        </div>

                        <div class="swiper-slide">
                            <img src="./images/fanMilk.jpg" alt="FanMilk">
                        </div>

                        <div class="swiper-slide">
                            <img src="./images/Korelebu.jpg" alt="FanMilk">
                        </div>
                        <div class="swiper-slide">
                            <img src="./images/gra.png" alt="GRA">
                        </div>

                    </div>
                    <!-- <div class="swiper-pagination"></div> -->
                </div>
            </div>
        </div>
    </section>
    <!-- Why Choose Us Section -->
    <section class="why-choose-us">
        <h2>Why Choose JobGhana?</h2>
        <div class="benefits">
            <div class="benefit">
                <i class="fa-solid fa-briefcase"></i>
                <h3>Vast Job Opportunities</h3>
                <p>Access a wide range of job listings from top companies across Ghana.</p>
            </div>
            <div class="benefit">
                <i class="fa-solid fa-users"></i>
                <h3>Connect with Employers</h3>
                <p>Build connections with employers and grow your professional network.</p>
            </div>
            <div class="benefit">
                <i class="fa-solid fa-chart-line"></i>
                <h3>Career Growth</h3>
                <p>Enhance your career with the right opportunities and guidance.</p>
            </div>
        </div>
    </section>
    <footer>
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section about">
                    <h3>About JobGhana</h3>
                    <p>JobGhana is your go-to platform for job opportunities across Ghana. Connect with top employers and take the next step in your career journey.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <p><a href="about_us.php">About Us</a></p>
                        <br>
                        <p><a href="privacy_policy.php">Privacy Policy</a></p>
                        <br>
                        <p><a href="terms_of_service.php">Terms of Service</a></p>
                    </ul>
                </div>
                <div class="footer-section contact">
                    <h3>Contact Us</h3>
                    <p><i class="fa-solid fa-envelope"></i> info@jobghana.com</p>
                    <br>
                    <p><i class="fa-solid fa-phone"></i> +233 54 089 0234</p>
                    <br>
                    <p><i class="fa-solid fa-map-marker-alt"></i> Accra, Ghana</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 JobGhana. All rights reserved.</p>
            </div>
        </div>
    </footer>



    <script>
        function searchJobs() {
            var keyword = document.getElementById('search-keyword').value.toLowerCase();
            var jobCards = document.getElementsByClassName('job-card');
            var noJobsMessage = document.getElementById('no-jobs-message');
            var jobsFound = false;

            for (var i = 0; i < jobCards.length; i++) {
                var jobTitle = jobCards[i].getElementsByTagName('h3')[0].innerText.toLowerCase();
                var companyName = jobCards[i].getElementsByTagName('p')[0].innerText.toLowerCase();
                var jobLocation = jobCards[i].getElementsByTagName('p')[1].innerText.toLowerCase();

                // Check if the search keyword matches any of the title, company name, or location
                if (jobTitle.includes(keyword) || companyName.includes(keyword) || jobLocation.includes(keyword)) {
                    jobCards[i].style.display = "";
                    jobsFound = true;
                } else {
                    jobCards[i].style.display = "none";
                }
            }

            // Show "No jobs found" message if no jobs match the search
            noJobsMessage.style.display = jobsFound ? "none" : "block";
        }
    </script>
    <script src="./js/swiper.js"></script>
</body>

</html>

<?php
$conn->close();
?>