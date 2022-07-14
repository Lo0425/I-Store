<?php 
$title = "Purchase History";
function get_content(){
require_once '../controllers/connection.php';
$id = $_SESSION['user_info']['id'];

$query = "SELECT rent_item_calander.id AS calander_id, inventoryforrent.id AS r_id, inventoryforrent.itemName, inventoryforrent.image, inventoryforrent.price, rent_item_calander.start_date, rent_item_calander.end_date, rent_item_calander.item_id,rent_item_calander.status FROM inventoryforrent LEFT JOIN rent_item_calander ON inventoryforrent.id = rent_item_calander.item_id  WHERE inventoryforrent.rentalId = $id ORDER BY rent_item_calander.status DESC;";

$result = mysqli_query($cn,$query);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<main class="py-5">
<?php

    ?>
    <?php
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $now = date('Y-m-d'); //Returns IST

    ?>
    <div class="text-center mb-5">
        <div class="fs-1"><?php echo $now ?></div>
        <div class="fs-1" id="runningTime"></div>
    </div>
    <div class="container bg-body py-3 rounded-1 mx-auto text-center shadow col-xl-10 col-lg-10 col-12 mb-3">
        <div class="d-flex justify-content-between">
            <div class="d-flex col-2">
                <p class="my-auto ps-5">Product</p>
            </div>

            <div class="col-2" id="div1"><p class="my-auto">StartDate</p></div>
            <div class="col-2" id="div1"><p class="my-auto">EndDate</p></div>
            <div class="col-3" id="div1"><p class="my-auto">Status</p></div>

        </div>
    </div>
    <?php 


foreach($items as $item){
    if($item['calander_id']!=""):
?>

    <div class="container bg-body py-5 rounded-1 mx-auto text-center shadow col-xl-10 col-lg-10 col-12 mb-2">
            
            <div class="d-flex justify-content-between">
                <div class="col-2 my-auto">

            <?php
                $calander_id =$item['calander_id'];
                if($now > $item['start_date'] && $now > $item['end_date']){
                    $query_update = "UPDATE rent_item_calander SET status = 'Completed' WHERE id = $calander_id ;";
                    $query_result = mysqli_query($cn, $query_update);

                    //update ongoing to completed
                }else if($now >= $item['start_date']){
                    $query_update = "UPDATE rent_item_calander SET status = 'Ongoing' WHERE id = $calander_id ;";
                    $query_result = mysqli_query($cn, $query_update);

                    //update pending to ongoing
                }else if($now < $item['start_date']){
                    $query_update = "UPDATE rent_item_calander SET status = 'Pending' WHERE id = $calander_id ;";
                    $query_result = mysqli_query($cn, $query_update);
                }
            ?>

               <img src="<?php echo $item['image'] ?>" alt="" class="img-fluid mx-auto w-50">
                    <p class="col-12 text-center mt-2 my-auto"><?php echo $item['itemName']?></p></div>
                    
                    <div class="col-2 my-auto"><p class="my-auto"><?php echo $item['start_date'] ?></p></div>
                    <div class="col-2 my-auto"><p class="my-auto"><?php echo $item['end_date'] ?></p></div>


                    <?php
                if($item['status']=="Pending"):
            ?>
                    <div class="col-3 my-auto"><badge class="p-3 px-3 badge bg-secondary"><?php echo $item['status'] ?></badge></div>
                <?php elseif($item['status']=="Completed"): ?>
                    <div class="col-3 my-auto"><badge class="p-3 px-2 badge bg-success"><?php echo $item['status'] ?></badge></div>
                <?php else: ?>
                    <div class="col-3 my-auto"><badge class="p-3 px-3 badge bg-warning"><?php echo $item['status'] ?></badge></div>
                <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
        </div>
    </div>

    <?php 
    else:
    ?>
    <div class="sticky-bottom container p-5 rounded-1 col-xl-10 col-lg-10 col-12 text-end d-flex justify-content-between shadow-lg bg-body" style="z-index:1;">
        <div class="me-auto">
            <h1 class="my-auto">Nothing in cart</h1>
        </div>
    </div>



<?php
endif;
    } 
}
require_once 'layout.php';
?>



<script type="text/javascript">
    $(document).ready(function() {
    setInterval(runningTime, 0);
    });
    function runningTime() {
    $.ajax({
        url: 'timeScript.php',
        success: function(data) {
        $('#runningTime').html(data);
        },
    });
    }
</script>