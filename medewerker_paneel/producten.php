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
        <h5 class="modal-title" id="exampleModalLabel">Nieuw Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
       <form action="producten_code.php" enctype="multipart/form-data" method="GET">
      <div class="modal-body">
        
      	<div class="form-group">
      		<label> Product</label>
      		<input type="text" name="product" class="form-control" placeholder="Product">
      	</div>

      	<div class="form-group">
      		<label> Type </label>
      		<input type="text" name="type" class="form-control" placeholder="Type">
      	</div>

      	<div class="form-group">
      		<label> Inkoop (€) <i><small>voor seperatie met decimale moet een '.' gebruikt worden</small></i></label>
      		<input type="text" name="inkoop_prijs"   class="form-control" placeholder="Inkoop prijs per stuk">
      	</div>

      	<div class="form-group">
      		<label> Verkoop (€) <i><small>voor seperatie met decimale moet een '.' gebruikt worden</small></i></label>
      		<input type="text" name="verkoop_prijs"   class="form-control" placeholder="Verkoop prijs per stuk">
      	</div>
      	<div class="form-group">
      		<label> Welke Leverancier: </label>
      		<?php $leveranciers = $connection->leveranciers();?>
      		<select class="form-control" name="leverancier">
      			<option value="0">kies leverancier</option>
      			<?php foreach($leveranciers as $Leverancier) {?>
      			<option value="<?php echo $Leverancier['lev_code']; ?>"><?php echo $Leverancier['naam'];?></option>
      			<?php } ?>
      		</select>
      	</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
        <button type="submit" name="opslaan_product" class="btn btn-primary">Opslaan</button>
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
		<h6 class="m-0 font-weight-bold text-primary">Producten
			 <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dmd">
  Toevoegen
</button>

<form method="GET">
<button name="producten" type="submit" class="btn btn-primary" >
  Alle producten
</button>
</form>
		</h6>
	 </div>

	  <!-- Search form -->
<form action="" method="GET" class="form-inline d-flex justify-content-center md-form form-sm active-purple active-purple-2 mt-2">
  <i class="fas fa-search" aria-hidden="true"></i>
  <input name="zoeken" class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Zoeken op product of filiaal"
    aria-label="Search">
</form>
</div>

<?php

if(isset($_GET['zoeken']))
{

	$zoeken = trim($_GET['zoeken']);

	$data = $connection->searchproducten($zoeken);

?>
<div style="overflow: auto;">
<table class="table table-bordered" id="dataTable" width="100%"  cellspacing="0">
			<thead>
				<tr>
					<th> ID </th>
					<th> Product </th>
					<th> Type </th>
					<th> Leverancier </th>
					<th> Inkoop <small><b>€</b> Ps.</small> </th>
					<th> Verkoop <small><b>€</b> Ps.</small></th>
					<th> Edit </th>
					<th> Delete </th>
					<th> Totaal inkoop </th>
					<th> Totaal verkoop </th>
					<th> Verwachte Omzet </th>
				</tr>
			</thead>
			<?php 
				$totaal_inkoop=0;
				$totaal_verkoop=0;
				$total_inkoop_prijs=0;
				$total_verkoop_prijs=0;
				$omzet = 0;
				foreach($data as $key) {

				$totaal_inkoop += $key['inkoop_prijs'];
				$totaal_verkoop += $key['verkoop_prijs'];


				
				
				$total_inkoop_prijs += $key['inkoop_prijs'];
				$total_verkoop_prijs += $key['verkoop_prijs'];
				$omzet = $total_verkoop_prijs - $total_inkoop_prijs;
				
				$id = $key['productcode'];
				
				?>
			<tr>
				<td><?php echo $id; ?></td>
				<td><?php echo $key['product']; ?></td>
				<td><?php echo $key['type']; ?></td>
				<td><?php echo $key['naam']; ?></td>
				<td><?php echo "<b>€</b> ". $key['inkoop_prijs']; ?></td>
				<td><?php echo "<b>€</b> ". $key['verkoop_prijs']; ?></td>

				
				<td>
					<form method="GET" action="product_aanpassen.php">
						<input type="hidden" name="product_id_edit" value="<?php echo $id; ?>">
						<button type="submit" name="product_aanpassen" class="btn btn-success">
							WIJZIGEN
						</button>
					</form>
				</td>
				<td>
					<form method="GET" action="producten_code.php">
						<input type="hidden" name="product_id_verwijderen" value="<?php echo $id; ?>">
						<button type="submit" name="product_verwijderen" class="btn btn-danger">
							VERWIJDEREN
						</button>
					</form>
				</td>
				<?php } ?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				<td><?php echo "<b>€</b> ". $total_inkoop_prijs; ?></td>
				<td><?php echo "<b>€</b> ". $total_verkoop_prijs ?></td>
			</tr>

				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				<td></td>
				<td></td>
				<hr>
				<td><?php echo "<b>€</b> ". $omzet; ?></td>
			</tr>
		
		</table>
	</div>
<?php
}

$producten = $connection->producten();
if(isset($_GET['producten']))
{
?>
<div style="overflow: auto;">
<table class="table table-bordered" id="dataTable" width="100%"  cellspacing="0">
			<thead>
				<tr>
					<th> ID </th>
					<th> Product </th>
					<th> Type </th>
					<th> Leverancier </th>
					<th> Inkoop <small><b>€</b> Ps.</small> </th>
					<th> Verkoop <small><b>€</b> Ps.</small></th>
					<th> Edit </th>
					<th> Delete </th>
					<th> Totaal inkoop </th>
					<th> Totaal verkoop </th>
					<th> Verwachte Omzet </th>
				</tr>
			</thead>
			<?php 
				$totaal_inkoop=0;
				$totaal_verkoop=0;
				$total_inkoop_prijs=0;
				$total_verkoop_prijs=0;
				$omzet = 0;
				foreach($producten as $product) {

				$totaal_inkoop += $product['inkoop_prijs'];
				$totaal_verkoop += $product['verkoop_prijs'];


				
				
				$total_inkoop_prijs += $product['inkoop_prijs'];
				$total_verkoop_prijs += $product['verkoop_prijs'];
				$omzet = $total_verkoop_prijs - $total_inkoop_prijs;
				
				$id = $product['productcode'];
				
				?>
			<tr>
				<td><?php echo $id; ?></td>
				<td><?php echo $product['product']; ?></td>
				<td><?php echo $product['type']; ?></td>
				<td><?php echo $product['naam']; ?></td>
				<td><?php echo "<b>€</b> ". $product['inkoop_prijs']; ?></td>
				<td><?php echo "<b>€</b> ". $product['verkoop_prijs']; ?></td>

				
				<td>
					<form method="GET" action="product_aanpassen.php">
						<input type="hidden" name="product_id_edit" value="<?php echo $id; ?>">
						<button type="submit" name="product_aanpassen" class="btn btn-success">
							WIJZIGEN
						</button>
					</form>
				</td>
				<td>
					<form method="GET" action="producten_code.php">
						<input type="hidden" name="product_id_verwijderen" value="<?php echo $id; ?>">
						<button type="submit" name="product_verwijderen" class="btn btn-danger">
							VERWIJDEREN
						</button>
					</form>
				</td>
				<?php } ?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				<td><?php echo "<b>€</b> ". $total_inkoop_prijs; ?></td>
				<td><?php echo "<b>€</b> ". $total_verkoop_prijs ?></td>
			</tr>

				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				<td></td>
				<td></td>
				<hr>
				<td><?php echo "<b>€</b> ". $omzet; ?></td>
			</tr>
		
		</table>
	</div>
<?php
}


include "includes/footer.php";
?>