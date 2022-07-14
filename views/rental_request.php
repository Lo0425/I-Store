<?php 
$title = "Purchase History";
function get_content(){
require_once '../controllers/connection.php';
$id = $_SESSION['user_info']['id'];

$query = "SELECT rent_item_calander.id AS calander_id, inventoryforrent.id AS r_id, inventoryforrent.itemName, inventoryforrent.image, inventoryforrent.price, rent_item_calander.start_date, rent_item_calander.end_date, rent_item_calander.item_id,rent_item_calander.status, user.username FROM inventoryforrent LEFT JOIN rent_item_calander ON inventoryforrent.id = rent_item_calander.item_id LEFT JOIN user ON user.id = rent_item_calander.rentalId WHERE inventoryforrent.rentalId != $id ORDER BY rent_item_calander.id ASC;";

$result = mysqli_query($cn,$query);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<main class="py-5">
    <div class="container bg-body py-3 rounded-1 mx-auto text-center shadow col-xl-10 col-lg-10 col-12 mb-3">
        <div class="d-flex justify-content-between">
            <div class="d-flex col-2">
                <p class="my-auto text-center col-12">Product</p>
            </div>
            <div class="col-3">
                <p class="my-auto text-start">User</p>
            </div>
            <div class="col-2" id="div1"><p class="my-auto">StartDate</p></div>
            <div class="col-2" id="div1"><p class="my-auto">EndDate</p></div>
            <div class="col-4" id="div1"><p class="mx-auto my-auto">Status</p></div>

        </div>
    </div>
    <?php 


foreach($items as $item){
    if($item['calander_id']!=""):
?>

    <div class="container bg-body py-5 rounded-1 mx-auto text-center shadow col-xl-10 col-lg-10 col-12 mb-2">
            
            <div class="d-flex justify-content-between">
                <div class="col-2 my-auto">
                    <img src="<?php echo $item['image'] ?>" alt="" class="img-fluid mx-auto w-50">
                    <p class="col-12 text-center my-auto"><?php echo $item['itemName']?></p>
                </div>
                    <div class="col-3 my-auto">
                        <p class="text-start my-auto"><?php echo $item['username']?></p>
                    </div>
                    <div class="col-2 my-auto"><p class="my-auto"><?php echo $item['start_date'] ?></p></div>
                    <div class="col-2 my-auto"><p class="my-auto"><?php echo $item['end_date'] ?></p></div>


                    <?php
                if($item['status']=="Pending"):
            ?>
                    <div class="mx-auto  my-auto"><badge class=" badge bg-secondary"><?php echo $item['status'] ?></badge></div>
                <?php elseif($item['status']=="Completed"): ?>
                    <div class="mx-auto  my-auto"><badge class=" badge bg-success"><?php echo $item['status'] ?></badge></div>

                <?php else: ?>

                    <div class="mx-auto my-auto"><badge class=" badge bg-warning"><?php echo $item['status'] ?></badge></div>


                <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
        </div>
    </div>





<?php
endif;
    } 
}
require_once 'layout.php';
?>

