<?php
include ("sessionchecker.php");
include ("connection.php");
include ("head.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_order'])) {
    $order_number = $_POST['order_number'];
    $user_id = $_POST['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // Get the current date and time
    $current_time = new DateTime();
    $current_time->add(new DateInterval('PT6H')); // Add 6 hours
    $delivered_date = $current_time->format('Y-m-d H:i:s');

    // $order_number = mt_rand(1000000, 9999999);


    // $description_with_order_number = $description . " Order Number: " . $order_number;

    // Insert notification with order number
    $stmt1 = $conn->prepare("INSERT INTO notification_table (user_id, title, description, status, order_number) VALUES (?, ?, ?, ?, ?)");
    $stmt1->bind_param("issss", $user_id, $title, $description, $status, $order_number);
    $stmt1->execute();
    $stmt1->close();

    // Update order_items to set status and delivered_date
    $sql_update = "UPDATE order_items SET status = 'Delivered', delivered_date = ? WHERE order_number = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $delivered_date, $order_number);
    $stmt_update->execute();
    $stmt_update->close();

    // Redirect to the admin order delivered page
    header("Location: admin_order_delivered.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\order7.css" />

    <style>
        @media only screen and (max-width: 425px) and (min-width: 320px) {
            #order_nav {
                width: 100%;
                font-size: 10px;
                text-align: center;
            }

            #order_head>h5 {
                font-size: 12px;
            }

            #order_head>div {
                width: 50%;
                display: flex;
                justify-content: end;
                gap: 5px;
            }

            #order_head>button {
                font-size: 12px;
                display: flex;
                justify-content: end;
            }

            #product_details {
                font-size: 14px;
            }

            #product_details>div.product_image.d-flex.justify-content-center.align-items-center>div>h5 {
                font-size: 12px;
            }

            #product_details>div.product_image.d-flex.justify-content-center.align-items-center>img {
                width: 50px;
            }

            #product_details>div.product_image.d-flex.justify-content-center.align-items-center>div>div {
                font-size: 10px;
            }

            #price {
                font-size: 12px;
                margin: 0px;

            }

            #product_details>div.product_image.d-flex.justify-content-center.align-items-center>div>div>p:nth-child(1) {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <?php
    $sql = "SELECT * FROM user_table WHERE username='" . $_SESSION['username'] . "'";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        ?>

        <nav class="navbar navbar-expand-lg navbar-light bg-light m-0 p-0">
            <div
                class="container-fluid ms-0 ms-md-3 d-flex align-items-center justify-content-space justify-content-md-between d-lg-none w-100">
                <div>
                    <a id="off_nav_button" class="btn btn-light" data-bs-toggle="offcanvas" href="#offcanvasExample"
                        role="button" aria-controls="offcanvasExample">
                        <span class="navbar-toggler-icon" style="width:15px"></span>
                    </a>

                    <a id="img" class="navbar-brand" href="admin.php">
                        <img src="img/LOGOO.png" alt="YsakaLogo" class="d-inline-block" style="width: 110px">
                    </a>
                </div>

                <div class="off d-lg-none my-2">
                    <button id="notif_button" class="btn p-1" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasRightSmall" aria-controls="offcanvasRightSmall" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="Notifications">
                        <div class="orders">

                            <div class="order_button">
                                <i class='bx bxs-bell'></i>
                            </div>
                        </div>
                    </button>

                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRightSmall"
                        aria-labelledby="offcanvasRightLabelSmall">
                        <div class="offcanvas-header">
                            <h5 id="offcanvasRightLabelSmall">Notifications</h5>
                            <button id="btn-close" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <?php
                            $notifs = mysqli_query($conn, "SELECT * FROM notification_table WHERE  to_admin = '1' ORDER BY date desc");
                            while ($notif = mysqli_fetch_assoc($notifs)) {
                                $date = date("F j, Y, g:i a", strtotime($notif["date"]));
                                $user_id = $notif["user_id"]; // Assuming you have an order_id field in the notification_table
                                $title = $notif["title"];

                                ?>
                                <a href="admin_order.php" style="text-decoration: none;">
                                    <div class="notification_section">
                                        <div class="notif_container">
                                            <div class="notif_title d-flex align-content-center justify-content-between">
                                                <p class="m-0"><?php echo $notif["title"]; ?></p>
                                                <p class="m-0 mt-1" style="font-size: 15px"><?php echo $date; ?></p>
                                            </div>
                                            <div class="notif_message">
                                                <p class="m-0 ms-2">Order #: <?php echo $notif['order_number']; ?></p>
                                                <p class="ms-2"><?php echo $notif["description"]; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php } ?>
                        </div>

                    </div>

                </div>
            </div>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <div id="offcanvasExampleLabel"
                        class="offcanvas-title d-flex flex-row align-items-center justify-content-center justify-content-md-end me-2">
                        <div class="btn-group">
                            <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <div class="user-off">
                                    <div class="photo ms-2 me-1">
                                        <img src="profile_picture/<?php echo $row['image_file'] ?>" alt="">
                                    </div>
                                    <div class="name ms-1 mt-1">
                                        <p><?php echo $_SESSION['username'] ?></p>
                                    </div>
                                </div>
                            </button>
                            <ul class="dropdown-menu p-2">
                                <li>
                                    <div class="drop_items ">
                                        <a class="ms-2 mt-3" href="admin_setting.php">Account</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="drop_items ">
                                        <a class="ms-2 mt-3" href="add_admin_form.php">Add Admin</a>
                                    </div>
                                </li>
                                <li>
                                    <div id="log_out" class="drop_items">
                                        <form action="logout.php" method="post">
                                            <button id="log_out_button" type="submit" name="logout"
                                                class="btn p-0 ps-2 text-start">Log
                                                out</button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav nav-fill gap-2 p-0">
                        <li class="nav-item ps-3 ">
                            <a class="nav-link text-dark text-start" href="admin.php">Home</a>
                        </li>
                        <li class="nav-item ps-3">
                            <a class="nav-link text-dark text-start" href="admin_products.php">Product</a>
                        </li>
                        <li class="nav-item ps-3 active">
                            <a class="nav-link text-dark text-start" href="admin_order.php">Orders</a>
                        </li>
                        <li class="nav-item ps-3">
                            <a class="nav-link text-dark text-start" href="admin_sale_report.php">Sale Report</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div
                class="container-fluid ms-0 ms-md-3 d-none d-md-flex align-items-center justify-content-space justify-content-md-between">
                <a id="img" class="navbar-brand" href="admin.php">
                    <img src="img/LOGOO.png" alt="YsakaLogo" class="d-lg-inline-block float-start d-none"
                        style="width: 110px">
                </a>

                <div class="container navbar-collapse d-flex d-md-none" id="navbarNav">
                    <ul class="navbar-nav nav-fill gap-2 p-0">
                        <li class="nav-item">
                            <a class="nav-link text-dark " href="admin.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="admin-products.php">Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark active" href="admin_order.php">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="admin_sale_report.php">Sale Report</a>
                        </li>

                    </ul>
                </div>

                <div class="right_nav d-none d-lg-flex">
                    <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRightLarge"
                        aria-controls="offcanvasRightLarge" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        title="Notifications">
                        <div class="orders">

                            <div class="order_button">
                                <i class='bx bxs-bell'></i>
                            </div>
                        </div>
                    </button>

                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRightLarge"
                        aria-labelledby="offcanvasRightLabelLarge">
                        <div class="offcanvas-header">
                            <h5 id="offcanvasRightLabelLarge">Notifications</h5>
                            <button id="btn-close" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <?php
                            $notifs = mysqli_query($conn, "SELECT * FROM notification_table WHERE  to_admin = '1' ORDER BY date desc");
                            while ($notif = mysqli_fetch_assoc($notifs)) {
                                $date = date("F j, Y, g:i a", strtotime($notif["date"]));
                                $user_id = $notif["user_id"]; // Assuming you have an order_id field in the notification_table
                                $title = $notif["title"];

                                ?>
                                <a href="admin_order.php" style="text-decoration: none;">
                                    <div class="notification_section">
                                        <div class="notif_container">
                                            <div class="notif_title d-flex align-content-center justify-content-between">
                                                <p class="m-0"><?php echo $notif["title"]; ?></p>
                                                <p class="m-0 mt-1" style="font-size: 15px"><?php echo $date; ?></p>
                                            </div>
                                            <div class="notif_message">
                                                <p class="m-0 ms-2">Order #: <?php echo $notif['order_number']; ?></p>
                                                <p class="ms-2"><?php echo $notif["description"]; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="btn-group">
                        <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="user">
                                <div class="name">
                                    <p class="text-end mt-1"><?php echo $_SESSION['username'] ?></p>
                                </div>
                                <div class="photo">
                                    <img src="profile_picture/<?php echo $row['image_file'] ?>" alt="">
                                </div>
                            </div>
                        </button>
                        <ul class="dropdown-menu p-2">
                            <li>
                                <div class="drop_items ">
                                    <a class="me-2" href="admin_setting.php">Account</a>
                                </div>
                            </li>
                            <li>
                                <div class="drop_items ">
                                    <a class="w-100 me-2 text-end" href="add_admin_form.php">Add Admin</a>
                                </div>
                            </li>
                            <li>
                                <div id="log_out" class="drop_items ">
                                    <form action="logout.php" method="post">
                                        <button type="submit" name="logout" class="btn p-0 py-1 text-end pe-2">Log
                                            out</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

    <?php } ?>
    <div class="chat">
        <a href="chat_system\admin\">
            <button value=" <?php echo $row['chatroomid']; ?>" type="button" class="btn  border-0"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
                <img src="img\chat_icon.png" />
            </button>
        </a>
    </div>

    <?php
    $sql = "
    SELECT o.*, 
        GROUP_CONCAT(vc.option SEPARATOR ', ') AS variant_options
    FROM order_items o
    LEFT JOIN variant_content vc ON FIND_IN_SET(vc.variant_content_id, o.variant_content_ids)
    WHERE o.status = 'Shipped'
    GROUP BY o.order_number
    ORDER BY o.order_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();


    ?>
    <div id="container" class="container-fluid-sm container-md rounded mb-3 mt-3 p-3">
        <div id="order_nav" class="p-2 rounded">
            <a class="order_nav_a" href="admin_order.php">For Confirmation</a>
            <a class="order_nav_a " href="admin_order_to_ship.php">To Ship</a>
            <a class="order_nav_a active" href="admin_order_shipped.php">Shipped</a>
            <a class="order_nav_a" href="admin_order_delivered.php">Delivered</a>
        </div>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($order = $result->fetch_assoc()): ?>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                    <input type="hidden" name="status" value="<?php echo $order['status']; ?>">
                    <input type="hidden" name="order_number" value="<?php echo $order['order_number']; ?>">
                    <a
                        href="admin_order_status.php?order_id=<?php echo $order['order_id']; ?>&status=<?php echo $order['status']; ?>&user_id=<?php echo $order['user_id']; ?>&order_number=<?php echo $order['order_number']; ?>"><input
                            type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                        <div id="order_item" class="rounded mt-3 p-2">
                            <div id="order_head" class="container w-100 mb-2 p-2 me-0">
                                <h5 class="m-0">Order ID: <?php echo $order['order_number']; ?></h5>
                                <input type="hidden" name="user_id" value="<?php echo $order['user_id']; ?>">
                                <input type="hidden" name="title" value="Order Delivered">
                                <input type="hidden" name="description"
                                    value="Your Order has been Delivered by the Seller. Click for more details">
                                <input type="hidden" name="status" value="Unread">

                                <button type="submit" class="btn btn-success" name="confirm_order">Confirm</button>
                            </div>

                            <!-- Display product details -->
                            <div id="product_details"
                                class="w-100 rounded border d-flex justify-content-between align-items-center p-2">
                                <div class="product_image d-flex justify-content-center align-items-center">
                                    <img src="product-images/<?php echo $order['image_file']; ?>" alt="" class="rounded me-2">
                                    <div class="product_variation">
                                        <h5><?php echo $order['product_name'] . ' | ' . $order['variant_options']; ?></h5>
                                        <div class="product_variation">
                                            <p>Quantity: <?php echo $order['quantity']; ?></p>
                                            <p>Price: ₱ <?php echo number_format($order['price'], 2); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div id="product_description">
                                    <div class="container d-flex align-items-center justify-content-center p-0">
                                        <p id="price" class="me-2 mt-2 mb-0">₱
                                            <?php echo number_format($order['price'] * $order['quantity'], 2); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Display total price -->
                            <div class="container d-flex align-items-center justify-content-end p-2 pt-3 pe-3">
                                <p class="m-0">Total: </p>
                                <h5 id="price" class="ms-2 m-0">₱
                                    <?php echo number_format($order['total'], 2); ?>
                                </h5>
                            </div>
                        </div>
                    </a>
                </form>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="container rounded d-flex align-items-center justify-content-center p-2 bg-light mt-3 text-center"
                style="height: 550px;">
                <h5>Empty Order.</h5>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <div class="footer_content flex-wrap flex-lg-nowrap">
            <div class="footer_logo">
                <img id="footer-logo" src="img\LOGO.png" alt="">
            </div>
            <div class="footer_details">
                <h4>SOCIALS</h4>
                <div class="socials">
                    <a href="#">
                        <p><i class='bx bxl-facebook-circle'></i>Facebook</p>
                    </a>
                    <a href="#">
                        <p><i class='bx bxl-tiktok'></i>Tiktok</p>
                    </a>
                    <a href="#">
                        <p><i class='bx bxl-instagram-alt'></i>Instagram</p>
                    </a>
                </div>
                <div class="copyright">
                    <p><i class='bx bx-copyright'></i>2021 Jessa Mae O. Figueroa | All Rights Reserve</p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>