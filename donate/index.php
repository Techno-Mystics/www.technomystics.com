
<?php
# Start server session
session_start();

?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.88.1">
        <title>TechnoMystics.com</title>
        <link rel="icon" type="image/png" href="https://discourse.technomystics.com/uploads/default/optimized/1X/ea2a40c6e7df3ff4835089c1cd2bed1298710b87_2_32x32.jpeg">
    
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
        
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <!-- Custom JavaScript -->
        <script src="/js/m_menu.js"></script>
        <script src="/js/all.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        
        <!--Web3 Stuff-->
        <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
        
        <!-- Load our App -->
        <script src="/donate/app.js"></script>
      </head>

      <body class="d-flex h-100 text-center text-white bg-dark">

      <div class="d-flex w-100 h-100 p-3 mx-auto flex-column">
      <?php
        include '../include/header.php';
      ?>
          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-sm-8 col-sm-push-2">
                <h1 class="text-center">Donate to TechnoMystics</h1>
                <p>TechnoMystics is now accepting donations in Polygon (MATIC)</p>
                <p>We utilize Web3.js to connect to your browser extension wallet</p>
                <hr/>
                <br/>
              </div>
            </div>
      
            <div id="donateRow" class="row">
              <!-- PETS LOAD HERE -->
            </div>
          </div>
      
          <div id="donateTemplate" style="display: none;">
            <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="panel panel-default panel-pet">
                <div class="panel-heading">
                  <h3 class="panel-title">Donate Polygon (MATIC)</h3>
                </div>
                <div class="panel-body">
                  <br/><br/>
                  <img src="/media/pics/polygon-matic-logo.png" height="100px">
                  <br><br>
                  <input type="number" id="donation-amount" value="0">
                  <br><br>
                  <small id="usd-conv">~$0.00</small>
                  <br><br>
                  <button id="donate-button" class="btn btn-light btn-donate" type="button">Donate</button>
                </div>
              </div>
            </div>
          </div>

          <div id="accountTemplate" style="display: none;">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="panel panel-default panel-pet">
                  <div class="panel-heading">
                    <h3 class="panel-title">Account Balance</h3>
                  </div>
                  <div class="panel-body">
                    <br><br>
                    <h2 id="balance-amount">0</h2>
                    <br><br>
                    <small id="usd-conv">~$0.00</small>
                    <br><br>
                    <button id="donate-button" class="btn btn-light btn-donate" type="button">Donate</button>
                  </div>
                </div>
              </div>
          </div>

          <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
            <small id="alert-title">alert</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>


          <?php
            include '../include/footer.php';
          ?>
        </div>
      </body>
</html>