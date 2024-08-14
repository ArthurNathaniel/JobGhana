<div class="sidebar_links">
    <div class="side_links">
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
    </div>
</div>
