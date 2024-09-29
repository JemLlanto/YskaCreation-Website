<?php
include("../../sessionchecker.php");
include("../../connection.php");
include("Layout/UserHeader.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Setting</title>
    <style>
        #profile {
            border: 5px solid gray;
        }

        #container button:focus {
            box-shadow: none;
        }

        body {
            background-color: var(--body_color) !important;
        }

        #container {
            /* background-color: white; */
        }

        .profile_image {
            /* background-color: gray; */
            position: relative;
            max-height: 300px;
            max-width: 300px;
            border-radius: 50%;
            border: 2px solid gray;
            /* overflow: hidden; */
        }

        .profile_image button {
            position: absolute;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            right: 20px;
            bottom: 20px;
            border: 3px solid white;
        }

        .change_profile {}

        #user_image img {
            /* max-height: 300px; */
            border-radius: 50%;

            max-width: 300px;
        }

        .btn {}

        body>div.container-fluid.d-flex.align-items-center.justify-content-center>div {
            width: clamp(200px, 80%, 840px);
        }

        #accordionExample {
            width: clamp(200px, 80%, 840px);
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

    $sql = "SELECT * FROM user_table WHERE username='" . $_SESSION['username'] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_array($result);


        if (count($_POST) > 0) {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $sex = $_POST['sex'];
            $phone = $_POST['phone'];
            $username = $_POST['username'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $province = $_POST['province'];
            $zip = $_POST['zip'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $image_file = $_POST['image_file'];

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query($conn, "UPDATE user_table SET
            first_name='$first_name',
            last_name='$last_name',
            sex='$sex',
            phone='$phone',
            address='$address',
            city='$city',
            province='$province',
            zip='$zip',
            username='$username',
            email='$email',
            image_file='$image_file',
            password='$hashed_password' WHERE user_id='" . $_POST['user_id'] . "'");
            echo "<script>
          alert('Record Successfully modified');
          window.location='user_setting.php';
          </script>";
        }
        ?>
        <!-- Modal -->
        <div class="modal fade" id="change_profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="user_update_photo.php" method="post" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Profile Picture</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="image_file" name="image_file"
                                    accept=".jpg, .jpeg, .png">
                                <label class="input-group-text" for="image_file">Upload</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="container" class="container-fluid mt-3 d-flex flex-column align-items-center justify-content-center">
            <div class="card  m-3 w-100">
                <div class="card-header d-flex justify-content-between align-items-center p-3">
                    <p class="card-text m-0">Profile</p>
                    <p class="card-text">ID: <?php echo $row['user_id']; ?></p>
                </div>

                <div class="row g-0 p-2 mb-2 border-bottom border-2">
                    <div id="user_image"
                        class="col-md-4 d-flex flex-column align-items-center justify-content-center pt-3 pb-3 px-2 "
                        style="">
                        <div class="profile m-0 p-0 position-relative">
                            <div class="w-100" style="border-radius: 50%; overflow: hidden; border: 3px solid gray;">
                                <img class="w-100 m-0" src="../../profile_picture/<?php echo $row['image_file'] ?>" alt="">

                            </div>
                            <button type="button" class="btn btn-primary p-0 position-absolute" data-bs-toggle="modal"
                                data-bs-target="#change_profile"
                                style="border-radius:50%; width: 50px; height: 50px; right: 10px; bottom: 20px; border: 2px solid white;">
                                <h1 class="m-0">+</h1>
                        </div>

                    </div>

                    <div class="col-md-8 wrapper ">
                        <h5 class="fw-bolder">User Details</h5>
                        <form action="setting_update_details.php" method="POST">
                            <div class="row pb-3 g-2">
                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                <div class="form-floating col-md-6">
                                    <input type="text" class="form-control" id="firstName" name="first_name"
                                        placeholder="John" value="<?php echo $row['first_name']; ?>" />
                                    <label for="firstName" class="form-label text-secondary ps-3">First name</label>
                                </div>
                                <div class="form-floating col-md-6">
                                    <input type="text" class="form-control" id="lastname" name="last_name" placeholder="Doe"
                                        value="<?php echo $row['last_name']; ?>" />
                                    <label for="lastName" class="form-label text-secondary ps-3">Last name</label>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text" for="sex">Sex</label>
                                <select class="form-select" id="sex" name="sex" value="<?php echo $row['sex']; ?>">
                                    <option selected><?php echo $row['sex']; ?></option>
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                </select>
                            </div>

                            <div class="form-floating mb-3 w-100">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="name@example.com" value="<?php echo $row['email']; ?>" />
                                <label for="email" class="form-label text-secondary">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="63+"
                                    value="<?php echo $row['phone']; ?>" />
                                <label for="phone" class="form-label text-secondary">Phone</label>
                            </div>


                            <div class="mb-2 d-flex flex-row justify-content-between align-items-center">
                                <div class="w-100  d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="wrapper p-2 pt-2 w-100 border-bottom border-2">
                    <h5 class="fw-bolder">Delivery Address</h5>
                    <form action="setting_update_delivery_details.php" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                        <div class="row pb-2">
                            <div class="form-floating col-md-6 mb-2">
                                <input type="text" class="form-control" id="blockLot" name="blockLot" placeholder="blockLot"
                                    value="<?php echo $row['blockLot']; ?>" />
                                <label for="firstName" class="form-label text-secondary  ps-4">House
                                    No./Block/Lot/Phase/Street
                                </label>
                            </div>
                            <div class="form-floating col-md-3 mb-2">
                                <input type="text" class="form-control" id="subdivision" name="subdivision"
                                    placeholder="Subdivision" value="<?php echo $row['subdivision']; ?>" />
                                <label for="firstName" class="form-label text-secondary ps-4 ">Subdivision</label>
                            </div>
                            <div class="form-floating col-md-3 mb-2">
                                <input type="text" class="form-control" id="barangay" name="barangay" placeholder="barangay"
                                    value="<?php echo $row['barangay']; ?>" />
                                <label for="firstName" class="form-label text-secondary ps-4 ">Barangay</label>
                            </div>

                        </div>
                        <div class="row pb-2">
                            <div class="form-floating col-md-4 mb-2">
                                <input type="text" class="form-control" id="city" name="city" placeholder="city"
                                    value="<?php echo $row['city']; ?>" />
                                <label for="firstName" class="form-label text-secondary ps-4 ">City</label>
                            </div>
                            <div class="form-floating col-md-4 mb-2">
                                <input type="text" class="form-control" id="province" name="province" placeholder="province"
                                    value="<?php echo $row['province']; ?>" />
                                <label for="firstName" class="form-label text-secondary ps-4 ">Province</label>
                            </div>
                            <div class="form-floating col-md-4 mb-2">
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="zip"
                                    value="<?php echo $row['zip']; ?>" />
                                <label for="firstName" class="form-label text-secondary ps-4 ">Zip</label>
                            </div>

                        </div>


                        <div class="my-2 d-flex flex-row justify-content-between align-items-center">
                            <div class="w-100  d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                    </form>
                </div>
            </div>
            <div class="wrapper px-2 pt-3 w-100">
                <h5 class="fw-bolder">Username and Password</h5>
                <form action="setting_update_account_details.php" method="POST">
                    <div class="row ">
                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                        <div class="form-floating col-md-6 mb-3 ">
                            <input type="text" class="form-control" id="username" placeholder="username" name="username"
                                value="<?php echo $row['username']; ?>" />
                            <label for="username" class="form-label text-secondary ps-4">Username</label>
                        </div>
                        <div class="form-floating col-md-3 mb-3 ">
                            <input type="password" class="form-control" id="password" placeholder="password"
                                name="password" />
                            <label for="password" class="form-label text-secondary ps-4">Password</label>
                        </div>
                        <div class="form-floating col-md-3 mb-3 ">
                            <input type="password" class="form-control" id="confirm_password" placeholder="confirm_password"
                                name="confirm_password" />
                            <label for="confirm_password" class="form-label text-secondary ps-4">Confirm Password</label>
                        </div>
                    </div>
                    <div class="mb-2 d-flex flex-row justify-content-between align-items-center">
                        <div class="w-100  d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <?php
    } else {
        echo "User not found.";
    }
    ?>

    <?php
    include("Layout\UserFooter.php");
    ?>
</body>

</html>