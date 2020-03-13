<?php
session_start();

include("includes/header.html");

if ($_SERVER["REQUEST_URI"] == "/authorization") {
    include("authorization.html");
} else if ($_SERVER["REQUEST_URI"] == "/registration") {
    include("registration.html");
} else if ($_SERVER["REQUEST_URI"] == "/user_page" && isset($_SESSION['name'])) {
    include("user_page.html");
} else {
    header("Location: /registration");
}

include("includes/footer.html");