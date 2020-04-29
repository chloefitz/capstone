<?php
// function to get bookingIds
function getBookingId(){
    
    global $cnxn;
    $sql = "SELECT bookingID
    FROM orders;";
    $statement = $cnxn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

// function to get service
function getServiceId(){
    global $cnxn;
    $sql = "SELECT serviceID, service
    FROM Services;";
    $statement = $cnxn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

// function to get cites
function getCityId(){
    global $cnxn;
    $sql = "SELECT cityID, city
    FROM Location;";
    $statement = $cnxn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

?>