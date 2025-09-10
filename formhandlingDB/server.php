<?php

$data=file_get_contents('php://input');
//file_put_contents('check.txt',$data);
$array=json_decode($data,true);


if (!$array) {
    
    echo "Invalid JSON input.";
    exit;
}

//establishing the database connect 
// host----username-----password-----database
$conn=new mysqli("localhost","root","","learnphp");


if ($conn->connect_error) {
    echo "Database connection failed: " . $conn->connect_error;
    exit;
}
$stmt = $conn->prepare("INSERT INTO marks (name, marks) VALUES (?, ?)");


$stmt->bind_param("sd", $array['name'], $array['cgpa']);


// file_put_contents('check.txt', "Insert success: " . ($success ? "yes" : "no") . "\n");
//file_put_contents('check.txt',$st);

if ($stmt->execute()) {
    echo "Data inserted successfully.";
} else {

    echo "Database insert error: " . $stmt->error;
}



$stmt->close();
$conn->close();






// $selectQuery = "SELECT * FROM marks";
// $result = $conn->query($selectQuery);

// $assoArray = $result->fetch_all(MYSQLI_ASSOC);

// file_put_contents('check.txt', json_encode($assoArray));

// echo json_encode($assoArray);




?>