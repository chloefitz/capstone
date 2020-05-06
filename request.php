
<?php
/*
Plugin Name: marks_landscape_request
Plugin URI: http://chelan.highline.edu/~csci201/
Description: Mark's Landscaping Request Form
Version: 1.0
Author: Domino Developers
Author URI: http://chelan.highline.edu/~csci201/
*/

function marksRequest(){
// code for error message output
ini_set('display_errors', 1);
error_reporting(E_ALL); 
require_once __DIR__ . "/dfunctions.php";
require_once __DIR__ . "/arrays.php";
require_once __DIR__ . "/ml_functions.php";



// declare variables
$name = $phone = $email = $address = $date = 
$services = $message = $propType = $company 
= $frequency = $city = $listofServices = "";

$date = $_GET['date'];

$listofServices = getServiceId();
$listofCities = getCityId();


           
// run if submit button hit
if (isset($_POST['formSubmit'])){

    // declare some variables
    $isEmailValid = $serviceValue = "";

    // POST data
    $propType = $_POST['propType'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $date = $_POST['date'];
    $service = $_POST['service'];
    $company = $_POST['company'];
    $message = $_POST['message'];
    $frequency = $_POST['frequency']; 

    // clean and sanitize data
    $propType = clean_input($propType);
    $name = clean_input($name);
    $phone = clean_input($phone);
    $email = clean_input($email);
    $address = clean_input($address);
    $city = clean_input($city);
    $date = clean_input($date);
    //$service = clean_input($service);
    $company = clean_input($company);
    $message = clean_input($message);
    $frequency = clean_input($frequency);



    // CONFIRMATION DATA echo inputs
    
    echo ("<h2>Please review your information </h2>");
    echo ("Name: $name<br />");
    echo ("Phone: $phone<br />");
    $isEmailValid = isValidEmail($email);  // validat email
    if ($isEmailValid == false) {
        echo ("<p style='color:red;'>Please provide valid email</p>");
    }
    else {
        echo ("Email: $email<br />");
    }
    echo ("Address: $address<br />");

    foreach($listofCities as $cities) { //loop got cities output
        $citiesValue = $cities['cityID'];
        $citiesName = $cities['city'];
        if ($citiesValue == $city) {
            echo ("City: $citiesName<br />");
        }    
    }
    
    echo ("Date: $date<br />");
    echo ("PropertyType: $propType<br />");

    foreach($service as $serviceValue) { // loop for services
        foreach($listofServices as $services) {
            $sValue = $services['serviceID'];
            $sName = $services['service'];
            if ($sValue == $serviceValue) {
                echo ("Services: $sName <br />");
            }
        }
        
    }
    echo ("Company: $company<br />");
    echo ("Frequency: $frequency<br />");
    echo ("Message: $message<br />");
    
    

    

    // phantom form to commit data
    echo ("<form method='post' action='http://localhost/Capstone/confirmation/confirmation_v5.php'>
        <input type='text' name='name' value='$name' hidden>
        <input type='text' name='phone' value='$phone' hidden>
        <input type='text' name='email' value='$email' hidden>
        <input type='text' name='address' value='$address' hidden>
        <input type='text' name='city' value='$city' hidden>
        <input type='text' name='date' value='$date' hidden>
        <input type='text' name='propType' value='$propType' hidden>");
        
    foreach($service as $serviceValue) { //loop for service array
        echo ("<input type='text' name='service[]' value='$serviceValue' hidden>");
    }
    
    echo ("<input type='text' name='company' value='$company' hidden>
        <input type='text' name='frequency' value='$frequency' hidden>
        <input type='text' name='message' value='$message' hidden>
        <input type='submit' name='commitSubmit' value='Submit Request' />");

    echo ("</form>");

    }
    




        // main form input
        echo ("<h1>Request an appointment today</h1>");
        echo ("<form method='post' action=''> 
        <label>Your Name:</label>
        <input type='text' name='name' value="); // name and sticky
        if (isset($_POST['formSubmit'])) {
            echo ("'$name'"); 
            echo ("required /><br /><br />");
        }

        echo ("<label>Company Name:</label>"); // compnay and sticky
        echo ("<input type='text' name='company' value=");
        if (isset($_POST['formSubmit'])) {
            echo ("'$company'"); 
            echo ("required /><br /><br />");
        }
        
        echo("<label>Phone Number:</label>"); // phone and sticky
        echo("<input type='tel' name='phone' value=");
        if (isset($_POST['formSubmit'])) {
            echo ("'$phone'");
        echo (" required /><br /><br />");
        }    

        echo("<label>E-mail:</label>");// email and sticky
        echo ("<input type='email' name='email' value=");
        if (isset($_POST['formSubmit'])) {
            echo ("'$email'"); 
            echo (" required /><br /><br />");
        }

        echo("<label for='city'>City:</label>
        <select id='city' name='city'>");// city and sticky
        
            foreach($listofCities as $cities) {
                $citiesValue = $cities['cityID'];
                $citiesName = $cities['city'];
            
                if (isset($_POST['formSubmit']) && $city == $citiesValue) {
                    echo ("<option value='$$citiesValue' selected>$citiesName</option>");
                }
                else {
                echo ("<option value='$citiesValue'>$citiesName</option>");
                }
                
            }
        
        echo ("</select>");
    
        echo("<br /><br />");
        echo ("<label>Address:</label>");// address and sticky
        echo ("<input type='text' name='address' value=");
        if (isset($_POST['formSubmit'])) {
            echo ("'$address'");
            echo (" required /><br /><br />");
        }

        echo("<label>Date of Service:</label>"); // date
        echo ("$date <input type='hidden' name='date' value='$date'>");
        
        echo("<br /><br />");

        echo ("<label>Property Type: </label>");  
        
        foreach($listPropertyType as $propTypeValue) {
            // property type and sticky
            if (isset($_POST['formSubmit']) && $_POST['propType'] == $propTypeValue) {
                echo ("<input type='radio' id='propType' name='propType' value='$propType' checked='checked'/>
               <label for='$propType'>$propType</label>");
            }
            // property type
            else {
            echo ("<input type='radio' id='propType' name='propType' value='$propTypeValue' />
            <label for='$propTypeValue'>$propTypeValue</label>");
            }
        }
          
            
            
       
    
        echo("<br /><br />");
        echo ("<label>Services:</label><br />");
      
    
            foreach($listofServices as $services) {
                $servicesValue = $services['serviceID'];
                $servicesName = $services['service'];
                // services and sticky
                if (isset($_POST['formSubmit']) && in_array($servicesValue,$service)) {                
                echo ("<input type='checkbox' name='service[]' value='$servicesValue' checked='checked' />$servicesName <br />");
                }
                // services
                else {
                    echo ("<input type='checkbox' name='service[]' value='$servicesValue' />$servicesName <br />");
                }
            }
          
       


        echo("<br /><br />");    
        echo ("<label>Frequency of Service</label>");
        // frequency and sticky
        foreach($listfrequency as $frequencyValue) {
            if (isset($_POST['formSubmit']) && $_POST['frequency'] == $frequencyValue) {
                echo ("<input type='radio' id='frequency' name='frequency' value='$frequency' checked='checked'/>
                <label for='$frequency'>$frequency</label>");
            }
            // frequency
            else {
                 echo ("<input type='radio' id='frequency' name='frequency' value='$frequencyValue' />
            <label for='$frequencyValue'>$frequencyValue</label>");
            }

}

        
        echo("<br /><br />");// message
        echo ("<textarea name='message' rows='10' cols='100' maxlength='300'>
        Let us know about any additonal information
        </textarea>
        <br /><br />    
        <input type='submit' name='formSubmit' value='Continue' /> 
        </form>");
    
    
}   

//This function calls the marksRequest function
function mlr_shortcode() {
    ob_start(); //This PHP function turns on auto buffering
    marksRequest();

    return ob_get_clean(); //Discards the buffer contents
}

//This function registers my shortcode with WordPress and calls the function above = mlr_shortcode
add_shortcode( 'marks_landscape_request', 'mlr_shortcode' );


    ?>
