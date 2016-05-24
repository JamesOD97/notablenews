<?php

function difference($article1, $article2) {
	
	$article1Words = array_filter(explode(" ", strtolower($article1->content)));
	$article2Words = array_filter(explode(" ", strtolower($article2->content)));
	
	return 2*count(array_unique(array_intersect($article1Words, $article2Words)))/(count(array_unique(array_merge($article1Words, $article2Words))));
}

?>