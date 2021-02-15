<?php

/*

Application Name: Hengelsport
CREATOR: DIEGO MOSSEVELD
DATE TIME: 24-11-2020, 20:28:11
TYPE: Webapplication


Hieronder bevindt zich database class met bijna alle benodigde functies die erbij horen
denk aan alles waar data uit een database nodig is


*/

class DB 
{
	// Properties
	private $host;
	private $dbname;
	private $user;
	private $pass;
	private $charset;
	private $options;
	private $conn;

	// Constructor Prepare VALUES
	public function __construct($host, $dbname, $user, $pass, $charset)
	{
		$this->host = $host;
		$this->dbname =$dbname;
		$this->user = $user;
		$this->pass = $pass;
		$this->charset = $charset;

		$this->options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

		try
		{
		$this->conn = new PDO("mysql:host=$host;dbname=$dbname;", $user, $pass, $this->options);
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}

	}

	/*
				Hieronde is het medewerkers gedeelte, medewerkers worden aangemaakt, gegevens van medewerkers kunnen worden aangepast of een medewerker kan worden verwijderd. Ook kunnen de medewerkers opgezocht doormiddel van de Medewerkers() functie. Neem gerust een kijk.
	*/

// Medewerker aanmaken
	public function maakMedewerkerAan($voorletters, $voorvoegsel, $achternaam, $gebruikersnaam, $wachtwoord, $locatiecode)
	{
			$nieuweMedewerker = "INSERT INTO medewerker (voorletters, voorvoegsels, achternaam, gebruikersnaam, wachtwoord, locatiecode) VALUES(:voorletters, :voorvoegsels, :achternaam,  :gebruikersnaam, :wachtwoord, :locatiecode)";
			$wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);
			$maakMedewerker = $this->conn->prepare($nieuweMedewerker);
		try
		{
			$maakMedewerker->execute(array(
										":voorletters" => $voorletters,
										":voorvoegsels" => $voorvoegsel,
										":achternaam" => $achternaam,
										":gebruikersnaam" => $gebruikersnaam,
										":wachtwoord" => $wachtwoordHash,
										":locatiecode" => $locatiecode
			));
			// header("Location: medewerker.php");
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}
	}

// Alle data van de medewerkers opzoeken
	public function medewerkers()
	{
		$allemedewerkers = "SELECT medewerker.*, filiaal.plaats FROM medewerker INNER JOIN filiaal ON filiaal.locatiecode = medewerker.locatiecode
		ORDER BY medewerkerscode";
		$medewerkersData = $this->conn->prepare($allemedewerkers);
		try
		{
			$medewerkersData->execute();
			$rijMedewerkersTabel = $medewerkersData->fetchAll(PDO::FETCH_ASSOC);
			return $rijMedewerkersTabel;
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function searchMedewerkers($zoek)
	{
		$zoeken = "SELECT medewerker.*, filiaal.plaats FROM medewerker INNER JOIN filiaal ON filiaal.locatiecode = medewerker.locatiecode 
			WHERE
			medewerker.gebruikersnaam LIKE '%".$zoek."%' OR
			filiaal.plaats LIKE '%".$zoek."%'
			;";
		$startzoeken = $this->conn->prepare($zoeken);
		try
		{
			$startzoeken->execute();
			
		$zoekData = $startzoeken->fetchAll(PDO::FETCH_ASSOC);
		return $zoekData;
		}catch(PDOException $e)
		{
			echo "Er is iets fout gegaan: ".$e->getmessage();
		}
	}

	// Gegevens van een medewerker wijzigen, dit kan aan de hand van een id die gekoppeld is aan de medewerker, vandaar de id als argument meegegeven.
	public function selectMedewerker($id)
	{
		$mdw = "SELECT * FROM medewerker WHERE medewerkerscode = :medewerkerscode";
		$wdm = $this->conn->prepare($mdw);
		$wdm->execute(array(":medewerkerscode" => $id));
		return $wdm;
	}

	public function MedewerkerAanpassen($id, $voorletters, $voorvoegsel, $achternaam, $gebruikersnaam, $wachtwoord, $locatiecode)
	{
		$medewerkerAanpassen = "UPDATE medewerker SET voorletters = :voorletters, voorvoegsels = :voorvoegsels, achternaam = :achternaam, gebruikersnaam = :gebruikersnaam, wachtwoord = :wachtwoord, locatiecode = :locatiecode WHERE medewerkerscode = :id";
		$veranderData = $this->conn->prepare($medewerkerAanpassen);
		try
		{
			$veranderData->execute(array(
									":id" => $id,
									":voorletters" => $voorletters,
									":voorvoegsels" => $voorvoegsel,
									":achternaam" => $achternaam,
									":gebruikersnaam" => $gebruikersnaam,
									":wachtwoord" => $wachtwoord,
									":locatiecode" => $locatiecode
			));
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}
	}

// medewerkers kunnen worden verwijderd met de onderstaande functie, zelfde als met medewerker aanpassen dit kan aan de hand van de id die als argument is meegegeven.
	public function medewerkerVerwijderen($id)
	{
		$zoekMedewerker = "DELETE FROM medewerker WHERE medewerkerscode = :id";
		$verwijderMedewerker = $this->conn->prepare($zoekMedewerker);
		try
		{
			$verwijderMedewerker->execute(array(
											":id" => $id
			));
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	/*
			*	Hieronde is het producten gedeelte, 
			*	producten worden aangemaakt, gegevens van 
			*	producten kunnen worden aangepast of een 
			*	product kan worden verwijderd. Ook kunnen
			*	de producten opgezocht doormiddel van de
			*	producten() functie. Neem gerust een kijk.
	


				Om een nieuw product aan te maken kan de onderstaande functie gebruikt worden
	*/
	public function maakProduct($product, $type, $inkoop_prijs, $verkoop_prijs, $lev_code)
	{
		$nieuwProduct = "INSERT INTO artikel (product, type, inkoop_prijs, verkoop_prijs, lev_code) VALUES (:product, :type, :inkoop_prijs, :verkoop_prijs, :lev_code)";
		$maakProduct = $this->conn->prepare($nieuwProduct);
		try
		{
			$maakProduct->execute(array(
									":product" => $product,
									":type" => $type,
									":inkoop_prijs" => $inkoop_prijs,
									":verkoop_prijs" => $verkoop_prijs,
									":lev_code" => $lev_code
			));

			$product_id = $this->conn->lastInsertId();
			return $product_id;
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	// Alle data van producten tabel vinden, neem onderstaande functie.
	public function producten()
	{
		$alleProducten = "SELECT artikel.*, leverancier.naam FROM artikel INNER JOIN leverancier ON leverancier.lev_code = artikel.lev_code";
		$dataProducten = $this->conn->prepare($alleProducten);
		try
		{
			$dataProducten->execute();
			$rijDataProducten = $dataProducten->fetchAll(PDO::FETCH_ASSOC);
			return $rijDataProducten;
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function searchproducten($zoek)
	{
		$zoeken = "SELECT artikel.*, leverancier.naam FROM artikel INNER JOIN leverancier ON leverancier.lev_code = artikel.lev_code
			WHERE
			artikel.product LIKE '%".$zoek."%' OR
			leverancier.naam LIKE '%".$zoek."%'
			;";
		$startzoeken = $this->conn->prepare($zoeken);
		try
		{
			$startzoeken->execute();
			
		$zoekData = $startzoeken->fetchAll(PDO::FETCH_ASSOC);
		return $zoekData;
		}catch(PDOException $e)
		{
			echo "Er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function productenPriceTotal($total_inkoop)
	{
		$total = "SELECT SUM(inkoop_prijs) as :Total_inkoop FROM artikel";
		$getTotal = $this->conn->prepare($total);
		$getTotal->execute(array(":total_inkoop" => $total_inkoop));
		return $getTotal;
		echo $getTotal;
	}

	// selectief product vinden, dit kan met onderstaande functie aan de hand van de geselecteerde id.
	public function selectProduct($id)
	{
		$product = "SELECT * FROM artikel WHERE productcode = :id";
		$getProduct = $this->conn->prepare($product);
		$getProduct->execute(array(":id" => $id));
		return $getProduct;
	}

	// ProductAanpassen() wordt gebruikt om gegevens van een product te wijzigen
	public function productAanpassen($id, $product, $inkoop_prijs, $verkoop_prijs, $locatiecode)
	{
		$productAanpassen = "UPDATE artikel SET product = :product, type = :type, inkoop_prijs = :inkoop_prijs, verkoop_prijs = :verkoop_prijs, locatiecode = :locatiecode WHERE productcode = :id";
		$VeranderProductData = $this->conn->prepare($productAanpassen);
		try
		{
			$VeranderProductData->execute(array(
										":id" => $id,
										":product" => $product,
										":type" => $type,
										":inkoop_prijs" => $inkoop_prijs,
										":verkoop_prijs" => $verkoop_waarde,
										"locatiecode" => $locatiecode
				));
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}
	}
		// Is er een product uit het assortiment en komt het niet meer terug, gebruik onderstaande functie om dit aan te geven. Hiermee wordt het product verwijderd!
		public function productVerwijderen($id)
	{
		$zoekProduct = "DELETE FROM product WHERE productcode = :id";
		$verwijderProduct = $this->conn->prepare($zoekProduct);
		try
		{
			$verwijderProduct->execute(array(
											":id" => $id
			));
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function maakFiliaal($locatie)
	{
		$nieuwfiliaal = "INSERT INTO filiaal (plaats) VALUES (:locatie)";
		$maakFiliaal = $this->conn->prepare($nieuwfiliaal);
		try
		{
			$maakFiliaal->execute(array(":locatie" => $locatie));
			$filiaal_id = $this->conn->lastInsertId();
			return $filiaal_id;
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function filiaal()
	{
		$selectFiliaal = "SELECT * FROM filiaal";
		$filiaal_data = $this->conn->prepare($selectFiliaal);
		$filiaal_data->execute();
		$filialen = $filiaal_data->fetchAll(PDO::FETCH_ASSOC);
		return $filialen;
	}

	public function selectFiliaal($id)
	{
		$selectFiliaal = "SELECT * FROM filiaal WHERE locatiecode = :id";
		$getfiliaalData = $this->conn->prepare($selectFiliaal);
		try
		{
			$getfiliaalData->execute(array(":id" => $id));
			$fData = $getfiliaalData->fetchAll(PDO::FETCH_ASSOC
			);
			return $fData;
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function filiaalWijzigen($id, $plaats)
	{
		$filiaalAanpassen = "UPDATE filiaal SET plaats = :locatie WHERE locatiecode = :id";
		$startAanpassen = $this->conn->prepare($filiaalAanpassen);
		try
		{
			$startAanpassen->execute(array(
									":id" => $id,
									":locatie" => $plaats
			));
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}
	}

		public function filiaalVerwijderen($id)
	{
		$zoekFiliaal = "DELETE FROM filiaal WHERE locatiecode = :id";
		$verwijderFiliaal = $this->conn->prepare($zoekFiliaal);
		try
		{
			$verwijderFiliaal->execute(array(
											":id" => $id
			));
		}catch(PDOException $e)
		{
			return "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function nieuwevoorraad($product_id, $filiaal_id, $aantal)
	{
		$nieuwevoorraad = "INSERT INTO voorraad (productcode, locatiecode, aantal) VALUES (:product_id, :filiaal_id, :aantal)";
		$maakvoorraad = $this->conn->prepare($nieuwevoorraad);
		try
		{
			$maakvoorraad->execute(array(
									":product_id" => $product_id,
									"filiaal_id" => $filiaal_id,
									":aantal" => $aantal
			));
		}catch(PDOException $e)
		{
			echo "sdfsd";
		}
	}

	public function voorraad()
	{
		$voorraad = "SELECT voorraad.*, filiaal.*, artikel.* FROM voorraad
			 INNER JOIN filiaal
			 ON filiaal.locatiecode = voorraad.locatiecode
			 INNER JOIN artikel
			 ON artikel.productcode = voorraad.productcode";
		$haalData = $this->conn->prepare($voorraad);
		$haalData->execute();
		$geheleVoorraad = $haalData->fetchAll(PDO::FETCH_ASSOC);
		return $geheleVoorraad;
	}

	public function voorraadFiliaal($id)
	{
		$voorraad = "SELECT voorraad.*, filiaal.*, artikel.* FROM voorraad
			 INNER JOIN filiaal
			 ON filiaal.locatiecode = voorraad.locatiecode
			 INNER JOIN artikel
			 ON artikel.productcode = voorraad.productcode
			 WHERE voorraad.productcode = :id";
		$haalData = $this->conn->prepare($voorraad);
		$haalData->execute(array(":id" => $id));
		$geheleVoorraad = $haalData->fetchAll(PDO::FETCH_ASSOC);
		return $geheleVoorraad;
	}

	public function voorraadWijzigen($product_id, $filiaal_id, $aantal)
	{
		$wijzig = "UPDATE voorraad SET productcode = :product_id, locatiecode = :filiaal_id, aantal = :aantal WHERE productcode = :product_id";
		$update = $this->conn->prepare($wijzig);
		try
		{
			$update->execute(array(
								":product_id" => $product_id,
								":filiaal_id" => $filiaal_id,
								":aantal" => $aantal
			));
			var_dump($update);
		}catch(PDOException $e)
		{
			echo "sdgds";
		}
	}


	public function voorraadVerwijderen($productcode)
	{
		$voorraadVerwijderen = "DELETE FROM voorraad WHERE productcode = :productcode";
		$verwijder = $this->conn->prepare($voorraadVerwijderen);
		try
		{
			$verwijder->execute(array(
				":productcode" => $productcode
				));
		}catch(PDOException $e)
		{
			echo "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function voorraadWinst()
	{
		$calculate = "SELECT SUM(voorraad.aantal) AS totaal_aantal, SUM(artikel.inkoop_prijs) AS totaal_inkoop, SUM(artikel.verkoop_prijs) AS totaal_verkoop FROM voorraad INNER JOIN artikel ON artikel.productcode = voorraad.productcode";
		$awnser = $this->conn->prepare($calculate);
		try
		{
			$awnser->execute();
			$getAwnser = $awnser->fetchAll(PDO::FETCH_ASSOC);
			return $getAwnser;
		}catch(PDOException $e)
		{
			echo "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function selectFilialenProduct($id)
	{
		$productFilialen = "SELECT product.productcode, filiaal.plaats FROM product INNER JOIN filiaal ON filiaal.locatiecode = product.locatiecode WHERE product.locatiecode = :id";
		$getData = $this->conn->prepare($productFilialen);
		try
		{
			$getData->execute(array(":id" => $id));
			$rowFilialen = $getData->fetchAll(PDO::FETCH_ASSOC);
			return $rowFilialen;
		}catch(PDOException $e)
		{
			echo "dsgdsg";
		}
	}

	public function maakLeverancier($naam, $telefoon)
	{
		$nieweleverancier = "INSERT INTO leverancier (naam, telefoon) VALUES (:naam, :telefoon)";
		$maakLeverancier = $this->conn->prepare($nieweleverancier);
		try
		{
			$maakLeverancier->execute(array(
										":naam" => $naam,
										":telefoon" => $telefoon
			));
		}catch(PDOException $e)
		{
			echo "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function leveranciers()
	{
		$leveranciers = "SELECT * FROM leverancier";
		$leverancier = $this->conn->prepare($leveranciers);
		try
		{
			$leverancier->execute();
			$dataLeverancier = $leverancier->fetchAll(PDO::FETCH_ASSOC);
			return $dataLeverancier;
		}catch(PDOException $e)
		{
			echo "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function selecteerLeverancier($id)
	{
		$selecteerLeverancier = "SELECT * FROM leverancier WHERE lev_code = :lev_code";
		$update_leverancier = $this->conn->prepare($selecteerLeverancier);
		try
		{
			$update_leverancier->execute(array(
											":lev_code" => $id));
			$fetchData = $update_leverancier->fetchAll(PDO::FETCH_ASSOC);
			return $fetchData;
		}catch(PDOException $e)
		{
			echo "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function wijzigLeverancier($id, $naam, $telefoon)
	{
		$wijzigLeverancier = "UPDATE leverancier SET naam = :naam, telefoon = :telefoon WHERE lev_code = :lev_code";
		$update = $this->conn->prepare($wijzigLeverancier);
		try
		{
			$update->execute(array(
							":lev_code" => $id,
							":naam" => $naam,
							":telefoon" => $telefoon
			));
		}catch(PDOException $e)
		{
			echo "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function verwijderLeverancier($id)
	{
		$verwijderLeverancier = "DELETE FROM leverancier WHERE lev_code = :lev_code";
		$verwijder = $this->conn->prepare($verwijderLeverancier);
		try
		{
			$verwijder->execute(array(":lev_code" => $id));
		}catch(PDOException $e)
		{
			echo "er is iets fout gegaan: ".$e->getmessage();
		}
	}

	public function login($gebruikersnaam, $wachtwoord)
	{
		$zoekgebruiker = "SELECT gebruikersnaam, wachtwoord FROM medewerker WHERE gebruikersnaam = :gebruikersnaam";
		$startzoeken = $this->conn->prepare($zoekgebruiker);
		try
		{
			$startzoeken->execute(array(
									":gebruikersnaam" => $gebruikersnaam
			));
			$gebruiker = $startzoeken->fetch(PDO::FETCH_ASSOC);
			var_dump($gebruiker);
			$wachtwoordHash = $gebruiker['wachtwoord'];
			if(!password_verify($wachtwoord, $wachtwoordHash))
			{
				echo "Sorry er is een fout opgetreden, probeer het even opnieuw";
			}
			else
			{	
				session_start();
				$_SESSION['gebruikersnaam'] = $gebruiker['gebruikersnaam'];
				header("Location: index.php");
			}
		}catch(PDOException $e)
		{
			echo "er is een fout opgetreden: ".$e->getmessage();
		}
	}

}
?>