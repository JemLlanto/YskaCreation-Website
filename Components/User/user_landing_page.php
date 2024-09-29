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
        @media only screen and (max-width: 425px) and (min-width: 320px) {
            #introText {
                width: 100%;
                font-size: 14px;
            }
        }

        @import url("../../head.php");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* BODY */

        .card-body h5 {
            margin-top: -11px;
            margin-left: -5px;
            font-size: 19px;
            /* margin-bottom: 50px; */
        }

        .card-body p {
            font-size: 15px;
            margin-top: -17px;
            margin-left: -5px;
            /* margin-bottom: 50px; */
        }

        .card-body a {
            font-size: 15px;
            margin-top: 0px;
            margin-left: -5px;
            width: 150px;
            padding: 3px;
            /* margin-bottom: 50px; */
        }

        #carouselExampleInterval {
            margin-top: -500px;
            margin-left: -250px;
        }

        #introText {
            width: 50%;
        }

        body>nav>div>div.d-lg-flex.align-items-center.justify-content-center.justify-content-md-end.d-md-none.me-2>div:nth-child(2)>img {
            width: 50px;
            border-radius: 50%;
        }

        @media only screen and (max-width: 425px) and (min-width: 320px) {
            #login-link {
                padding: 10px;
                padding-top: 5px;
                padding-bottom: 5px;
            }

            #login-link p {
                font-size: 14px;
            }

            #carouselExampleInterval {
                margin-top: 0px;
                margin-left: -250px;
            }

            #introText {
                width: 100%;
                font-size: 18px;
            }

            .card-body h5 {
                margin-top: -11px;
                margin-left: -5px;
                font-size: 14px;
            }

            .card-body p {
                font-size: 11px;
                margin-top: -17px;
                margin-left: -5px;
            }

            .card-body a {
                font-size: 12px;
                margin-top: 0px;
                margin-left: -5px;
                width: 150px;
                padding: 3px;
            }
        }
    </style>
</head>

<body>
    <?php
    $active = "home";
    include("Layout\UserNavBar.php");
    include("Layout\UserChat.php");
    ?>

    <div class="container-fluid d-flex align-items-end justify-content-center flex-column position-absolute pe-2 gap-3 pb-0 pe-lg-5 "
        id="Intro">
        <div class="d-flex flex-column align-items-end text-end">
            <h1>Introduction</h1>
            <p id="introText" class="">Hello! Welcome to Yskah Creations, we offer customized Glass Art Painting, Phone
                Case Painting, and Keychain Painting, you can choose from faceless vector art, pets, or anime art
                styles, we've got you covered in handmade art with love that you will cherish.

                Thank you for choosing Yskah Creation. We look forward to creating something special just for you!</p>
        </div>
        <a href="user_products.php"><button type="button" class="btn btn-lg btn-light p-3 w-100">Order Now</button></a>
    </div>

    <div class="overflow-hidden d-flex justify-content-center" style=" height: 60dvh">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active " data-bs-interval="3000">
                    <img src="../../img/homepic1.jpg" class="d-block w-100 img-fluid" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="../../img/homepic2.jpg" class="d-block w-100  img-fluid" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="../../img/homepic3.jpg" class="d-block w-100  img-fluid" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="../../img/homepic4.jpg" class="d-block w-100  img-fluid" alt="...">
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
                        <img src="../../product-images/<?php echo $row['image_file'] ?>" class="card-img-top" alt="...">
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
    include("Layout\UserFooter.php");
    ?>
</body>

</html>