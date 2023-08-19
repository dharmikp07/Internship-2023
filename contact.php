<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $number = $_POST["number"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

        $conn = mysqli_connect("localhost", "root","");
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        mysqli_select_db($conn, "dottech");
        $stmt = $conn->prepare("INSERT INTO contact (name, email, number, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $number, $subject, $message);
    
        // Execute the prepared statement
        if ($stmt->execute()) {
            //echo "Record inserted successfully";
            $response = array("status" => "success", "message" => "Your message has been sent. Thank you!");
        } else {
            // echo "Error: " . $stmt->error;
            $response = array("status" => "error", "message" => "Error inserting record");
        }
        header("Content-Type: application/json");
        echo json_encode($response);
        
        $stmt->close();
        mysqli_close($conn);
    }
    
    
else {
    header("HTTP/1.1 405 Method Not Allowed");
    header("Allow: POST");
    echo "Method not allowed";
}
?>
