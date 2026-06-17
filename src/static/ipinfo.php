<?php
$headers = getallheaders();

echo 'Chicken says...<br/>';
echo '<br/>';

if (FALSE === $headers)
{
  echo 'getallheaders() failed!';
} 
else
{
  foreach($headers as $key=>$value) {
    echo $key.': <strong>'.$value.'</strong><br/>';
  }
}

echo '<br/>';

foreach( $_SERVER as $key => $value ) 
{
  echo $key.': <strong>'.$value.'</strong><br/>';
}
?>
