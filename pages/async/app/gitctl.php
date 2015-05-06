<?php

  require_once('include/functions.inc.php');
  use Gitonomy\Git\Repository;

  $repository = new Repository($GIT_LOCATION);

  $lang = 'en';
  selectLanguage();
  require_once("lang/$lang/app.lang.php");

  if (!verifyAuth()) die('You are not logged');

  if (!isset($_REQUEST['action'])) die('No action Provided');

  $action = $_REQUEST['action'];

  //Create Branch function
  if ($action == 'createbranch') {
    $branch_name = $_REQUEST['branch_name'];
    $repository->run('checkout', array('-b',$branch_name));
  }

  if ($action == 'checkout') {
    $branch_name = $_REQUEST['branch_name'];
    $repository->run('checkout', array($branch_name)); 
  }
  
  else if ($action == 'deletebranch') {
    $branch_name = $_REQUEST['branch_name'];
    $repository->run('branch', array('-D',$branch_name));   
  }

  else if ($action == 'getbranches') {
    $branches = array();
    foreach ($repository->getReferences()->getBranches() as $branch) {
        $branches[] = $branch->getName();
    }
    echo json_encode($branches);
  }

  else if ($action == 'getinfos') {
    
    $commit = $repository->getHeadCommit();
    foreach ($commit->getTree()->getEntries() as $name => $data ) {
      if (  strpos($name,".qs") > 0 || strpos($name,".qsm") > 0) {
        print $name;
        print_r($data);
      }
    }

  }

  else if ($action == 'commit') {
    $commit_message = $_REQUEST['commit_message'];
    $repository->run('add', array('-A'));
    $repository->run('commit', array('--author', $_SESSION['uinfos']['username'] . 
                                                 ' <' . $_SESSION['uinfos']['username'] . '@' . 
                                                 $_SERVER['SERVER_NAME'] . '>' , 
                                                 '-m', "\"$commit_message\""));
  }

  else if ($action == 'checkpending') {

    $outp = $repository->run('status',array());
    if (strstr($outp,'nothing to commit')  !== false ) echo json_encode(array('pending' => false));
    else echo json_encode(array('pending' => true));
    
  }

?>