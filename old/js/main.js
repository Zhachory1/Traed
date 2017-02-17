$(function(){
    //Default values
    var listOfSym = [],
        currStock = 0;

    //Timer
    $("#time").clock();

    //Get User's data
    /**************************************************************************/
    getUserStocks(1);
    /**************************************************************************/

    //Events
    /**************************************************************************/
    $("#sl").on('click', '.single', function() {
        var id = parseInt($(this).attr("id"))
        if(id != currStock) {
            currStock = id;
            setNewStock(id);
            //Nice scroll bars.
        }
    });

    $("#logout").click(function(e) {
        e.preventDefault();
        $.ajax("scripts/logout.php");
        window.location.href = 'http://localhost/stock_app/index.php';
    });

    $("#addStock").submit(function(e) {
        e.preventDefault();
        var that = $("#addStock").serialize();
        $.ajax("scripts/addUserStock.php?"+that)
            .done(function(data) {
                if(data == 0) {
                    $("#addErr").html("This stock symbol is not valid.").fadeIn(500).delay(5000).fadeOut(500);
                } else {
                    $("#addSuc").html("The stock has been added to your portfolio. Please wait while we load your portfolio...").fadeIn(500).delay(2000).fadeOut(500);
                    setTimeout(function() {
                        $("#add").modal("hide")
                        getUserStocks(0);
                    }, 2000);
                }
            });
    });

    $("#sl").on('click', '.rem', function() {
        console.log("Clicked")
        var that = "remsym=" + $(this).attr("value");
        $.ajax("scripts/removeUserStock.php?"+that)
            .done(function(data) {
                if(data == listOfSym[currStock][2]) {
                    currStock = 0;
                    setNewStock(0);
                }
                getUserStocks(0);
            });
    });
    /**************************************************************************/

    //Refreshes
    /**************************************************************************/
    /**************************************************************************/


    //Functions
    /**************************************************************************/
    function setNewStock(currentStock) {
        currStock = currentStock;
        $(".single").removeClass("active");
        $("#"+currStock).addClass("active");
        $("#graph").html('<iframe frameBorder="0" src="chart.php?sym='+listOfSym[currentStock][0]+'"></iframe>');

        //Get and fill percent chart
        Highcharts.getOptions().plotOptions.pie.colors = (function () {
            var colors = [],
                base = Highcharts.getOptions().colors[0],
                i;

            for (i = 0; i < 10; i += 1) {
                // Start out with a darkened base color (negative brighten), and end
                // up with a much brighter color
                colors.push(Highcharts.Color(base).brighten((i - 3) / 10).get());
            }
            return colors;
        }());

        $('#per').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: true,
                type: 'pie',
                backgroundColor: "transparent"
            },
            title: {
                text: null
            },
            tooltip: {
                pointFormat: '<b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: "#e0e0e0",
                        format: '{point.percentage:.1f} %',
                        style: { 
                            textShadow: false
                        }
                    }
                }
            },
            series: [{
                name: 'Buy or Sell',
                data: [
                    { name: 'Buy', y: 75.33 },
                    { name: 'Sell', y: 24.67 }
                ]
            }]
        });
    }

    function fillStockList() {
        $("#listOfSL").html("");
        $("#remsym").html("");
        for (var i = 0; i <= listOfSym.length-1; i++) {
            if(currStock == i) {
                $("#listOfSL").append('<div class="single active" id="'+i+'"><div type="button" class="rem btn btn-default" value="'+listOfSym[i][2]+'"><span class="glyphicon glyphicon-minus"></span></div><h3>'+listOfSym[i][0]+'</h3></div>');
            } else {
                $("#listOfSL").append('<div class="single" id="'+i+'"><div type="button" class="rem btn btn-default" value="'+listOfSym[i][2]+'"><span class="glyphicon glyphicon-minus"></span></div><h3>'+listOfSym[i][0]+'</h3></div>');
            }
        }
        $("#sl").niceScroll();
    }   

    function getUserStocks(firstTime) {
        $.getJSON("scripts/getUserStocks.php", function (data) {
            listOfSym = data;
            //Initialize with first stock in list
            //Fill stock list info
            fillStockList();
            //Get and fill stock chart, detail stock info, news, and pie chart
            fillStockList(currStock);
            if (firstTime) {
                setNewStock(currStock);
            }
        });
    }
    /**************************************************************************/
});
