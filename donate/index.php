
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
            <div class="row justify-content-center">
              <div class="col-xs-12 col-sm-8 col-sm-push-2">
                <h1 class="text-center">Donate to TechnoMystics</h1>
                <p>TechnoMystics is now accepting donations in Polygon (MATIC)</p>
                <p><a href="https://polygon.technology/" target="_blank" class="link-light">Polygon</a> connects multiple Ethereum compatible blockchains and helps us minimize transaction fees.</p>
                <p>Donate using our Web3 app below or send Polygon(MATIC) directly to our address: <a href="https://polygonscan.com/address/0x3cE8Ee797ce0dc3ACbDf308f4E504EB0f6149737" target="_blank" class="link-light">0x3cE8Ee797ce0dc3ACbDf308f4E504EB0f6149737</a></p>
                <hr/>
                <h3 id="goal-progress-title">Progress Towards Monthly Goal: $-</h3>
                <div class="progress" id="goal-progress" style="display: none;">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>


                <hr/>
                <br/>
              </div>
            </div>
      
            <div id="donateRow" class="row justify-content-center">
              <!-- Loading Spinner -->
              <div id="loading-spinner" class="spinner-border text-light" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <!-- PETS LOAD HERE -->
            </div>
          </div>
      
          <div id="donateTemplate" class="mx-auto" style="display: none;">
            <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="panel panel-default panel-pet">
                <div class="panel-heading">
                  <h3 class="panel-title">Donate Polygon (MATIC)</h3>
                </div>
                <div class="panel-body">
                  <br/><br/>
                  <img src="/media/pics/polygon-matic-logo.png" height="100px">
                  <br><br>
                  <div class="input-group mb-3 input-group-sm">
                    <span class="input-group-text">MATIC</span>
                    <input type="text" id="donation-amount" class="form-control col-xs-4" aria-label="Amount in MATIC" width="300px">
                    <span id="usd-conv-donation" class="input-group-text">$-</span>
                  </div>
                  
                  <button id="donate-button" class="btn btn-light btn-donate" type="button">Donate</button>
                  <button id="switch-to-matic" class="btn btn-light btn-switch" type="button" style="display: none;">Switch to Polygon</button>
                </div>
              </div>
            </div>
          </div>

          <div id="getWallet" style="display: none;">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="panel panel-default panel-pet">
                  <div class="panel-heading">
                    <h3 class="panel-title">No Wallet Detected</h3>
                  </div>
                  <div class="panel-body">
                    <br><br>
                    <h4 id="message">You need a crypto wallet and some Polygon (MATIC) to donate. We recommend <a href="https://metamask.io" target="_blank" class="link-light">Metamask</a>!</h4>
                    <a href="https://metamask.io" target="_blank"><img src="/media/pics/metamaskicon.png" width="100px"></a>
                    <br><br>
                    <small>Once installed, <a href="/donate/" class="link-light">reload</a> this page.</small>



                    <br><br>
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

      <script>
        setMenuItem("m_donate");
      </script>
</html>