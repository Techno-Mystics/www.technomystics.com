<?php
# Start server session
session_start();




?>

<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>TechnoMystics.com</title>

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
    <link href="/css/all.css" rel="stylesheet">
    
    <!-- Custom JavaScript -->
    <script src="/js/m_menu.js"></script>
    <script src="/js/all.js"></script>
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

    <div class="w-100 h-100 p-3">
    <p class="lead"><img src="/media/pics/techno.png" height="100px"> + <img src="/media/pics/mystic.png" height="100px"> = <img src="/media/pics/technomystic.png" height="100px"></p>
    </div>


<?php
include 'include/footer.php';
?>
</div>


    
  </body>

<script>
setMenuItem("m_home");
</script>

</html>

