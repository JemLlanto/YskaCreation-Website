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
            /* height: 80dvh; */
            /* width: 90%; */
            background: white;
            border-radius: 10px;
        }

        #container a {
            text-decoration: none;
        }

        #select_all {
            /* height: 40px; */
            /* padding: 5px; */

            /* justify-content: center; */
            background-color: var(--body_color);
            /* margin-bottom: 10px; */
            /* border-radius: 5px; */
        }

        #price {
            color: var(--ter_color);
        }

        #check_out {
            border: none;
            background-color: var(--ter_color);
            color: white;
        }

        .cart_item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* justify-content: space-between; */
            /* flex-wrap: nowrap; */
            /* flex-direction: row; */
            width: 100%;
            background-color: var(--body_color);
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 5px;
        }

        #product_details {
            display: flex;
            /* width: 80%; */
            /* margin-top: 10px; */

            /* height: 35px; */
        }

        .product_details p {
            color: rgb(0, 0, 0);
        }

        .check_box {
            /* height: 100%; */
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            background-color: white;
            margin-right: 10px;
            border-radius: 5px;
            /* border: 1px solid var(--main_border); */
        }

        .product_image {
            overflow: hidden;
            border-radius: 5px;
            width: 150px;
            margin-right: 10px;
        }

        .product_image img {
            width: 150px;
            margin-right: 10px;
        }

        /* .product_variation {
  background-color: gray;
}
#product_price {
  background-color: gray;
} */
        .product_description {
            padding-left: 5px;
            /* width: 35dvw; */
            /* background-color: gray; */
        }

        .product_description h5 {
            color: black;
            margin-top: 5px;
        }

        .edit_delete {
            width: 0%;
            display: flex;
            justify-content: end;
            /* background-color: gray; */
        }

        .edit_button {
            /* right: 0; */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .edit_button a {
            text-decoration: none;
            color: black;
        }

        .edit_button button {
            height: 150px;
            width: 50px;
            background-color: var(--main_color);
            border-radius: 5px;
            border: none;
        }

        .delete_button button {
            height: 150px;
            width: 50px;
            background-color: var(--ter_color);
            border-radius: 5px;
            border: none;
            color: white;
        }

        #empty_cart {
            background-color: var(--body_color);
            height: 350px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #empty_cart h5 {
            color: var(--main_border);
        }
    </style>
</head>

<body>

    <?php
    $active = "cart";
    include("Layout\UserNavBar.php");
    include("Layout\UserChat.php");
    ?>

    <div id="container" class="container-fluid-sm container-md d-flex flex-column mb-3 mt-3 p-3"
        style="min-height: 650px;">
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION['user_id'];
        $sql = "
        SELECT o.*, 
               GROUP_CONCAT(vc.option SEPARATOR ', ') AS variant_options
        FROM order_table o
        LEFT JOIN variant_content vc ON FIND_IN_SET(vc.variant_content_id, o.variant_content_ids)
        WHERE o.user_id = $user_id
        GROUP BY o.order_id
    ";

        $result = $conn->query($sql);

        ?>

        <div id="container" class="container-fluid-sm container-md d-flex flex-column mb-3 mt-3 p-3"
            style="min-height: 650px;">
            <?php if ($result->num_rows > 0): ?>
                <div id="select_all"
                    class="container rounded p-2 mb-2 ps-2 d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center ps-2">
                        <input type="checkbox" name="selectAllCheckbox" id="selectAllCheckbox">
                        <label for="selectAllCheckbox" class="ms-2 py-3">Select All</label>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="me-3 d-flex flex-column align-items-end justify-content-start">
                            <p class="m-0">Total</p>
                            <h5 id="price" class="m-0">₱ 0.00</h5>
                        </div>
                        <form id="checkoutForm" action="user_check_out.php" method="post">
                            <input type="hidden" name="selected_items" id="selected_items">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                            <?php endwhile; ?>
                            <button id="check_out" class="py-3 p-2 rounded">Check Out</button>
                        </form>
                    </div>
                </div>
                <?php
                $result->data_seek(0);
                while ($item = $result->fetch_assoc()):
                    ?>
                    <div class="cart_item">
                        <div id="product_details">
                            <div class="check_box">
                                <input type="checkbox" class="itemCheckbox" data-index="<?php echo $item['order_id']; ?>"
                                    data-price="<?php echo $item['price'] * $item['quantity']; ?>">
                            </div>
                            <div class="product_image">
                                <img src="../../product-images/<?php echo $item['image_file']; ?>" alt="Product Image">
                            </div>
                            <div class="product_description">
                                <h5><?php echo $item['product_name'] . ' | ' . $item['variant_options']; ?></h5>
                                <div class="product_variation">
                                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                                    <p>Price: ₱ <?php echo number_format($item['price'], 2); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="edit_delete">
                            <div class="edit_button">
                                <a
                                    href="user_product_update.php?product_id=<?php echo $item['product_id']; ?>&order_id=<?php echo $item['order_id']; ?>">
                                    <button>Edit</button>
                                </a>
                            </div>
                            <div class="delete_button ms-2">
                                <form action="delete-from-cart.php" method="post">
                                    <input type="hidden" name="order_id" value="<?php echo $item['order_id']; ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <div class="cart_item d-flex align-self-center justify-content-center" style="height:50dvh;">
                    <h5>Click <a href="user_products.php">here</a> for more products.</h5>
                </div>
            <?php else: ?>
                <div id="select_all"
                    class="container rounded p-2 mb-2 ps-2 d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center ps-2">
                        <input type="checkbox" id="selectAllCheckbox">
                        <p class="ms-2 mt-3">Select All</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="me-3 d-flex flex-column align-items-end justify-content-start">
                            <p class="m-0">Total</p>
                            <h5 id="price" class="m-0">₱ 0.00</h5>
                        </div>
                        <a href="user_check_out.php"><button id="check_out" class="py-3 p-2 rounded" disabled>Check
                                Out</button></a>
                    </div>
                </div>
                <div id="empty_cart" class="container rounded p-2">
                    <h5>Your cart is empty. Order <a href="user_products.php">here</a>.</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const selectAllCheckbox = document.getElementById("selectAllCheckbox");
            const itemCheckboxes = document.querySelectorAll(".itemCheckbox");
            const checkoutForm = document.getElementById("checkoutForm");
            const selectedItemsInput = document.getElementById("selected_items");
            const totalPriceElement = document.getElementById("price");
            const checkoutButton = document.getElementById("check_out");

            function updateSelectedItems() {
                const selectedItems = [];
                let totalPrice = 0;

                itemCheckboxes.forEach(function (checkbox) {
                    if (checkbox.checked) {
                        selectedItems.push(checkbox.getAttribute('data-index'));
                        totalPrice += parseFloat(checkbox.getAttribute('data-price'));
                    }
                });

                selectedItemsInput.value = JSON.stringify(selectedItems);
                totalPriceElement.innerText = `₱ ${totalPrice.toFixed(2)}`;
                checkoutButton.innerText = `Check Out (${selectedItems.length})`;

                // Enable or disable checkout button based on selected items
                if (selectedItems.length > 0) {
                    checkoutButton.removeAttribute('disabled');
                } else {
                    checkoutButton.setAttribute('disabled', 'disabled');
                }
            }

            selectAllCheckbox.addEventListener("click", function () {
                itemCheckboxes.forEach(function (checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateSelectedItems();
            });

            itemCheckboxes.forEach(function (checkbox) {
                checkbox.addEventListener("click", updateSelectedItems);
            });

            checkoutForm.addEventListener("submit", function (event) {
                updateSelectedItems();
                if (selectedItemsInput.value === '[]') {
                    event.preventDefault();
                    alert("Please select at least one item to check out.");
                }
            });
        });
    </script>

    <?php
    include("Layout\UserFooter.php");
    ?>

</body>

</html>