<?php

class Article {

    public $id;
    public $pub_time;
    public $title;
    public $content;
    public $link;
    public $author;
    public $feed;
    
    function publish($conn) {
    
        if ($sqlstmt = $conn->prepare("INSERT INTO `articles` (`pub_time`, `title`, `content`, `link`, `author`, `feed`) VALUES (?, ?, ?, ?, ?, ?);")) {
        
			$datetime = date("Y-m-d H:i:s", $this->pub_time);
        
            if ($sqlstmt->bind_param("sssssi",
                                    $datetime,
                                    $this->title,
                                    $this->content,
                                    $this->link,
                                    $this->author,
                                    $this->feed)) {
            
                if ($sqlstmt->execute()) {
                
                    if ($sqlstmt->affected_rows === 1) {
                    
                        return True;
                    } else {
                    
                        die("Did execute INSERTION statement, but nothing changed. Wat.");
                    }
                } else {
                
                    die("Could not execute INSERTION statement.");
                }
            } else {
                die("Could not bind parameter. Check this->link");
            }
        } else {
            die("Could not prepare statement. Check statement.");
        }
    }
    
    function exists($conn) {
    
        if ($sqlrsltArticles = $conn->query("SELECT `link`, `feed` FROM `articles`;")) {
        
            $sqlrsltArticles->data_seek(0);	// Pushes the result cursor to the beginning

		    while ($article = $sqlrsltArticles->fetch_assoc()) {
		
		        if (($article['link'] == $this->link) && ($article['feed'] == $this->feed)) {
		            
		            return True;
		            break;
	            }
		    }
		    
		    return False;
        } else {
            die("Misformed or rejected SQL request. Check permissions and SQL statement.");
        }
    }
}
