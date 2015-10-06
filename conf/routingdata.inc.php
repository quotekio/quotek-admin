<?php

  $routing = array ('/' => 'index.php',
                    '/app' => 'app.php',
                    '/app/signout' => 'app.php',
                    '/install' => 'install.php',

                    //ACE hack
                    '/mode-c_cpp.js' => 'acehack/mode-c_cpp.js',
                    '/theme-monokai.js' => 'acehack/theme-monokai.js',
                    '/theme-xcode.js' => 'acehack/theme-xcode.js',
                    '/theme-chaos.js' => 'acehack/theme-chaos.js',
                    
		    		'/async/auth' => 'async/auth.php',
		    		'/async/chlang' => 'async/chlang.php',
		    		'/async/gettemplate' => 'async/gettemplate.php',
		    		'/async/login' => 'async/login.php',
                    '/async/resolvemessage' => 'async/resolvemessage.php',

                    '/async/app/object' => 'async/app/object.php',
                    '/async/app/alldata' => 'async/app/alldata.php',
                    '/async/app/gettable' => 'async/app/gettable.php',
                    '/async/app/graphdata' => 'async/app/graphdata.php',
            		'/async/app/getapp' => 'async/app/getapp.php',
            		'/async/app/config/delete' => 'async/app/delconfig.php',
                    '/async/app/adamctl' => 'async/app/adamctl.php',
                    '/async/app/gwctl' => 'async/app/gwctl.php',
                    '/async/app/backtestctl' => 'async/app/backtestctl.php',
                    '/async/app/grapher' => 'async/app/grapher.php',
                    '/async/app/sess2json' => 'async/app/sess2json.php',
                    '/async/app/gitctl' => 'async/app/gitctl.php',
                    '/async/app/histview' => 'async/app/histview.php',
                    
                    '/async/app/stats/trades' => 'async/app/stats/trades.php',
                    '/async/app/stats/perf' => 'async/app/stats/perf.php'



  );
?>
