<div class="navbar_all">
    <div class="logo"></div>
  <div class="links home_links">
    <a href="index.php">Home</a>
    <a href="about_us.php">About JobGhana</a>
    <a href="admin_login.php">For Admin</a>
 <a href="login.php">For Employers</a>
 <a href="job_seekers_login.php">For Job Seekers</a>
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