<?php
/**
	 * Function to break an xml file into several smaller files 
	 * If the orig xml file is smaller than max size then it will be converted into a single file
	 * @param string $boundaryTag for product boundary tag name
	 * @param int $startAt file number to start at 
	 * @param int maxItems how many occurences of the item to break the file at
	 * @param string $rawdata the raw data from the original xml file
	 * @param string $fixedFooter if not null then footer will be this string and not computed
	 * @returns $arrFiles array of filenames created
**/



	$items=0;

	function breakIntoFiles($boundaryTag, $startAt, $maxItems, $rawdata, $fixedFooter) {
		 
			$arr = explode("\n",$rawdata);
			GLOBAL $items; // no.of items done in loop. resets to zero everytime a file is created
			$files = $startAt; // count of files created
			$length = count($arr); 
			$header = ""; // header block for xml file
			$footer = ""; // footer block for xml file
			$chunk = "";  // chunk of xml data to be written into file
			$arrFiles = array(); // array of files created
			$boundaryIsFound = false; // true when first boundary tag is found
			$fileWritten = false;	 // false if some data has not been written to file

					// get footer data
			$footerBreak= "</" . trim($boundaryTag). ">";		

			for ($i = $length-1; $i>= 0; $i--){
				$line = $arr[$i];
				if (strpos($line, $footerBreak) == false) {
					$footer = $line . "\r\n" . $footer;
				}
				else
					break;
			}

					// process main data		
			for ($i = 0;$i < $length; $i++){
				$line  = $arr[$i];
							
				if (strpos($line, "<". trim($boundaryTag) . ">") !== false ||
					strpos($line, "</" . trim($boundaryTag) ." ") !== false) {
					$items ++;
					$boundaryIsIsFound = true;
				}


				if (!$boundaryIsFound)
					$header .= $line . "\r\n";
	
				
				if ($items >= $maxItems) {
					$items = 0;
					$files++;

					$filename =  $files . ".xml";
					$f = fopen($filename, "w");
					fwrite($f,$header);
					fwrite($f, $chunk);
					if ($fixedFooter == null || $fixedFooter == '')
						fwrite($f, $footer);
					else
						fwrite($f, $fixedFooter);	
					fclose($f);
					$arrFiles[] = $filename;
					$chunk = $line . "\r\n";
					$fileWritten = true;
				}
				else {
					$fileIsWritten = false;
					if ($boundaryIsFound)
						$chunk .= $line . "\r\n";
				}
			}

			if (!$fileIsWritten ) {
					$files++;

					$filename =  $files . ".xml";
					$f = fopen($filename, "w");
					fwrite($f,$header);
					fwrite($f, $chunk);
					fclose($f);
					$arrFiles[] = $filename;
				
			}

			return $arrFiles;

	}		

	$x = file_get_contents("10.xml");
	// echo $x;
	$rawdata1 = $x;
	$fixedFooter1="</wiki>";
	$boundaryTag1 = "page";
	$startAt1 = 0;
	$maxItems1 = 1;

	$temp= breakIntoFiles($boundaryTag1, $startAt1, $maxItems1, $rawdata1, $fixedFooter1);

	var_dump($temp);

?>