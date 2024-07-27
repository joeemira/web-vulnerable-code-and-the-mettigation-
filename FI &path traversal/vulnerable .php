<?php
// Vulnerable to Path Traversal
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    include($file);
}
?>
