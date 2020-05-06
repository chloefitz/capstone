<?php

// clean up input data
function clean_input ($data){
    $data = trim($data);  // trim white spaces
    $data = strip_tags($data); // strip tags
    $data = stripslashes($data); // strip slashes
    $data = htmlspecialchars($data); // strip html special characters
    return $data;
        
}

// print array
function prettify($x){
    print "<PRE>";
    print_r ( $x );
    print "</PRE>";
}

// validate email
function isValidEmail ($email){
  
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // validate it is a correctly formed email
        
        $isValid = false;
    }   
    else {
        
        $isValid = true;
    }
    return $isValid;
}

// validate dates
function isValidDate ($submitDate){
   
    if (strlen($submitDate) > 6 OR strlen($submitDate) < 6 ){ // string length must be 6 characters
        $isValid = false;
    }
    elseif (!ctype_digit($submitDate)){ // must be number
        $isValid = false;
    }
    
    elseif ($submitDate){
        $submitDate = date("Y-m-d", strtotime($submitDate)); // convert data to proper date format
    
        $isValid = true;
        
    }
    
 
    return $isValid;
}

//random booking id 

function random_num() {
    $randomsArray = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9','10');
    shuffle($randomsArray);
    $randoms = array();
    
    for ($i = 0; $i < 7; $i++) {
        $randoms[] = array_pop($randomsArray);
    }
    
    $bookingId = implode('', $randoms);
	
	return $bookingId;
}


?>