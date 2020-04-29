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

function random_num($size) {
	$alpha_key = '';
	$keys = range('A', 'Z');
	
	for ($i = 0; $i < 2; $i++) {
		$alpha_key .= $keys[array_rand($keys)];
	}
	
	$length = $size - 2;
	
	$key = '';
	$keys = range(0, 9);
	
	for ($i = 0; $i < $length; $i++) {
		$key .= $keys[array_rand($keys)];
	}
	
	return $alpha_key . $key;
}


?>