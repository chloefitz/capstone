<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Request service</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>

<?php
//v2 - gettting services output to work
// code for error message output
ini_set('display_errors', 1);
error_reporting(E_ALL); 
require_once 'includes/dbconnection.php';
require_once 'includes/dbfunctions.php';
require_once 'includes/arrays.php';
require_once 'includes/functions.php';



try{
    
    $orderData = getBookingDataOrder();
    foreach($orderData as $row2) {
        $orderID = $row2['orderID'];
        $ordersCustId = $row2['Customers_customerID'];
        $date = $row2['bookedDate'];
        $bookingId = $row2['bookingID'];
        $status = $row2['status'];
        $frequency = $row2['frequency'];
        $message = $row2['message'];

        $customerData = getBookingDataCustomer($ordersCustId);
    
        foreach($customerData as $row) {
            
            $name = $row ['customerName'];    
            $phone = $row ['customerPhoneNumber'];    
            $email  = $row ['customerEmail'];
            $address = $row ['customerAddress'];
            $propType = $row ['propertyType'];
            $company = $row ['companyName'];
            
            $serviceData = getBookingDataServices($orderID);
            
            echo ("<table><tr>");
            echo ("<th>Date</th><th>BookingId</th><th>Customer Name</th>
            <th>Email</th><th>Phone</th>");
            echo ("</tr><tr>");
            echo ("<td>$date</td>");
            echo ("<td>$orderID</td>");
            echo ("<td>$name</td>");
            echo ("<td>$email</td>");
            echo ("<td>$phone</td>");
            echo ("</tr><tr>");
            echo ("<th colspan='2'>Address</th><th>City</th><th>Company</th>
            <th>Property Type</th>");
            echo ("</tr><tr>");
            echo("<td colspan='2'>$address</td>");
            echo ("<td>City coming soon</td>");
            echo ("<td>$company</td>");
            echo ("<td>$propType</td>");
            echo ("</tr><tr>");
            echo ("<th>Services ID</th><th colspan='4'>Services</th>");
            echo ("</tr>");

            foreach($serviceData as $row3) {
                $servicesID = $row3['Services_serviceID'];
                $servicesOrderId = $row3['Orders_orderID'];
                $services = getServiceId();
                foreach($services as $serviceList) {
                $serviceName = $serviceList['service'];
                $serviceValue = $serviceList['serviceID'];
                if ($servicesID == $serviceValue ){
                    echo ("<tr><td>$servicesID</td><td colspan='4'>$serviceName</td></tr>");
                    }    
                   
                        
                }
          

            }

            echo ("<tr>");
            echo ("<th colspan='5'>Message</th>");
            echo ("</tr><tr>");
            echo ("<td colspan='5'>$message</td>");
            echo ("</tr><tr>");
            echo ("<th>Frequency</th><th>Team Assigned</th><th>Status</th>
            <th colspan='2'></th>");
            echo ("</tr><tr>");
            echo ("<td>$frequency</td>");
            echo ("<td>Team info will go here</td>");
            echo ("<td>$status</td>");
            echo ("<td colspan='2'></td>");
            echo ("</tr></table>");
        }


    
    }
}



catch (Exception $e){
    $errorMessage = $e->getMessage();
    echo $errorMessage;
}


     


?>
</html>

