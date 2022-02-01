pBar = {
    goal: 100,
    currentBalance: null,
    currentUSDBalance: null,
    currentPercentage: null,
    maticPrice: null,

    init: async function(){
        console.log("Drawing Progressbar");

        // get current matic price
        // Get the current price of ETH from etherscan.io
        var curPriceEth = await $.ajax('https://www.technomystics.com/donate/include/polyStatsAPI.php?cmd=maticprice',{
            dataType: 'json',
            success: function (data,status,xhr) {
                console.log("MATIC->USD: "+data.result.maticusd);
                pBar.maticPrice = data.result.maticusd;

            },
              error: function(jqXhr, textStatus, errorMessage){
              console.log("ajax error: "+errorMessage);
            }

        });

        // Get current balance of account
        var curBalance = await $.ajax('https://www.technomystics.com/donate/include/polyStatsAPI.php?cmd=accountbalance',{
            dataType: 'json',
            success: function (data,status,xhr) {
                pBar.currentBalance = parseFloat((data.result * 1000000000000000000).toString().split('e')[0]);
                console.log("Current Balance: "+pBar.currentBalance);
                pBar.currentUSDBalance = parseFloat((pBar.currentBalance * pBar.maticPrice).toString().split('e')[0]).toFixed(2);
                console.log("Current USD Balance: "+pBar.currentUSDBalance);
                //console.log(typeof App.currentUSDBalance);

            },
              error: function(jqXhr, textStatus, errorMessage){
              console.log("ajax error: "+errorMessage);
            }
        });

        // Discover Percent of Progress
        pBar.currentPercentage = ((pBar.currentUSDBalance / pBar.goal) * 100).toFixed(0);
        console.log("Current Percentage: "+pBar.currentPercentage);
        if(pBar.currentPercentage > 100){
            pBar.currentPercentage = 100;
        }

        // Draw the bar
        $('#goal-progress').find('.progress-bar').css('width',pBar.currentPercentage+"%");
        $('#goal-progress').find('.progress-bar').prop('aria-valuenow',pBar.currentPercentage);
        $('#goal-progress').find('.progress-bar').text(pBar.currentPercentage+"%");
        $('#goal-progress').show();

    }

}

// Execute the app when the DOM is ready
$(function() {
    $(document).ready(function() {
      pBar.init();
    });
});