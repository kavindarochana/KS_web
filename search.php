<?php

$pdo = new PDO('mysql:host=localhost;dbname=KS_web','root','');

$search = $_GET['q'];

$searche = explode(" ", $search);

$x = 0;
$construct ="";
$params = array();
foreach($searche as $term) {

	$x++;

	if($x == 1) {
		$construct .= "title Like CONCAT('%',:search$x,'%') OR description Like CONCAT('%',:search$x,'%') OR keywords Like CONCAT('%',:search$x,'%')";
	} else {
		$construct .= " AND title Like CONCAT('%',:search$x,'%') OR description Like CONCAT('%',:search$x,'%') OR keywords Like CONCAT('%',:search$x,'%')";
	}
	$params[":search$x"] = $term;

}


$results = $pdo->prepare("SELECT * FROM `index` WHERE $construct");
$results->execute($params);

//$y = $results->rowcount(); 
if ($results->rowcount() == 0){
	echo "No results found! <hr />";
} else {
	echo $results->rowcount()." results found! <hr />";
}


echo "<pre>";
//print_r($results->fetchAll());
//echo '<a href="">KS</a>';
foreach ($results->fetchAll() as $result) {
	$linkx =$result["url"];

	
	//echo '<a href="' . $linkx. '">KS</a>';
	
	echo $result["title"]. "</br>";

	if ($result["description"] == ""){
		echo "No description available."."<br />";
	}else{
		echo $result["description"]."<br />";
	}
	echo '<a href="' . $linkx. '">';
	echo $result["url"]. "</br>";
	echo "<hr />";
	echo '</a>';
	//echo '<a href="echo '$result["title"]';">go</a>';
}