<?php
// Include the database connection file
include("../connection.php");

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $mobile = $_POST["mobile"];
    $companyName = $_POST["company_name"];
    $companyEmail = $_POST["company_email"];
    $password = md5($_POST["password"]);
    $gstin = $_POST["gstin"];
    $addressLine = $_POST["address_line2"];
    $area = $_POST["area"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $role = 2; // Default role

    // Check if the email and GSTIN do not exist in the database
    $checkEmailQuery = "SELECT * FROM tbl_user WHERE email = '$companyEmail'";
    $checkGstinQuery = "SELECT * FROM tbl_seller WHERE gstin = '$gstin'";

    $emailResult = $conn->query($checkEmailQuery);
    $gstinResult = $conn->query($checkGstinQuery);

    if ($emailResult->num_rows > 0) {
        echo '<script>alert("Email already exists.")</script>';
    } elseif ($gstinResult->num_rows > 0) {
        echo '<script>alert("GSTIN already exists.")</script>';
    } else {
        // Insert data into the users table
        $insertUserQuery = "INSERT INTO tbl_user (email, password, role, status) VALUES ('$companyEmail', '$password', $role, 1)";
        $conn->query($insertUserQuery);

        // Get the user ID of the newly inserted user
        $userId = $conn->insert_id;

        // Insert data into the sellers table
        $insertSellerQuery = "INSERT INTO tbl_seller (user_id, seller_name, company_name, contact_no,gstin) VALUES ($userId, '$name', '$companyName', '$mobile','$gstin')";
        $conn->query($insertSellerQuery);

        // Insert data into the addresses table
        $insertAddressQuery = "INSERT INTO tbl_address (user_id, name, mobile_number, pincode, address, area, city, state) VALUES ($userId, '$name', '$mobile', '$zip', '$addressLine', '$area', '$city', '$state')";
        $conn->query($insertAddressQuery);

        // Redirect to the login page
        header("Location: login.php");
        exit();
    }
    
    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../css/templatemo-hexashop.css">
    <link rel="stylesheet" href="../css/owl-carousel.css">
    <link rel="stylesheet" href="../css/lightbox.css">
    <link rel="stylesheet" href="../css/sellerHome.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/sellerHome.js"></script>
    <title>Careers</title>
    <style>
        * {
            font-size: 18px;
        }

        body {
            font-style: italic;
            font-family: 'Times, Times New Roman, serif';
        }

        .highlight-box {
            border: 2px solid #a8b0bc;
            /* Border color */
            padding: 10px;

            /* Padding inside the box */
            background-color: #d7eced;
            /* Background color */
            display: inline-block;
            /* Display as an inline box */
        }

        /* Optional: Style for the equation text */
        .equation {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .faq-container {

            margin: 0 auto;
        }

        .faq-item {
            margin-bottom: 5px;
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: bold;
            padding: 10px;
            background-color: white;
        }

        .faq-answer {
            display: none;
            padding: 10px;
            border-top: 1px solid #ccc;
            background-color: #f0f0f0;
        }

        .arrow {
            width: 0;
            height: 0;
            border: 4px solid transparent;
            border-bottom-color: black;

            transform: rotate(180deg);
            /* Set the initial rotation */
            transition: transform 0.3s ease-in-out;
        }
        .error_form{
            color:red;
        }
        .open .arrow {
            transform: rotate(0deg);
        }
    </style>
</head>

<body onload="load()">


    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="../index.php" class="logo">
                            <img src="../images/logo.png">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->

                        <ul class="nav" style="font-size: 18px;">
                            <li class="scroll-to-section" id="learning" onclick=learn()><a href = "about.php">About SwapZone</a></li>
                            <li class="scroll-to-section" id="learning" onclick=learn()><a>Life at SwapZone</a></li>
                            <li class="scroll-to-section" id="learning" onclick=learn()><a>Jobs</a></li>
                            <li class="submenu" id="createAccount" onclick=load()>
                                <a href="javascript:;">Interviewing at SwapZone</a>
                                <ul>
                                    <li><a href="#listProducts">Know your Team</a></li>
                                    <li><a href="#Storage">How we hire</a></li>
                                    <li><a href="#receive">Interview Resources</a></li>
                                </ul>
                            </li>
                            <li class="scroll-to-section" id="learning" onclick=learn()><a>Candidate Login</a></li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <section id="Account">
        <div class="container" id="Accountcreate">
            <br><br><br><br><br>
            <h2>Create Your Account</h2><br>
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name = "name" id="name" placeholder="Name">
                        <div class="error-message" id="name-error"></div>
                        <span class="error_form" id="name_error_message"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" name ="mobile" class="form-control" id="mobile" placeholder="Mobile Number">
                        <div class="error-message" id="mobile-error"></div>
                        <span class="error_form" id="mobile_error_message"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" name = "company_name" class="form-control" id="company_name" placeholder="Company Name">
                        <div class="error-message" id="company-error"></div>
                        <span class="error_form" id="company_name_error_message"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="email" class="form-control" name = "company_email" id="company_email" placeholder="Company Email">
                        <div class="error-message"  id="companyEmail-error"></div>
                        <span class="error_form" id="company_email_error_message"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="password" name= "password" class="form-control" id="password" placeholder="Password">
                        <div class="error-message" id="password-error"></div>
                        <span class="error_form" id="password_error_message"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password">
                        <div class="error-message" id="confirmPassword-error"></div>
                        <span class="error_form" id="retype_password_error_message"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" name = "gstin" class ="form-control" id="gstin" placeholder="GSTIN">
                        <div class="error-message"  id="gstin-error"></div>
                        <span class="error_form" id="gstin_error_message"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" name = "address_line2" class="form-control" id="address_line2" placeholder="Address">
                        <div class="error-message" id="addressLine-error"></div>
                        <span class="error_form" id="address_line_error_message"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" name = "area" class="form-control" id="area" placeholder="Area">
                        <div class="error-message" id="area-error"></div>
                        <span class="error_form" id="area_error_message"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" name = "city" class="form-control" id="city" placeholder="City">
                        <div class="error-message" id="city-error"></div>
                        <span class="error_form" id="city_error_message"></span>
                    </div>
                    
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" name = "state" class="form-control" id="state" placeholder="State">
                        <div class="error-message" id="state-error"></div>
                        <span class="error_form" id="state_error_message"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" name = "zip" class="form-control" id="zip" placeholder="Zip Code">
                        <div class="error-message" id="zip-error"></div>
                        <span class="error_form" id="zip_error_message"></span>
                    </div>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="terms">
                    <label class="form-check-label" for="terms">I agree to the terms and conditions</label>
                    <div class="error-message" id="terms-error"></div>
                </div>
                <button type="submit" class="btn btn-primary">Create Account</button>
            </form>
        </div>
        <div class="container" id="listProducts"><br><br><br>
            <h2>List Products</h2><br><br>
            <div class="row">
                <div class="col-md-6">
                    <br>     
                    <img src="../images/List.png" alt="" style="height: 380px; width: 550px;">
                </div>
                <div class="col-md-6">
                    What exactly is a listing? The process of registering your product on the SwapZone platform, making
                    it available to customers, and allowing them to see and purchase your goods is referred to as
                    listing. It entails constructing a complete product page with vital information such as the product
                    title, description, photos, pricing, and other pertinent features. A well-written listing attracts
                    potential consumers and makes it easier to sell your stuff on SwapZone.
                    <br><br>
                    <span style="color: red;">*</span> If your product is already available on SwapZone, you have the
                    option to seamlessly link or 'Latch'
                    onto the existing product listing. This allows you to make your product live on the platform without
                    the need to create a separate listing.
                    <br><br>
                    <span style="color: red;">*</span> For products not currently available on SwapZone, you'll need to
                    provide complete information and
                    create a new listing with details like description, dimensions, features, images, and usage
                    instructions.
                </div>
            </div>
            <div class="container" id="Storage"><br><br><br>
                <h2>Storage and Shipping</h2><br><br>
                <div class="row">
                    <div class="col-md-6">
                        Congratulations on receiving your first order! When it comes to shipping your products to
                        customers, SwapZone understands the importance of fast and reliable delivery in secure
                        packaging.
                        <br>
                        The two popular fulfilment options: <br><br>
                        <span style="color: rgb(35, 181, 35);">&#10004;</span> Fulfilment by SwapZone (FBS)<br>
                        <span style="color: rgb(35, 181, 35);">&#10004;</span> Non Fulfilment by SwapZone (NFBS)<br><br>

                        <h3>Non Fulfilment by SwapZone (NFBS)</h3><br>
                        With Non-Fulfillment by SwapZone (NFBS), you can benefit from end-to-end delivery of your
                        products directly from your location to the customer. In NFBS, it is the responsibility of the
                        seller to ensure that the product is properly packed and ready for dispatch before the delivery
                        agent arrives at the seller's location. This service allows you to maintain control over the
                        packaging process while leveraging SwapZone's logistics network for efficient and reliable
                        delivery. <br><br>

                        <span style="color: rgb(35, 181, 35);">&#10004;</span>&emsp;Delivery to 19000+ pin codes across
                        India <br>
                        <span style="color: rgb(35, 181, 35);">&#10004;</span>&emsp; Tracking of your product <br>
                        <span style="color: rgb(35, 181, 35);">&#10004;</span>&emsp;Customer returns support <br>
                        <span style="color: rgb(35, 181, 35);">&#10004;</span>&emsp;Logistics support from community
                        warehouse available


                    </div>
                    <div class="col-md-6">
                        <h3>Fulfilment by SwapZone (FBS)</h3><br>
                        Eliminate worries about storage, packing, shipping, and delivery by leveraging SwapZone's
                        Fulfilment by SwapZone (FBS) service. FBS offers a comprehensive solution that handles all your
                        shipping needs under one roof. With FBS, you can entrust SwapZone to efficiently manage the
                        entire process, from storing your products to expertly packing and shipping them to customers.
                        FBS maintains the standards required by FAssured, enabling a SwapZone seller to have access to
                        the FAssured badge on their listings. Enjoy a hassle-free experience and focus on growing your
                        business while SwapZone takes care of the logistics. <br> <br>

                        <span style="color: rgb(35, 181, 35);">&#10004;</span>&emsp; Pick-up from seller location to
                        SwapZone
                        warehouse <br>
                        <span style="color: rgb(35, 181, 35);">&#10004;</span> &emsp;Faster delivery to customer <br>
                        <span style="color: rgb(35, 181, 35);">&#10004;</span>&emsp; Seamless order processing <br>
                        <span style="color: rgb(35, 181, 35);">&#10004;</span> &emsp;Customer returns handled end to end
                        <br>
                        <span style="color: rgb(35, 181, 35);">&#10004;</span> &emsp;Warehouse space <br>
                        <span style="color: rgb(35, 181, 35);">&#10004;</span> &emsp;Quality selection recommendation
                        <br>
                        <span style="color: rgb(35, 181, 35);">&#10004;</span> &emsp;Rigorous quality checks <br>
                        <span style="color: rgb(35, 181, 35);">&#10004;</span> &emsp;Quality packaging materials <br>
                    </div>
                </div>
                <div class="col-md-12"><br><br>
                    Consider the fulfilment option that best suits your needs and preferences to ensure timely and
                    secure delivery of your products to SwapZone customers. <br><br><br>
                    <table style="text-align: left;border-collapse: collapse;
                        width: 100%;">
                        <tr style="background-color: rgb(124, 223, 155);">
                            <th></th>
                            <th>&emsp;Fulfilment by SwapZone</th>
                            <th>&emsp;Non Fulfilment by SwapZone</th>
                        </tr>
                        <tr>
                            <td>Packaging</td>
                            <td>SwapZone will pack your products</td>
                            <td>Seller will pack their products before pick-up</td>
                        </tr>
                        <tr>
                            <td>Storage</td>
                            <td>SwapZone will store your products at the nearest SwapZone warehouse</td>
                            <td>Seller will store products at their premise or community warehouse</td>
                        </tr>
                        <tr>
                            <td>Shipping</td>
                            <td>SwapZone will pick and deliver your products to the customer</td>
                            <td>Seller will schedule a pick-up & a delivery agent will pick your order</td>
                        </tr>
                        <tr>
                            <td>Fees</td>
                            <td>Relevant FBS fees will be applicable</td>
                            <td>Normal shipping cost will be applicable to help deliver your product to your customer,
                                based on local, zonal or national delivery.</td>
                        </tr>
                        <tr>
                            <td>Returns</td>
                            <td>Managed by SwapZone</td>
                            <td>Managed by SwapZone</td>
                        </tr>
                        <tr>
                            <td>Customer Service</td>
                            <td>Managed by SwapZone</td>
                            <td>Managed by SwapZone</td>
                        </tr>
                    </table>
                </div>
                <div class="container" id="receive"><br><br><br>
                    <h2>Receive Payments</h2><br><br>
                    <div class="row">
                        <div class="col-md-6">
                            <img src="images/receive.jpg" alt="" class="img-fluid" style="width: 505px;
                            height: 375px;">
                        </div>
                        <div class="col-md-6">
                            SwapZone is your ultimate online platform for seamless and secure payment processing. With a
                            focus on convenience and reliability, SwapZone empowers your website to effortlessly handle
                            payments directly on-site. Our cutting-edge payment solutions ensure a smooth transaction
                            experience for your users, allowing them to complete purchases, subscriptions, and
                            transactions without ever leaving your website's interface.
                            <br>

                            <br>
                            Experience the future of online payments with SwapZone. Elevate your website's user
                            experience and streamline your payment processes by embracing a platform that prioritizes
                            efficiency, security, and customer satisfaction. Join us in revolutionizing the way payments
                            are made and received on your site.
                        </div>
                    </div>
                </div>

                <div class="container" id="grow"><br><br><br>
                    <h2>Grow Faster</h2><br><br>
                    <div class="row">
                        <div class="col-md-6">
                            At SwapZone, we recognize that there may be times when you require additional assistance for
                            your online business. That's why, with your SwapZone seller account, you gain access to a
                            diverse range of tools and support functions designed to foster business growth. These
                            include:
                            <ul>
                                <li><span style="color: rgb(35, 181, 35);">&#10004;</span> &emsp;<b>Price Recommendation
                                        Tool:</b> Helps you determine optimal &emsp;&emsp; &emsp;&emsp;pricing for your
                                    products.</li>
                                <li><span style="color: rgb(35, 181, 35);">&#10004;</span> &emsp;<b>Product
                                        Recommendation Tool:</b> Suggests popular and trending &emsp;&emsp;products to
                                    expand your
                                    product
                                    selection.</li>
                                <li><span style="color: rgb(35, 181, 35);">&#10004;</span> &emsp;<b>SwapZone Ads:</b>
                                    Enables you to advertise your products and &emsp;&emsp;reach a larger customer base.
                                </li>
                                <li><span style="color: rgb(35, 181, 35);">&#10004;</span> &emsp;<b>Paid Account
                                        Management services:</b> Offers dedicated account &emsp;&emsp;management support
                                    for
                                    personalised guidance.</li>
                                <li> <span style="color: rgb(35, 181, 35);">&#10004;</span> &emsp;<b>Catalog &
                                        Photoshoot services:</b> Assists with creating high-&emsp; &emsp;&emsp;quality
                                    product catalogues
                                    and
                                    images.</li>
                                <li><span style="color: rgb(35, 181, 35);">&#10004;</span> &emsp;<b>Shopping Festivals
                                        and more:</b> Participate in exciting sales
                                    &emsp;&nbsp;&nbsp;&nbsp;&nbsp;&emsp;events and promotional
                                    campaigns.</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <img src="images/grow.jpg" alt="" class="img-fluid" style="width: 505px;
                            height: 450px;">

                        </div>
                    </div>
                    <div class="container" id="help"><br><br><br>
                        <h2>Help and Support</h2><br><br>
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/contact.gif" alt="" class="img-fluid" style="width: 505px;
                                height: 500px;">

                            </div>
                            <div class="col-md-6">
                                At SwapZone, we are committed to providing exceptional help and support to ensure your
                                experience is smooth and enjoyable. Our dedicated support team is available around the
                                clock to assist you with any questions, concerns, or issues you may have.
                                <br><br>
                                Whether you need guidance on how to use our platform, assistance with a transaction, or
                                simply have a suggestion to improve our services, we're here for you. You can reach out
                                to our support team via email, live chat, or phone, and we'll respond promptly to
                                address your needs.
                                <br><br>
                                We value your feedback and take every opportunity to enhance your satisfaction. Our
                                comprehensive knowledge base is also available, providing step-by-step guides and FAQs
                                to help you navigate through the platform with ease.
                                <br><br>
                                At SwapZone, your success and satisfaction are our top priorities. Join our community
                                today and experience the highest level of help and support for all your swapping needs.

                            </div>
                        </div>
                    </div>

    </section>
    <section style="padding-top:100px;" id="feeType">
        <div class="container mt-5">
            <div class="row" id="paymentCycle">
                <div class="container">
                    <h2>Payment Cycle</h2><br><br>
                    <div class="row">
                        <div class="col-md-6">
                            At SwapZone, we offer a seamless and transparent payment cycle to ensure a smooth and secure
                            experience for all users. Here's how our payment cycle works:
                            <br>
                            <b>Initiating a Swap: </b>When you initiate a swap on SwapZone, our platform calculates the
                            estimated amount you'll receive based on the current exchange rates. This gives you a clear
                            understanding of the value you'll get before confirming the transaction.
                            <br>
                            <b>Sending the Items:</b> Once you agree to the estimated amount, you'll need to send the
                            items
                            you're swapping to the designated address provided by SwapZone. We recommend using secure
                            shipping methods to ensure the safe delivery of your items.
                            <br>
                            <b>Verification and Confirmation:</b> After receiving your items, our team will verify their
                            condition and authenticity. This step is crucial to maintain the quality and trust of our
                            swapping community. Once the verification is complete, you'll be notified, and the swap will
                            proceed.
                            <br>
                        </div>
                        <div class="col-md-6">
                            <b>Receiving Your Items:</b> Simultaneously, the other party in the swap will send their
                            items to
                            you. Just like in the previous step, we'll ensure the verification of these items before
                            proceeding.
                            <br>
                            <b>Completion and Payment:</b> Once both sets of items are verified, the swap is considered
                            complete. The agreed-upon payment will be processed to your preferred payment method,
                            ensuring a fair and secure transaction for both parties.
                            <br>
                            <b>Feedback and Support:</b> We encourage users to provide feedback on their swapping
                            experience.
                            This helps us continually improve our services and maintain a high level of satisfaction
                            within the SwapZone community. If you have any questions or need assistance at any point
                            during the payment cycle, our dedicated support team is available to help.
                            <br><br>
                            <span style="color: red;">*</span> At SwapZone, we prioritize security, transparency, and
                            user satisfaction throughout the
                            entire payment cycle. Join us to experience a reliable and efficient platform for
                            hassle-free item swapping.

                        </div>
                        <div class="col-md-6" id="fees">
                            <!-- Description goes here -->
                            <br><br>
                            <h2>Fee Type</h2><br>

                            The costs imposed by SwapZone vary depending on the type of items you sell, the delivery
                            method
                            you select, and the selling price of your products. There are four sorts of fees that apply:
                            <br><br>
                            <h3>Fixed Fee (Platform Opportunity)</h3><br>

                            The fixed charge, also known as the closure fee, is adopted on the SwapZone platform to
                            improve
                            the
                            overall client and seller experience. This charge is used to foster product innovation,
                            improve
                            the
                            SwapZone platform, and provide sellers with new growth prospects. SwapZone intends to
                            continually
                            improve its services and create a better climate for sellers to grow and build their
                            companies
                            by
                            introducing the set fee.
                            <br>
                            <span style="color: red;">*</span> Payment timelines vary according on seller tier. Payments
                            are
                            provided as soon as possible
                            after
                            shipment.
                            To view your payment schedules, log in to your SwapZone seller account.

                            <!-- Add more content here as needed -->
                        </div>

                        <div class="col-md-6">
                            <br>
                            <br>
                            <table style="text-align: left;border-collapse: collapse;
                    width: 100%;">
                                <tr style="background-color: rgb(124, 223, 155);">
                                    <th>Average Selling Price (₹)</th>
                                    <th> Fulfilment by SwapZone</th>
                                    <th>Non Fulfilment by SwapZone</th>
                                </tr>
                                <tr>
                                    <td>0 - 300</td>
                                    <td>14</td>
                                    <td>16</td>
                                </tr>
                                <tr>
                                    <td>301 - 500</td>
                                    <td>14</td>
                                    <td>16</td>
                                </tr>
                                <tr>
                                    <td>501 - 1000</td>
                                    <td>30</td>
                                    <td>30</td>
                                </tr>
                                <tr>
                                    <td>>1000</td>
                                    <td>50</td>
                                    <td>55</td>
                                </tr>
                            </table>
                            <span style="color: red;">*</span> Please note that the information provided above is based
                            on
                            the standard rate card and is subject
                            to change. To obtain the accurate and up-to-date fixed fee applicable to your sales, we
                            recommend logging into your SwapZone seller account. By accessing your account, you can stay
                            informed about the specific fixed fees that apply to your transactions.
                        </div>
                        <div class="col-md-6"><br><br><br>
                            <img src="images/Fee.jpg" alt="Image" class="img-fluid" style="width: 500px;
                    height: 450px;">
                        </div>
                        <div class="col-md-6">
                            <!-- Description goes here -->
                            <br><br><br>
                            <h3>Commission Fee (Category)</h3><br>

                            The Commission Fee is a percentage-based fee that changes according to the category in which
                            your goods is sold on SwapZone. Each category has a different set of commission rates that
                            are
                            added to the product's ultimate selling price. The commission rate is subject to fluctuate
                            dependent on market conditions, the seller ecology, demand, and other variables.

                            We recommend entering into your SwapZone seller account to acquire the correct commission
                            charge
                            for your product. You may remain up to date on the particular commission rates that apply to
                            your items by logging into your account.
                            <br>
                            * Payment timelines vary according on seller tier. Payments are provided as soon as possible
                            after
                            shipment.
                            To view your payment schedules, log in to your SwapZone seller account.

                        </div>


                        <div class="col-md-6"><br>
                            <br><br><br>
                            <h3 style="text-align: left;">Collection Fee (Mode of payment to customer)</h3><br>

                            The Collection cost is calculated based on the method of payment selected by the consumer,
                            whether prepaid (e.g., UPI, Netbanking) or Cash on Delivery (COD).
                            <br>
                            A fee is imposed for prepaid orders to cover the payment gateway associated with the
                            transaction. Cash on Delivery, a postpaid way of payment collection, on the other hand,
                            charges
                            a fee to enable the cash collecting service.
                            <br>
                            The collecting charge is depending on the product's ultimate selling price.

                        </div>
                        <div class="col-md-6">
                            <br>
                            <br><br><br>
                            <table style="text-align: left;border-collapse: collapse;
                    width: 100%;">
                                <tr style="background-color: rgb(124, 223, 155);">
                                    <th>Average Selling Price (₹) </th>
                                    <th> Cash on Delivery (COD)</th>
                                    <th>Prepaid</th>
                                </tr>
                                <tr>
                                    <td>0 - 750</td>
                                    <td>₹ 12.5</td>
                                    <td>₹ 12.5</td>
                                </tr>
                                <tr>
                                    <td>>750</td>
                                    <td>2%</td>
                                    <td>2%</td>
                                </tr>
                            </table>
                            <span style="color: red;">*</span> Please note that the information provided above is based
                            on
                            the standard rate card and is subject to change. To obtain the accurate and up-to-date
                            collection fee applicable to your sales, we recommend logging into your SwapZone seller
                            account.
                            By accessing your account, you can stay informed about the specific collection fees that
                            apply
                            to your transactions.
                        </div>

                    </div> <br><br><br> <br>
                    <div id="gross">
                        <div class="col-md-12">
                            <h2>How to calculate your gross margin?</h2> <br><br>
                            The seller dashboard provides comprehensive information about the various fee types
                            applicable to each sale, allowing you to understand the details in a detailed manner.
                            <br>
                            To calculate your gross margin for each sale, you can follow these indicative steps:
                            <br> <br>
                            <div class="highlight-box">
                                <p class="equation"> Total SwapZone fees = Fixed Fee + Commission Fee + Shipping Fee +
                                    Collection Fee</p>
                            </div>
                            <br><br>
                            <div class="highlight-box">
                                <p class="equation"> Gross Margin (excluding GST) = Selling Price of Product - Total
                                    SwapZone Fees charged</p>
                            </div> <br><br>
                            Let’s understand with an example
                            You are a Non-FBS seller selling a Denim Jacket on SwapZone at ₹2000 (selling
                            price).
                            <table>
                                <tr>
                                    <td style="color:blue">Step 1:</td>
                                    <td>Calculate Shipping Fees <br>
                                        Geography: If you are selling the product from Ludhiana to a customer in
                                        Bangalore, the
                                        national shipping cost will be applicable. <br>
                                        Weight: The weight of the final packed product to be measured and relevant
                                        prices to be applied. <br>
                                        If the quantity of the packed product is 2, the final shipping cost is ₹144</td>
                                </tr>
                                <tr>
                                    <td style="color:blue">Step 2:</td>
                                    <td>Calculate Collection Fees <br>
                                        If you choose the prepaid mode of payment from your customer, 2% will be applied
                                        (since your selling price is above ₹750) <br>
                                        Final collection fee: 2% of 2000 = ₹40</td>
                                </tr>
                                <tr>
                                    <td style="color:blue">Step 3:</td>
                                    <td>Calculate Commission Fees <br>
                                        Apply the percentage relevant to the Denim Jacket category. Since the seller
                                        here is
                                        a NonFBS seller, 5% will be applicable. <br>
                                        5% x ₹2000 = ₹100</td>
                                </tr>
                                <tr>
                                    <td style="color:blue">Step 4:</td>
                                    <td>Calculate Fixed fees
                                        Since the selling price of the Denim Jacket is above ₹1000 and you are a
                                        Non-FBS
                                        seller, the fixed fee will be ₹55</td>
                                </tr>
                                <tr>
                                    <td style="color:blue">Step 5:</td>
                                    <td>Total SwapZone fees <br>
                                        ₹144 + ₹40 + ₹100 + ₹55 = ₹339</td>
                                </tr>
                                <tr>
                                    <td style="color:blue">Step 6:</td>
                                    <td>Calculate gross margin <br>
                                        Selling price = ₹2000 <br>
                                        SwapZone Fees = ₹339 <br>
                                        Gross Margin = ₹2000 - ₹339 = ₹1661</td>
                                </tr>
                            </table> <br><br>
                            Note: The figures mentioned above are for illustrative purposes only and intended to provide
                            a general understanding. Actual fees may vary based on factors such as the specific services
                            selected, precise dimensions/weight/volumetric weight, category classification, additional
                            services utilised, recent rate card updates, applicable GST, and other factors. To obtain
                            accurate and up-to-date information on the fees applicable to your sales, we recommend
                            logging into your SwapZone seller account. By accessing your account, you can view the
                            specific fees applicable to your products and transactions.
                        </div>
                    </div>
    </section>
    <section id="learn">
        <div class="container mt-5"><br><br><br><br>
            <h1 class="text-center mb-4">Frequently Asked Questions (FAQ)</h1>
            <div id="accordion">

                <!-- General Section -->
                <br>
                <h3 class="text-center">General</h3><br>

                <!-- FAQ 1 -->
                <div class="faq-container">
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            How do I create a seller account?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            To create a seller account on SwapZone, go to the "Seller Registration" page and fill out
                            the required information. Once submitted, your account will be reviewed and approved within
                            24 hours.
                        </div>
                    </div>
                    <hr>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            Is SwapZone available internationally?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            Yes, SwapZone operates globally, allowing users from different countries to participate in
                            buying and selling clothing items.
                        </div>
                    </div>
                    <hr>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            How do I list an item for sale on SwapZone?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            Listing an item is easy! Just log in to your account, click on "List Item," provide details
                            about the clothing item, upload photos, and set a price.
                        </div><hr>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            What payment methods are accepted on SwapZone?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            SwapZone currently supports various payment methods, including credit/debit cards, PayPal,
                            and other secure online payment options.
                        </div><hr>
                    </div>
                </div><br>
                <!-- Add 19 more FAQs below -->
                <h3 class="text-center">Fees and Charges</h3><br>
                <!-- FAQ 2 -->
                <div class="faq-container">
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            Are there any fees for listing items on SwapZone?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            Listing items on SwapZone is currently free. However, there may be additional charges for
                            premium features and services.
                        </div>
                    </div><hr>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            How are fees calculated for successful sales?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            SwapZone charges a small commission on each successful sale, which is deducted from the
                            final sale price.
                        </div>
                    </div><hr>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            Can I get a refund on fees if my item doesn't sell?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            SwapZone's fees are non-refundable, even if your item doesn't sell. Make sure to accurately
                            describe and present your items to increase your chances of a successful sale.
                        </div>
                    </div><hr>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            Are there any charges for using the Fulfillment by SwapZone service?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            Yes, there are fees associated with using Fulfillment by SwapZone. These fees cover storage,
                            packaging, and shipping services.
                        </div><hr>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            Are there any hidden fees I should be aware of?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            SwapZone is transparent about its fees. All fees associated with listing, selling, and using
                            additional services are clearly stated during the process.
                        </div>
                    </div><hr>
                </div>
                <br>
                <h3 class="text-center">Manage Your Account:</h3><br>
                <div class="faq-container">
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            How can I update my account information?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            Log in to your SwapZone account and go to the "Account Settings" page. Here, you can edit
                            your profile details, including your contact information and password.
                        </div>
                    </div>
<hr>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            What should I do if I forget my password?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            If you forget your password, click on the "Forgot Password" link on the login page. Follow
                            the instructions to reset your password.
                        </div>
                    </div>
<hr>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            How can I close my SwapZone account?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            To close your account, contact our support team. Keep in mind that closing your account is
                            irreversible and will result in the removal of your listings.
                        </div>
                    </div><hr>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            Can I have multiple listings for the same item?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            Duplicate listings for the same item are not allowed. Each item should have a single,
                            accurate listing.
                        </div>
                    </div><hr>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            How can I change my email address associated with my account?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            For security reasons, you can't change your email address directly. If you need to update
                            it, please contact our support team for assistance.
                        </div>
                    </div><hr>
                </div>
                <!-- FAQ 2 -->
                <br>
                <h3 class="text-center">Fulfillment by SwapZone:</h3><br>
                <div class="faq-container">
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            What is Fulfillment by SwapZone?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            Fulfillment by SwapZone is a service where you can store your clothing items in our
                            warehouse, and we handle packaging and shipping when you make a sale.
                        </div>
                    </div>
<hr>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            How do I enroll in Fulfillment by SwapZone?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            You can opt for Fulfillment by SwapZone when you list your items for sale. Select the option
                            and follow the instructions to send your items to our warehouse.
                        </div>
                    </div>
<hr>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            What are the benefits of using Fulfillment by SwapZone?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            Fulfillment by SwapZone saves you time and effort by taking care of storage, packaging, and
                            shipping. It also offers reliable shipping options for your customers.
                        </div>
                    </div><hr>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            Can I use Fulfillment by SwapZone for international orders?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            Yes, Fulfillment by SwapZone supports both domestic and international orders, providing a
                            seamless experience for sellers and buyers worldwide.
                        </div>
                    </div><hr>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleAnswer(this)">
                            How do I track the status of orders fulfilled by SwapZone?
                            <div class="arrow"></div>
                        </div>
                        <div class="faq-answer">
                            You can track the status of orders through your account dashboard. We provide real-time
                            updates on order processing, packaging, and shipping.
                        </div>
                    </div><hr>
                </div>
            </div>
        </div>

    </section>
    <!-- jQuery -->
    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="first-item">
                        <div class="logo">
                            <img src="../images/white-logo.png" alt="SwapZone">
                        </div>
                        <ul>
                            <li><a href="#">SwapZone, Kochi</a></li>
                            <li><a href="#">SwapZone@gmail.com</a></li>
                            <li><a href="#">+91 9548782431</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h4>Shopping &amp; Categories</h4>
                    <ul>
                        <li><a href="#">Men’s Shopping</a></li>
                        <li><a href="#">Women’s Shopping</a></li>
                        <li><a href="#">Kid's Shopping</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Homepage</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>Help &amp; Information</h4>
                    <ul>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">FAQ's</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Tracking ID</a></li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <div class="under-footer">
                        <p>Copyright © 2023 SwapZone All Rights Reserved.

                         
                        </p>
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="../js/jquery-2.1.0.min.js"></script>
    <script>
        function toggleAnswer(element) {
            var answer = element.nextElementSibling;
            if (answer.style.display === 'none') {
                answer.style.display = 'block';
                element.classList.add('open');
                element.querySelector('.arrow').style.transform = 'rotate(0deg)';
            } else {
                answer.style.display = 'none';
                element.classList.remove('open');
                element.querySelector('.arrow').style.transform = 'rotate(180deg)';
            }
        }
    </script>
    <!-- Bootstrap -->
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js'"></script>
    <script>
        function load() {
    document.getElementById("Account").style.display = "block";
    document.getElementById("feeType").style.display = "none";
    document.getElementById("learn").style.display = "none";
}
function feesAndCommission() {
    document.getElementById("Account").style.display = "none";
    document.getElementById("feeType").style.display = "block";
    document.getElementById("learn").style.display = "none";
}
function learn(){
    document.getElementById("Account").style.display = "none";
    document.getElementById("feeType").style.display = "none";
    document.getElementById("learn").style.display = "block";
}
    </script>
    <!-- Plugins -->
    <script src="../js/owl-carousel.js"></script>
    <script src="../js/accordions.js"></script>
    <script src="../js/datepicker.js"></script>
    <script src="../js/scrollreveal.min.js"></script>
    <script src="../js/waypoints.min.js"></script>
    <script src="../js/jquery.counterup.min.js"></script>
    <script src="../js/imgfix.min.js"></script>
    <script src="../js/slick.js"></script>
    <script src="../js/lightbox.js"></script>
    <script src="../js/isotope.js"></script>

    <!-- Global Init -->
    <script src="../js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>