<?php


		
	$subject='Get In Touch ';
	
	$to='democon3232@gmail.com'; 
	$from='info@thehighways.in'; 
	$name='dev';
	
	$message = 'test here';

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Get In Touch - '.$name.'<'.$from.'>' . "\r\n";

	$result=mail($to,$subject,$message,$headers); 
	
	
	if($result)
	{
		
		echo 1;
		
	}else{
		
		echo 0;
		
	}	 
	

?>