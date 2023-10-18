<?php
$dbServer = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "forza";
$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["submit"])) {
    $file = $_FILES["fileToUpload"];

    if ($file["error"] === UPLOAD_ERR_OK) {
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];


        $sql = "INSERT INTO files (file_name, file_data) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $null = NULL;
        $stmt->bind_param("sb", $fileName, $null);
        $stmt->send_long_data(1, file_get_contents($fileTmpName));

        if ($stmt->execute()) {
            echo "File uploaded and saved to the database successfully.";
        } else {
            echo "Error uploading file: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}
$conn->close();
?>
