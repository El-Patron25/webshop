<?php
include "classes/db.class.php";

$connection = new DB("localhost", "vissen", "root", "", "utf8");

/*
*
	Nieuwe Medewerker aanmaken als de onderstaande waarde is geselecteerd
*
*/
if(isset($_GET['opslaan_product']))
{
	$fieldnames = ["product", "type", "inkoop_prijs", "verkoop_prijs", "leverancier"];
	$error = false;
	foreach ($fieldnames as $fieldname) {
		if(!isset($_GET[$fieldname]) || empty($_GET[$fieldname]))
		{
			$error = true;
		}
		if(!$error)
		{
			$product = $_GET['product'];
			$type = $_GET['type'];
			$inkoop_prijs = $_GET['inkoop_prijs'];
			$verkoop_prijs = $_GET['verkoop_prijs'];
			$leverancier = $_GET['leverancier'];
		}
	}
	try
	{
	$connection->maakProduct($product, $type, $inkoop_prijs, $verkoop_prijs, $leverancier);
	header("Location: producten.php");
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

if(isset($_GET['wijzig_product_btn']))
{
	$fieldnames = ["edit_product", "edit_type", "edit_inkoop_prijs", "edit_verkoop_prijs", "filiaal"];
	$error = false;
	foreach ($fieldnames as $fieldname) {
		if(!isset($_GET[$fieldname]) || empty($_GET[$fieldname]))
		{
			$error = true;
		}
		if(!$error)
		{

			$id = $_GET['id'];
			$product = $_GET['edit_product'];
			$type = $_GET['edit_type'];
			$inkoop_prijs = $_GET['edit_inkoop_prijs'];
			$verkoop_prijs = $_GET['edit_verkoop_prijs'];
			$filiaal = $_GET['filiaal_verander'];
			if(isset($_GET['filiaal_verander']))
			{
				$filiaal = $_GET['filiaal'];
			}
		}
	}
	try
	{
		$connection->productAanpassen($id, $product, $type, $inkoop_waarde, $verkoop_waarde, $filiaal);
		header("Location: producten.php");
	}catch(PDOException $e)
	{
		return "er is iets fout gegaan: ".$e->getmessage();
	}
}

if(isset($_GET['product_verwijderen']))
{
	$id = $_GET['product_id_verwijderen'];
	$connection->productVerwijderen($id);
	header("Location: producten.php");
}

?>