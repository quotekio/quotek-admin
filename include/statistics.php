<?php

  /* Changes an array of the form [ [x1,y1],..,[xn,yn] ] 
     to an array of the form { 'A1' : [x1,..,xn], 'A2': [y1,..,yn] }
     This is very useful since jquery flot takes its datasets as form 1,
     which is quite hard to process as is.
  */
  function dedupDataArray($data_array) {

    $result = array( 'A1' => array(), 'A2' => array() );
    foreach ($data_array as $point) {
      $result['A1'][] = $point[0];
      $result['A2'][] = $point[1];
    }
  }

  /*
  Packs data in stacks of pack_size elements, shifting by one element each time.
  Useful for moving average computation
  */
  function packDataArrayMoving($data_array,$pack_size) {

    $result = array();
    $offset = 0;

    for ($i=0;$i<count($data_array);$i++) {
      $result[$i] = array();
      for ($j=$offset; $j<$offset+$pack_size; $j++) {
        $result[$i][] = $data_array[$j];
      }
      $offset++;
    }
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
      $covariance += ( $data1[$i][1] - $avg1 ) * ( $data2[$i][1] - $avg2 );
    }

    $covariance /= count($data1);
    return $covariance;
  }

  //computes the standard deviation.
  function sigma($data) {
    return sqrt(variance($data));
  }

  //cumulative average
  function cavg($point,$average,$count) {
    return ($average + (($point - $average) / $count));
  }


  /* ##### GRAPHABLE FUNCTIONS ##### */

  function movingAverage($data, $period, $add_bollinger=false) {
   
    $result = array( 'moving_average' => array(),
                     'bollinger_1' => array(),
                     'bollinger_2' => array() );

    $dedup_array = dedupDataArray();
    $packed_array = $dedup_array['A1'];

    for ($i=0;$i< count($packed_array);$i++) {

      $cavg = average($packed_array[$i]);

      $result['moving_average'][] = array($cavg, $dedup_array['A2'][$i]);

      if ($add_bollinger) {
      	$csigma = sigma($packed_array[$i]);
        $result['bollinger_1'][] = array( $cavg - 2 * $csigma, $dedup_array['A2'][$i]);
        $result['bollinger_2'][] = array( $cavg + 2 * $csigma, $dedup_array['A2'][$i]);
      }
    }




    return $result;


  }

  function linearRegression($data,$add_raff=false) {
    $result = array( 'linear_regression' => array(),
                     'raff_1' => array(),
                     'raff_2' => array() );

    return $result;
  }

?>