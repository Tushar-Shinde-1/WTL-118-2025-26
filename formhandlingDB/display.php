<?php


$conn=new mysqli("localhost","root","","learnphp");

$selectQuery = "SELECT * FROM marks";
$result = $conn->query($selectQuery);

$assoArray = $result->fetch_all(MYSQLI_ASSOC);
if(count($assoArray)>=1)
{

//file_put_contents('check.txt', json_encode($assoArray));

echo json_encode($assoArray);

}
else{
    echo json_encode([]);
}
$conn->close();

?>