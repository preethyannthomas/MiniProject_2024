<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for the fixed header */
        .fixed-top-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #fff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1030; /* Make sure it's above the sidebar */
        }

        /* Custom CSS for the sidebar */
        #sidebar {
            height: 100vh;
            width: 250px; /* Increase width */
            position: fixed;
            top: 70px; /* Adjust this to match the header height */
            left: -250px;
            transition: all 0.3s;
            z-index: 1029; /* Below the fixed header */
            border-right: 1px solid #ccc; /* Add a border to separate sidebar from content */
            background-color: #fff; /* Background color */
            color: #000; /* Text color */
            padding-left: 15px;
        }

        #sidebar.active {
            left: 0;
        }

        #sidebar ul {
            list-style: none;
            padding: 0;
        }

        #sidebar ul li {
            padding: 10px;
        }

        /* Custom CSS for the navigation icon */
        #sidebarCollapse {
    position: fixed;
    left: 50px; /* Adjust the left position as needed */
    top: 15px;
    cursor: pointer;
    z-index: 1031; /* Above everything */
    background-color: transparent; /* Background color */
    color: #000 !important; /* Icon color */
    border: none; /* Remove border */
    outline: none !important; /* Remove outline */
    padding: 0;
}
        /* Remove button outline */
        #sidebarCollapse:active,
        #sidebarCollapse:focus {
            outline: none !important;
        }

        /* Custom CSS for the content area */
        #content {
            margin-left: 0;
            transition: all 0.3s;
            padding-left: 270px; /* Adjust padding to match sidebar width */
        }

        /* Highlight active link */
        #sidebar ul li.active a {
            color: blue; /* Active link text color */
        }

        #sidebar ul li a {
            color: #000; /* Link text color */
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header class="fixed-top-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">
                &emsp;&emsp;
                <img src="images/logo.png" alt="Logo" width="200">
            </a>
        </nav>
    </header>
    <div id="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    Profile
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Product Details
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Banking
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Shipping
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    Log Out
                </a>
            </li>
        </ul>
    </div>

    <div id="content">
        <button id="sidebarCollapse" class="btn">
            <i class="fas fa-bars"></i>
        </button>
        <main class="p-4">
            <h1>Welcome to Seller Dashboard</h1>
            <!-- Content for each section goes here -->
        </main>
    </div>

    <!-- Include Bootstrap and jQuery JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Font Awesome for the navigation icon -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Show/hide sidebar on button click
            $("#sidebarCollapse").click(function() {
                $("#sidebar").toggleClass("active");
                $("#content").toggleClass("active");
            });
        });
    </script>
</body>
</html>
