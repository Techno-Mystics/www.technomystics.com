App = {
    web3Provider: null,
    accounts: [],
    donateTo: '0x3cE8Ee797ce0dc3ACbDf308f4E504EB0f6149737',
    currentBalance: null,
    currentUSDBalance: null,
    contracts: {},
    connected: false,
    web3: null,
    chainId: null,
    acceptedNetworks: [ 80001 ],
    networkAccepted: false,
    esJsonData: null,
    maticPrice: null,
    latestTXHash: null,
    opexMonthly: 100,


    // This is the first function called. Here we can setup stuff needed later
    init: async function() {

        // Get the current price of ETH from etherscan.io
        var curPriceEth = await $.ajax('https://www.technomystics.com/donate/include/polyStatsAPI.php?cmd=maticprice',{
            dataType: 'json',
            success: function (data,status,xhr) {
                console.log("MATIC->USD: "+data.result.maticusd);
                App.maticPrice = parseFloat(data.result.maticusd);

            },
              error: function(jqXhr, textStatus, errorMessage){
              console.log("ajax error: "+errorMessage);
            }

        });

        // Get current balance of account
        var curBalance = await $.ajax('https://www.technomystics.com/donate/include/polyStatsAPI.php?cmd=accountbalance',{
            dataType: 'json',
            success: function (data,status,xhr) {
                App.currentBalance = parseFloat(data.result * 1000000000000000000);
                console.log("Current Balance: "+App.currentBalance);
                App.currentUSDBalance = Number((App.currentBalance * App.maticPrice).toPrecision(3)).toString().split('e')[0];
                console.log("Current USD Balance: "+App.currentUSDBalance);
                //console.log(typeof App.currentUSDBalance);

            },
              error: function(jqXhr, textStatus, errorMessage){
              console.log("ajax error: "+errorMessage);
            }
        });

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
      }

      return App.drawAccountTemplate();
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
            donateTemplate.find('.btn-donate').prop("disabled",true);
        }

        donateRow.append(donateTemplate.html());

        return App.bindEvents();
    },

    drawAccountTemplate: function(){
        console.log("Drawing Account Template");

        var donateRow = $('#donateRow');
        var accountTemplate = $('#accountTemplate');

        accountTemplate.find('#balance-amount').text(App.currentBalance+' MATIC');
        accountTemplate.find('#usd-conv').text('$'+App.currentUSDBalance);
        accountTemplate.find('#cur-opex').text('Current Monthly Expense: $'+App.opexMonthly);

        donateRow.append(accountTemplate.html());

        return App.drawDonateForm();
    },

    // Bind to some events to make our app function
    bindEvents: function() {
        // Donate Button Clicked
        $(document).on('click', '.btn-donate', App.handleDonate);

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


    },

    handleRPCMessage: function(message){
        //console.log(message);
        if(App.latestTXHash.blockHash){
            if(message.data.result.hash == App.latestTXHash.blockHash){
                console.log(message);
                // Alert the user that their transaction has been submitted.
                var container = $('#container');
                var alert = $('#alert');
                alert.find('#alert-title').html('Transaction Successful: <a href="https://mumbai.polygonscan.com/tx/'+App.latestTXHash.transactionHash+'" target="_blank" class="alert-link">'+App.latestTXHash.transactionHash+'</a>');
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
    handleDonate: function() {
        var amount = $('#donation-amount').val();
        var sender = App.accounts[0];
     
        // Amount must be greater than 0
        if(amount > 0){
            App.transferEth(App.accounts[0].toString(),App.donateTo.toString(),amount.toString());

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
        alert.find('#alert-title').html('Transaction Submitted: <a href="https://mumbai.polygonscan.com/tx/'+txHash.transactionHash+'" target="_blank" class="alert-link">'+txHash.transactionHash+'</a>');
        alert.show();
        container.append(alert.html());
        setTimeout(function(){
            alert.hide();
        },6000);
       

    }
}

// Execute the app when the DOM is ready
$(function() {
    $(document).ready(function() {
      App.init();
    });
});