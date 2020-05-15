<?php
// function to get bookingIds
function getBookingId(){
    global $wpdb;
    $result = $wpdb->get_results("SELECT bookingID
    FROM $wpdb->orders");

    return $result;
}

// function to get service
function getServiceId(){
    global $wpdb;
    $result = $wpdb->get_results("SELECT serviceID, service
    FROM $wpdb->Services");

    return $result;
}    

// function to get cites
function getCityId(){
    global $wpdb;
    $result = $wpdb->get_results("SELECT cityID, city
    FROM $wpdb->Location");

    return $result;
}

// function to get customer data
function getBookingDataCustomer($ordersCustId){
    global $wpdb;
    $result = $wpdb->get_results("SELECT customerID, customerName, customerPhoneNumber, customerEmail, customerAddress,
    propertyType, companyName
    FROM $wpdb->Customers
    WHERE customerID = $ordersCustId");


    return $result;
}

// function to get order data
function getBookingDataOrder(){
    global $wpdb;
    $result = $wpdb->get_results("SELECT orderID, Customers_customerID, bookedDate, bookingID, Teams_teamID, 
    Location_cityID, status, frequency, message, Teams_teamID, Customers_customerID
    FROM $wpdb->Orders
    ORDER BY bookedDate desc");
   
    return $result;
}

// function to get order data by status
function getBookingDataOrderStatus($statusController){
    global $wpdb;
    $result = $wpdb->get_results("SELECT orderID, Customers_customerID, bookedDate, bookingID, Teams_teamID, 
    Location_cityID, status, frequency, message, Customers_customerID
    FROM $wpdb->Orders
    WHERE status = '$statusController'
    ORDER BY bookedDate desc");

    return $result;
}

// function to get services data
function getBookingDataServices($orderID){
    global $wpdb;
    $result = $wpdb->get_results("SELECT *
    FROM $wpdb->requestedServices
    WHERE $orderID = Orders_orderID");

    return $result;
}

// function to get Teams
function getTeams(){
    global $wpdb;
    $result = $wpdb->get_results("SELECT teamID, teamName
    FROM $wpdb->teams");

    return $result;
}
?>