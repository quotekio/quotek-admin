<?php

  require_once("include/functions.inc.php");

  $path_ok1 = 'C:\foo\bar';
  $path_ok2 = 'z:///foo/bar';
  $path_ok3 = 'B:\\\\foo\bar';
  $path_ok4 = 'B:\\\\foo\bar foo';

  $path_err1 = '/tototos';
  $path_err2 = '0:\gjgdd\titi';
  $path_err3 = 'c\gjgdd\titi';
  $path_err4 = 'c/gjgdd\titi';
  $path_err5 = 'c:B/gjgdd\titi';
  $path_err6 = 'c:\fjksqkj+4?';


  



  echo "TEST1: ";
  echo  (pathValidate($path_ok1,'windows') === true ) ? 'OK' : 'ERROR';
  echo "<br>";
  echo "TEST2 ";
  echo (pathValidate($path_ok2,'windows') === true ) ? 'OK' : 'ERROR';
  echo "<br>";
  echo "TEST3 ";
  echo (pathValidate($path_ok3,'windows') === true) ? 'OK' : 'ERROR';  
  echo "<br>";

  echo "TEST4 ";
  echo (pathValidate($path_ok4,'windows') === true) ? 'OK' : 'ERROR';  
  echo "<br>";



  echo "TEST5 (ERR1):";
  echo (pathValidate($path_err1,'windows') === false ) ? 'OK' : 'ERROR';
  echo "<br>";
  echo "TEST6 (ERR2):";
  echo (pathValidate($path_err2,'windows') === false ) ? 'OK' : 'ERROR';  
  echo "<br>";
  echo "TEST7 (ERR3):";
  echo (pathValidate($path_err3,'windows') === false ) ? 'OK' : 'ERROR';
  echo "<br>";
  echo "TEST8 (ERR4):";
  echo (pathValidate($path_err4,'windows') === false ) ? 'OK' : 'ERROR';  
  echo "<br>";

  echo "TEST9 (ERR5):";
  echo (pathValidate($path_err5,'windows') === false ) ? 'OK' : 'ERROR';  
  echo "<br>";

  echo "TEST10 (ERR6):";
  echo (pathValidate($path_err5,'windows') === false ) ? 'OK' : 'ERROR';  
  echo "<br>";


  echo "<br><br> **** UNIX ***** <br><br>";

  $path_ok1 = '/foo/bar/fooooqj';
  
  $path_err1 = 'fjksksjsqk/tototo';
  $path_err2 = '/usr/bin/ghsjss()/bar';


  echo "TEST1 ";
  echo (pathValidate($path_ok1,'unix') === true) ? 'OK' : 'ERROR';  
  echo "<br>";

  echo "TEST2 (ERR1):";
  echo (pathValidate($path_err1,'unix') === false ) ? 'OK' : 'ERROR';
  echo "<br>";
  echo "TEST3 (ERR2):";
  echo (pathValidate($path_err2,'unix') === false ) ? 'OK' : 'ERROR';  
  echo "<br>";






  



?>





<!-- <html>

  <head>
    <script type="text/javascript" src="/js/jquery.js"></script>

    <script type="text/javascript" src="/js/jquery.jqplot.min.js"></script>
    <link rel="stylesheet" type="text/css" hrf="/css/jquery.jqplot.min.css" />
    <script language="javascript" type="text/javascript" src="/js/jqplot.plugins/jqplot.barRenderer.js"></script>
    <script language="javascript" type="text/javascript" src="/js/jqplot.plugins/jqplot.categoryAxisRenderer.js"></script>
     <script type='text/javascript' src='/js/bootstrap.js'></script>
     <script type='text/javascript' src='/js/chiliconfig.js'></script>

  </head>

  <body>
    <div id="chart1" style="height:400px;width:600px;background:black"></div>

    <script type="text/javascript">

    var line1 = [['Nissan', 4],['Porche', 6],['Acura', 2],['Aston Martin', 5],['Rolls Royce', 6]];
 
    if ($('#chart1').length <= 0) alert('Chart 1 not present');

    else {

    $('#chart1').jqplot([line1], {
        title:'Default Bar Chart',
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
        },
        axes:{
            xaxis:{
                renderer: $.jqplot.CategoryAxisRenderer
            }
        }
    });

    /*
    $('#chart1').jqplot([[[1, 2],[3,5.12],[5,13.1],[7,33.6],[9,85.9],[11,219.9]]],

      { title:'Exponential Line',
        axes:{yaxis:{renderer: $.jqplot.LogAxisRenderer}},
        series:[{color:'#5FAB78'}]
      }


    ); */

    }

    </script>


  </body>


</html>

-->


