<?php   # Script 16.2 - view_users.php
// This script retrieves all the records from the users table.

$page_title = 'View the Current Users';
include ('includes/header.html');

// Page header:
echo '<h1>Registered Users</h1>';

require('../mysqli_oop_connect.php');       // Connect to the db

// Make the query:
$q = "SELECT CONCAT(last_name, ', ', first_name) AS name,
    DATE_FORMAT(registration_date, '%M, %d, %Y') AS dr FROM users ORDER BY 
    registration_date ASC";

$r = $mysqli->query($q);           // Run the query


// Count the number of returned rows
$num = $r->num_rows;

if ($num > 0 ) {    // If it ran ok, display the records

    // Print how many users there are:
    echo "<p>There are currently $num registered users.</p>\n";

    // Table header.
    echo '<table align="center" cellspacing="3" cellpadding = "3" width="75%">
    <tr><td align="left"><b>Name</b></td><td align="left"><b>Date Registered</b>
    </td></tr>';
    
    // Fetch and print all the records
    while ($row = $r->fetch_object()) {
        echo '<tr><td align="left">' . $row->name . '</td><td align="left">' .
        $row->dr . '</td></tr>';
    }
    
    echo '</table>';        // Close the table
    
    $r->free(); // Free up the resources
    unset($r);
    
} else {    // If it did not run OK.
    
    // Public message:
    echo '<p class="error">The current users could not be retrieved.  We
    apologize for any inconvience.</p>';
    
    // Debugging message:
    echo '<p>' . mysqli_error($dbc) . '<br /><br/>Query: ' . $q . '</p>';
    
}

$mysqli->close();     // Close the database connection.
unset($mysqli);

include ('includes/footer.html');

?>