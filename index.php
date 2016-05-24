<?php

$secure = parse_ini_file('/home/notablenews/.secure/secure.ini');

require('article.php');                 // Includes the holder class 'Article'
require('difference.php');				// Includes the difference calculator function

$conn = new mysqli($secure['hostname'], $secure['username'], $secure['password'], $secure['db']);
										// Connect to MYSQL
										
$referenceArticle = new Article();
$referenceArticle->title = "The dark side to Uber’s unstoppable cash grab";
$referenceArticle->content = "Uber's insane fundraising streak looks to get even more insane, as the New York Times is reporting that a new fund for super wealthy investors to bet on Uber has recently cropped up. But even as cash continues to rain down on Silicon Valley's biggest unicorn, the deluge could spell trouble for Uber on a number of fronts. Morgan Stanley and Bank of America are encouraging private wealth clients with net worths of $10 million to invest in a fund call the New Rider LP, which is a fancy way for people with money to buy stock in companies that haven't gone public yet. The strange thing, though, is that investors aren't allowed to view any of Uber's financial information, which in essence means they are making blind bets on Uber. The fund is part of the $10 billion in capital already raised by the startup, which has been recently valued at $62.5 billion. Even weirder, the investors don't get direct equity in Uber, which means there are less protections for investors should Uber go belly up. But this hasn't stopped these investors from committing $500 million to Uber's latest round of fundraising. A blind bet on Uber But talk about crummy timing! The news about rich people making a rich company even richer came the middle of a pretty bad PR week for Uber. The backlash to the company's new atom-and-bit logo is in full swing, especially among Wall Street commentators. (FT said it suggests \"arrogance and inconsistency,\" while Inc said it \"reveals everything that's wrong\" with the company.) Drivers in New York and San Francisco are coming out in droves to protest the recent fare cuts. And an even bigger protest is being planned for this Sunday's Super Bowl, which threatens to undercut Uber's image in its own backyard. So any news about millionaires being encouraged to pump more money into Uber's already bulging coffers is sure to reinforce perceptions that the company is out of touch — perceptions that founder and CEO Travis Kalanick said he specifically trying to reverse through the company's recent rebranding. \"The early app was an attempt at something luxury,\" Kalanick told Wired. \"That's where we came from, but it's not where we are today.\" As more and more investors jump on the Uber bandwagon, the pressure on Kalanick to go public will certainly ratchet up. Kalanick seems to be trying to hold off on an IPO until he can bleed the capital markets dry. After all, an IPO would mean his investors would like to start seeing returns on their investments, and would require that Uber form a less friendly board of directors than what it has now. Kalanick, a reputed micromanager, would no doubt balk at that. \"Take the goddamn company public\" But investors and the big banks are getting antsy with Uber. Not content to coast on fees and the like, they will eventually want to reap the rewards from Uber's IPO. \"When you take money from me, am I getting money from you?\" venture capitalist Fred Wilson, who is not an investor in Uber, told Business Insider recently. \"You have a responsibility to give me my money back sometime. You can't just say fuck you. Take the goddamn company public.\" All of which could spell good news for Uber's main rival, Lyft. The lesser ride-hail company has recently been forced into a brutal price war with Uber, which has in turn fueled a mini-revolt among drivers. But Lyft's partnership with General Motors, as well as investments from seasoned venture capitalists Carl Icahn and Marc Andreessen, could help keep it afloat until Uber goes public. At that point, Uber will have to throw the curtain back on its revenue-generating operation, which will provide an abundance of insight into the stability (or lack there of) of the on-demand economy the ride-hail company helped create.";

if (!$conn->connect_error) {			// If connection successful

	$sqlstmtGetArticles = "SELECT `id`, `title`, `content`, `link` FROM `articles`;";
										// Select all the news feeds
										
	if ($sqlrsltGetArticles = $conn->query($sqlstmtGetArticles)) {
										// Get SQL results
										// If successful return
		$sqlrsltGetArticles->data_seek(0);	// Pushes the result cursor to the beginning
		
		$differences = [];
		$articles = [];
										
		while ($article = $sqlrsltGetArticles->fetch_assoc()) {
										// Foreach article found,
			$artclArticle = new Article();
			$artclArticle->id = $article['id'];
			$artclArticle->title = $article['title'];
			$artclArticle->content = $article['content'];
			$artclArticle->link = $article['link'];
			
			$articles[$artclArticle->id] = $artclArticle;
			$differences[$artclArticle->id] = difference($referenceArticle, $artclArticle);
		}
		
		arsort($differences);
		
		foreach($differences as $id => $difference) {
			
			print '<a href="' . $articles[$id]->link . '">' . $articles[$id]->title . '</a><br />';
		}
	} else {
		print "Hrhflkjbr";
	}
} else {
	print "Eror";
}
		
?>