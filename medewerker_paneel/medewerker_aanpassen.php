<?php
include "classes/db.class.php";
include "includes/header.php";
include "includes/navbar.php";

if(isset($_GET['medewerker_aanpassen']))
{
	$id = $_GET['medewerker_id_edit'];
$connection = new DB("localhost", "vissen", "root", "", "utf8");
$medewerker = $connection->selectMedewerker($id);
foreach($medewerker as $data)
{
?>

	<!-- Data Voorbeeld -->
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">What do you wanna edit 
			
		</h6>
	 </div>

	 <div class="card-body">
	 
	 	<form action="medewerker_code.php" method="GET">
	 		<input type="hidden" name="id" value="<?php echo $data['medewerkerscode']; ?>">
	 		<div class="form-group">
      		<label> Voorletters </label>
      		<input type="text" name="edit_voorletters" value="<?php echo $data['voorletters']; ?>" class="form-control" placeholder="voornaam">
      	</div>

      	<div class="form-group">
      		<label> Voorvoegsel </label>
      		<input type="text" name="edit_voorvoegsel" value="<?php echo $data['voorvoegsels']; ?>" class="form-control" placeholder="voorvoegsel">
      	</div>

      	<div class="form-group">
      		<label> Achternaam </label>
      		<input type="text" name="edit_achternaam" value="<?php echo $data['achternaam']; ?>" class="form-control" placeholder="achternaam">
      	</div>

	 	<div class="form-group">
      		<label> Gebruikersnaam </label>
      		<input type="text" name="edit_gebruikersnaam" value="<?php echo $data['gebruikersnaam']; ?>" class="form-control" placeholder="Gebruikersnaam">
      	</div>

      	<div class="form-group">
      		<label> Wachtwoord </label>
      		<input type="password" name="edit_wachtwoord" value="<?php echo $data['wachtwoord']; ?>" class="form-control" placeholder="Wachtwoord">

                  <div class="form-group">
                  <label> Locatie </label>
                  <?php $filialen = $connection->filiaal();?>
                  <select class="form-control" name="edit_locatiecode">
                        <option value="0">kies filiaal</option>
                        <?php foreach($filialen as $filiaal) {?>
                        <option value="<?php echo $filiaal['locatiecode']; ?>"><?php echo $filiaal['plaats'];?></option>
                        <?php } ?>
                  </select>
                  
            </div>
      	</div>
      	<a href="medewerker.php" class="btn btn-danger"> ANNULEER</a>
      	<button type="submit" name="wijzig_medewerker_btn" class="btn btn-primary"> WIJZIGEN </button>
      	</form>
      	<?php }
      	} ?>
	 </div>

<?php
include "includes/footer.php";
?>