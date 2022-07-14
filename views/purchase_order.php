<?php 
$title = "Purchase History";
function get_content(){
require_once '../controllers/connection.php';

$id = $_SESSION['user_info']['id'];

$query = "SELECT orders.id AS order_id, orders.user_id, order_detail.product_id, order_detail.quantity,order_detail.status, order_detail.id AS order_detail_id, order_detail.order_id, inventoryforsale.id, inventoryforsale.itemName, inventoryforsale.Quantity, inventoryforsale.Category, inventoryforsale.image, inventoryforsale.price, inventoryforsale.size, user.id AS user__id, user.username, user.address, user.PhoneNumber FROM orders LEFT JOIN order_detail ON order_detail.order_id = orders.id LEFT JOIN inventoryforsale ON inventoryforsale.id = order_detail.product_id LEFT JOIN user ON user.id = orders.user_id WHERE orders.user_id != $id ORDER BY order_detail.status ASC;";


$result = mysqli_query($cn,$query);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<main class="py-5">
    <div class="container bg-body py-3 rounded-1 mx-auto text-center shadow col-xl-10 col-lg-10 col-12 mb-3">
        <div class="d-flex justify-content-between col-12">
            <div class="d-flex col-2 ps-3">
                <p class="my-auto mx-auto">Product</p>
            </div>

            <div class="mx-auto my-auto col-4" id="div1"><p class="my-auto text-start">Costumer Details</p></div>
            <div class="col-2" id="div1"><p class="my-auto">Quantity</p></div>
            <div class="col-2 pe-3" id="div1"><p class="my-auto">Action</p></div>

        </div>
    </div>
    <?php 

// var_dump($items);
// die();

foreach($items as $item){

?>
    <div class="container bg-body py-5 rounded-1 mx-auto text-center shadow col-xl-10 col-lg-10 col-12 mb-2">
            
            <div class="container-fluid d-flex justify-content-between col-12">
            <div class="col-2 my-auto">
               <?php $total = $item['price'] * $item['quantity']; ?>
                <div class="col-12">
                    <img src="<?php echo $item['image'] ?>" alt="" class="img-fluid mx-auto w-50"></div>
                    <p class="col-12 text-center my-auto"><?php echo $item['itemName']?></p>
                </div>

                <div class="col-4 text-start my-auto">
                    <p>Name: <?php echo $item['username'] ?></p>
                    <p>Address: <?php echo $item['address'] ?></p>
                    <p>Contact Number: <?php echo $item['PhoneNumber'] ?></p>
                </div>
                <div class="col-2 my-auto">
                    <p class="my-auto"><?php echo $item['quantity'] ?></p>
                </div>
            <?php
            
            ?>
            <?php if($item['status']=="Received"): ?>
            <div class="my-auto col-2"><button class="btn btn-success"><p class="my-auto"><?php echo $item['status'] ?></p></button></div>
            <?php else: ?>
                <div class="my-auto col-2"><button class="btn btn-danger"><p class="my-auto"><?php echo $item['status'] ?></p></button></div>
                <?php endif; ?>
        </div>
    </div>



<?php
    } 
}
require_once 'layout.php';
?>

