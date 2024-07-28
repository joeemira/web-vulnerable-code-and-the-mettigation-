<?php 
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Login successful!";
    } else {
        echo "Invalid username or password!";
    }
    $stmt->close();
}


/*
stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
Preparation: The prepare method prepares the SQL query with placeholders (?) instead of directly embedding user inputs.
Placeholders: ? acts as placeholders for the actual user inputs ($username and $password), ensuring that the SQL query structure is fixed and cannot be altered by user inputs.
*/
/*
$stmt->bind_param("ss", $username, $password);
Binding: The bind_param method binds the actual user inputs ($username and $password) to the placeholders in the prepared statement.
Parameter Types: The "ss" indicates that both parameters are strings (s). If there were an integer, the type would be i.
*/
/* so the query will be 
`SELECT * FROM users WHERE username = ? AND password = ? `
User inputs are safely bound to the placeholders:
 if an attacker tried to inject some code it will be like that 
` username = 'admin\' --', password = 'password' `
*/

?>