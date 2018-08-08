<!DOCTYPE HTML>
<html>
<head>
    <title>@yield("title","首页")</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- Custom Theme files -->
    <link href="/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/bootstrap/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!-- js -->
    <script src="/bootstrap/js/jquery-1.11.1.min.js"></script>
    <!-- //js -->
    <!-- animation-effect -->
    <link href="/bootstrap/css/animate.min.css" rel="stylesheet">
    <script src="/bootstrap/js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <!-- //animation-effect -->
    <link href='/bootstrap/css/family.css' rel='stylesheet' type='text/css'>
    <link href='/bootstrap/css/fa2' rel='stylesheet' type='text/css'>
</head>

<body>
@include("layouts.shop._nave")
@include("layouts.shop._errors")
@include("layouts.shop._messages")
@yield("content")
<!-- header -->
<!-- banner -->

@include("layouts.shop._footer")
<!-- for bootstrap working -->
<script src="/public/bootstrap/js/bootstrap.js"></script>

<!-- //for bootstrap working -->
</body>
</html>