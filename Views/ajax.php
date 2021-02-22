<?php
if (isset($_POST['data'])) {
    parse_str($_POST['data'], $output);
    return $_POST['data'];

} else {
    die();
}