<?php 
$title = "Purchase History";

function get_content(){
require_once '../controllers/connection.php';

$id = $_SESSION['user_info']['id'];

$query = "SELECT orders.id AS order_id, orders.user_id, order_detail.product_id, order_detail.quantity,order_detail.status, order_detail.id AS order_detail_id, order_detail.order_id, inventoryforsale.id, inventoryforsale.itemName, inventoryforsale.Quantity, inventoryforsale.Category, inventoryforsale.image, inventoryforsale.price, inventoryforsale.size FROM orders LEFT JOIN order_detail ON order_detail.order_id = orders.id LEFT JOIN inventoryforsale ON inventoryforsale.id = order_detail.product_id WHERE orders.user_id = $id ORDER BY order_detail.id DESC;";


$result = mysqli_query($cn,$query);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<main class="py-5">
    <div class="container bg-body py-3 rounded-1 mx-auto text-center shadow col-xl-10 col-lg-10 col-12 mb-3">
        <div class="d-flex justify-content-between">
            <div class="d-flex col-2">
                <p class="my-auto ps-2">Product</p>
            </div>

            <div class="col-2 my-auto" id="div1">
            <p class="my-auto">Unit Price</p>
            </div>
            <div class="col-2" id="div1"><p class="my-auto">Quantity</p></div>
            <div class="col-2" id="div1"><p class="my-auto">Total Price</p></div>
            <div class="col-3" id="div1"><p class="my-auto">Action</p></div>

        </div>
    </div>
    <?php 



foreach($items as $item){

?>
    <div class="container bg-body py-5 rounded-1 mx-auto text-center shadow col-xl-10 col-lg-10 col-12 mb-2">
            
            <div class="d-flex justify-content-between col-12">
                <div class="col-2 ms-2 my-auto text-start">
               <?php $total = $item['price'] * $item['quantity']; ?>
                    <img src="<?php echo $item['image'] ?>" alt="" class="img-fluid mx-auto w-75 border border-dark">
                    <p class="col-12 text-start pt-2"><b><?php echo $item['itemName']?></b></p>
                </div>
                    <div class="col-1 my-auto"><p class="my-auto">RM <?php echo $item['price'] ?></p></div>
                    <div class="col-2 my-auto"><p class="my-auto"><?php echo $item['quantity'] ?></p></div>
                    <?php
            
            ?>
            <div class="col-1 my-auto"><p class="my-auto">RM <?php echo $total ?></p></div>


            <?php if($item['status'] == "Received"):?>
            <div class="my-auto col-3">
                <span class="badge bg-success p-2"><p class="my-auto"><?php echo $item['status'] ?></p></span>
            </div>
            <?php else: ?>
            <div class=" my-auto col-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $item['order_detail_id'] ?>"><p class="my-auto">Order Received</p></button>
            </div>

                <?php endif; ?>

                
                <div class="modal fade" id="exampleModal-<?php echo $item['order_detail_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm Shipment Successful</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close_payment">
                            </button>
                        </div>
                        <div class="modal-body">
                        <a class="btn btn-success" href="/controllers/users/item_received.php?id=<?php echo $item['order_detail_id']; ?>">Confirm</a>
                            </div>
                            
           
                        </div>
                    </div>
                </div>

        </div>
    </div>



<?php
    } 
}
require_once 'layout.php';

?>



