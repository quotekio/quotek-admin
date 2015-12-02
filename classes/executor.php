<?php

class executor {

  function __construct($queue_file) {
    $this->queue_file = $queue_file;
  }

  function enqueue($cmd) {
    file_put_contents($this->queue_file,$cmd . "\n", FILE_APPEND | LOCK_EX);
  }

  function poll() {

    while(1) {

      $queue_data = file_get_contents($this->queue_file);
      $queue_entries = split("\n", $queue_data);
      foreach ($queue_entries as $entry) {
      
        if ($entry != "") {

	        $pid = pcntl_fork();

	        if ($pid == -1) {
	          die('dupplication impossible');
	        } 
	        else if ($pid) {   
	          //parents  
	          file_put_contents($this->queue_file,"", LOCK_EX );
	          //pcntl_wait($status);
	        }

	        else {
	          echo "RUNNING \"" . $entry . "\"\n" ;
	          exec($entry);
	          exit();
	        }
        }
      }
      sleep(.5);
    }
    
  }
}

?>