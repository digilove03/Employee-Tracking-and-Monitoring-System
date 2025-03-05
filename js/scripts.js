/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});


document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".nav-link");

    // Get current page URL
    const currentPage = window.location.pathname.split("/").pop();

    links.forEach(link => {
        // Check if the href matches the current page
        if (link.getAttribute("href") === currentPage) {
            link.classList.add("active");
        }

        // Add click event to store active link in localStorage
        link.addEventListener("click", function () {
            localStorage.setItem("activeLink", this.getAttribute("href"));
        });
    });

    // Retrieve and apply active class after page reload
    const activeLink = localStorage.getItem("activeLink");
    if (activeLink) {
        links.forEach(link => {
            if (link.getAttribute("href") === activeLink) {
                link.classList.add("active");
            }
        });
    }
});
