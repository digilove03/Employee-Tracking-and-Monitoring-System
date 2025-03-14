<style>
    .timeDiv {
        display: flex;
        align-items: center;
        justify-content: flex-end; /* Aligns content to the right */
        flex-grow: 1; /* Pushes time to the right */
        margin-right: 20px; /* Adds spacing from the navbar items */
    }
    .showTime {
        display: flex;
        flex-direction: column;
        align-items: flex-end; /* Aligns text inside the div to the right */
        color: white;
        font-size: 14px; /* Adjust text size */
    }
    #topNavBG {
    background-color: #1E3A8A !important; /* Deep Navy Blue */
}
</style>

<script>
    function updateDateTime() {
        const now = new Date();

        // Format date
        const day = now.getDate();
        const month = now.toLocaleString('en-US', { month: 'short' }); // e.g., Feb
        const year = now.getFullYear();

        // Format time with AM/PM
        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12 || 12; // Convert 24-hour to 12-hour format

        // Update the displayed date and time
        document.getElementById("currentDate").textContent = `${day}-${month}-${year}`;
        document.getElementById("currentTime").textContent = `${hours}:${minutes}:${seconds} ${ampm}`;
    }

    // Ensure the time updates in real-time
    setInterval(updateDateTime, 1000);
    
    // Run the function immediately when the page loads
    document.addEventListener("DOMContentLoaded", updateDateTime);
</script>

<nav class="sb-topnav navbar navbar-expand navbar-dark d-flex" id="topNavBG">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="dashboard.php">E M T S</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Time Display -->
    <div class="timeDiv">
        <div class="showTime">
            <span id="currentDate"></span>
            <span id="currentTime"></span>
        </div>
    </div>

    <!-- Navbar -->
    <ul class="navbar-nav" style="margin: 25px;">
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
