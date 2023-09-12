<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];
    $Ville = $_POST['Ville'];
    $address = $_POST['address'];
    
    $file_name = $_FILES['file']['name'];
    $file_tmp_name = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_error = $_FILES['file']['error'];
    
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $new_file_name = uniqid('', true) . '.' . $file_ext;
        
    if($file_error === 0) {
        
        move_uploaded_file($file_tmp_name, 'uploads/' . $new_file_name);
//database Connection
        $host = "sql202.epizy.com";
        $user = "epiz_34193423";
        $pass = "SGWUD7WlpC";
        $db = "epiz_34193423_tectra";
        $conn = new mysqli($host, $user, $pass, $db);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
//insert into data base
            $sql = "INSERT INTO `register`(`Nom`, `lastname`, `email`, `phone`, `Position`, `Ville`, `address`, `filename`)
            VALUES ('$name', '$last_name', '$email', '$phone', '$position','$Ville', '$address', '$new_file_name')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    } else {
        echo "Error uploading file: " . $file_error;
    }
}
    // Function to create random file name
function uniqidReal($lenght) {
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception("No cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
}
?>