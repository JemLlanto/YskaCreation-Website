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

                <a id="img" class="navbar-brand" href="user_landing_page.php">
                    <img src="../../img/LOGOO.png" class="d-inline-block" style="width: 110px">
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
                        $notifs = mysqli_query($conn, "SELECT * FROM notification_table WHERE user_id = '" . $_SESSION["user_id"] . "' AND to_admin = '0' ORDER BY date desc");
                        while ($notif = mysqli_fetch_assoc($notifs)) {
                            $date = date("F j, Y, g:i a", strtotime($notif["date"]));
                            $user_id = $notif["user_id"]; // Assuming you have an order_id field in the notification_table
                            $title = $notif["title"];

                            // Determine the URL based on the title
                            $url = "#";
                            if ($title == "Order Placed") {
                                $url = "user_order.php";
                            } elseif ($title == "Order Cancelled") {
                                $url = "user_order.php";
                            } elseif ($title == "Order Confirm") {
                                $url = "user_order_to_ship.php";
                            } elseif ($title == "Order Shipped") {
                                $url = "user_order_shipped.php";
                            } elseif ($title == "Order Delivered") {
                                $url = "user_order_delivered.php";
                            }
                            ?>
                            <a href="<?php echo $url; ?>" style="text-decoration: none;">
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
        </div>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <div id="offcanvasExampleLabel"
                    class="offcanvas-title d-flex flex-row align-items-center justify-content-center justify-content-md-end me-2">
                    <div class="btn-group">
                        <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="user-off">
                                <div class="photo ms-2 me-1">
                                    <img src="../../profile_picture/<?php echo $row['image_file'] ?>" alt="">
                                </div>
                                <div class="name ms-1 mt-1">
                                    <p><?php echo $_SESSION['username'] ?></p>
                                </div>
                            </div>
                        </button>
                        <ul class="dropdown-menu p-2">
                            <li>
                                <div class="drop_items ">
                                    <a class="ms-2 mt-3" href="user_setting.php">Account</a>
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
                    <li class="nav-item ps-3 active">
                        <a class="nav-link text-dark text-start" href="user_landing_page.php">Home</a>
                    </li>
                    <li class="nav-item ps-3">
                        <a class="nav-link text-dark text-start" href="user_products.php">Product</a>
                    </li>
                    <li class="nav-item ps-3">
                        <a class="nav-link text-dark text-start" href="user_cart.php">Cart</a>
                    </li>
                    <li class="nav-item ps-3">
                        <a class="nav-link text-dark text-start" href="user_order.php">Orders</a>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="container-fluid ms-0 ms-md-3 d-none d-md-flex align-items-center justify-content-space justify-content-md-between">
            <a id="img" class="navbar-brand" href="user_landing_page.php">
                <img src="../../img/LOGOO.png" class="d-lg-inline-block float-start d-none" style="width: 110px">
            </a>


            <div class="container navbar-collapse d-flex d-md-none" id="navbarNav">
                <ul class="navbar-nav nav-fill gap-2 p-0">
                    <li class="nav-item">
                        <a class="nav-link text-dark<?php if ($active == 'home')
                            echo ' active'; ?>"
                            href="user_landing_page.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark<?php if ($active == 'product')
                            echo ' active'; ?>"
                            href="user_products.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark<?php if ($active == 'cart')
                            echo ' active'; ?>"
                            href="user_cart.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark<?php if ($active == 'orders')
                            echo ' active'; ?>"
                            href="user_order.php">Orders</a>
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
                        $notifs = mysqli_query($conn, "SELECT * FROM notification_table WHERE user_id = '" . $_SESSION["user_id"] . "' AND to_admin = '0' ORDER BY date desc");
                        while ($notif = mysqli_fetch_assoc($notifs)) {
                            $date = date("F j, Y, g:i a", strtotime($notif["date"]));
                            $user_id = $notif["user_id"]; // Assuming you have an order_id field in the notification_table
                            $title = $notif["title"];

                            // Determine the URL based on the title
                            $url = "#";
                            if ($title == "Order Placed") {
                                $url = "user_order.php";
                            } elseif ($title == "Order Cancelled") {
                                $url = "user_order.php";
                            } elseif ($title == "Order Confirm") {
                                $url = "user_order_to_ship.php";
                            } elseif ($title == "Order Shipped") {
                                $url = "user_order_shipped.php";
                            } elseif ($title == "Order Delivered") {
                                $url = "user_order_delivered.php";
                            }
                            ?>
                            <a href="<?php echo $url; ?>" style="text-decoration: none;">
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
                                <img src="../../profile_picture/<?php echo $row['image_file'] ?>" alt="">
                            </div>
                        </div>
                    </button>
                    <ul class="dropdown-menu p-2">
                        <li>
                            <div class="drop_items ">
                                <a class="me-2" href="user_setting.php">Account</a>
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