<?php
 
  /**************************************************************************** 
	Php script to export database table by table into seprate CSV files
	Author: Bahar Ali (baharalikhaan@gmail.com)
	Release: Dec 11, 2019
	***************************************************************************/
	 
	$host = "";  
	$user = "";  
	$password = "";  
	$dbname = "";  
	$con = mysqli_connect($host, $user, $password,$dbname);
    $resource =  mysqli_query($con,"SHOW TABLES");
  
    $location="path-to-output-directory";
    $tables = ['table1','table2'];
	
    while ($row =  mysqli_fetch_array($resource))
	{
     $table = $row[0];
	 if(in_array( $table ,  $tables ))
	 {
		$data = array();
		$header = array();
	 
	    //get table header
		$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE  TABLE_SCHEMA='".$dbname."' and TABLE_NAME='".$table."'";
		$result = mysqli_query($con,$sql);
		while($row = mysqli_fetch_array($result))
		{
			array_push($header,$row[0]);
		}
		$data[] =  $header;
		
		//get data
		$query = "SELECT * FROM ".$table;
		$result = mysqli_query($con,$query);
		
		while($row = mysqli_fetch_array($result))
		{
			$arr2 = array();
			for($i=0; $i<sizeof($row)/2;$i++) 
			{
				 array_push($arr2,$row[$i]);
			}
			 
		 $data[]=$arr2;
		  
		}

		$filename = $location.$table.'.csv';
		$export_data =  $data;
		$file = fopen($filename,"w");
		foreach ($export_data as $line){
		  fputcsv($file,$line);
		}
		fclose($file); 
	 }
    }
    exit();
    ?>
