<DOCTYPE HTML>
<html	lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>Pokaż dane</title>
</head>

<body>
	<?php
		ini_set("auto_detect_line_endings", true);
		
		$file_in = "CsvSampleOpenData Zadanie 1.csv";

		$keys = array();
		$newArray = array();
		
		// Otwieranie bazy
		$connection = new Mongo();
		$db = $connection->selectDB( "MyBase" );
		$collection = $db->selectCollection( "Transaction" );
		
		//echo $collection->count();
		$collection->remove();

		function csvToArray($file, $delimiter) { 
		  if (($handle = fopen($file, 'r')) !== FALSE) { 
			$i = 0; 
			while (($lineArray = fgetcsv($handle, 0, $delimiter, '"')) !== FALSE) { 
				for ($j = 0; $j < count($lineArray); $j++) { 
				$arr[$i][$j] = $lineArray[$j]; 
				} 
			  $i++; 
			} 
			fclose($handle); 
		  } 
			return $arr; 
		} 

		$data = csvToArray($file_in, ',');
		/* debagger
		echo "<pre>";
			print_r($data);
		echo "</pre>";
		*/
		$n = count($data);
		
		$count = count($data) -1;
		$labels = array_shift($data);  
		foreach ($labels as $label) {
			$keys[] = $label;
		}
		
		$count_keys = count($keys);
		//print_r("$count ,$count_keys");
		
		$keys[] = 'id';

		for ($i = 0; $i < $count; $i++) {
			$data[$i][] = $i;
		}

		for ($j = 0; $j < $count; $j++) {
			//if ($count = $count_keys) {
			
			
			
			
			$d = array_combine($keys, $data[$j]);
			
			//} else {
			//	echo "Błąd";
			//}
		//print_r($d);
		$newArray[$j] = $d;
		$collection->insert($d);
		}
		$dane= json_encode($newArray);
		
		
		
		//Zapis danych do pliku
	/*
		$file_out = fopen("Zadanie 1.json","c");
		fputs($file_out, $dane);
		fclose($file_out);
		print_r("Utworzono plik: Zadanie 1.json");
		*/
		// Wyświetlenie wszystkich wyników
		$cursor = $collection->find();
		foreach ($cursor as $id => $value) {
			echo "$id: ";
			var_dump( $value );
		}
		// pierwszego		
		//$rangeQuery = array('id' => 2);
		//print_r($collection->find().limit(1);
	?>


</body>
</html>