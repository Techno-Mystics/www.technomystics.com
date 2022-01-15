<?php
# Start server session
session_start();

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
	header("Location: https://mail.technomystics.com/");
}

?>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Mail.TechnoMystics.com</title>

    <!-- Bootstrap core CSS -->
	<link href="/css/bootstrap.min.css" rel="stylesheet">

	<meta name="theme-color" content="#7952b3">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    
    <!-- Custom styles for this template -->
    <link href="/css/index.css" rel="stylesheet">
    
    <!-- Custom JavaScript -->
    <script src="/js/m_menu.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </head>
<body class="d-flex h-100 text-center text-white bg-dark">
	  
    
<div class="d-flex w-100 h-100 p-3 mx-auto flex-column">

<!-- ALERT -->
<!--
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <small>your ip address</small>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
-->
<?php
include 'include/header.php';
?>
<div class="h-100 p-3 align-middle">
	<ul class="list-group w-50 mx-auto" style="text-align: left;">
	  <li class="list-group-item list-group-item-dark"><a class="link-dark" href="https://mail.technomystics.com/">Login To Webmail</a> <small>(roundcube)</small></li>
	  <li class="list-group-item list-group-item-dark"><a class="link-dark" href="https://mail.technomystics.com/pfadmin/users/login.php">Manage Account</a></li>
	  <li class="list-group-item list-group-item-dark"><a class="link-dark" href="https://discourse.technomystics.com/t/go-for-all-systems/14">New Account</a></li>
	</ul>
</div>

<?php
include 'include/footer.php';
?>
</div>


    
 </body>

<script>
setMenuItem("m_mail");
</script>

</html>
