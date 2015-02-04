<?php
    $developer = 'Victor'; // Please replace with your name
    $color = isset($_GET['color']) ?: '#C00';
    
    abstract class Reader {
        abstract public function __construct($filename);
        abstract public function getData();
    }
    
    class CSVReader extends Reader {
        public $csv_file;
        
        public function __construct($filename) {
            $this->csv_file = fopen($filename, 'r');
            return $this->csv_file;
        }
        
        public function getData() {
            $data = array();
            
            while ($line = fgets($this->csv_file)) {
                $data[] = explode(',', str_replace("\r\n", '', $line));
            }

			return $data;
        }
    }
    
    /*
    Added to read the data file
    */ 
  
    class DataReader extends Reader{
	public $data_file;
 
	public function __construct($filename){
	    $this->data_file = fopen($filename,'r');
	    return $this->data_file;
        }

        public function getData(){
	   //$data = json_decode($this->data_file,true);
	   $data = array();
	   $data2 = array();

           while($line = fgets($this->data_file)){
		$data[] = explode('],[', str_replace('/\[\[(\w+)\[\]/"','',$line));
	   }
           
          foreach ($data as &$data2){
	        $data2[] = explode('[,]', str_replace('/\[\[(\W+)\[\]/','',$data));
		$data2[0] = str_replace('/\[\[(\w+)\[\]/','',$data2);
		print_r($data[0]);
          }		
                    //return $data2;
        }	
    }   

    ?>
    <html>
    <head>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.js"></script>
    <script type="text/javascript" src="chart.js"></script>
    
    <style>
        #chart {
            position: relative;
            borider-bottom: 1px #000 solid;
            border-left: 1px #000 solid;
            height: 90%; //changed to '%' so the chart can be expanded
            width: 100%  //added to expand the chart 
        }
        
        #chart .value {
            background-color: #f00;
            bottom: 0;
            position: absolute;
            background: -webkit-gradient(linear, left top, left bottom, from(<?= $color ?>), to(#000));
            background: -moz-linear-gradient(top,  <?= $color ?>,  #000);
            padding: 2px;
            color: #fff;
        }
    </style>
    </head>
    <body onload="init();">
    
    <?php
    
    echo 'Lines of Code Changed per Week by ' . $developer . '<br><br>' . "\r\n";
    
    echo '<div id="chart">' . "\r\n";
     
     $file = $_GET['file'];  
      
     if ($file ===""){
     echo "No file given";

     }else{

       if ($file === "data.csv") { 
            $reader = new CSVReader ('data.csv');
            $data = $reader->getData();

        } else {
        	$reader = new DataReader($file);
       		$data = $reader->getData();
     
        }
     }

   
    foreach ($data as &$values) {
        echo '<div class="value" timestamp="' . $values[0] . '" value="' . $values[1] . '" title="' . $values[0] . ': ' . $values[1] . '"></div>' . "\r\n";
    }
    
?>
</div>
</body>
</html>
