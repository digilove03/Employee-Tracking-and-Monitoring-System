<style>
    .timeDiv{
        width: 100%;
        display:flex;
        justify-content:center;
    }
    .showTime {
        height: 100%;
        width: 100px;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
        color:white;
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
        const ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12 || 12; // Convert 24-hour to 12-hour format

        // Display formatted date and time
        document.getElementById("currentDate").innerHTML = `${day}-${month}-${year}`;
        document.getElementById("currentTime").innerHTML = `${hours}:${minutes} ${ampm}`;
    }

    // Update the time every second
    setInterval(updateDateTime, 1000);
    
    // Call the function once immediately
    updateDateTime();
</script>

<nav class="sb-topnav navbar navbar-expand navbar-dark" id="topNavBG">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="dashboard.php">Employee Monitoring</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        
        <!--Time-->
        <div class="timeDiv">
            <div class="showTime">
                <span id="currentDate"></span>
                <span id="currentTime"></span>
            </div>
        </div>
        
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto" style="margin: 25px;">
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
