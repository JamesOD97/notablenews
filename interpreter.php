<?php

class Interpreter {

    public $source = 0;
    public $feed = 0;
	
	function interpret($domdocFeed) {
	
	    $aryArticles = [];
	
	    switch ($this->source) {
	    
	        case 1:						// The Verge
	        
	            $domlistArticles = $domdocFeed->getElementsByTagName('entry');
										// Get all articles
	            foreach ($domlistArticles as $domitmArticle) {
	                                    // For each article
	                $artclArticle = new Article();
	                                    // Create an article class
	                $pub_time = strtotime(trim($domitmArticle->getElementsByTagName('published')->item(0)->nodeValue));
	                $title = trim($domitmArticle->getElementsByTagName('title')->item(0)->nodeValue);
                    $content = strip_tags(trim($domitmArticle->getElementsByTagName('content')->item(0)->nodeValue));
	                $link = trim($domitmArticle->getElementsByTagName('id')->item(0)->nodeValue);
	                $author = trim($domitmArticle->getElementsByTagName('author')->item(0)->nodeValue);
	                                    // Get the relevant info from the feed
	                $artclArticle->pub_time = $pub_time;
	                $artclArticle->title = $title;
	                $artclArticle->content = $content;
	                $artclArticle->link = $link;
	                $artclArticle->author = $author;
	                $artclArticle->feed = $this->feed;
	                                    // Add it to the class
	                
	                $aryArticles[] = $artclArticle;
	                                    // Add the article to the list of articles
	            }
	            
	            break;
	            
            case 2:						// Literally everyone else
			case 3:
			case 4:
			case 5:
			case 7:
            
                $domlistArticles = $domdocFeed->getElementsByTagName('item');
                                        // Get all articles
                foreach ($domlistArticles as $domitmArticle) {
                                        // For each article
                    $artclArticle = new Article(); 
                                        // Create an article class
                    $pub_time = strtotime(trim($domitmArticle->getElementsByTagName('pubDate')->item(0)->nodeValue));
                    $title = trim($domitmArticle->getElementsByTagName('title')->item(0)->nodeValue);
					$content = strip_tags($domitmArticle->getElementsByTagName('description')->item(0)->nodeValue);
					$content = preg_replace('/\n/', ' ', $content);
                    $content = preg_replace('/(\&nbsp;|\&hellip;|\&#8230;|\&#8212;|\&#8220;|\&#8221;|[^a-zA-Z0-9\s\&#8217;\-])/', '', $content);
					$content = trim(preg_replace('/(Read More|Read more)(.*)/', '', $content));
                    $link = trim($domitmArticle->getElementsByTagName('guid')->item(0)->nodeValue);
                                        // Get the relevant info from the feed
	                $artclArticle->pub_time = $pub_time;
	                $artclArticle->title = $title;
	                $artclArticle->content = $content;
	                $artclArticle->link = $link;
	                $artclArticle->feed = $this->feed;
	                                    // Add it to the class
                    
                    $aryArticles[] = $artclArticle;
	                                    // Add the article to the list of articles
                }
                
                break;
				
            default:
                die("Some random uninterpretable source was selected, or rather some source wasn't selected. Fix it.");
                break;
	    }
	    
	    return $aryArticles;
	}
}

?>
