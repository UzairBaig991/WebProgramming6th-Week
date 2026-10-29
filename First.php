<?php 
echo "This is PHP first class programming language". "<br>";
$X=55;
echo $X;
echo "<br>";
$y="ali";
$s="77.6";
echo $y;
echo "<br>";
echo $s;
$food= array(12, "Biryani", 55.5, "Pizza");
echo "<br>";
echo $food[0];
echo "<br>";
echo $food[1];
echo "<br>";
echo $food[2];
echo "<br>";
echo $food[3];
$fruit= ["Apple", "Banana", "Mango", 55.5];
echo "<br>";
echo $fruit[2];
for ($i=0; $i<4; $i++){
    echo "<br>";
    echo $fruit[$i];
}
foreach ($fruit as $value){
    echo "<br>";
    echo $value;
}
?>