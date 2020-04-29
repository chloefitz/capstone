<!doctype html>
<?php
/*
Author: Chloe Fitzgerald
Create Date: 4/21/2020

v1 - Primary Form
v2 - Dispaly inputs and create hidden form
v3 - change services loop to use array from DB from services table
test
*/

// code for error message output
ini_set('display_errors', 1);
error_reporting(E_ALL); 
require_once 'includes/dbconnection.php';
require_once 'includes/dbfunctions.php';
require_once 'includes/arrays.php';
require_once 'includes/functions.php';


// declare variables
$name = $phone = $email = $address = $date = 
$services = $message = $propType = $company 
= $frequency = $city = $listofServices = "";

$date = $_GET['date'];

$listofServices = getServiceId();
$listofCities = getCityId();



?>

<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Request service</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>

    <body>
        
        <h1>Request an appointment today</h1>
        <form method="post" action="">
        <label>Your Name:</label>
        <input type="text" name="name" value="<?php if (
        isset($_POST['formSubmit'])) echo $_POST['name']; ?>" required /><br /><br />

        <label>Company Name:</label>
        <input type="text" name="company" value="<?php if (
        isset($_POST['formSubmit'])) echo $_POST['company']; ?>" required /><br /><br />

        <label>Phone Number:</label>
        <input type="tel" name="phone" value="<?php if (
        isset($_POST['formSubmit'])) echo $_POST['phone']; ?>" required /><br /><br />

        <label>E-mail:</label>
        <input type="email" name="email" value="<?php if (
        isset($_POST['formSubmit'])) echo $_POST['email']; ?>" required /><br /><br />

        <label for="city">City:</label>
        <select id="city" name="city">
        <?php
            foreach($listofCities as $cities) {
                $citiesValue = $cities['cityID'];
                $citiesName = $cities['city'];
                echo ("<option value='$citiesValue'>$citiesName</option>");
            }
        ?>
        </select>
        <br /><br />
        <label>Address:</label>
        <input type="text" name="address" value="<?php if (
        isset($_POST['formSubmit'])) echo $_POST['phone']; ?>" required /><br /><br />
        
        <label>Date of Service:</label>
        <?php echo ("$date <input type='hidden' name='date' value='$date'>"); ?>
        
        <br /><br />

    <label>Property Type: </label>  
     
    
        <?php
        
            foreach($listPropertyType as $propType) {

                echo ("<input type='radio' id='propType' name='propType' value='$propType' />
                <label for='$propType'>$propType</label>");
            }
          
            
            
        ?>
    
        <br /><br />
        <label>Services:</label><br />
        <?php
    
            foreach($listofServices as $services) {
                $servicesValue = $services['serviceID'];
                $servicesName = $services['service'];
                echo ("<input type='checkbox' name='service[]' value='$servicesValue' />$servicesName <br />");
            }
          
        ?>


        <br /><br />    
        <label>Frequency of Service</label>
        <input type='radio' id='Weekly' name='frequency' value='Weekly'  />
        <label for='Weekly'>Weekly</label>
        <input type='radio' id='Bi-Weekly' name='frequency' value='Bi-Weekly'  />
        <label for='Bi-Weekly'>Bi-Weekly</label>
		<input type='radio' id='Monthly' name='frequency' value='Monthly'  />
        <label for='Monthly'>Monthly</label>
          
        
        <br /><br />
        <textarea name="message" rows="10" cols="100" maxlength="300">
        Let us know about any additonal information
        </textarea>
        <br /><br />    
        <input type="submit" name="formSubmit" value="Continue" /> 
        </form>
    
    </body>
    <?php

           
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



            // echo inputs
            echo ("Name: $name<br />");
            echo ("Phone: $phone<br />");
            $isEmailValid = isValidEmail($email);
            if ($isEmailValid == false) {
                echo ("<p style='color:red;'>Please provide valid email</p>");
            }
            else {
                echo ("Email: $email<br />");
            }
            echo ("Address: $address<br />");

            foreach($listofCities as $cities) {
                $citiesValue = $cities['cityID'];
                $citiesName = $cities['city'];
                if ($citiesValue == $city) {
                    echo ("City: $citiesName<br />");
                }    
            }
            
            echo ("Date: $date<br />");
            echo ("PropertyType: $propType<br />");
            foreach($service as $serviceValue) {
                echo ("Services: $serviceValue <br />");
            }
            echo ("Company: $company<br />");
            echo ("Frequency: $frequency<br />");
            echo ("Message: $message<br />");

            // phantom form to commit data
            echo ("<form method='post' action='http://localhost/Capstone/confirmation/confirmation_v3.php'>
                <input type='text' name='name' value='$name' hidden>
                <input type='text' name='phone' value='$phone' hidden>
                <input type='text' name='email' value='$email' hidden>
                <input type='text' name='address' value='$address' hidden>
                <input type='text' name='address' value='$city' hidden>
                <input type='text' name='date' value='$date' hidden>
                <input type='text' name='propType' value='$propType' hidden>");
                
            foreach($service as $serviceValue) {
                echo ("<input type='text' name='service[]' value='$serviceValue' hidden>");
            }
            echo ("<input type='text' name='company' value='$company' hidden>
                <input type='text' name='frequency' value='$frequency' hidden>
                <input type='text' name='message' value='$message' hidden>
                <input type='submit' name='commitSubmit' value='Submit Request' />");

            echo ("</form>");
    
        
    }
    
    
    ?>

</html>