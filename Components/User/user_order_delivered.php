<?php
include("../../sessionchecker.php");
include("../../connection.php");
include("Layout/UserHeader.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #container a {
            text-decoration: none;
            color: black;
        }

        #shipping_information {
            background-color: white;
        }

        #shipping_information_text {
            color: rgb(0, 208, 139);
        }

        #payment_details_text,
        #address_details {
            color: gray;
        }

        #address {
            background-color: white;
        }

        #address_head {
            /* background-color: gray; */
        }

        #order_nav {
            display: flex;
            align-items: center;
            justify-content: space-around;
            /* flex-direction: column; */
            background-color: white;
        }

        #order_nav a {
            text-decoration: none;
            color: black;
            width: 100%;
        }

        .order_nav_a:hover,
        .order_nav_a.active {
            background-color: var(--main_color);
        }

        .order_nav_a {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
            margin-right: 5px;
            border-radius: 5px;
            padding-top: 5px;
            padding-bottom: 5px;
            transition: 0.2s;
        }

        #order_item {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: white;
        }

        #order_head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* background-color: gray; */
        }

        #product_details {
            /* background-color: gray; */
        }

        .product_image img {
            width: 100px;
            height: 100px;
        }

        #product_description {
            margin-top: 65px;
            /* width: 100%; */
            /* display: flex;
  align-items: center;
  justify-content: space-between; */
            /* background-color: rgb(104, 104, 104); */
        }

        #price {
            color: var(--ter_color);
        }

        #payment_details {
            background-color: white;
        }

        #total_payment {
            color: var(--ter_color);
        }
    </style>
</head>

<body>
    <?php
    $active = "orders";
    include("Layout\UserNavBar.php");
    include("Layout\UserChat.php");
    ?>
    <?php
    $user_id = $_SESSION['user_id'];
    $sql = "
    SELECT o.*, 
           GROUP_CONCAT(vc.option SEPARATOR ', ') AS variant_options
    FROM order_items o
    LEFT JOIN variant_content vc ON FIND_IN_SET(vc.variant_content_id, o.variant_content_ids)
    WHERE o.user_id = ? AND o.status = 'Delivered'
    GROUP BY o.order_id
    ORDER BY delivered_date DESC
";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <div id="container" class="container-fluid-sm container-md rounded mb-3 mt-3 p-3" style="min-height: 700px;">
        <div id="order_nav" class="p-2 rounded">
            <a class="order_nav_a " href="user_order.php">For Confirmation</a>
            <a class="order_nav_a " href="user_order_to_ship.php">To Ship</a>
            <a class="order_nav_a " href="user_order_shipped.php">Shipped</a>
            <a class="order_nav_a active" href="user_order_delivered.php">Delivered</a>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($order = $result->fetch_assoc()): ?>

                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                <input type="hidden" name="order_number" value="<?php echo $order['order_number']; ?>">
                <input type="hidden" name="status" value="<?php echo $order['status']; ?>">
                <a
                    href="user_order_status.php?order_id=<?php echo $order['order_id']; ?>&status=<?php echo $order['status']; ?>&user_id=<?php echo $order['user_id']; ?>&order_number=<?php echo $order['order_number']; ?>">
                    <div id="order_item" class="rounded mt-3 p-2">
                        <div id="order_head" class="container w-100 mb-2 p-2 me-0">
                            <h5 class="m-0">Order ID: <?php echo $order['order_number']; ?></h5>
                            <p id="shipping_information_text" class="m-0 text-end">The order/s has been delivered.</p>
                        </div>

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
            <?php endwhile; ?>
            <div class="container rounded d-flex align-items-center justify-content-center p-2 bg-light mt-3 text-center"
                style="height: 200px;">
                <h5>Check out more products <a href="user_products.php" style="color: #4d88ff
;">here.</a></h5>
            </div>
        <?php else: ?>
            <div class="container rounded d-flex align-items-center justify-content-center p-2 bg-light mt-3 text-center"
                style="height: 550px;">
                <h5>Empty Order. Check our products <a href="user_products.php" style="color: #4d88ff
;">here.</a></h5>
            </div>
        <?php endif; ?>
    </div>

    <?php
    $stmt->close();
    $conn->close();
    ?>
    <?php
    include("Layout\UserFooter.php");
    ?>
</body>

</html>