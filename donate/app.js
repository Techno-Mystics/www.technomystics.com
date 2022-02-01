App = {
    web3Provider: null,
    accounts: [],
    donateTo: '0x3cE8Ee797ce0dc3ACbDf308f4E504EB0f6149737',
    currentBalance: null,
    currentUSDBalance: null,
    currentGoalPercent: null,
    contracts: {},
    connected: false,
    web3: null,
    chainId: null,
    acceptedNetworks: [ 137 ],
    networkAccepted: false,
    esJsonData: null,
    maticPrice: null,
    latestTXHash: null,
    opexMonthly: 100,


    // This is the first function called. Here we can setup stuff needed later
    init: async function() {
        // Show loading spinner
        App.loadingSpinner(true);

        // Get the current price of ETH from etherscan.io
        var curPriceEth = await $.ajax('https://www.technomystics.com/donate/include/polyStatsAPI.php?cmd=maticprice',{
            dataType: 'json',
            success: function (data,status,xhr) {
                console.log("MATIC->USD: "+data.result.maticusd);
                App.maticPrice = data.result.maticusd;

            },
              error: function(jqXhr, textStatus, errorMessage){
              console.log("ajax error: "+errorMessage);
            }

        });

        // Get current balance of account
        var curBalance = await $.ajax('https://www.technomystics.com/donate/include/polyStatsAPI.php?cmd=accountbalance',{
            dataType: 'json',
            success: function (data,status,xhr) {
                console.log("Balance API Result: "+data.result)
                App.currentBalance = parseFloat((data.result / 1000000000000000000).toString().split('e')[0]);
                console.log("Current Balance: "+App.currentBalance);
                App.currentUSDBalance = parseFloat((App.currentBalance * App.maticPrice).toString().split('e')[0]).toFixed(2);
                console.log("Current USD Balance: "+App.currentUSDBalance);
                //console.log(typeof App.currentUSDBalance);

            },
              error: function(jqXhr, textStatus, errorMessage){
              console.log("ajax error: "+errorMessage);
            }
        });

        // Discover Percent of Progress
        App.currentGoalPercent = ((App.currentUSDBalance / App.opexMonthly) * 100).toFixed(0);
        console.log("Current Percentage: "+App.currentGoalPercent);
        if(App.currentGoalPercent > 100){
            App.currentGoalPercent = 100;
        }

        // Draw the bar
        $('#goal-progress-title').text("Progress Towards Monthly Goal: $"+App.opexMonthly);
        $('#goal-progress').find('.progress-bar').css('width',App.currentGoalPercent+"%");
        $('#goal-progress').find('.progress-bar').prop('aria-valuenow',App.currentGoalPercent);
        $('#goal-progress').find('.progress-bar').text(App.currentGoalPercent+"%");
        $('#goal-progress').show();

        return await App.initWeb3();
    },
  
    // Initialize Web3
    initWeb3: async function() {
  
        // First we check to see which type of Web3 we're using.
      // Modern dapp browsers...
      if (window.ethereum){
        try {
          //Request account access
          App.accounts = await window.ethereum.request({ method: "eth_requestAccounts" });
          App.connected = true;
        } catch (error) {
          // User denied account access...
          console.error("User denied account access");
          App.connected = false;
        }
        
        // User granted access to accounts
        console.log("Account[0]: "+App.accounts[0]);
        
        App.web3Provider = window.ethereum;
        console.log("modern dapp browser");
      }
      // Legacy dapp browsers...
      else if (window.web3) {
          try {
            App.web3Provider = window.web3.currentProvider;
            App.accounts = window.eth.accounts;
            console.log("legacy dapp browser");
          } catch (error) {
              console.error("User denied account access");
              App.connected = false;
          }
        
      }
      else{
          // Failed to connect to wallet or wallet account access denied
          App.connected = false;
      }

      // Initialize Web3
      if(App.connected){
        App.web3 = new Web3(App.web3Provider);
        // Get current Blockchain Network and check if we accept
        App.chainId = await App.web3.eth.net.getId();
        console.log("Chain ID: "+App.chainId);

        if(App.acceptedNetworks.includes(App.chainId)){
            console.log("Valid Blockchain Network");
            App.networkAccepted = true;
        }
        
        console.log("App.connected: "+App.connected);
        return App.drawDonateForm();
      }
      else{
          return App.drawWalletOptions();
          
      }

    },

    drawWalletOptions: function(){
        $('#getWallet').show();
        App.loadingSpinner(false);
    },

    // Draw the form for donating ETH on the mainnet
    drawDonateForm: function(){
        var donateRow = $('#donateRow');
        var donateTemplate = $('#donateTemplate');

        // Check if we have an account unlocked
        if(App.connected){
            donateTemplate.find('.btn-donate').prop("disabled",true);
        }
        else{
            donateTemplate.find('.btn-donate').prop("disabled",false);
        }

        // Check if we're on an accepted network
        if(App.networkAccepted){
            donateTemplate.find('.btn-donate').prop("disabled",false);
        }
        else{
            donateTemplate.find('.btn-donate').hide();
            donateTemplate.find('.btn-switch').show();
        }

        donateRow.append(donateTemplate.html());

        return App.bindEvents();
    },



    switchNetwork: async function(){
        await window.ethereum.request({ method: "wallet_switchEthereumChain",
            params: [{ chainId: '0x89'}] });

    },

    // Bind to some events to make our app function
    bindEvents: function() {
        // Donate Button Clicked
        $(document).on('click', '.btn-donate', App.handleDonate);

        // Switch to Polygon Network
        $(document).on('click', '.btn-switch', App.switchNetwork);

        // Account Changed in Wallet
        App.web3Provider.on('accountsChanged',(accounts) =>{
            App.handleAccountChange(accounts);
        });

        // Network Changed in Wallet
        App.web3Provider.on('chainChanged', (chainId) => {
            App.handleChainChange(chainId);
        });

        // Wallet received RPC Message
        App.web3Provider.on('message',(message) =>{
            App.handleRPCMessage(message);
            console.log("Got Message Event");
        });

        // Update the donation amount in USD based on captured ETH->USD price earlier
        $('#donation-amount').on("input",function(){
            var amount = parseFloat($(this).val());
            $('#usd-conv-donation').text("~$"+(amount*App.maticPrice).toFixed(2));
        
        });

        // Should be finished loading by now
        App.loadingSpinner(false);


    },

    handleRPCMessage: function(message){
        //console.log(message);
        if(App.latestTXHash){
            if(message.data.result.hash == App.latestTXHash.blockHash){
                console.log(message);
                // Alert the user that their transaction has been submitted.
                var container = $('#container');
                var alert = $('#alert');
                alert.find('#alert-title').html('Transaction Successful: <a href="https://polygonscan.com/tx/'+App.latestTXHash.transactionHash+'" target="_blank" class="alert-link">'+App.latestTXHash.transactionHash+'</a>');
                alert.show();
                container.append(alert.html());
                setTimeout(function(){
                    alert.hide();
                },6000);


            }
        }
    },

    // What happens when the user switches blockchain networks?
    handleChainChange: function(chainId){
        var newChainId = parseInt(chainId,16);
        console.log("Changed to Network: "+newChainId);

        if(App.acceptedNetworks.includes(newChainId)){
            console.log("Valid Blockchain Network");
            App.networkAccepted = true;
        }

        // For now we will just reload the page
        window.location.reload();


    },

    // Handle accepting donations via the Donate button
    handleDonate: async function() {
        var amount = $('#donation-amount').val();
        var sender = App.accounts[0];
     
        // Amount must be greater than 0
        if(amount > 0){
            await App.transferEth(App.accounts[0].toString(),App.donateTo.toString(),amount.toString());

            // Transaction attempted, zero out the textbox.
            $('#donation-amount').val(0);
            $('#usd-conv-donation').text('~$0.00');

        }
        else{
            window.alert("Amount must be greater than 0.");
        }

    },

    // The user switched accounts, notify them we're tracking and update proper variables
    handleAccountChange: async function(accounts){
        var container = $('#container');
        var alert = $('#alert');
        console.log("new Account: "+accounts[0]);
        App.accounts = accounts;

        alert.find('#alert-title').text('Changed to account: '+App.accounts[0]);
        alert.show();
        container.append(alert.html());
        setTimeout(function(){
            alert.hide()
        },6000);

    },

    // Perform and ETH transaction on the mainnet
    transferEth: async function(sender,receiver,amount){
        var txHash = await App.web3.eth.sendTransaction({
            to:receiver,
            from:sender,
            value:App.web3.utils.toWei(amount,"ether")
        },function(err,result){
            if(err){
                window.alert(err.message);
            }
        });
        // Record the last txHash
        console.log(txHash);
        App.latestTXHash = txHash;

        // Alert the user that their transaction has been submitted.
        
        var container = $('#container');
        var alert = $('#alert');
        alert.find('#alert-title').html('Transaction Submitted: <a href="https://polygonscan.com/tx/'+txHash.transactionHash+'" target="_blank" class="alert-link">'+txHash.transactionHash+'</a>');
        alert.show();
        container.append(alert.html());
        setTimeout(function(){
            alert.hide();
        },6000);
       

    },

    loadingSpinner: function(show) {
        if(show == true){
            $('#loading-spinner').show();
        }
        else{
            $('#loading-spinner').hide();
        }
    }
}

// Execute the app when the DOM is ready
$(function() {
    $(document).ready(function() {
      App.init();
    });
});