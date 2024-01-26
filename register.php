<?php
include("conn.php");

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$your_name = mysqli_real_escape_string($conn, $_POST['your_name']);
$chat_room_name = mysqli_real_escape_string($conn, $_POST['chat_room_name']);

if ($username == "" || $password == "") {
    echo "<script>window.alert('Username and Password are required fields!')</script>";
} else {
    // Insert user data into the 'user' table
    $insert_user_query = mysqli_query($conn, "INSERT INTO user(username, password, email, phone, your_name) VALUES('$username', '$password', '$email', '$phone', '$your_name')") or die(mysqli_error($conn));

    // Check if the user insertion was successful
    if ($insert_user_query) {
        // Get the last inserted user ID
        $user_id = mysqli_insert_id($conn);

        // Insert chat room data into the 'chat_room' table
        $insert_chat_room_query = mysqli_query($conn, "INSERT INTO chat_room( chat_room_name) VALUES('$chat_room_name')") or die(mysqli_error($conn));

        // Check if the chat room insertion was successful
        if ($insert_chat_room_query) {
            echo "<script>window.alert('Account successfully created! You can now login with your credentials.')</script>";
            echo "<script>window.location.href='index.php?registered'</script>";
        } else {
            echo "<script>window.alert('Error creating account. Please try again.')</script>";
        }
    } else {
        echo "<script>window.alert('Error creating account. Please try again.')</script>";
    }
}
?>
