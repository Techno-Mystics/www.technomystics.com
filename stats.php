<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
	<title>Stats.TechnoMystics.com</title>
<!-- Bootstrap core CSS -->
<link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
<link rel="icon" href="/assets/img/favicons/favicon.ico">
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
</head>


<body class="d-flex h-100 w-100 text-center text-white bg-dark">
<div class=" d-flex w-100 h-100 p-3 mx-auto flex-column">


<?php
include 'include/header.php';
//&from=1641887774891&to=1642060574892

$dt = new DateTimeImmutable();
$dtInterval = $dt->modify("-48 hours");

?>

<hr>

	<div class="w-100 p-3">
	<iframe src="https://stats.technomystics.com:3000/d/lj6brF17k/stats-technomystics-com?orgId=1&from=<?php echo strtotime($dtInterval->format('Y-m-d H:i:s'))*1000; ?>&to=<?php echo strtotime($dt->format('Y-m-d H:i:s'))*1000; ?>&kiosk" width="100%" height="1600px" frameborder="0"></iframe>
	</div>

<?php
include 'include/footer.php';
?>

</div>
</body>


<script>
setMenuItem("m_stats");
</script>


</html>
