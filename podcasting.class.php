<?php

/**
 * Podcasting parser
 *
 * Usage:
 * 		require_once('podcasting.class.php');
 * 		$p = new Podcasting('http://server.url/feed.rss');
 *   	echo $p->filter('Tech');
 * 
 * @category   RSSParsers
 * @package    RadioMovie
 * @author     Andrea Bergamasco <info AT vjandrea DOT net>
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    Release: master
 * @link       http://github.com/vjandrea/RadioMovie
 */
class Podcasting {

	private $debug_log = '';
	private $feed_url = '';
	private $raw_xml = ''; // raw content of the RSS feed


	/**
	 * Podcasting constructor
	 * @param string $feedurl the url of the RSS feed to parse.
	 */
	function __construct($feedurl)
	{
		$this->debug_log = "New instance of ".__CLASS__."\n";
		if($feedurl != "")
		{
			$this->feed_url = trim($feedurl);
			$this->debug_log .= "Feed url: ".$this->feed_url."\n";
		}
		return true;
	}


	/**
	 * Returns the debug log.
	 * @access public 
	 * @return string the debug log content.
	 */
	public function dump_debug_log()
	{
		return $this->debug_log;
	}


	/**
	 * Loads the RSS feed.
	 * @access private 
	 * @return boolean true if the RSS has been loaded successfully.
	 */
	private function load_feed()
	{
		$this->debug_log .= "load_feed()\n";
		return ($this->raw_xml = simpleraw_xml_load_file($this->feed_url));
	}


	/**
	 * Returns the raw RSS content.
	 * @access public
	 * @return string the xml content of the RSS feed.
	 */
	public function dump_raw_xml()
	{
		var_dump( $this->raw_xml );
	}


	/**
	 * Returns the filtered item titles.
	 * @access public
	 * @return string a newline separated list of item titles, null if the feed parsing failed.
	 */
	public function filter($filter = "")
	{
		$this->debug_log .= "process({$filter})\n";

		if($this->load_feed())
		{
			foreach($this->raw_xml->channel->item as $item)
			{
				$output = '';

				$from = array('“','”','–',"''",'’');
				$to = array('"','"','-','"',"'");

				$d = new DateTime($item->pubDate);
				$currentItem = $d->format('d/m/Y')."\t".str_replace($from, $to, $item->title);


				if(stristr($item->title,$filter))
				{
					$output .= "{$currentItem}\n";
				}
				else
				{
					//echo "{$currentItem}\n";
				}
				return $output;
			}
		}
		else
		{
			return null;
		}
	}
}