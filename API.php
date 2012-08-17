<?php
		header('content-type: application/json; charset=utf-8');
		
		include('Kwirious/Kwirio.php');

		$Kwirious = new Kwirio();

		$Kwirious->setHash($_GET['h']);   
		
		$data = array();    
		
		if($Kwirious->validate()){
				$rslt = $Kwirious->crack();
				
				if($rslt == "Hash not cracked! :(")
						$data = array("hash" => $_GET['h'], "valid" => TRUE, "found" => FALSE, "result" => "");	
				else
						$data = array("hash" => $_GET['h'], "valid" => TRUE, "found" => TRUE, "result" => $rslt);					
		}
		
		else
				$data = array("hash" => $_GET['h'], "valid" => FALSE, "found" => FALSE, "result" => "");	
								
		$pattern = array(',"', '{', '}');
		$replacement = array(",\n\t\"", "{\n\t", "\n}");
		$rspn = str_replace($pattern, $replacement, json_encode($data));
				
		echo $rspn;			
?>