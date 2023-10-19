<?php
// Include the database connection file
include("../connection.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:./');
    exit();
}

// Function to fetch customer data from the database with pagination
function fetchCustomers($conn, $limit, $offset) {
    $query = "SELECT c.customer_id, u.email, c.customer_name, c.contact_no
    FROM tbl_customer c
    INNER JOIN tbl_user u ON c.user_id = u.user_id
    WHERE u.status = 1
    LIMIT $offset, $limit";

    $result = $conn->query($query);
    $data = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }

    return $data;
}

// Define the number of entries per page
$entriesPerPage = isset($_GET['entries']) ? intval($_GET['entries']) : 10;

// Calculate the total number of customers
$totalCustomersQuery = "SELECT COUNT(*) AS total FROM tbl_customer";
$totalCustomersResult = $conn->query($totalCustomersQuery);
$totalCustomers = $totalCustomersResult->fetch_assoc()['total'];

// Calculate the total number of pages
$totalPages = ceil($totalCustomers / $entriesPerPage);

// Get the current page number from the URL
$currentSlide = isset($_GET['slide']) ? max(1, min($totalPages, intval($_GET['slide']))) : 1;

// Calculate the offset
$offset = ($currentSlide - 1) * $entriesPerPage;

// Fetch customer data for the current page
$customers = fetchCustomers($conn, $entriesPerPage, $offset);

// Function to generate the pagination URLs
function getPaginationUrl($page, $entries) {
    return "customerprofile.php?entries=$entries&slide=$page";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Profiles</title>
    <link rel="stylesheet" href="../libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
    <!-- build:css assets/css/app.min.css -->
    <link rel="stylesheet" href="../libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="../libs/bower/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="../libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/core.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <!-- endbuild -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
    <script src="../libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script>
        Breakpoints();
    </script>
    <style>
        /* Style the container to control chart size */
        .chart-container {
            width: 500px; /* Adjust width as needed */
            height: 500px; /* Adjust height as needed */
            margin: 0 auto; /* Center the chart within the container */
        }

        /* Pagination styling */
        .pagination {
            display: inline-block;
            background-color: #fff;
            padding: 5px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
        }

        .pagination a.active {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body class="menubar-left menubar-unfold menubar-light theme-primary">
<!-- Start main area -->

<?php include_once('header.php');?>

<?php include_once('sidebar.php');?>
<main id="app-main" class="app-main">
    <div class="wrap">
        <section class="app-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget">
                        <header class="widget-header">
                            <h3 class="widget-title">Customer Profiles</h3>
                        </header>
                        <hr class="widget-separator">
                        <div class="widget-body">
                            <div class="container">
                                <!-- Entries per page dropdown -->
                                <div class="form-group">
                                    <label for="entriesPerPage">Entries per page:</label>
                                    <select id="entriesPerPage" name="entriesPerPage" onchange="changeEntriesPerPage(this)">
                                        <option value="10" <?php if ($entriesPerPage === 10) echo 'selected'; ?>>10</option>
                                        <option value="25" <?php if ($entriesPerPage === 25) echo 'selected'; ?>>25</option>
                                        <option value="50" <?php if ($entriesPerPage === 50) echo 'selected'; ?>>50</option>
                                    </select>
                                </div>

                                <!-- Customer Table -->
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Row</th>
                                        <th>Customer Name</th>
                                        <th>Email</th>
                                        <th>Contact No</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($customers as $index => $customer): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo $customer['customer_name']; ?></td>
                                            <td><?php echo $customer['email']; ?></td>
                                            <td><?php echo $customer['contact_no']; ?></td>
                                            <td>
                                                <a href="view_customer.php?id=<?php echo $customer['customer_id']; ?>" class="btn btn-info">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div class="pagination">
                                    <?php if ($currentSlide > 1): ?>
                                        <a href="<?php echo getPaginationUrl($currentSlide - 1, $entriesPerPage); ?>">Previous</a>
                                    <?php endif; ?>

                                    <?php for ($i = max(1, $currentSlide - 5); $i <= min($currentSlide + 5, $totalPages); $i++): ?>
                                        <a class="<?php echo $i === $currentSlide ? 'active' : ''; ?>" href="<?php echo getPaginationUrl($i, $entriesPerPage); ?>"><?php echo $i; ?></a>
                                    <?php endfor; ?>

                                    <?php if ($currentSlide < $totalPages): ?>
                                        <a href="<?php echo getPaginationUrl($currentSlide + 1, $entriesPerPage); ?>">Next</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- APP FOOTER -->
    <?php include_once('footer.php');?>
</main>
<script src="../libs/bower/jquery/dist/jquery.js"></script>
<script src="../libs/bower/jquery-ui/jquery-ui.min.js"></script>
<script src="../libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
<script src="../libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
<script src="../libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
<script src="../libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
<script src="../libs/bower/PACE/pace.min.js"></script>
<!-- endbuild -->

<!-- build:js assets/js/app.min.js -->
<script src="../assets/js/library.js"></script>
<script src="../assets/js/plugins.js"></script>
<script src="../assets/js/app.js"></script>
<!-- endbuild -->
<script>
    // JavaScript function to handle changing entries per page
    function changeEntriesPerPage(select) {
        const entries = select.value;
        window.location.href = "customerprofile.php?entries=" + entries + "&slide=1";
    }
</script>
</body>
</html>
