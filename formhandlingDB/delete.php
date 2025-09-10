<?php
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

$conn = new mysqli("localhost", "root", "", "learnphp");

try {
    if ($conn->connect_error) {
        throw new Exception("Database connection failed");
    }

    $stmt = $conn->prepare("DELETE FROM marks WHERE no=?");
    if (!$stmt) {
        throw new Exception("Query preparation failed");
    }

    $stmt->bind_param('i', $id);
    if (!$stmt->execute()) {
        throw new Exception("Query execution failed");
    }
if($stmt->affected_rows===0)
{
    echo json_encode([]);
}
    //file_put_contents("check1.txt", "Delete success: " . ($stmt->affected_rows > 0 ? "Yes" : "No"));
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>