<?php
	include 'simple_html_dom.php';

	function getGenre($url) {
		$html = file_get_html('http://www.imdb.com'.$url);
		$allGenre = "";
		foreach ($html->find("div[itemprop=genre]") as $element) {
			foreach($element->find('a') as $genre) {
				$allGenre = $allGenre.trim($genre->plaintext).",";
			}
		}
		return mb_substr($allGenre, 0, -1);	
	}


	/*function getDirector($url) {
		$html = file_get_html('http://www.imdb.com'.$url);
		
		foreach ($html->find('div[itemprop=director] a span') as $element) {
			echo $element->plaintext;
		}	
	}*/

?>
