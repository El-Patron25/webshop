<?php
include "classes/db.class.php";
include "includes/header.php";
include "includes/navbar.php";

if(isset($_GET['product_aanpassen']))
{
	$id = $_GET['product_id_edit'];
$connection = new DB("localhost", "vissen", "root", "", "utf8");
$product = $connection->selectProduct($id);
foreach($product as $data)
{
?>

	<!-- Data Voorbeeld -->
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">What do you wanna edit 
			
		</h6>
	 </div>

	 <div class="card-body">
	 
	 	<form action="producten_code.php" method="GET">
	 		<input type="hidden" name="id" value="<?php echo $data['productcode']; ?>">
	 		<div class="form-group">
      		<label> Product </label>
      		<input type="text" name="edit_product" value="<?php echo $data['product']; ?>" class="form-control" placeholder="product">
      	</div>

      	<div class="form-group">
      		<label> Type </label>
      		<input type="text" name="edit_type" value="<?php echo $data['type']; ?>" class="form-control" placeholder="type">
      	</div>

      	<div class="form-group">
      		<label> Inkoop Waarde </label>
      		<input type="text" name="edit_inkoop_prijs" value="<?php echo $data['inkoop_prijs']; ?>" class="form-control" placeholder="Inkoop Prijs">
      	</div>

      	<div class="form-group">
      		<label> Verkoop Waarde </label>
      		<input type="text" name="edit_verkoop_prijs" value="<?php echo $data['verkoop_prijs']; ?>" class="form-control" placeholder="Verkoop Prijs">
      	</div>
            <?php $voorraad = $connection->voorraadFiliaal($id);
            ?>

            <div class="form-group">
                  <label> Welke filiaal wil je wijzigen: 
                        <select class="form-control" name="filiaal_verander">
                        <option value="0">kies filiaal</option>
                        <?php foreach($voorraad as $plaats) {?>
                        <option value="<?php echo $plaats['id']; ?>"><?php echo $plaats['plaats'];?></option>
                        <?php } ?>
                  </select>
            </div> </label><label> of toevoegen:</label>
                  <?php $filialen = $connection->filiaal();?>
                  <select class="form-control" name="filiaal">
                        <option value="0">kies filiaal</option>
                        <?php foreach($filialen as $filiaal) {?>
                        <option value="<?php echo $filiaal['id']; ?>"><?php echo $filiaal['plaats'];?></option>
                        <?php } ?>
                  </select>
            </div>
      	<a href="producten.php" class="btn btn-danger"> ANNULEER</a>
      	<button type="submit" name="wijzig_product_btn" class="btn btn-primary"> WIJZIGEN </button>
      	</form>
      	<?php }
      	} ?>
	 </div>

<?php
include "includes/footer.php";
?>