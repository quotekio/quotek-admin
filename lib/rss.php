<?php

class Rss()  {

  function __construct($url,$max_items=5) {

    $rss = new DOMDocument();
    $rss->load($url);
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
?>