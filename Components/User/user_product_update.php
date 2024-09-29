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
    if (isset($_GET['product_id']) && isset($_GET['order_id'])) {
        $product_id = intval($_GET['product_id']);
        $order_id = intval($_GET['order_id']);

        // Initialize the min and max prices
        $min_combined_price = PHP_INT_MAX;
        $max_combined_price = PHP_INT_MIN;

        // Fetch product details
        $product_result = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $product_id");
        $product = mysqli_fetch_assoc($product_result);

        // Fetch current order details
        $order_result = mysqli_query($conn, "SELECT * FROM order_table WHERE order_id = $order_id");
        $order = mysqli_fetch_assoc($order_result);

        // Fetch current variant selections
        $variant_content_ids = explode(',', $order['variant_content_ids']);

        // Calculate the min and max combined prices for the product variants
        $variants_result = mysqli_query($conn, "SELECT * FROM variant_table WHERE product_id = $product_id");
        while ($variant = mysqli_fetch_assoc($variants_result)) {
            $variant_id = $variant['variant_id'];
            $contents_result = mysqli_query($conn, "SELECT * FROM variant_content WHERE variant_id = $variant_id");
            while ($content = mysqli_fetch_assoc($contents_result)) {
                $price = floatval($content['price']);
                if ($price < $min_combined_price) {
                    $min_combined_price = $price;
                }
                if ($price > $max_combined_price) {
                    $max_combined_price = $price;
                }
            }
        }

        // If no variants were found, set prices to 0
        if ($min_combined_price == PHP_INT_MAX) {
            $min_combined_price = 0;
        }
        if ($max_combined_price == PHP_INT_MIN) {
            $max_combined_price = 0;
        }

        if ($product && $order) {
            ?>
            <div id="container" class="container-fluid rounded d-flex mb-3 mt-3 py-2">
                <div class="row row-cols-1 row-cols-md-2 gx-1 gy-4 gy-md-0">
                    <div class="col">
                        <div id="carouselExampleInterval" class="carousel slide " data-bs-ride="carousel" data-interval="false">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="../../product-images/<?php echo $product['image_file'] ?>"
                                        class="d-block w-100 rounded" alt="...">
                                </div>
                                <?php
                                $res = mysqli_query($conn, "SELECT * FROM product_samples WHERE product_id = $product_id");
                                while ($samples = mysqli_fetch_assoc($res)) {
                                    ?>
                                    <div class="carousel-item  " data-bs-interval="3000">
                                        <img src="product-images/product_samples/<?php echo $samples['image_file'] ?>"
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
                                <h1><?php echo $product['product_name'] ?></h1>
                                <h3>Php <?php echo number_format($min_combined_price, 2) ?> -
                                    <?php echo number_format($max_combined_price, 2) ?>
                                </h3>
                            </div>

                            <div class="product_description w-100 mt-2">
                                <p><?php echo $product['description'] ?></p>
                            </div>

                            <div class="variation_ordernow d-flex flex-column w-100">
                                <div class="quantity_buttons">
                                    <div class="add_to_cart_order_now mt-4 p-2">
                                        <button class="add_to_cart rounded" data-bs-toggle="modal"
                                            data-bs-target="#variation_modal">
                                            <h5>Update Cart</h5>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="variation_modal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title w-100" id="exampleModalLabel">
                                                        <div class="w-100 d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h5 class="m-0">Update Cart</h5>
                                                            </div>
                                                            <div class="m-0" id="totalPrice">Php
                                                                <?php echo number_format($order['price'], 2) ?>
                                                            </div>
                                                        </div>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="update-cart-form" action="update-cart.php" method="POST">
                                                        <?php
                                                        $variants = mysqli_query($conn, "SELECT * FROM variant_table WHERE product_id = $product_id");
                                                        while ($variant = mysqli_fetch_assoc($variants)) {
                                                            $variant_id = $variant['variant_id'];
                                                            ?>
                                                            <div class="row w-100 border border-3 rounded m-auto pt-2 mb-2">
                                                                <div
                                                                    class="d-flex justify-content-between border-bottom align-content-center border-3 mb-2 pb-1">
                                                                    <h5 class="m-0"><?php echo $variant['name']; ?></h5>
                                                                </div>
                                                                <div
                                                                    class="m-0 mb-3 pt-2 d-flex justify-content-start flex-wrap gap-1">
                                                                    <?php
                                                                    $contents = mysqli_query($conn, "SELECT * FROM variant_content WHERE variant_id = $variant_id");
                                                                    while ($content = mysqli_fetch_assoc($contents)) {
                                                                        $isChecked = in_array($content['variant_content_id'], $variant_content_ids) ? 'checked' : '';
                                                                        ?>
                                                                        <label class="shadow-sm radio-container rounded">
                                                                            <input type="radio"
                                                                                name="variants[<?php echo $variant['variant_id']; ?>]"
                                                                                value="<?php echo $content['variant_content_id'] . '-' . $content['price']; ?>"
                                                                                <?php echo $isChecked; ?>>
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
                                                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                                        <div class="input-group mt-3">
                                                            <label for="quantity">
                                                                <h5>Quantity</h5>
                                                            </label>
                                                            <input type="number" class="form-control w-100 rounded py-2 ps-2"
                                                                id="quantity" name="quantity"
                                                                value="<?php echo $order['quantity']; ?>" min="1">
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="submitForm()">Update Cart</button>
                                                        </div>
                                                    </form>
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
                function calculateTotalPrice() {
                    let total = 0;
                    const radios = document.querySelectorAll('input[type="radio"]:checked');
                    radios.forEach((radio) => {
                        total += parseFloat(radio.value.split('-')[1]);
                    });
                    document.getElementById('totalPrice').innerText = 'Php ' + total.toFixed(2);
                }

                function submitForm() {
                    calculateTotalPrice();
                    console.log('Submitting form'); // Debug log
                    document.getElementById('update-cart-form').submit();
                }

                document.querySelectorAll('.variation-btn').forEach((button, index) => {
                    button.addEventListener('click', function () {
                        const carousel = document.querySelector('#carouselExampleInterval');
                        const bootstrapCarousel = new bootstrap.Carousel(carousel);
                        bootstrapCarousel.to(index + 1);
                    });
                });
            </script>

            <?php
        } else {
            echo "<p>Product or Order not found.</p>";
        }
    } else {
        echo "<p>No product or order selected.</p>";
    }
    ?>

    <?php
    include("Layout\UserFooter.php");
    ?>
</body>

</html>