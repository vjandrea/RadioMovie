<?php


class Podcasting {

	private $log = '';
	private $feed_url = '';
	private $xml = ''; 

	function __construct($feedurl)
	{
		$this->log = "New instance of ".__CLASS__."\n";
		if($feedurl != "")
		{
			$this->feed_url = trim($feedurl);
			$this->log .= "Feed url: ".$this->feed_url."\n";
		}
	}

	public function dump_log()
	{
		return $this->log;
	}

	public function load_feed()
	{
		$this->log .= "load_feed()\n";
		$this->xml = simplexml_load_file($this->feed_url);
	}

	public function dump_xml()
	{
		var_dump( $this->xml );
	}

	public function process($filter = "")
	{
		$this->log .= "process({$filter})\n";

		// we load the feed
		$this->load_feed();

		foreach($this->xml->channel->item as $item)
		{
			$from = array('“','”','–',"''",'’','RADIOMOVIE');
			$to = array('"','"','-','"',"");

			$d = new DateTime($item->pubDate);
			$currentItem = $d->format('d/m/Y')."\t".str_replace($from, $to, $item->title);


			if(stristr($item->title,$filter))
			{
				echo "<strong>{$currentItem}</strong>\n";
			}
			else
			{
				//echo "{$currentItem}\n";
			}
			
		}
	}
}