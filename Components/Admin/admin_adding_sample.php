<?php
include ("connection.php");

if (isset($_POST['addsample'])) {
    $product_id = $_POST['product_id'];


    if ($_FILES['image_file']['error'] === 4) {
        echo "<script>alert('Image does not exist.');
        window.location='admin-products.php';
        </script>";
    } else {
        $file_name = $_FILES['image_file']['name']; // Fix: Changed 'product_name' to 'name'
        $file_size = $_FILES['image_file']['size']; // Added missing semicolon

        $tmpname = $_FILES["image_file"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $file_name);
        $imageExtension = strtolower(end($imageExtension));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script>alert('Invalid image extension.');
            window.location='admin-products.php';
            </script>";
        } else if ($file_size > 2000000) { // Changed 2000 to 2000000 for 2MB limit
            echo "<script>alert('Image size is too large.');
            window.location='admin-products.php';
            </script>";
        } else {
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpname, 'product-images/product_samples/' . $newImageName); // Fixed typo $tempname to $tmpname
            $query = "INSERT INTO product_samples (product_id, image_file) VALUES ('$product_id', '$newImageName')"; // Fixed SQL query syntax
            mysqli_query($conn, $query);

            echo "<script>
                alert('Product uploaded successfully.');
                window.location='admin-products.php';
                </script>";
        }
    }
}

$conn->close();
?>