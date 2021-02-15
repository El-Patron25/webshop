<?php
include "classes/db.class.php";
include "includes/header.php";
include "includes/navbar.php";

if(isset($_GET['voorraad_aanpassen']))
{
      $id = $_GET['voorraad_id_edit'];
$connection = new DB("localhost", "vissen", "root", "", "utf8");
$voorraad = $connection->voorraadFiliaal($id);

?>

      <!-- Data Voorbeeld -->
<div class="card shadow mb-4">
      <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">What do you wanna edit 
                  
            </h6>
       </div>

       <div class="card-body">
       
            <form action="voorraad_code.php" method="GET">
                  
            <div class="form-group">
                  <label> Product </label>
                  <div class="form-group">
                  
                  <select class="form-control" name="product">
                        <option value="0">kies Product</option>
                       <?php foreach($voorraad as $data) { ?>
                        <option value="<?php echo $data['locatiecode']; ?>"><?php echo $data['product']; ?></option>
                        <?php } ?>
                  </select>
            </div>
            

            

            <div class="form-group">
                  <label> Aantal + </label>
                  <?php foreach($voorraad as $data) { ?>
                  <input type="number" name="aantal"
                   value="<?php echo $data['aantal']; ?>" class="form-control" placeholder="aantal">
                   <?php } ?>
            </div>

            


            
            <?php $voorraad = $connection->voorraadFiliaal($id);
            ?>
            <p>Huidige FIlialen actief: <?php foreach($voorraad as $plaats) {
                  echo "<b>".$plaats['plaats']."</b>, ";
            }
                  ?>
                  
            </p>
            <div class="form-group">
                  <label> Filialen </label>
                  <div class="form-group">
                  <?php $filialen = $connection->voorraadFiliaal($id);?>
                  <select class="form-control" name="filiaal">
                        <option value="0">kies filiaal</option>
                        <?php foreach($filialen as $filiaal) {?>
                        <option value="<?php echo $filiaal['locatiecode']; ?>"><?php echo $filiaal['plaats'];?></option>
                        <?php } ?>
                  </select>
            </div>
            </div>
            <a href="voorraad.php" class="btn btn-danger"> ANNULEER</a>
            <button type="submit" name="wijzig_voorraad_btn" class="btn btn-primary"> WIJZIGEN </button>
            </form>
            
       </div>
 <?php } ?>
<?php
include "includes/footer.php";
?>