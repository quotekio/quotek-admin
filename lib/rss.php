<?php

class Rss {

  function __construct($url,$max_items=5) {

    $opts = array(
            'http'=>array(
                    'timeout' => 2, 
                    'method'=>"GET",
                    'header'=>"Accept-language: en,fr\r\n" .
                     "Cookie: foo=bar\r\n" .
                     "User-Agent: VH RSS Reader")
            );
    $context = stream_context_create($opts);
    
    libxml_use_internal_errors (true);
    $rss = new DOMDocument();
    $rss->recover = true;
    $rss->strictErrorChecking = false;

    $xml_data = file_get_contents($url,false,$context);

    if (! $rss->loadXML($xml_data) ) {
      var_dump ( libxml_get_errors () );
    }
    
    else  {
      $this->feed = array();
      $nitems = 0;
      foreach ($rss->getElementsByTagName('item') as $node) {
        $item = array (
        'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
        //'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
        //'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
        'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue);

        $this->feed[] = $item;
        if ( count($this->feed) == $max_items ) break;
      }
    }
  }
};
?>
