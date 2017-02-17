<!DOCTYPE html5>
<html>
<head>
	<title>TradingView Chart Widget</title>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=100" />
	<link rel="dns-prefetch" href="https://dwq4do82y8xi7.cloudfront.net/">
  <link href="https://dwq4do82y8xi7.cloudfront.net/static/css/embed_widget.5ae035f8366e.css" rel="stylesheet" type="text/css">
	<style type="text/css">
		html {
			height: 100vh;
		}
	</style>
</head>
<body>
	<!-- TradingView Widget BEGIN -->
<script type="text/javascript" src="https://d33t3vvu2t2yu5.cloudfront.net/tv.js"></script>
<script type="text/javascript">
new TradingView.widget({
  "autosize": true,
  "symbol": "<?php echo $_GET['sym'];?>",
  "interval": "D",
  "timezone": "Etc/UTC",
  "theme": "White",
  "style": "1",
  "locale": "en",
  "toolbar_bg": "#f1f8f6",
  "hide_side_toolbar": false,
  "details": true,
  "news": [
    "headlines"
  ],
  "hotlist": true,
  "hideideas": true,
  "studies": [
    "MASimple@tv-basicstudies"
  ],
  "show_popup_button": true,
  "popup_width": "1000",
  "popup_height": "650"
});
</script>
<!-- TradingView Widget END -->

</body>
</html>