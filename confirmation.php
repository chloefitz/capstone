<!doctype html>
<?php
/*
Author: Chloe Fitzgerald
Create Date: 4/23/2020

v1 - Display form values
v2 - Insert into database
v3- check for existing bookingID and insert into requestedService Table
v4 - clean data again just to be sure no hacking nonsense
stop from reinserting by creating session variable
v5- send email
*/

// code for error message output
ini_set('display_errors', 1);

error_reporting(E_ALL); 
require_once 'includes/dbconnection.php';
require_once 'includes/arrays.php';
require_once 'includes/dbfunctions.php';
require_once 'includes/functions.php';

$lifetime = 60 * 60 * 24;

session_set_cookie_params($lifetime, '/');
session_start();

// declare variables
$name = $phone = $email = $address = $date = 
$services = $message  = $company 
= $message = $bookId = $frequency = $propType = 
$status = $lookupBookId= "";



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
$bookedTime = "2:00";
$status = "Pending";

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

// create booking id
$bookId = random_num(6);

// does booking id already exist?
$lookupBookId = getBookingId();
foreach ($lookupBookId as $value) {
    
    if ($bookId != $value['bookingID']){
        break;
    }
    else {
        $bookId = random_num(6);
        continue;
    }
    
    
}

if (isset($_SESSION['complete']) == false) {

// insert post data into db customers table
try{    
    //Define the query
     $sql = "INSERT INTO Customers(customerName, customerPhoneNumber, customerEmail, 
     customerAddress, propertyType, companyName) VALUES (:customerName, 
     :customerPhoneNumber, :customerEmail, :customerAddress,
     :propertyType,:companyName)" ;   

    //Prepare the statement
    $statement = $cnxn->prepare($sql);

    //Bind the parameters

    $statement->bindParam(':customerName', $name, PDO::PARAM_STR);
    $statement->bindParam(':customerPhoneNumber', $phone, PDO::PARAM_STR);
    $statement->bindParam(':customerEmail', $email, PDO::PARAM_STR);
    $statement->bindParam(':customerAddress', $address, PDO::PARAM_STR); 
    $statement->bindParam(':propertyType', $propType, PDO::PARAM_STR);
    $statement->bindParam(':companyName', $company, PDO::PARAM_STR);
     
    //Execute
    $statement->execute();
    $statement->closeCursor();

    $idCust = $cnxn->lastInsertId();
    $_SESSION['complete'] = 'success';

   //echo $statement->errorCode();    
    
   }
    catch (Exception $e){
        $errorMessage = $e->getMessage();
        echo $errorMessage;
    }

    // insert post data into db orders table
    try{    
        //Define the query
         $sql = "INSERT INTO Orders(bookedDate, bookedTime, bookingID, 
         Customers_customerID, frequency, message, status) VALUES (:bookedDate, 
         :bookedTime, :bookingID, :Customers_customerID,
         :frequency,:message, :status)" ;   
    
        //Prepare the statement
        $statement = $cnxn->prepare($sql);
    
        //Bind the parameters
    
        $statement->bindParam(':bookedDate', $date, PDO::PARAM_STR);
        $statement->bindParam(':bookedTime', $bookedTime, PDO::PARAM_STR);
        $statement->bindParam(':bookingID', $bookId, PDO::PARAM_STR);
        $statement->bindParam(':Customers_customerID', $idCust, PDO::PARAM_STR);
        $statement->bindParam(':frequency', $frequency, PDO::PARAM_STR); 
        $statement->bindParam(':message', $message, PDO::PARAM_STR);
        $statement->bindParam(':status', $status, PDO::PARAM_STR);     
        //Execute
        $statement->execute();
        $statement->closeCursor();

        $idOrder = $cnxn->lastInsertId();
    
       //echo $statement->errorCode();    
        
       }

        catch (Exception $e){
            $errorMessage = $e->getMessage();
            echo $errorMessage;
        }

        



        // insert post data into db requestedServices table
        foreach ($service as $value) {
            try{    
                //Define the query
                 $sql = "INSERT INTO requestedServices(Orders_orderID, Services_serviceID) 
                 VALUES (:Orders_orderID, :Services_serviceID)" ;   
            
                //Prepare the statement
                $statement = $cnxn->prepare($sql);
            
                //Bind the parameters
            
                $statement->bindParam(':Orders_orderID', $idOrder, PDO::PARAM_INT);
                $statement->bindParam(':Services_serviceID', $value, PDO::PARAM_INT);
        
                //Execute
                $statement->execute();
                $statement->closeCursor();
        
                $idService = $cnxn->lastInsertId();
            
               //echo $statement->errorCode();    
                
               }
                catch (Exception $e){
                    $errorMessage = $e->getMessage();
                    echo $errorMessage;
                }
        
        }
        echo ("<h2>Success! Here's your bookingId: $bookId</h2>");
    echo ("ID $idCust ID $idOrder ID $idService");
    }

else {
    $success = $_SESSION['complete'];
    echo ("<h2>$success Here's your bookingId: $bookId</h2>");
    echo ("ID $idCust ID $idOrder ID $idService");
}
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
    <?php
        // echo inputs
        /*
        echo ("Name: $name<br />");
        echo ("Phone: $phone<br />");
        $isEmailValid = isValidEmail($email);
        if ($isEmailValid == "false") {
            echo ("Please provide valid email<br />");
        }
        else {
            echo ("Email: $email<br />");
        }
        echo ("Address: $address<br />");
        echo ("Date: $date<br />");
        foreach($service as $serviceValue) {
            echo ("Services: $serviceValue <br />");
        }
        echo ("Company: $company<br />");
        echo ("Frequency: $frequency<br />");
        echo ("Message: $message<br />");

        echo ("<h2>Here's your bookingId: $bookId</h2>");
        echo ("ID $idCust ID $idOrder ID $idService");
        

        
        
        $to      = 'chloefitz@hotmail.com';
        $subject = 'the subject';
        $message = 'Booking ID: $bookId';
        $headers = 'From: chloefitz@students.highline.edu' . "\r\n" .
        'Reply-To: chloefitz@students.highline.edu' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
          */    
                 
                


    
    ?>
    </body>

</html>

