<?php 

$xmlString = file_get_contents('goodxml.xml');
$newxmlString = "";
$array = preg_split("/\r\n|\n|\r/", $xmlString);

// new xml & fix
foreach ($array as $line) {
	
		// @fix

		$newxmlString  =  $newxmlString . $line;

		// native name country
		if (strpos($line, 'name native') !== false) {
			
				$nativenamere = '/<name native="(.*?)">(.*?)</ms';

				preg_match($nativenamere, $line, $nativename, PREG_OFFSET_CAPTURE, 0);

				if($nativename){
					
					$newxmlString  =  $newxmlString . '<nativename>' . $nativename[1][0] . '</nativename>';
					
				}
			
		}
		
		// native language 
		if (strpos($line, 'language') !== false) {
			
				$langre = '/<language native="(.*?)">(.*?)</ms';

				preg_match($langre, $line, $nativelang, PREG_OFFSET_CAPTURE, 0);

				if($nativelang){
					
					$newxmlString  =  $newxmlString . '<nativelang>' . $nativelang[1][0] . '</nativelang>';
					
				}
			
		}
		
		
		
		// map Latitudine & Longitudine
		if (strpos($line, 'map_url') !== false) {
			
				$mapre = '/@(.*?),(.*?),/ms';

				preg_match($mapre, $line, $map, PREG_OFFSET_CAPTURE, 0);

				if($map){
					
					$newxmlString  =  $newxmlString . '<latitudine>' . $map[1][0] . '</latitudine>';
					$newxmlString  =  $newxmlString . '<longitudine>' . $map[2][0] . '</longitudine>';
					
				}
		}
		
		// currency code
		if (strpos($line, 'currency') !== false) {
			
				$currencyre = '/<currency code="(.*?)">(.*?)</ms';

				preg_match($currencyre, $line, $currency, PREG_OFFSET_CAPTURE, 0);

				if($currency){
					
					$newxmlString  =  $newxmlString . '<currencycode>' . $currency[1][0] . '</currencycode>';
					$newxmlString  =  $newxmlString . '<currencyname>' . $currency[2][0] . '</currencyname>';
					
				}
		}
	
	
}



$xml = new SimpleXMLElement($newxmlString);

//print_r($xml);

// open table
echo "<table><tr><td>Regiune</td><td>Țară</td><td>Limbă</td><td>Moneda</td><td>Latitudine</td><td>Longitudine</td></tr>";


foreach ($xml as $element) {
	
	
	
	echo "<tr><td>". $element['zone'][0] ."</td><td>".$element->name."(".$element->nativename.")</td><td>".$element->language."(".$element->nativelang.")</td><td>".$element->currencyname."(".$element->currencycode.")</td><td>".$element->latitudine."</td><td>".$element->longitudine."</td></tr>";
		
	
}

// close table
echo '</table>';





?>