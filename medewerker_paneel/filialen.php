<?php
include "classes/db.class.php";
include "includes/header.php";
include "includes/navbar.php";
?>

<div class="modal fade" id="dmd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nieuw Filiaal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

       <form action="filialen_code.php" method="GET">
      <div class="modal-body">
        
      	<div class="form-group">
      		<label> plaats</label>
      		<select class="form-control" name="plaats">
      			<option value="Almere">Almere</option>
      			<option value="Den Haag">Den Haag</option>
      			<option value="Breda">Breda</option>
      			<option value="Den Bosch">Den Bosch</option>
      			<option value="Haarlem">Haarlem</option>
      			<option value="Amstelveen">Amstelveen</option>
      			<option value="Hoofdorp">Hoofddorp</option>
      			<option value="Utrecht">Utrecht</option>
      			<option value="Limburg">Limburg</option>
      			<option value="Zwolle">Zwolle</option>
      			<option value="Eindhoven">Eindhoven</option>
      			<option value="Tilburg">Tilburg</option>
      			<option value="Delft">Delft</option>
      			<option value="Purmerend">Purmerend</option>
      		</select>
      		<!-- <input type="text" name="plaats" class="form-control" placeholder="plaats"> -->
      	</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
        <button type="submit" name="opslaan_filiaal" class="btn btn-primary">Opslaan</button>
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
		<h6 class="m-0 font-weight-bold text-primary">Filialen
			 <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dmd">
  Toevoegen
</button>
		</h6>
	 </div>
</div>
<?php
$connection = new DB("localhost", "vissen", "root", "", "utf8");

$filiaal = $connection->filiaal();
?>
<div style="overflow: auto;">
<table class="table table-bordered" id="dataTable" width="100%"  cellspacing="0">
			<thead>
				<tr>
					<th> Filiaal </th>
					<th> EDIT </th>
					<th> DELETE </th>
				</tr>
			</thead>
			<?php
			foreach($filiaal as $value){
				$id = $value['locatiecode'];
			?>

			<tr>
				<td><?php echo $value['plaats']; ?></td>
					<td>
					<form method="GET" action="filiaal_aanpassen.php">
						<input type="hidden" name="filiaal_id_edit" value="<?php echo $id; ?>">
						<button type="submit" name="filiaal_aanpassen" class="btn btn-success">
							WIJZIGEN
						</button>
					</form>
				</td>
				<td>
					<form method="GET" action="filialen_code.php">
						<input type="hidden" name="filiaal_id_verwijderen" value="<?php echo $id; ?>">
						<button type="submit" name="filiaal_verwijderen" class="btn btn-danger">
							VERWIJDEREN
						</button>
					</form>
				</td>
			</tr>
		<?php } ?>
</table>
	</div>
<?php
include "includes/footer.php";
?>

<?php
include "includes/footer.php";
?>