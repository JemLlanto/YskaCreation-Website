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
    <link rel="stylesheet" href="css\landing_page9.css">
    <style>
        body {
            background-color: lightgray;
        }

        @media only screen and (max-width: 425px) and (min-width: 320px) {
            #introText {
                width: 100%;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <?php
    $active = "home";
    include("Layout\AdminNavBar.php");
    include("Layout\AdminChat.php");
    ?>



    <div class="container-fluid d-flex align-items-end justify-content-center flex-column position-absolute pe-2 gap-3 pb-0 pe-lg-5 "
        id="Intro">
        <div class="d-flex flex-column align-items-end text-end">
            <h1>Introduction</h1>
            <p id="introText" class="w-75">Hello! Welcome to Yskah Creations, we offer customized Glass Art Painting,
                Phone
                Case Painting, and Keychain Painting, you can choose from faceless vector art, pets, or anime art
                styles, we've got you covered in handmade art with love that you will cherish.

                Thank you for choosing Yskah Creation. We look forward to creating something special just for you!</p>
        </div>
        <a href="index-products.php"><button type="button" class="btn btn-lg btn-light p-3 w-100">Order Now</button></a>
    </div>

    <div class="overflow-hidden d-flex justify-content-center" style=" height: 60dvh">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active " data-bs-interval="3000">
                    <img src="img\homepic1.jpg" class="d-block w-100 img-fluid" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="img\homepic2.jpg" class="d-block w-100  img-fluid" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="img\homepic3.jpg" class="d-block w-100  img-fluid" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="img\homepic4.jpg" class="d-block w-100  img-fluid" alt="...">
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid my-5" style="">
        <div class=" d-flex justify-content-center">
            <h3 class=" pt-4 ps-4 ">Products</h3>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 m-1 mt-4 mb-4 d-flex justify-content-center">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM products");
            while ($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="col">
                    <div class="card w-100 mb-2">
                        <img src="product-images/<?php echo $row['image_file'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['product_name'] ?></h5>
                            <p class="card-text">
                            <p>Php <?php echo $row['price'] ?>.00</p>
                            </p>
                            <a href="user_product_preview.php?product_id=<?php echo $row['product_id']; ?>"
                                class="w-100 btn btn-primary py-1">View
                                Product</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
    $sql = "
    SELECT o.*,
    GROUP_CONCAT(vc.option SEPARATOR ', ') AS variant_options
    FROM order_items o
    LEFT JOIN variant_content vc ON FIND_IN_SET(vc.variant_content_id, o.variant_content_ids)
    WHERE o.status = 'Pending'
    GROUP BY o.order_number
    ORDER BY o.order_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();


    ?>
    <a href="admin_order.php" style="text-decoration: none; color: black;">
        <div id="" class="container py-3 rounded d-flex justify-content-center" style="background-color: white;">
            <h5 class="m-0 " href="admin_order.php">New Orders</h5>
        </div>
        <div id="container" class="container-fluid-sm container-md rounded mb-3 mt-3 " style="background-color: white;">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($order = $result->fetch_assoc()): ?>


                    <!-- Display order details -->


                    <div id="order_item" class="rounded mt-3 p-2">

                        <div id="order_head" class="container w-100 mb-2 p-2 me-0">
                            <h5 class="m-0">Order ID: <?php echo $order['order_number']; ?></h5>
                            <input type="hidden" name="user_id" value="<?php echo $order['user_id']; ?>">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">

                        </div>

                        <!-- Display product details -->
                        <div id="product_details"
                            class="w-100 rounded border d-flex justify-content-between align-items-center p-2">
                            <div class="product_image d-flex justify-content-center align-items-center">
                                <img src="product-images/<?php echo $order['image_file']; ?>" alt="" class="rounded me-2"
                                    style="width: 100px;">
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
                            <h5 id="price" class="ms-2 m-0">₱ <?php echo number_format($order['total'], 2); ?></h5>
                        </div>
                    </div>

                <?php endwhile; ?>
        </a>
    <?php else: ?>
        <div class="container rounded d-flex align-items-center justify-content-center p-2 bg-light mt-3 text-center"
            style="height: 550px;">
            <h5>Empty Order.</h5>
        </div>
    <?php endif; ?>
    </div>

    <footer>
        <div class="footer_content flex-wrap flex-md-nowrap">
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