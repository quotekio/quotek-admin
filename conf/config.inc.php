<?php
  $SITE_ROOT = '/usr/local/qate/admin/web';
  $MODULES_PATH='/usr/local/qate/admin/vhmodules';
  $MAIL_FROM = "no-reply@chiliconfig.com";
  $CONTACT_EMAIL = "clement@digi-nation.com";

  $QATE_PATH = "/usr/local/qate/";
  $QATE_TMP = "/tmp/qate";
  
  $QATE_PIDFILE = "$QATE_TMP/qate.pid";
  $EXEC_QUEUE_FILE = "${QATE_TMP}/run.queue";

  //autoreboot options
  $AR_MAXTRIES = 5;
  $AR_DATA_EXPIRES = 3600;

  $GIT_USER = 'git';
  $GIT_LOCATION='/quotek';

  $QATE_BT_EXPORTS = "/usr/local/qate/admin/data/dumps";

  $QATE_AEP_ADDR = "127.0.0.1";
  $QATE_AEP_PORT = 9999;
  
  $VH_VERSION = "4.0 alpha2";
  $API_VERSION= "1.0.0";
  $API_LASTMOD = "2013-09-07";

  $DEMO_MODE = false;
  $DEMO_BROKER_MODULE = 'igconnector3';
  $DEMO_BROKER_PARAMS = '{"username":"***REMOVED***","password":"***REMOVED***","api_key":"***REMOVED***","api_url":"https://demo-api.ig.com"}';

  $LANG_LIST = array('en' => 'English' , 'fr' => 'Français');

  $TWITTER_CONSUMER_KEY = 'hp9gZjRQzuz1vq88P0vqevEE2';
  $TWITTER_CONSUMER_SECRET = '0R9VnDuJn0yCnfdXXUHaG3fJcFx5cf5ARpES49ThejYmKb62KS';
  $TWITTER_ACCESS_TOKEN = '2998838957-7yfKiu7bUIasBQXasI4IXVOiaVoLyHgy2WIRiIo';
  $TWITTER_ACCESS_TOKEN_SECRET = 'szrpOO7X8f66irda1HyjLlpkDGyAW2R9TfSy3ZFhJJFOb';


  $SOURCE_DEFAULT = <<<EOT
class newstrat: public strategy {
  public:

    quotek::broker* br0;
                  
    int initialize() {

      //put your init code here

      br0 = new quotek::broker(this);
      return 0;

    }

    void evaluate() {

      //put your evaluation code here

    }
};

EOT;

  $INCLUDE_PATHS = array ('/usr/local/qate/admin',
			  '/usr/local/qate/admin/includes',
			  '/usr/local/qate/admin/classes',
			  '/usr/local/qate/admin/lib',
			  '/usr/local/qate/admin/lib/influx',
			  '/usr/local/qate/admin/templates',
			  '/usr/local/qate/admin/lang'
 			 );

  foreach($INCLUDE_PATHS as $incpath) {
    set_include_path(get_include_path() . ':' . $incpath);
  }

  try{
    $dbhandler = new PDO('sqlite:'.dirname(__FILE__).'/../data/quotek.sqlite');
    $dbhandler->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbhandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
} catch(Exception $e) {
    echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
    die();
}

//#### GRAPHIC SETTINGS ####
$PCOLOR = '#1AB394';
$LCOLOR = '#ED5565';


//loads composer autoload
require __DIR__ . '/../vendor/autoload.php';

?>
