<?php
// function to get bookingIds
function getBookingId(){
    
    global $wpdb;
    $sql = "SELECT bookingID
    FROM orders;";
    $statement = $wpdb->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

// function to get service
function getServiceId(){
    global $wpdb;
    $sql = "SELECT serviceID, service
    FROM Services;";
    $statement = $wpdb->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}
// function to get cites
function getCityId(){
    global $wpdb;
    $sql = "SELECT cityID, city
    FROM Location;";
    $statement = $wpdb->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

?>