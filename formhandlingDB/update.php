<?php
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];
$name = $data['name'];
$cgpa = $data['cgpa'];

$conn = new mysqli("localhost", "root", "", "learnphp");

$stmt = $conn->prepare("UPDATE marks SET name=?, marks=? WHERE no=?");
$stmt->bind_param("sdi", $name, $cgpa, $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["status" => "success", "message" => "Data updated successfully"]);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>
