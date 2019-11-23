<?php
 
$files = glob("perfector/*.*");
 
for ($i=1; $i<count($files); $i++)
 
{
 
$image = $files[$i];
 

echo '<img src="'.$image .'" alt="instant perfector" style="display: inline-block; margin-bottom: 5px; width: 100%;" />';
}
 
?>

