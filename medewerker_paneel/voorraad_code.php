<?php
include "classes/db.class.php";

$connection = new DB("localhost", "vissen", "root", "", "utf8");

/*
*
	Nieuwe Medewerker aanmaken als de onderstaande waarde is geselecteerd
*
*/
if(isset($_GET['opslaan_voorraad']))
{
	$fieldnames = ["locatiecode", "aantal", "productcode"];
	$error = false;
	foreach ($fieldnames as $fieldname) {
		if(!isset($_GET[$fieldname]) || empty($_GET[$fieldname]))
		{
			$error = true;
		}
		if(!$error)
		{
			$filiaal_id = $_GET['locatiecode'];
			$product_id = $_GET['productcode'];
			$aantal = $_GET['aantal'];
		}
	}
	try
	{
	$connection->nieuwevoorraad($product_id, $filiaal_id, $aantal);
	header("Location: voorraad.php");
	}catch(PDOException $e)
	{
		return "er is iets fout gegaan: ".$e->getmessage();
	}
}

/*
*
	Medewerker Wijzigen als de onderstaande waarde is geselecteerd
*
*/

if(isset($_GET['wijzig_voorraad_btn']))
{
	$fieldnames = ["aantal", "filiaal"];
	$error = false;
	foreach ($fieldnames as $fieldname) {
		if(!isset($_GET[$fieldname]) || empty($_GET[$fieldname]))
		{
			$error = true;
		}
		if(!$error)
		{
			$product_id = $_GET['product'];
			$aantal = $_GET['aantal'];
			$filiaal_id = $_GET['filiaal'];
			
		}
	}
	try
	{

		$connection->voorraadWijzigen($product_id, $filiaal_id, $aantal);
		var_dump($connection->voorraadWijzigen($product_id, $filiaal_id, $aantal));
		header("Location: voorraad.php");
	}catch(PDOException $e)
	{
		return "er is iets fout gegaan: ".$e->getmessage();
	}
}

if(isset($_GET['voorraad_verwijderen']))
{
	$id = $_GET['voorraad_id_verwijderen'];
	$connection->voorraadVerwijderen($id);
	// header("Location: voorraad.php");
}

?>