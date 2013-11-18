<?php
// client-ip.php : Demo script by nixCraft <www.cyberciti.biz>
// get an IP address
$ip = $_SERVER['REMOTE_ADDR'];
// display it back
echo "<h2>Client IP</h2>";
echo "Your IP address : " . $ip;
echo "<br>Your hostname : ". gethostbyaddr($ip) ;
echo "<br> Http client ip: ". getenv('HTTP_CLIENT_IP');
echo "<br> Forward for: ".getenv('HTTP_X_FORWARDED_FOR');
?>
