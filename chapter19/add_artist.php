<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Tranisitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Add an Artist</title>
</head>
<body>
<?php   # Script 19.1 - add_artist.php

// This page allows the administrator to add an artist

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form
    
    // Validate the first and middle names (neither required):
    $fn = (!empty($_POST['first_name'])) ? trim($_POST['first_name']) : NULL;
    $mn = (!empty($_POST['middle_name'])) ? trim($_POST['middle_name']) : NULL;
    
    // Check for last name...
    if (!empty($_POST['last_name'])) {
        
        $ln = trim($_POST['last_name']);
        
        // Add the artist to the database:
        require ('../../mysqli_connect.php');
        $q = 'INSERT INTO artists (first_name, middle_name, last_name)
        VALUES (?, ?, ?)';
        
        $stmt = mysqli_prepare($dbc, $q);
        mysqli_stmt_bind_param($stmt, 'sss', $fn, $mn, $ln);
        mysqli_stmt_execute($stmt);
        
        // Check the results...
        if (mysqli_stmt_affected_rows($stmt) == 1) {
            
            echo '<p>The artist has been added.</p>';
            $_POST = array();
            
        } else {    // Error!
            
            $error = 'The new artist could not be added to the database!';
            
        }
        
        // Clase this prepared statement
        mysqli_stmt_close($stmt);
        mysqli_close($dbc);         // Close the database connection
        
    }
    
} // End of submission IF

// Check for an error and print it:
if (isset($error)) {
    
    echo '<h1>Error!</h1>
    <p style="font-weight:bold; color: #C00">' . $error . ' Please try again.</p>';
    
}

// Display the form
?>

<h1>Add a Print</h1>
<form action="add_artist.php" method="post">
    
    <fieldset><legend>Fill out the form to add an artist:</legend>
    
    <p><b>First Name:</b> <input type="text" name="first_name" size="10" maxlength="20"
    value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /></p>
    <p><b>Middle Name:</b> <input type="text" name="middle_name" size="10" maxlength="20"
    value="<?php if (isset($_POST['middle_name'])) echo $_POST['middle_name']; ?>" /></p>
    <p><b>Last Name:</b> <input type="text" name="last_name" size="10" maxlength="20"
    value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></p>
    
    </fieldset>
    
    <div align="center"><input type="submit" name="submit" value="submit" /></div>
    
</form>


</body>

</html>