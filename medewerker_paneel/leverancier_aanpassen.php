<?php
include "classes/db.class.php";
include "includes/header.php";
include "includes/navbar.php";

if(isset($_GET['leverancier_aanpassen']))
{
	$id = $_GET['leverancier_id_edit'];
$connection = new DB("localhost", "vissen", "root", "", "utf8");
$leverancier = $connection->selecteerLeverancier($id);
foreach($leverancier as $data)
{
?>

	<!-- Data Voorbeeld -->
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">What do you wanna edit 
			
		</h6>
	 </div>

	 <div class="card-body">
	 
	 	<form action="leverancier_code.php" method="GET">
	 		<input type="hidden" name="id" value="<?php echo $data['lev_code']; ?>">
	 		<div class="form-group">
      		<label> Naam </label>
      		<input type="text" name="edit_naam" value="<?php echo $data['naam']; ?>" class="form-control" placeholder="naam">
      	</div>

      	<div class="form-group">
      		<label> Telefoon </label>
      		<input type="text" name="edit_telefoon" value="<?php echo $data['telefoon']; ?>" class="form-control" placeholder="telefoon">
      	</div>

      	
      	<a href="leveranciers.php" class="btn btn-danger"> ANNULEER</a>
      	<button type="submit" name="wijzig_leverancier_btn" class="btn btn-primary"> WIJZIGEN </button>
      	</form>
      	<?php }
      	} ?>
	 </div>

<?php
include "includes/footer.php";
?>