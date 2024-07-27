// different ways of metigation

<?php
// Secure File Inclusion  method 1
if (isset($_GET['file'])) {
    $file = basename($_GET['file']); // Get the basename of the file to avoid directory traversal
    $allowed_files = array('page1.php', 'page2.php', 'page3.php'); // List of allowed files

    if (in_array($file, $allowed_files)) {
        include('includes/' . $file); // Include only if the file is in the allowed list
    } else {
        echo "Invalid file!";
    }
} else {
    echo "No file specified!";
}
?>

// to disable remote file inclution =================================================
//update this configration on `php.ini`
; php.ini
allow_url_include = Off

// Use a whitelist approach: //second method==========================================
Instead of allowing any file to be included, use a predefined list of allowed files.
<?php
// Secure File Inclusion using Whitelist
$whitelist = array(
    'page1' => 'includes/page1.php',
    'page2' => 'includes/page2.php',
    'page3' => 'includes/page3.php'
);

if (isset($_GET['file'])) {
    $file_key = $_GET['file'];

    if (array_key_exists($file_key, $whitelist)) {
        include($whitelist[$file_key]);
    } else {
        echo "Invalid file!";
    }
} else {
    echo "No file specified!";
}
?>
// third method ================================================================== 
Use built-in functions to validate file paths:
Ensure the file exists and is within a specific directory.
<?php
// Secure File Inclusion with realpath
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $base_dir = realpath(dirname(__FILE__) . '/includes');

    $file_path = realpath($base_dir . '/' . $file);

    // Check if the file exists and is within the allowed directory
    if ($file_path && strpos($file_path, $base_dir) === 0 && file_exists($file_path)) {
        include($file_path);
    } else {
        echo "Invalid file!";
    }
} else {
    echo "No file specified!";
}
?>