<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="css/head.css"> -->
    <script defer src="js/bootstrap.bundle.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://twitter.github.io/bootstrap/assets/js/bootstrap-transition.js"></script>
    <script type="text/javascript" src="http://twitter.github.io/bootstrap/assets/js/bootstrap-collapse.js"></script>
    <style>
        :root {
            --main_color: rgb(248, 244, 0);
            --sec_color: rgb(255, 237, 80);
            --ter_color: rgb(255, 72, 40);
            --body_color: rgb(235, 235, 235);
            --main_border: rgb(123, 123, 123);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        #navbarNav {
            align-items: center;
            justify-content: space-evenly;
            flex-direction: column;
        }

        #Intro {
            height: 60dvh;
            width: 100dvw;
            z-index: 1;
            background: var(--main_color);
            background: linear-gradient(90deg,
                    rgba(255, 255, 0, 0.05) 0%,
                    var(--main_color) 80%,
                    var(--main_color) 100%);
        }

        body>nav>div {
            height: 100%;
        }

        /* droptdown on user */
        .right_nav {
            display: flex;
        }

        #offcanvasExampleLabel>div>button {
            background-color: rgb(255, 255, 255);
            border: none;
            padding: 0;
            margin-top: 5px;
            box-shadow: none;
            border-radius: 20px;
            outline: rgb(255, 255, 255);
            height: 65px;
            width: 180px;
        }

        #offcanvasExampleLabel>div>button:focus {
            box-shadow: none;
        }

        #offcanvasExampleLabel .dropdown-menu .drop_items a {
            width: 100%;
        }

        #offcanvasExampleLabel .dropdown-menu .drop_items {
            display: flex;
            justify-content: start;
            /* align-items: center; */
            /* background-color: pink; */
        }

        #offcanvasExampleLabel .drop_items a {
            height: 100%;
            width: 100%;
        }

        #offcanvasExampleLabel .drop_items button {
            /* height: 100%; */
            width: 160px;
            /* background-color: gray; */
        }

        body>nav>div>div.right_nav>div.btn-group>button {
            background: transparent;
            margin-right: 0;
            border: none;
            height: 70px;
            padding: 0;
            padding-top: 7px;
        }

        body>nav>div>div.right_nav>div.btn-group>button:focus {
            box-shadow: none;
        }

        body>nav>div>div.right_nav>button:focus {
            box-shadow: none;
        }

        #login-link {
            background: var(--main_color);
            padding: 8px 28px 8px 28px;
            border-radius: 7px;
        }

        #navbarNav>ul>li>a.active {
            border-bottom: 2px solid black;
        }

        #navbarNav>ul>li>a:hover {
            border-bottom: 2px solid black;
        }

        .offcanvas .nav-item {
            /* background-color: lightblue; */
            display: flex;
            justify-content: start;
            border-radius: 5px;
        }

        .offcanvas .nav-item:hover,
        .offcanvas .nav-item.active {
            transition: 0.3s;
            background-color: lightgrey;
        }

        /* off canvass notification */
        .off .btn .orders {
            height: 40px;
            width: 40px;
            padding: 0;
            /* display: flex;
  justify-content: center;
  align-items: center; */
            /* background-color: gray; */
        }

        .off .btn .orders .notif {
            position: absolute;
        }

        .off .btn .orders .order_button {
            height: 35px;
            width: 35px;
            /* display: flex;
  justify-content: center;
  align-items: center; */
            /* background-color: gray; */
        }

        .off .btn .orders .order_button i {
            /* width: 20px; */
            margin-top: 2px;
            font-size: 20px;
        }

        /* offcanvas user */
        .user-off {
            height: 55px;
            width: auto;
            background: var(--main_color);
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: start;
            border-radius: 50px;
            padding-right: 20px;
            transition: 0.2s;
        }

        .user-off:hover {
            background: var(--sec_color);
        }

        /* .user-off .photo {
  height: 45px;
  width: 45px;
  background: url(img\User.jpg);
  background-position: center;
  background-size: cover;
  border-radius: 50%;
  overflow: hidden;
} */

        .user-off .photo img {
            height: 45px;
            width: 45px;
            border-radius: 50%;
        }

        .user-off .name {
            display: flex;
            justify-content: start;
            align-items: center;
            padding: 0;
            height: 45px;
            /* background-color: gray; */
            /* width: 50px; */
            /* margin-right: 15px; */
        }

        .user-off .name p {
            font-size: 14px;
            margin: 0;
            color: black;
            text-align: right;
        }

        #btn-close:focus,
        #notif_button,
        #log_out_button,
        #off_nav_button,
        #log_out button {
            box-shadow: none;
        }

        /* nav user */
        .user {
            height: 55px;
            width: 180px;
            background: var(--main_color);
            margin-right: 0;
            display: flex;
            align-items: center;
            justify-content: end;
            border-radius: 50px;
            padding-right: 8px;
            transition: 0.2s;
        }

        .user:hover {
            background: var(--sec_color);
        }

        .user .photo {
            height: 45px;
            width: 45px;
            background: url(img\User.jpg);
            background-position: center;
            background-size: cover;
            border-radius: 50%;
            margin-left: 0;
            overflow: hidden;
        }

        .user .photo img {
            height: 45px;
            width: 45px;
        }

        .user .name {
            display: flex;
            justify-content: end;
            align-items: center;
            padding: 0;
            height: 45px;
            width: 50px;
            margin-right: 10px;
        }

        .user .name p {
            font-size: 15px;

            margin: 0;
            color: black;
            text-align: right;
        }

        body>div.navi-bar>div>div.right_nav>div.btn-group>button {
            background-color: rgb(255, 255, 255);
            border: none;
            padding: 0;
            margin-top: 5px;
            box-shadow: none;
            border-radius: 20px;
            outline: rgb(255, 255, 255);
            height: 65px;
            width: 180px;
        }

        .dropdown-menu {
            right: 0;
            padding: 15px;
            /* height: 150px; */
            width: 180px;
        }

        .dropdown-menu .drop_items {
            padding-right: 5px;
            display: flex;
            justify-content: end;
            align-items: center;
            width: 100%;
            height: 40px;
            margin-bottom: 5px;
            /* border-bottom: 1px solid gray; */
            transition: 0.2s;
            padding: 0;
            border-radius: 5px;
        }

        .dropdown-menu .drop_items:hover {
            background-color: var(--body_color);
        }

        #log_out button {
            /* background-color: gray; */
            width: 160px;
        }

        .dropdown-menu a {
            display: block;
            text-decoration: none;
            color: black;
        }

        .dropdown-menu a:hover {
            color: black;
        }

        body>div.navi-bar>div>div.btn-group>ul>li:nth-child(2)>div>form>button {
            height: 35px;
            font-size: 15px;
        }

        .btn-group {
            margin-right: 10px;
        }

        a {
            text-decoration: none;
        }

        .notification_section {
            width: 100%;
            background: rgb(237, 237, 237);
            border-radius: 5px;
            overflow: hidden;
            padding: 5px;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        .notification_section a {
            text-decoration: none;
        }

        .notif_title {
            width: 100%;
            height: 30px;
            /* background: rgb(192, 192, 192); */
            border-bottom: 2px solid rgb(200, 200, 200);
        }

        .notif_title p {
            font-size: 20px;
            color: black;
        }

        .notif_message {
            margin-top: 10px;
            width: 100%;
            /* background: rgb(192, 192, 192); */
        }

        .notif_message p {
            font-size: 15px;
            color: rgb(103, 102, 102);
        }

        .notif_details {
            width: 100%;
            /* background: rgb(192, 192, 192); */
            margin-bottom: 0;
        }

        .notif_details p {
            font-size: 13px;
            color: gray;
        }

        footer {
            width: 100%;
            height: 300px;
            background: rgb(12, 12, 12);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .footer_content {
            color: gray;
            width: 85%;
            height: 280px;
            /* background: rgb(98, 98, 98); */
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .footer_details {
            padding-top: 50px;
            width: 900px;
            height: 280px;
            /* background: rgb(153, 152, 152); */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .socials {
            width: 100%;
            height: 50px;
            padding-top: 30px;
            /* background: rgb(199, 199, 199); */
            /* border-bottom: 1px solid rgb(153, 152, 152); */
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            font-size: 15px;
        }

        .socials a {
            text-decoration: none;
            color: gray;
            transition: 0.2s;
        }

        .socials a:hover {
            /* text-decoration: none; */
            margin-bottom: 5px;
            color: rgb(202, 202, 202);
        }

        .socials i {
            margin-top: 5px;
            /* color: gray; */
        }

        .copyright {
            color: gray;
            margin-top: 55px;
            bottom: 0;
            width: 100%;
            height: 70px;
            /* background: rgb(199, 199, 199); */
            display: flex;
            justify-content: space-evenly;
            align-items: end;
            font-size: 15px;
        }

        .footer_logo {
            width: 280px;
            height: 280px;
            /* background: rgb(153, 152, 152); */
        }

        .footer_logo img {
            width: 280px;
            height: 280px;
        }

        .orders {
            /* margin-left: -2px; */
            /* position: relative; */
            height: 50px;
            width: 50px;
            background: white;
            border-radius: 50%;
            border: 2px solid rgb(157, 157, 157);
            /* right: 0; */
        }

        .orders .notif {
            position: absolute;
            height: 20px;
            width: 20px;
            background: rgb(255, 255, 255);
            padding: 3px;
            border-radius: 50%;
            display: flex;
            margin-left: -10px;
        }

        .orders .notif p {
            height: 16px;
            width: 16px;
            font-size: 12px;
            background: rgb(255, 0, 0);
            padding: 5px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .orders .order_button {
            margin: auto;
            height: 45px;
            width: 45px;
            padding: 5px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .orders .order_button i {
            margin-top: 5px;
            color: gray;
            font-size: 30px;
        }

        .chat {
            background-color: var(--main_color);
            position: fixed;
            z-index: 1;
            right: 20px;
            bottom: 20px;
            height: 70px;
            width: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            transition: 0.3s;
            /* display: block; */
            /* align-items: center; */
            /* top: 790px; */
            /* left: 1720px; */
        }

        .chat img {
            width: 50px;
        }

        /* .chat img:hover, */
        .chat:hover {
            background-color: var(--sec_color);
            transform: scale(105%);
        }

        .chat button:focus {
            box-shadow: none;
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

            #carouselExampleInterval {
                margin-top: 0px;
            }

            #introText {
                width: 100%;
                font-size: 18px;
            }

            footer {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .footer_content {
                width: 100%;
                height: auto;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .footer_logo {
                width: 100%;
                height: auto;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #footer-logo {
                width: 30%;
                height: auto;
            }

            .footer_details {
                padding-top: 5px;
                width: 100%;
                height: auto;
                display: flex;
                align-items: center;
            }

            .socials {
                padding-top: 10px;
                display: flex;
                flex-direction: column;
            }

            .copyright {
                margin-top: 45px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .copyright p {
                font-size: 8px;
            }
        }
    </style>
</head>

<body>
</body>

</html>