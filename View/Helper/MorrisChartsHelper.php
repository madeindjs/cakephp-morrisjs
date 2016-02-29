<?php

/*
  Copyright 2012 Scott Harwell

  Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
 */

App::uses ('HtmlHelper', 'View/Helper');
App::uses ('MorrisCharts', 'MorrisCharts.Vendor');

class MorrisChartsHelper extends AppHelper
{
  public $options = array(
            'targetDiv' => 'graph',
            'type'      => 'Line',
            'resize'    =>  'true',
            'hideHover' =>  'false'
  );

  public $targetDiv = 'graph';
  public $labels = array();
  public $yKeys = array();
  private $data = array();


  //to copy script in the deafult layout header
  public function scriptDefaultLayout()
  {
    return 
      '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">'.
      '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>'.
      '<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>'.
      '<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>';
  }

  //a function to set the number of 
  private function setYKeys($array)
  {
    $yKeys = array();
    for( $i=1 ; $i < count($array) ; $i++){
      array_push($yKeys, $i);
    }
    return $yKeys;
  }

  //a function to parse the data to the MorrisJS's format 
  private function setData($array)
  {
    $return = '';

    for( $i = 0 ; $i < count($array[0]) ; $i++ )
    {
      $arrayToPush = array();
      for( $j=0 ; $j < count($array) ; $j++){
        $arrayToPush += array( $j => $array[$j][$i] );
      }
      $this->data[$i] = $arrayToPush ;
      // $return = $return.json_encode($arrayToPush , JSON_FORCE_OBJECT) ;
    }

/*    $return = str_replace('}{', '},{', $return);
    return '['.$return.']' ;*/
    
  }


  //a function to generate the javascript chart in the view
  public function createJsChart ( $labels , $array  , $options  )
  {



    if(isset($options['targetDiv'])){   $this->options['targetDiv']  = $options['targetDiv'] ;}
    if(isset($options['type'])){        $this->options['type']       = $options['type'] ;}
    if(isset($options['resize'])){      $this->options['resize']     = $options['resize'] ;}
    if(isset($options['hideHover'])){   $this->options['hideHover']  = $options['hideHover'] ;}

    if (!in_array( $this->options['type'] , array('Line' , 'Area' , 'Bar')))
    {
      debug('Type must be Line, Area or Bar');
      return null;
    }

    

    $this->labels = $labels ;
    $this->yKeys = $this->setYKeys($array);
    $this->setData($array);

    $this->labels[0] ='';
    array_shift($this->labels);

    return "<script type='text/javascript'>
        $(function() {
          Morris.".$this->options['type']."({
                hideHover: ".$this->options['hideHover']." ,
                element: ".$this->options['targetDiv'].",
                resize: ".$this->options['resize'].",
                data: ".json_encode($this->data).",
                ykeys: ".json_encode($this->yKeys).",
                xkey: '0',
                labels: ".json_encode($this->labels)."
              });
        });</script>";
  }

}
