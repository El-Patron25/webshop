<?php
include "classes/db.class.php";
include "includes/header.php";
include "includes/navbar.php";
$connection = new DB("localhost", "vissen", "root", "", "utf8");
?>
<!-- Modal -->
<div class="modal fade" id="dmd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nieuwe Medewerker</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
       <form action="medewerker_code.php" method="GET">
      <div class="modal-body">
        
      	<div class="form-group">
      		<label> Voorletters </label>
      		<input type="text" name="voorletters" class="form-control" placeholder="Voorletters">
      	</div>

      	<div class="form-group">
      		<label> voorvoegsel </label>
      		<input type="text" name="voorvoegsel" class="form-control" placeholder="Voorvoegsel">
      	</div>

      	<div class="form-group">
      		<label> Achternaam </label>
      		<input type="text" name="achternaam"   class="form-control" placeholder="Achternaam">
      	</div>

      	<div class="form-group">
      		<label> Gebruikersnaam </label>
      		<input type="text" name="gebruikersnaam"   class="form-control" placeholder="Gebruikersnaam">
      	</div>

      	<div class="form-group">
      		<label> Wachtwoord </label>
      		<input type="text" name="wachtwoord"   class="form-control" placeholder="Wachtwoord">
      	</div>

      	<div class="form-group">
      		<label> Locatie <small><i>als er nog geen filiaal is aangemaakt moet dat eerst gedaan worden: zie overzichten->filialen</i></small> </label>
      		<?php $filialen = $connection->filiaal();?>
      		<select class="form-control" name="filiaal">
      			<option value="0">kies filiaal</option>
      			<?php foreach($filialen as $filiaal) {?>
      			<option value="<?php echo $filiaal['locatiecode']; ?>"><?php echo $filiaal['plaats'];?></option>
      			<?php } ?>
      		</select>
      		
      	</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
        <button type="submit" name="opslaan_medewerker" class="btn btn-primary">Opslaan</button>
      </div>
  </form>
      </div>
  </div>
</div>

<!-- Begin container Fluid -->
<div class="container-fluid">

<!-- Data Example -->
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Medewerkers
			 <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dmd">
  Toevoegen
</button>
		</h6>
    <form method="GET">
<button name="medewerkers" type="submit" class="btn btn-primary" >
  All medewerkers
</button>
</form>
	 </div>

   <!-- Search form -->
<form action="" method="GET" class="form-inline d-flex justify-content-center md-form form-sm active-purple active-purple-2 mt-2">
  <i class="fas fa-search" aria-hidden="true"></i>
  <input name="zoeken" class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Zoeken op gebruikersnaam of filiaal"
    aria-label="Search">
</form>
</div>
<?php
if(isset($_GET['zoeken']))
{
  $zoeken = trim($_GET['zoeken']);
  // $zoeken += preg_replace("#[^0-9a-z]#i", "", $zoeken);
  $data = $connection->searchMedewerkers($zoeken);
 
?>
<div style="overflow: auto;">
 <table class="table table-bordered" id="dataTable" width="100%"  cellspacing="0">
      <thead>
        <tr>
          <th> ID </th>
          <th> Voorletters </th>
          <th> Voorvoegsel </th>
          <th> Achternaam </th>
          <th> Gebruikersnaam </th>
          <th> Filiaal </th>
          <th> wijzigen </th>
          <th> verwijderen </th>
        </tr>
      </thead>
      <?php foreach($data as $key) {

        $id = $key['medewerkerscode'];

        ?>
      <tr>
        <td><?php echo $id; ?></td>
        <td><?php echo $key['voorletters']; ?></td>
        <td><?php echo $key['voorvoegsels']; ?></td>
        <td><?php echo $key['achternaam']; ?></td>
        <td><?php echo $key['gebruikersnaam']; ?></td>
        <td><?php echo $key['plaats']; ?></td>
        <td>
          <form method="GET" action="medewerker_aanpassen.php">
            <input type="hidden" name="medewerker_id_edit" value="<?php echo $id; ?>">
            <button type="submit" name="medewerker_aanpassen" class="btn btn-success">
              WIJZIGEN
            </button>
          </form>
        </td>
        <td>
          <form method="GET" action="medewerker_code.php">
            <input type="hidden" name="medewerker_id_verwijderen" value="<?php echo $id; ?>">
            <button type="submit" name="medewerker_verwijderen" class="btn btn-danger">
              VERWIJDEREN
            </button>
          </form>
        </td>
      </tr>
    <?php } ?>
    </table>
  </div>
<?php
}

$medewerkers = $connection->medewerkers();

if(isset($_GET['medewerkers']))
{
?>
<div style="overflow: auto;">
 <table class="table table-bordered" id="dataTable" width="100%"  cellspacing="0">
			<thead>
				<tr>
					<th> ID </th>
					<th> Voorletters </th>
					<th> Voorvoegsel </th>
					<th> Achternaam </th>
					<th> Gebruikersnaam </th>
					<th> Filiaal </th>
					<th> wijzigen </th>
					<th> verwijderen </th>
				</tr>
			</thead>
			<?php foreach($medewerkers as $medewerker) {

				$id = $medewerker['medewerkerscode'];
				?>
			<tr>
				<td><?php echo $id; ?></td>
				<td><?php echo $medewerker['voorletters']; ?></td>
				<td><?php echo $medewerker['voorvoegsels']; ?></td>
				<td><?php echo $medewerker['achternaam']; ?></td>
				<td><?php echo $medewerker['gebruikersnaam']; ?></td>
				<td><?php echo $medewerker['plaats']; ?></td>
				<td>
					<form method="GET" action="medewerker_aanpassen.php">
						<input type="hidden" name="medewerker_id_edit" value="<?php echo $id; ?>">
						<button type="submit" name="medewerker_aanpassen" class="btn btn-success">
							WIJZIGEN
						</button>
					</form>
				</td>
				<td>
					<form method="GET" action="medewerker_code.php">
						<input type="hidden" name="medewerker_id_verwijderen" value="<?php echo $id; ?>">
						<button type="submit" name="medewerker_verwijderen" class="btn btn-danger">
							VERWIJDEREN
						</button>
					</form>
				</td>
			</tr>
		<?php } ?>
		</table>
	</div>
<?php
}
include "includes/footer.php";
?>