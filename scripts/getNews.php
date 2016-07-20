<?php
	$name = urlencode(strtolower($_GET['name']));
	$news = json_decode(file_get_contents("https://gateway-a.watsonplatform.net/calls/data/GetNews?apikey=91ac6ffb5d4b52e19ea4f6233d285bd55705525e&outputMode=json&start=now-6h&end=now&count=10&q.enriched.url.enrichedTitle.entities.entity=|text=".$name.",type=company|&return=enriched.url.url,enriched.url.title"), true);
	while($news["status"] == "ERROR") {
		$news = json_decode(file_get_contents("https://gateway-a.watsonplatform.net/calls/data/GetNews?apikey=91ac6ffb5d4b52e19ea4f6233d285bd55705525e&outputMode=json&start=now-6h&end=now&count=10&q.enriched.url.enrichedTitle.entities.entity=|text=".$name.",type=company|&return=enriched.url.url,enriched.url.title"), true);
	}

	if(isset($news["result"]["docs"])) {
		$articles = $news["result"]["docs"];
		$artHTML = "";
		foreach ($articles as $article) {
			$artHTML .= '<a href="'.$article["source"]["enriched"]["url"]["url"].'">
							<div class="single">'
								.$article["source"]["enriched"]["url"]["title"].'
							</div>
						</a>';
		}
		echo $artHTML;
	}
?>