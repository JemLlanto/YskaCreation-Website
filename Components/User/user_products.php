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
</head>

<body>

    <?php
    $active = "product";
    include("Layout\UserNavBar.php");
    include("Layout\UserChat.php");
    ?>

    <div class="container-fluid-md container-lg rounded mt-3 p-3 bg-light">
        <div class="row row-cols-1 row-cols-md-4 d-flex flex-row m-1 mt-4 mb-4 gy-2">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM products");
            while ($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="card w-100">
                        <img src="../../product-images/<?php echo $row['image_file'] ?>" class="card-img-top" alt="..." />
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['product_name'] ?></h5>
                            <p class="card-text">
                            <p class="m-0">Php <?php echo $row['price'] ?>.00</p>
                            </p>
                            <a href="user_product_preview.php?product_id=<?php echo $row['product_id']; ?>"
                                class="btn btn-primary w-100">View
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