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
    ?>
    <?php
    $sql = "SELECT * FROM user_table WHERE username='" . $_SESSION['username'] . "'";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        ?>

        <?php

        // Retrieve parameters
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $order_number = isset($_GET['order_number']) ? $_GET['order_number'] : 0;
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

        $items = [];
        if ($order_id && $status) {

            $sql = "SELECT oi.*, 
                   GROUP_CONCAT(vc.option SEPARATOR ', ') AS variant_options
            FROM order_items oi
            LEFT JOIN variant_content vc ON FIND_IN_SET(vc.variant_content_id, oi.variant_content_ids)
            WHERE oi.user_id = ? AND oi.order_number = ? AND oi.status = ?
            GROUP BY oi.order_id";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("iss", $user_id, $order_number, $status);
                $stmt->execute();
                $result = $stmt->get_result();
                $items = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
            } else {
                echo "Error: " . $conn->error;
            }
        }

        if (isset($_POST['selected_items']) && !empty($_POST['selected_items'])) {
            $selectedItems = json_decode($_POST['selected_items'], true);
            $totalPrice = 0;
            ?>

            <div id="payment_details"
                class="container rounded d-flex justify-content-start align-items-start flex-column mb-2 p-3">
                <div class="mb-3">
                    <h5>Payment Details</h5>
                </div>
                <div class="w-100 d-flex align-items-center justify-content-between">
                    <p id="payment_details_text" class="m-0 ms-2">Merchandise Subtotal</p>
                    <p id="payment_details_text" class="m-0 me-2">₱ <?php echo number_format($totalPrice, 2); ?></p>
                </div>
                <div class="w-100 d-flex align-items-center justify-content-between">
                    <p id="payment_details_text" class="m-0 ms-2">Shipping Subtotal (Luzon/Visayas/Mindanao)</p>
                    <p id="payment_details_text" class="m-0 me-2">₱ 00.00</p>
                </div>
                <div class="w-100 d-flex align-items-center justify-content-between mt-3">
                    <h5 class="ms-2">Total Payment</h5>
                    <h5 id="total_payment" class="me-2">₱ <?php echo number_format($totalPrice, 2); ?></h5>
                </div>
            </div>

            <div id="place_order" class="w-100 rounded d-flex align-items-center justify-content-end">
                <div>
                    <p class="m-0">Total Payment</p>
                    <h5 id="price" class="m-0">₱ <?php echo number_format($totalPrice, 2); ?></h5>
                </div>
                <button id="place_order_button" type="button" class="btn py-3 px-4 ms-2" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Place Order
                </button>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Payment via GCASH</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="payment" class="d-flex flex-column align-items-center p-2">
                                    <div>
                                        <p>Scan the QR code to pay</p>
                                    </div>
                                    <div>
                                        <img src="img/Gcash-BMA-QRcode-768x1024.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form action="user-order-form.php" method="post">
                                    <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">
                                    <input type="hidden" name="title" value="Order Placed">
                                    <input type="hidden" name="selected_items" id="selected_items"
                                        value='<?php echo json_encode($selectedItems); ?>'>
                                    <input type="hidden" name="description"
                                        value="Your Order has been placed successfully. Click for more details">
                                    <input type="hidden" name="status" value="Unread">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button id="done_button" type="submit" class="btn btn-primary">Done</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        // Check if there are items
        if ($items): ?>
            <div id="container" class="container-fluid-sm container-md rounded mb-3 mt-3 p-3">
                <div id="shipping_information"
                    class="container rounded d-flex justify-content-start align-items-start flex-column mt-3 p-3">
                    <div class="w-100 mb-3 d-flex align-items-center justify-content-between py-2">
                        <h5 class="m-0">Shipping Information</h5>
                        <p id="shipping_information_text" class="m-0">
                            <?php
                            switch ($status) {
                                case 'Pending':
                                    echo "Waiting for Seller's confirmation";
                                    break;
                                case 'Shipping':
                                    echo 'The seller is preparing the order/s.';
                                    break;
                                case 'Shipped':
                                    echo 'The order/s has been shipped.';
                                    break;
                                case 'Delivered':
                                    echo 'The order/s has been delivered.';
                                    break;
                                default:
                                    echo 'Unknown status';
                                    break;
                            }
                            ?>
                        </p>
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-between">
                        <p id="payment_details_text" class="m-0 ms-2">Order ID</p>
                        <p id="payment_details_text" class="m-0 me-2">
                            <?php echo htmlspecialchars($items[0]['order_number']); ?>
                        </p>
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-between">
                        <p id="payment_details_text" class="m-0 ms-2">Order Time</p>
                        <p id="payment_details_text" class="m-0 me-2">
                            <?php echo date('m/d/Y H:i:s', strtotime($items[0]['order_date'])); ?>
                        </p>
                    </div>
                </div>

                <div id="shipping_address" class="container rounded mt-3 p-3 bg-light">
                    <div id="address_head" class="w-100 d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="m-0">
                                <img id="location_icon" class="mb-1 me-1" src="img/location.png" alt="">
                                Delivery Address
                            </h5>
                        </div>
                    </div>
                    <div id="address_details" class="d-flex flex-column align-items-start ms-4 mt-2">
                        <p class="m-0 mb-1 ms-2"> <?php echo $row['first_name'] . ' ' . $row['last_name']; ?> |
                            <?php echo $row['phone']; ?>
                        </p>
                        <p class="ms-2 me-2">
                            <?php echo $row['blockLot'] . ' ' . $row['subdivision'] . ', ' . $row['barangay'] . ', ' . $row['province'] . ', ' . $row['city'] . ' ' . $row['zip']; ?>
                        </p>
                    </div>
                </div>

                <?php
                $totalPrice = 0;
                foreach ($items as $item):
                    $totalPrice += $item['price'] * $item['quantity'];
                    ?>
                    <div id="order_item" class="rounded mt-3 p-2">
                        <div id="product_details" class="w-100 rounded d-flex justify-content-between align-items-center p-2">
                            <div class="product_image d-flex justify-content-center align-items-center">
                                <img src="../../product-images/<?php echo $item['image_file']; ?>" alt="" class="rounded me-2">
                                <div class="product_variation">
                                    <h5><?php echo $item['product_name'] . ' | ' . $item['variant_options']; ?></h5>
                                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                                    <p> <?php echo number_format($item['price'], 2); ?></p>
                                </div>
                            </div>
                            <div id="product_description">
                                <div class="container d-flex align-items-center justify-content-center p-0">
                                    <p id="price" class="me-2 mt-2 mb-0">
                                        ₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $shippingCost = 150;
                    $totalPayment = $totalPrice + $shippingCost;
                endforeach; ?>


                <div id="payment_details"
                    class="container rounded d-flex justify-content-start align-items-start flex-column mt-3 mb-2 p-3">
                    <div class="mb-3">
                        <h5>Payment Details</h5>
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-between">
                        <p id="payment_details_text" class="m-0 ms-2">Merchandise Subtotal</p>
                        <p id="payment_details_text" class="m-0 me-2">₱<?php echo number_format($totalPrice, 2); ?></p>
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-between">
                        <p id="payment_details_text" class="m-0 ms-2">Shipping Subtotal (
                            <b><?php echo $row['island_group']; ?></b> )
                        </p>
                        <p id="payment_details_text" class="m-0 me-2">₱ <?php echo number_format($shippingCost, 2); ?></p>
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-between mt-3">
                        <h5 class="ms-2">Total Payment</h5>
                        <h5 id="total_payment" class="me-2">₱<?php echo number_format($totalPayment, 2); ?></h5>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div id="empty_order"
                class="container rounded p-2 text-center d-flex align-items-center justify-content-center bg-light mt-1"
                style="height: 150px">
                <h5>Empty Order.</h5>
            </div>
        <?php endif; ?>
    <?php }
    ?>

    <?php
    include("Layout\UserFooter.php");
    ?>

</body>

</html>