<div class="navbar_all">
    <div class="logo"></div>
    <div class="links">
        <?php if (isset($_SESSION['employer_id'])): ?>
            <a href="business_profile.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'business_profile.php' ? 'active' : ''; ?>">Your Business Profile</a>
            <a href="account_settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'account_settings.php' ? 'active' : ''; ?>">Account Settings</a>
            <a href="add_job.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'add_job.php' ? 'active' : ''; ?>">Add Job Listing</a>
            <a href="view_jobs.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_jobs.php' ? 'active' : ''; ?>">View Job Listing</a>
            <a href="view_applications.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_applications.php' ? 'active' : ''; ?>">Applicant who applied</a>
        <?php endif; ?>

        <?php if (isset($_SESSION['job_seeker_id'])): ?>
            <a href="profile.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">Your Profile</a>
            <a href="account_settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'account_settings.php' ? 'active' : ''; ?>">Account Settings</a>
            <a href="job_listing.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'job_listing.php' ? 'active' : ''; ?>">Job Listing</a>
            <a href="bookmark_jobs.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'bookmark_jobs.php' ? 'active' : ''; ?>">Bookmarked Jobs</a>
        <?php endif; ?>
        <div class="logout">
            <div class="link">
                <a href="">Home</a>
            </div>
     <a href="logout.php">Logout</a>
    </div>
    </div>
 
    <button id="toggleButton">
    <i class="fa-solid fa-bars-staggered"></i>
</button>

</div>  

<script>
    // Get the button and sidebar elements
    var toggleButton = document.getElementById("toggleButton");
    var sidebar = document.querySelector(".links");
    var icon = toggleButton.querySelector("i");

    // Add click event listener to the button
    toggleButton.addEventListener("click", function() {
        // Toggle the visibility of the sidebar
        if (sidebar.style.display === "none" || sidebar.style.display === "") {
            sidebar.style.display = "block";
            icon.classList.remove("fa-bars-staggered");
            icon.classList.add("fa-xmark");
        } else {
            sidebar.style.display = "none";
            icon.classList.remove("fa-xmark");
            icon.classList.add("fa-bars-staggered");
        }
    });
</script>