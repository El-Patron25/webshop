<?php
include "classes/db.class.php";
include "includes/header.php";
include "includes/navbar.php";

if(isset($_GET['filiaal_aanpassen']))
{
	$id = $_GET['filiaal_id_edit'];
$connection = new DB("localhost", "vissen", "root", "", "utf8");
$filiaal = $connection->selectFiliaal($id);
foreach($filiaal as $data)
{
?>

	<!-- Data Voorbeeld -->
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">What do you wanna edit 
			
		</h6>
	 </div>

	 <div class="card-body">
	 
	 	<form action="filialen_code.php" method="GET">
	 		<input type="hidden" name="id" value="<?php echo $data['id']; ?>">
	 		<div class="form-group">
      		<label> Plaats </label>
      		<div class="form-group">
      		<?php $filialen = $connection->filiaal();?>
      		<select class="form-control" name="edit_plaats">
      			<option value="0">kies filiaal</option>
      			<?php foreach($filialen as $filiaal) {?>
      			<option value="<?php echo $filiaal['plaats']; ?>"><?php echo $filiaal['plaats'];?></option>
      			<?php } ?>
      		</select>
      	</div>
      	</div>


      	</div>
      	<a href="filialen.php" class="btn btn-danger"> ANNULEER</a>
      	<button type="submit" name="wijzig_filiaal_btn" class="btn btn-primary"> WIJZIGEN </button>
      	</form>
      	<?php }
      	} ?>
	 </div>

<?php
include "includes/footer.php";
?>