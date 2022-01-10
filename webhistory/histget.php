<?php  
 //get url
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https://";
    else $link = "http://";
    $link .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	parse_str(parse_url($link)['query'],$params);
	$filename=str_replace("..","",basename($params["filename"]));
	file_put_contents("./".$filename,urldecode(file_get_contents("php://input")));
?>     
