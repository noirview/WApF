<?php
session_start();

if (isset($_SESSION['name']) && isset($_SESSION['id']) &&
    isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'])['path'] != "/user_page"){
    
    header('Location: /user_page'); 
}

include("includes/header.html");

if ($_SERVER["REQUEST_URI"] == "/authorization") {
    include("authorization.html");
} else if ($_SERVER["REQUEST_URI"] == "/registration") {
    include("registration.html");
} else if ($_SERVER["REQUEST_URI"] == "/user_page" && isset($_SESSION['name'])) {
    include("user_page.html");
} else {
    include("registration.html");
}

include("includes/footer.html");