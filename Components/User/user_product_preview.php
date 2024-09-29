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
        @import url("head.php");

        /* BODY */

        #container {
            background-color: white;
            width: 90%;
        }

        #carouselExampleInterval {
            width: clamp(250px, 100%, 1150px);
        }

        #container .product_name_price {
            background: rgb(255, 247, 0);
        }

        #container .product_name_price h1,
        h3 {
            margin-bottom: 0%;
        }

        #container .product_name_price h1 {
            font-size: clamp(1rem, 2.5vw, 2.5rem);
        }

        #container .product_name_price h3 {
            font-size: clamp(1rem, 1.75vw, 2rem);
        }

        .container {
            width: 100%;
        }

        .product_description {
            padding: 10px;
            font-size: clamp(0.65rem, 1.65vw, 2rem);
        }

        .variation_ordernow {
            height: 280px;
        }

        .product_variation {
            padding: 10px;
        }

        .variation {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 45px;
            width: 90px;
            background: rgb(255, 247, 0);
            border-radius: 8px;
            transition: 0.2s;
        }

        .product_ordernow_addtocart {
            background-color: gray;
            padding: 10px;
            width: 100%;
            border: none;
        }

        .h4,
        h4 {
            font-size: clamp(0.85rem, 1.655vw, 1.7rem);
        }

        #add-to-cart-form {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: start;
            justify-content: space-between;
        }

        .order_now,
        .add_to_cart {
            padding-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 20px;
            height: 55px;
            width: clamp(80px, 50%, 200px);
        }

        .order_now {
            background: rgb(255, 64, 0);
            color: white;
        }

        .add_to_cart {
            background: rgb(255, 255, 255);
            color: rgb(255, 64, 0);
            border: 2px solid rgb(255, 64, 0);
        }

        #quantity {
            /* background-color: gray; */
        }

        #quantity_button {
            /* border: none; */
        }

        .add_to_cart_order_now {
            /* border: 1px solid var(--ter_color); */
            display: flex;
            align-items: center;
            justify-content: end;
            /* background-color: gray; */
            width: 100%;
        }

        .variation_ordernow {
            height: 100px;
            display: flex;
        }

        .variation {
            height: 30px;
            width: 70px;
        }

        .order_now,
        .add_to_cart {
            border-radius: 20px;
            height: 35px;
        }

        #container {
            width: 100%;
        }



        .add_to_cart,
        .order_now {
            transition: .3s;
        }

        .add_to_cart:hover {
            background-color: var(--ter_color);
            color: white
        }

        .order_now:hover {
            background-color: rgb(223, 64, 36);
        }

        .product_description {
            height: 350px;
            overflow: scroll;
            overflow-x: hidden;
            background-color: #f2f2f2;
        }

        .radio-container {
            background-color: var(--main_color);
            padding: 0;
            transition: .3s;
        }

        .radio-container:hover {
            background-color: var(--ter_color);
            color: white;

        }

        .radio-container input[type="radio"] {
            display: none;
        }

        .radio-container input[type="radio"]:checked+.label-text {
            background-color: var(--ter_color);
            color: white;
        }

        .label-text {
            display: flex;
            align-items: center;
            padding: 0.5em;
            border-radius: 5px;
            width: 100%;
        }

        .radio-circle {
            background-color: white;
            height: 20px;
            width: 20px;
            border-radius: 5px;
            margin-right: 10px;
        }

        @media only screen and (max-width: 320px) {
            #login-link {
                padding: 10px;
                padding-top: 5px;
                padding-bottom: 5px;
            }

            #login-link p {
                font-size: 14px;
            }

            .btn {
                font-size: 11px;
            }
        }
    </style>
</head>

<body>

    <?php
    $active = "product";
    include("Layout\UserNavBar.php");
    include("Layout\UserChat.php");
    ?>

    <?php
    if (isset($_GET['product_id'])) {
        $product_id = intval($_GET['product_id']);

        $result = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $product_id");
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            ?>

            <div id="container" class="container-fluid rounded d-flex mb-3 mt-3 py-2">
                <div class="row row-cols-1 row-cols-md-2 gx-1 gy-4 gy-md-0">
                    <div class="col">
                        <div id="carouselExampleInterval" class="carousel slide " data-bs-ride="carousel" data-interval="false">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="../../product-images/<?php echo $row['image_file'] ?>"
                                        class="d-block w-100 rounded" alt="...">
                                </div>
                                <?php
                                $res = mysqli_query($conn, "SELECT * FROM product_samples WHERE product_id = $product_id");
                                while ($samples = mysqli_fetch_assoc($res)) {

                                    ?>
                                    <div class="carousel-item  " data-bs-interval="3000">
                                        <img src="../../product-images/product_samples/<?php echo $samples['image_file'] ?>"
                                            class="d-block w-100 rounded" alt="...">
                                    </div>
                                <?php } ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="col">
                        <div class="container-fluid">
                            <div class="product_name_price rounded d-flex justify-content-between p-3 align-items-center">
                                <h1><?php echo $row['product_name'] ?></h1>
                                <?php
                                // Initialize variables for minimum and maximum prices
                                $min_combined_price = PHP_INT_MAX;
                                $max_combined_price = 0;

                                // Fetch all variants for the product
                                $variants_query = mysqli_query($conn, "SELECT * FROM variant_table WHERE product_id = $product_id");
                                $variants = mysqli_fetch_all($variants_query, MYSQLI_ASSOC);

                                // Function to calculate minimum and maximum combined prices recursively
                                function calculateMinMaxCombinedPrices($current_variant_index, $current_price)
                                {
                                    global $variants, $conn, $product_id, $min_combined_price, $max_combined_price;

                                    // Base case: reached end of variants array
                                    if ($current_variant_index >= count($variants)) {
                                        // Update min_combined_price if current combination's price is lower
                                        if ($current_price < $min_combined_price) {
                                            $min_combined_price = $current_price;
                                        }
                                        // Update max_combined_price if current combination's price is higher
                                        if ($current_price > $max_combined_price) {
                                            $max_combined_price = $current_price;
                                        }
                                        return;
                                    }

                                    // Fetch contents for current variant
                                    $variant_id = $variants[$current_variant_index]['variant_id'];
                                    $contents_query = mysqli_query($conn, "SELECT * FROM variant_content WHERE variant_id = $variant_id");
                                    $contents = mysqli_fetch_all($contents_query, MYSQLI_ASSOC);

                                    // Iterate over each content option of current variant
                                    foreach ($contents as $content) {
                                        // Calculate new price considering current content option
                                        $new_price = $current_price + floatval($content['price']);

                                        // Recursive call for next variant
                                        calculateMinMaxCombinedPrices($current_variant_index + 1, $new_price);
                                    }
                                }

                                // Start recursion from first variant
                                calculateMinMaxCombinedPrices(0, 0);

                                ?>
                                <h3>Php <?php echo number_format($min_combined_price, 2) ?> -
                                    <?php echo number_format($max_combined_price, 2) ?>
                                </h3>
                            </div>

                            <div class="product_description w-100 mt-2">
                                <p>
                                    <?php echo $row['description'] ?>
                                </p>
                            </div>
                            <div class="variation_ordernow d-flex flex-column w-100">
                                <div class="quantity_buttons">
                                    <div class="add_to_cart_order_now mt-4 p-2">
                                        <button class="add_to_cart rounded" data-bs-toggle="modal"
                                            data-bs-target="#add_to_cart_modal">
                                            <h5>Add to Cart</h5>
                                        </button>
                                        <button class="order_now ms-2 rounded" style="border:none;" onclick="orderNow()">
                                            <h5>Order Now</h5>
                                        </button>
                                    </div>

                                    <!-- Add to Cart Modal -->
                                    <div class="modal fade" id="add_to_cart_modal" tabindex="-1"
                                        aria-labelledby="addToCartLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title w-100" id="addToCartLabel">
                                                        <div class="w-100 d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h5 class="m-0">Add to Cart</h5>
                                                            </div>
                                                            <div class="m-0" id="cartTotalPrice">
                                                                Php <?php echo $row['price'] ?>.00
                                                            </div>
                                                        </div>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="add-to-cart-form" action="add-to-cart-form.php" method="POST">
                                                        <!-- Include variant selection similar to Order Now -->
                                                        <?php
                                                        $product_id = $row['product_id'];
                                                        $variants = mysqli_query($conn, "SELECT * FROM variant_table WHERE product_id = $product_id");

                                                        while ($variant = mysqli_fetch_assoc($variants)) {
                                                            ?>
                                                            <div class="row w-100 border border-3 rounded m-auto pt-2 mb-2">
                                                                <div
                                                                    class="d-flex justify-content-between border-bottom align-content-center border-3 mb-2 pb-1">
                                                                    <h5 class="m-0"><?php echo $variant['name']; ?></h5>
                                                                </div>
                                                                <div
                                                                    class="m-0 mb-3 pt-2 d-flex justify-content-start flex-wrap gap-1">
                                                                    <?php
                                                                    $variant_id = $variant['variant_id'];
                                                                    $contents = mysqli_query($conn, "SELECT * FROM variant_content WHERE variant_id = $variant_id");
                                                                    while ($content = mysqli_fetch_assoc($contents)) {
                                                                        ?>
                                                                        <label class="shadow-sm radio-container rounded">
                                                                            <input type="radio"
                                                                                name="variants[<?php echo $variant['variant_id']; ?>]"
                                                                                value="<?php echo $content['variant_content_id'] . '-' . $content['price']; ?>">
                                                                            <div class="label-text m-auto">
                                                                                <div class="radio-circle"></div>
                                                                                <?php echo $content['option']; ?>
                                                                            </div>
                                                                        </label>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <input type="hidden" name="product_id"
                                                            value="<?php echo $row['product_id']; ?>">
                                                        <input type="hidden" name="product_name"
                                                            value="<?php echo $row['product_name']; ?>">
                                                        <input type="hidden" id="cart_total_price" name="price"
                                                            value="<?php echo $row['price']; ?>">
                                                        <input type="hidden" name="image_file"
                                                            value="<?php echo $row['image_file']; ?>">
                                                        <div class="input-group mt-3">
                                                            <label for="cart_quantity">
                                                                <h5>Quantity</h5>
                                                            </label>
                                                            <input type="number" class="form-control w-100 rounded py-2 ps-2"
                                                                id="cart_quantity" name="quantity" value="1" min="1">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close
                                                    </button>
                                                    <button type="button" class="btn btn-primary" onclick="submitCartForm()">Add
                                                        to Cart
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Order Now Modal -->
                                    <div class="modal fade" id="order_now_modal" tabindex="-1" aria-labelledby="orderNowLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title w-100" id="orderNowLabel">
                                                        <div class="w-100 d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h5 class="m-0">Order Now</h5>
                                                            </div>
                                                            <div class="m-0" id="orderTotalPrice">
                                                                Php <?php echo $row['price'] ?>.00
                                                            </div>
                                                        </div>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="order-now-form" action="user_order_now.php" method="POST">
                                                        <!-- Include variant selection similar to Add to Cart -->
                                                        <?php
                                                        $product_id = $row['product_id'];
                                                        $variants = mysqli_query($conn, "SELECT * FROM variant_table WHERE product_id = $product_id");

                                                        while ($variant = mysqli_fetch_assoc($variants)) {
                                                            ?>
                                                            <div class="row w-100 border border-3 rounded m-auto pt-2 mb-2">
                                                                <div
                                                                    class="d-flex justify-content-between border-bottom align-content-center border-3 mb-2 pb-1">
                                                                    <h5 class="m-0"><?php echo $variant['name']; ?></h5>
                                                                </div>
                                                                <div
                                                                    class="m-0 mb-3 pt-2 d-flex justify-content-start flex-wrap gap-1">
                                                                    <?php
                                                                    $variant_id = $variant['variant_id'];
                                                                    $contents = mysqli_query($conn, "SELECT * FROM variant_content WHERE variant_id = $variant_id");
                                                                    while ($content = mysqli_fetch_assoc($contents)) {
                                                                        ?>
                                                                        <label class="shadow-sm radio-container rounded">
                                                                            <input type="radio"
                                                                                name="order_variants[<?php echo $variant['variant_id']; ?>]"
                                                                                value="<?php echo $content['variant_content_id'] . '-' . $content['price']; ?>">
                                                                            <div class="label-text m-auto">
                                                                                <div class="radio-circle"></div>
                                                                                <?php echo $content['option']; ?>
                                                                            </div>
                                                                        </label>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <input type="hidden" name="product_id"
                                                            value="<?php echo $row['product_id']; ?>">
                                                        <input type="hidden" name="product_name"
                                                            value="<?php echo $row['product_name']; ?>">
                                                        <input type="hidden" id="order_total_price" name="price"
                                                            value="<?php echo $row['price']; ?>">
                                                        <input type="hidden" name="image_file"
                                                            value="<?php echo $row['image_file']; ?>">
                                                        <input type="hidden" name="description"
                                                            value="Your Order has been placed successfully. Click for more details">
                                                        <input type="hidden" name="status" value="Unread">
                                                        <input type="hidden" name="title" value="Order Placed">
                                                        <div class="input-group mt-3">
                                                            <label for="order_quantity">
                                                                <h5>Quantity</h5>
                                                            </label>
                                                            <input type="number" class="form-control w-100 rounded py-2 ps-2"
                                                                id="order_quantity" name="quantity" value="1" min="1">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" form="order-now-form" class="btn btn-primary">Order
                                                        Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <script>
                // Function to calculate total price for Add to Cart modal
                function calculateCartTotalPrice() {
                    let total = 0;
                    const radios = document.querySelectorAll('input[name^="variants"]:checked');
                    radios.forEach((radio) => {
                        total += parseFloat(radio.value.split('-')[1]);
                    });
                    document.getElementById('cart_total_price').value = total.toFixed(2);
                    document.getElementById('cartTotalPrice').innerText = 'Price: Php ' + total.toFixed(2);
                }

                // Function to submit Add to Cart form
                function submitCartForm() {
                    // Check if at least one variant is selected
                    const radios = document.querySelectorAll('input[name^="variants"]:checked');
                    if (radios.length === 0) {
                        alert("Please select a variant option.");
                        return;
                    }

                    calculateCartTotalPrice();
                    document.getElementById('add-to-cart-form').submit();
                }

                // Function to calculate total price for Order Now modal
                function calculateOrderTotalPrice() {
                    let total = 0;
                    const radios = document.querySelectorAll('input[name^="order_variants"]:checked');
                    radios.forEach((radio) => {
                        total += parseFloat(radio.value.split('-')[1]);
                    });
                    document.getElementById('order_total_price').value = total.toFixed(2);
                    document.getElementById('orderTotalPrice').innerText = 'Price: Php ' + total.toFixed(2);
                }

                // Function to handle Order Now button click
                function orderNow() {
                    calculateOrderTotalPrice();
                    const modal = new bootstrap.Modal(document.getElementById('order_now_modal'));
                    modal.show();
                }

                // Function to submit Order Now form
                function submitOrderForm() {
                    // Check if at least one variant is selected
                    const radios = document.querySelectorAll('input[name^="order_variants"]:checked');
                    if (radios.length === 0) {
                        alert("Please select a variant option.");
                        return;
                    }

                    calculateOrderTotalPrice();
                    document.getElementById('order-now-form').submit();
                }

                // Event listener when DOM is loaded
                document.addEventListener('DOMContentLoaded', (event) => {
                    // Add event listeners for radio inputs in Add to Cart modal
                    document.querySelectorAll('input[name^="variants"]').forEach((radio) => {
                        radio.addEventListener('change', calculateCartTotalPrice);
                    });

                    // Add event listeners for radio inputs in Order Now modal
                    document.querySelectorAll('input[name^="order_variants"]').forEach((radio) => {
                        radio.addEventListener('change', calculateOrderTotalPrice);
                    });
                });

            </script>


            <?php
        } else {
            echo "<p>Product not found.</p>";
        }
    } else {
        echo "<p>No product selected.</p>";
    }
    ?>

    <?php
    include("Layout\UserFooter.php");
    ?>

</body>

</html>