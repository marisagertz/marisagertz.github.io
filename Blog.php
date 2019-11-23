<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>example page</title>
<link rel="stylesheet" href="phpexample.css" type="text/css" media="screen" />
</head>
<body>

<!-- this example from Kevin Yank http://www.sitepoint.com/article/php-xml-parsing-rss-1-0/ -->
<?php 




// Create an XML parser
$xml_parser = xml_parser_create();

// Set the functions to handle opening and closing tags
xml_set_element_handler($xml_parser, "startElement", "endElement");

// Set the function to handle blocks of character data
xml_set_character_data_handler($xml_parser, "characterData");

// Open the XML file for reading
$fp = fopen("http://marisagertz.tumblr.com/rss","r")
       or die("Error reading RSS data.");

// Read the XML file 4KB at a time
while ($data = fread($fp, 4096))
   // Parse each 4KB chunk with the XML parser created above
   xml_parse($xml_parser, $data, feof($fp))
       // Handle errors in parsing
       or die(sprintf("XML error: %s at line %d",  
           xml_error_string(xml_get_error_code($xml_parser)),  
           xml_get_current_line_number($xml_parser)));

// Close the XML file
fclose($fp);

// Free up memory used by the XML parser
xml_parser_free($xml_parser);



$insideitem = false;
$tag = "";
$title = "";
$description = "";
$link = "";
$pubdate= "";


function startElement($parser, $tagName, $attrs) {
   global $insideitem, $tag;
   if ($insideitem) {
		
		 $tag = $tagName;
		  } elseif ($tagName == "ITEM") {
       $insideitem = true;
   }
}


function characterData($parser, $data) {
   global $insideitem, $tag, $title, $pubdate, $description, $link;

	  if ($insideitem) {


switch ($tag) {
           case "TITLE":
           $title .= $data;
           break;
           case "PUBDATE":
           $pubdate .= $data;
           break;
           case "DESCRIPTION":
           $description .= $data;
           break;
           case "LINK":
           $link .= $data;
           break;
          
       }
   }
}

function endElement($parser, $tagName) {
   global $insideitem, $tag, $title, $pubdate, $description, $link;
   if ($tagName == "ITEM") {
       printf("<h2><b><a href='%s'>%s</a></b></h2>",
           trim($link),htmlspecialchars(trim($title)));
            printf("<h3 class=\"date\">%s</h3>",htmlspecialchars(trim($pubdate)));
       printf("<p>%s</p>",htmlspecialchars(trim($description)));


		$title = "";
       $description = "";
       $link = "";
       $pubdate = "";


        $insideitem = false;
   }
}


echo "hello world";

?>



</body>

</html>
