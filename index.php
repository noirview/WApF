<?php
session_start();

include("includes/header.html");

if ($_SERVER["REQUEST_URI"] == "/authorization") {
    include("authorization.html");
} else if ($_SERVER["REQUEST_URI"] == "/registration" || "/") {
    include("registration.html");
} 

include("includes/footer.html");
