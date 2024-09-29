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
        #container {
            background-color: white;
        }

        #address {
            background-color: var(--body_color);
        }

        #address_head {
            width: 100%;
        }

        #address_details {
            /* background-color: gray; */
        }

        #change_address {
            border: none;
            background-color: transparent;
        }

        #change_address_button {
            background-color: white;
        }

        #location_icon {
            width: 20px;
        }

        #cart_item {
            /* background-color: var(--body_color); */
        }

        #product_description {
            /* background-color: gray; */
            /* width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between; */
        }

        .product_image img {
            width: 70px;
        }

        #product_details {
            /* background-color: gray; */
        }

        #payment_details {
            background-color: var(--body_color);
        }

        #total_payment {
            color: var(--ter_color);
        }

        #place_order_button {
            color: white;
            background-color: var(--ter_color);
            font-size: 20px;
        }

        #payment_details_text {
            color: gray;
        }

        #price {
            color: var(--ter_color);
        }

        #done_button {
            background-color: var(--ter_color);
            color: white;
            border: none;
        }

        #payment img {
            width: 300px;
        }
    </style>
</head>

<body>
    <?php
    $active = "cart";
    include("Layout\UserNavBar.php");
    include("Layout\UserChat.php");
    ?>
    <?php
    $sql = "SELECT * FROM user_table WHERE username='" . $_SESSION['username'] . "'";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        ?>


        <div id="container" class="container-fluid-sm container-md rounded d-flex flex-column mb-3 mt-3 p-3">
            <div id="address" class="container rounded d-flex justify-content-start align-items-start flex-column mb-2 p-2">
                <div id="address_head" class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5><img id="location_icon" class="mb-1 me-1" src="img/location.png" alt="">Delivery Address</h5>
                    </div>
                    <div id="change_address_button" class="rounded">
                        <a href="user_setting.php"><button id="change_address" class="border rounded p-2">Edit delivery
                                details</button></a>
                    </div>
                </div>
                <div id="address_details" class="d-flex flex-column align-items-start ms-4 mt-2">
                    <p id="payment_details_text" class="m-0 mb-1 ms-2">
                        <?php echo $row['first_name'] . ' ' . $row['last_name']; ?> | <?php echo $row['phone']; ?>
                    </p>
                    <p id="payment_details_text" class="ms-2 me-2">
                        <?php echo $row['blockLot'] . ' ' . $row['subdivision'] . ', ' . $row['barangay'] . ', ' . $row['province'] . ', ' . $row['city'] . ' ' . $row['zip']; ?>
                    </p>
                </div>
            </div>

            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (isset($_POST['selected_items']) && !empty($_POST['selected_items'])) {
                $selectedItems = json_decode($_POST['selected_items'], true);
                $totalPrice = 0;
                $user_id = $_SESSION['user_id'];

                foreach ($selectedItems as $order_id) {
                    $sql = "
                SELECT o.*, GROUP_CONCAT(vc.option SEPARATOR ', ') AS variant_options
                FROM order_table o
                LEFT JOIN variant_content vc ON FIND_IN_SET(vc.variant_content_id, o.variant_content_ids)
                WHERE o.user_id = $user_id AND o.order_id = $order_id
                GROUP BY o.order_id
            ";
                    $result = $conn->query($sql);
                    if ($item = $result->fetch_assoc()):
                        ?>
                        <div id="product_details" class="w-100 rounded border d-flex justify-content-between align-items-end mb-2 p-2">
                            <div class="product_image d-flex justify-content-center align-items-center">
                                <img src="../../product-images/<?php echo $item['image_file']; ?>" alt="" class="rounded me-2">
                                <div class="m-0">
                                    <h5><?php echo $item['product_name'] . ' | ' . $item['variant_options']; ?></h5>
                                    <p>Php <?php echo number_format($item['price'], 2); ?> </p>
                                </div>
                            </div>
                            <div id="product_description">
                                <div class="container p-0">
                                    <p id="price" class="me-2 mt-2 mb-0 text-end">₱
                                        <?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                        $totalPrice += $item['price'] * $item['quantity'];
                    endif;
                }

                $shippingCost = 150;
                $totalPayment = $totalPrice + $shippingCost;
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
                        <p id="payment_details_text" class="m-0 ms-2">Shipping Subtotal (
                            <b><?php echo $row['island_group']; ?></b> )
                        </p>
                        <p id="payment_details_text" class="m-0 me-2">₱ <?php echo number_format($shippingCost, 2); ?></p>
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-between mt-3">
                        <h5 class="ms-2">Total Payment</h5>
                        <h5 id="total_payment" class="me-2">₱ <?php echo number_format($totalPayment, 2); ?></h5>
                    </div>
                </div>

                <div id="place_order" class="w-100 rounded d-flex align-items-center justify-content-end">
                    <div>
                        <p class="m-0">Total Payment</p>
                        <h5 id="price" class="m-0">₱ <?php echo number_format($totalPayment, 2); ?></h5>
                    </div>
                    <button id="place_order_button" type="button" class="btn py-3 px-4 ms-2" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Place Order
                    </button>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
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
                                            <img src="../../img/Gcash.jpeg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <form action="user-order-form.php" method="post">
                                        <input type="hidden" name="totalPrice" value="<?php echo $totalPayment; ?>">
                                        <input type="hidden" name="title" value="Order Placed">
                                        <input type="hidden" name="selected_items" id="selected_items"
                                            value='<?php echo json_encode($selectedItems); ?>'>
                                        <input type="hidden" name="description"
                                            value="Your Order has been placed successfully. Click for more details">
                                        <input type="hidden" name="status" value="Unread">

                                        <input type="hidden" name="a_title" value="New Order">
                                        <input type="hidden" name="a_description"
                                            value="New order from <?php echo $_SESSION['username']; ?>. Click for more details">
                                        <input type="hidden" name="to_admin" value="1">

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
    } ?>
    </div>

    <?php
    include("Layout\UserFooter.php");
    ?>

</body>

</html>