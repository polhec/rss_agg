<?php
 
//Naslovi RSS feedov, ki bodo vključeni

$ra_strani = array(
	'http://med.over.net/feed/', 
	'http://travel.over.net/feed/',
	'http://style.over.net/feed/'
	);

require_once('autoloader.php'); //Naloži SimplePie
 
$feed = new SimplePie();
$feed->set_feed_url( $ra_strani );
$feed->init();

//$feed->handle_content_type();
$file = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?><rss version=\"2.0\" >

<channel>
 	<title>RSS Over.net</title>
 	<description>Združeni RSS feedi Over.net</description>
 	<link>http://med.over.net</link>
 	<lastBuildDate>" .  date('r', time()) . "</lastBuildDate>
 	<pubDate>" .  date('r', time()) . "</pubDate>
	<language>sl-SI</language>
 ";
foreach ($feed->get_items() as $item):

$file .= "
  	<item>
  		<title>" . $item->get_title() . "</title>";

	foreach ($item->get_categories() as $category)
	{
		$file .= "\n\t\t<category><![CDATA[" . $category->get_label() . "]]></category>";
	}
$file .= "
  		<description><![CDATA[" . $item->get_description() . "]]></description>
  		<link>" . $item->get_permalink() . "</link>
  		<guid isPermaLink=\"false\">" . $item->get_permalink() . "</guid>
  		<pubDate>" . $item->get_date() . "</pubDate>
 	</item>
 ";
endforeach;

$file .= "
</channel>
</rss>";

// Izpiši kodo v brskalnik
echo $file;

//Izpiši kodo v datoteko "index.rss"
//file_put_contents("index.rss", $file);
	

?>