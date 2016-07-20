# Traed Stocks

This is a stock analysis full stack solution that indicates price reversals on stocks 
in the NYSE and NASDAQ stock exchanges for my Senior Thesis at UNT Fall 2016. My solution 
is divided into four sections, the UI, the Database, the controller, and the back-end processes 
that get and process the algorithms.

The UI uses HTML, CSS, and Javascript with many JS libraries (i.e. Jquery, Underscore, etc.) to 
create a responsive design. I also use the TradingView API to present current stock data with 
the option of showing technical indicators as an overlay. Along with that, there is a list of 
stocks that you may add or delete and also the price reversal indicator that I have created.

The database is a simple MySQL database. The schema consists of history normal OHLCV data of 15,000
stocks, 9 technical analyses of each stock, news coverage average per stock, candlestick indicator 
history, my own algorithm needs, and user portfolio and login information.

The controller uses PHP and Javascript with Ajax statements to connect the Model and the View. This 
helps also connect the TradingView API into the Dashboard.

The back-end uses Python to get data from various APIs to get news reports and stock OHLCV data and 
store it in the database. It also does it's own technical analysis computations of 9 technical 
indicators and store that in the database. It groups the TA computations together in a logical and 
advantageous way. Finally it calculates the candlestick patterns for every stock. 

### Notice

There is an algorithm I am using to calculate the price reversal indicator. But as it is patent-
pending, I will not describe or provide diagrams of how I am calculating and formatting all the 
data together.

## Usage

Go to [this site](http://thetraed.noip.me) to register. Once registered, you can login normally and go to the dashboard
to track your own stocks with a portfolio.

## Support

Please [open an issue](https://github.com/Zhachory1/Traed/issues/new) for support.
