<?php
include "classes/db.class.php";
include "includes/header.php";
include "includes/navbar.php";
$connection = new DB("localhost", "vissen", "root", "", "utf8");
?>

<div class="modal fade" id="dmd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nieuw Voorraad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

       <form action="voorraad_code.php" method="GET">
      <div class="modal-body">
        
      	<div class="form-group">
      		<label> Product </label>
      		<div class="form-group">
      		<?php $producten = $connection->producten();?>
      		<select class="form-control" name="productcode">
      			<option value="0">kies product</option>
      			<?php foreach($producten as $product) {?>
      			<option value="<?php echo $product['productcode']; ?>"><?php echo $product['product'];?></option>
      			<?php } ?>
      		</select>
      	</div>
      	</div>

        <div class="form-group">
          <label> Aantal </label>
          <input type="number" name="aantal" class="form-control" placeholder="Aantal">
        </div>

      	<div class="form-group">
      		<label> Plaats </label>
      		<div class="form-group">
      		<?php $filialen = $connection->filiaal();?>
      		<select class="form-control" name="locatiecode">
      			<option value="0">kies filiaal</option>
      			<?php foreach($filialen as $filiaal) {?>
      			<option value="<?php echo $filiaal['locatiecode']; ?>"><?php echo $filiaal['plaats'];?></option>
      			<?php } ?>
      		</select>
      	</div>
      	</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
        <button type="submit" name="opslaan_voorraad" class="btn btn-primary">Opslaan</button>
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
		<h6 class="m-0 font-weight-bold text-primary">Voorraad
			 <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dmd">
  Toevoegen
</button>
		</h6>
	 </div>
</div>
<?php
$connection = new DB("localhost", "vissen", "root", "", "utf8");

$voorraad = $connection->voorraad();
?>
<div style="overflow: auto;">
<table class="table table-bordered" id="dataTable" width="100%"  cellspacing="0">
			<thead>
				<tr>
					<th> Product </th>
					<th> Filiaal</th>
					<th> Aantal </th>
					<th> Inkoop prijs</th>
					<th> Verkoop prijs</th>
          <th> WIJZIGEN </th>
          <th> DELETE </th>
          <th> Totaal Inkoop </th>
          <th> Totaal Verkoop</th>
          <th> Verwachte Omzet</th>
				</tr>
			</thead>
			<?php
			foreach($voorraad as $value){
        $id = $value['productcode'];
				$omzet = 0;
        $totaal_inkoop = 0;
        $totaal_verkoop = 0;
        $totaal_omzet = 0;

        $totaal_inkoop += $value['aantal'] * $value['inkoop_prijs'];
        $totaal_verkoop += $value['aantal'] * $value['verkoop_prijs'];
        $omzet += $totaal_verkoop - $totaal_inkoop;
        
			?>

			<tr>
				<td><?php echo $value['product']; ?></td>
				<td><?php echo $value['plaats']; ?></td>
				<td><?php echo $value['aantal']; ?></td>
				<td><?php echo "<b>€</b> ".$value['inkoop_prijs']; ?></td>
				<td><?php echo "<b>€</b> ".$value['verkoop_prijs']; ?></td>
				
        <td>
          <form method="GET" action="voorraad_aanpassen.php">
            <input type="hidden" name="voorraad_id_edit" value="<?php echo $id; ?>">
            <button type="submit" name="voorraad_aanpassen" class="btn btn-success">
              WIJZIGEN
            </button>
          </form>
        </td>
        <td>
          <form method="GET" action="voorraad_code.php">
            <input type="hidden" name="voorraad_id_verwijderen" value="<?php echo $id; ?>">
            
            <button type="submit" name="voorraad_verwijderen" class="btn btn-danger">
              VERWIJDEREN
            </button>
          </form>
        </td>

			</tr>
		<?php } 
    $winst = $connection->voorraadWinst();
    // foreach ($winst as $profit) {
    //   echo $profit['totaal_inkoop'];
    // }
    var_dump($winst);
    ?>

    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td><?php echo "<b>€</b> ".$totaal_inkoop; ?></td>
      <td><?php echo "<b>€</b> ".$totaal_verkoop; ?></td>
      <td><?php echo "<b>€</b> ". $totaal_omzet; ?></td>
    </tr>
</table>
	</div>
<?php
include "includes/footer.php";
?>

<?php
include "includes/footer.php";
?>