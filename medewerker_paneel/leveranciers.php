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
        <h5 class="modal-title" id="exampleModalLabel">Nieuw Leverancier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
       <form action="leverancier_code.php" enctype="multipart/form-data" method="GET">
      <div class="modal-body">
        
      	<div class="form-group">
      		<label> Naam </label>
      		<input type="text" name="naam" class="form-control" placeholder="Naam Leverancier">
      	</div>

      	<div class="form-group">
      		<label> Telefoon </label>
      		<input type="text" name="telefoon" class="form-control" placeholder="Telefoon">
      	</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
        <button type="submit" name="opslaan_leverancier" class="btn btn-primary">Opslaan</button>
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
		<h6 class="m-0 font-weight-bold text-primary">Leveranciers
			 <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dmd">
  Toevoegen
</button>
		</h6>
	 </div>
</div>
<?php
$leveran = $connection->leveranciers();
?>
<div style="overflow: auto;">
<table class="table table-bordered" id="dataTable" width="100%"  cellspacing="0">
			<thead>
				<tr>
					<th> Naam </th>
					<th> Telefoon </th>
					<th> Edit </th>
					<th> Delete </th>
				</tr>
			</thead>
			<?php 

				foreach($leveran as $leverancier) {
					$id = $leverancier['lev_code'];
				?>
			<tr>
				<td><?php echo $leverancier['naam']; ?></td>
				<td><?php echo $leverancier['telefoon']; ?></td></td>
				
				<td>
					<form method="GET" action="leverancier_aanpassen.php">
						<input type="hidden" name="leverancier_id_edit" value="<?php echo $id; ?>">
						<button type="submit" name="leverancier_aanpassen" class="btn btn-success">
							WIJZIGEN
						</button>
					</form>
				</td>
				<td>
					<form method="GET" action="leverancier_code.php">
						<input type="hidden" name="leverancier_id_verwijderen" value="<?php echo $id; ?>">
						<button type="submit" name="leverancier_verwijderen" class="btn btn-danger">
							VERWIJDEREN
						</button>
					</form>
				</td>
				<?php } ?>
		
		</table>
	</div>
<?php
include "includes/footer.php";
?>