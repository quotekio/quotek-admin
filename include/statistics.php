<?php

  /* Changes an array of the form [ [x1,y1],..,[xn,yn] ] 
     to an array of the form { 'XT' : [x1,..,xn], 'YV': [y1,..,yn] }
     This is very useful since jquery flot takes its datasets as form 1,
     which is quite hard to process as is.
  */
  function dedupDataArray($data_array) {

    $result = array( 'XT' => array(), 'YV' => array() );
    foreach ($data_array as $point) {
      $result['XT'][] = $point[0];
      $result['YV'][] = $point[1];
    }
    return $result;
  }

  /*
  Packs data in stacks of pack_size elements, shifting by one element each time.
  Useful for moving average computation
  */
  function packDataArrayMoving($data_array,$pack_size) {

    $result = array();
    $offset = 0;

    for ($i=0;$i<count($data_array) - $pack_size ;$i++) {
      $result[$i] = array();
      for ($j=$offset; $j< $offset + $pack_size; $j++) {
        $result[$i][] = $data_array[$j];
      }
      $offset++;
    }

    return $result;
  }

  function average($data) {
    $avg = 0.00;
    foreach($data as $point) {
      $avg += $point;
    }
    $avg /= count($data);
    return $avg;
  }

  function variance($data) {
    $avg = average($data);
    $variance = 0.00;

    for($i=0; $i<count($data); $i++) {
      $variance += pow( $data[$i] - $avg, 2);    
    }
    $variance /= count($data);
    return $variance;
  }

  function covariance($data1, $data2) {
    $avg1 = average($data1);
    $avg2 = average($data2);
    $covariance = 0.00;

    for($i=0; $i<count($data1); $i++) {
      $covariance += ( $data1[$i] - $avg1 ) * ( $data2[$i] - $avg2 );
    }

    $covariance /= count($data1);
    return $covariance;
  }

  //computes the standard deviation.
  function sigma($data) {
    return sqrt(variance($data));
  }


  /* ##### GRAPHABLE FUNCTIONS ##### */

  function movingAverage($data, $period, $add_bollinger=false) {
   
    $result = array( 'moving_average' => array(),
                     'bollinger_1' => array(),
                     'bollinger_2' => array() );

    $dedup_array = dedupDataArray($data);

    $packed_array = packDataArrayMoving($dedup_array['YV'], $period);
    
    for ($i=0;$i< count($packed_array);$i++) {

      $cavg = average($packed_array[$i]);

      $result['moving_average'][] = array($dedup_array['XT'][$i + $period] , $cavg );

      if ($add_bollinger) {
      	$csigma = sigma($packed_array[$i]);
        $result['bollinger_1'][] = array($dedup_array['XT'][$i + $period], $cavg - 2 * $csigma );
        $result['bollinger_2'][] = array($dedup_array['XT'][$i + $period], $cavg + 2 * $csigma );
      }
    }
    return $result;
  }

  function linearRegression($data,$add_raff=false) {
    $result = array( 'linear_regression' => array(),
                     'raff_1' => array(),
                     'raff_2' => array() );


    $dedup_array = dedupDataArray($data);

    $avgxt = average($dedup_array['XT']);
    $avgyv = average($dedup_array['YV']);

    /* Computes linear regression coefficients */
    $a = covariance($dedup_array['XT'], $dedup_array['YV']) / variance($dedup_array['XT']);
    $b = $avgyv - ($a * $avgxt);

    /* Computes std dev (eventually useful for RAFF) */ 
    $csigma = sigma($dedup_array['YV']);

    /* Given LREG Coefs, we translate Y points */
    for ($i=0;$i< count($data); $i++ ) {

      $ny = $a * $dedup_array['XT'][$i] + $b;
      
      $result['linear_regression'][] = array( $dedup_array['XT'][$i], $ny );
      if ( $add_raff ) {
        $result['raff_1'][] = array($dedup_array['XT'][$i], $ny - $csigma );
        $result['raff_2'][] = array($dedup_array['XT'][$i], $ny + $csigma );
      }
    }

    return $result;
  }

?>