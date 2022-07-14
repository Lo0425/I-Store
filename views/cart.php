<?php 
$title = "Cart";
function get_content(){
require_once '../controllers/connection.php';
$id = $_SESSION['user_info']['id'];

$query = "SELECT cart.id AS cart_no, cart.user_id, inventoryforsale.id AS p_id, inventoryforsale.itemName, inventoryforsale.image, inventoryforsale.price, inventoryforsale.size, cart_items.product_id, cart_items.id AS cart_item_id,cart_items.quantity FROM cart LEFT JOIN cart_items ON cart_items.cart_id = cart.id LEFT JOIN inventoryforsale ON inventoryforsale.id = cart_items.product_id WHERE user_id = $id ORDER BY cart_items.id DESC;";
$result = mysqli_query($cn,$query);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
// var_dump($items);
// die();

$inventory_rent_query = "SELECT * FROM inventoryforrent;";
$inventory_rent_result = mysqli_query($cn, $inventory_rent_query);
$inventory_rent = mysqli_fetch_all($inventory_rent_result, MYSQLI_ASSOC);


$total_price = 0;

?>

<main class="py-5">
    <div class="container bg-body py-3 rounded-1 mx-auto text-center shadow col-xl-10 col-lg-10 col-12 mb-3">
        <div class="d-flex justify-content-between">
            <div class="d-flex col-2">
                <input type="checkbox" class="my-auto mx-3" id="select-all"><p class="my-auto">Product</p>
            </div>
            <div class="col-2">

            </div>
            <div class="col-2 my-auto" id="div1"><p class="my-auto">Unit Price</p></div>
            <div class="col-2" id="div1"><p class="my-auto">Quantity</p></div>
            <div class="col-2" id="div1"><p class="my-auto">Total Price</p></div>
            <div class="col-2" id="div1"><p class="my-auto">Action</p></div>

        </div>
    </div>
    <?php 
    foreach($items as $item){
        ?>
    <?php if($item['product_id'] != ""): ?>
        <div class="container bg-body py-5 rounded-1 mx-auto text-center shadow col-xl-10 col-lg-10 col-12 mb-2">
            
            <div class="d-flex justify-content-between">
                <div class="col-2 my-auto">
               <?php $total = $item['price'] * $item['quantity']; ?>

                    <input type="checkbox" name="item" value="<?php echo $total ?>" id="<?php echo $item['cart_item_id']; ?>" onclick="totalIt()">

                    <input type="hidden" name="quantity" value="<?php echo $item['quantity']; ?>">


                    <img src="<?php echo $item['image'] ?>" alt="" class="img-fluid mx-auto w-50"></div>
                    <p class="col-2 text-start my-auto"><?php echo $item['itemName']?></p>
                    
                    <div class="col-2 my-auto"><p class="my-auto">RM <?php echo $item['price'] ?></p></div>
                    <div class="col-2 my-auto"><p class="my-auto"><?php echo $item['quantity'] ?></p></div>
                    <?php
            
            ?>

<div class="col-2 my-auto"><p class="my-auto">RM <?php echo $total ?></p></div>
<div class="col-2 my-auto"><button class="btn btn-danger" data-bs-target="#deleteproduct-<?php echo $item['cart_item_id']; ?>" data-bs-toggle="modal"><i class="fa-regular fa-trash-can"></i></button></div>


<div class="modal" id="deleteproduct-<?php echo $item['cart_item_id'] ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure to delete <?php echo $item['itemName'] ?> from your cart?</p>
            </div>
                        <div class="modal-footer">
                            <a class="btn btn-danger" href="/controllers/users/delete_item.php?id=<?php echo $item['cart_item_id']; ?>">Confirm</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            </div>

            </div>

            <input type="hidden" value="<?php echo $total ?>" id="total">

            <input type="hidden" value="<?php echo $item['cart_item_id'] ?>" id="cart_item_id">

                
        <?php   
            endif;
        }   //endforeach;
        ?>
    <script src="https://www.paypal.com/sdk/js?client-id=AamE5_7lCdb6Wo3d9YJHl5lWKIltcVOgczJjMba9FoOJ3V9R1eOLyoF1YdRtXZQ6HJ8Z7usnpq6VaupT&currency=MYR"></script>

    <div class="sticky-bottom container p-5 rounded-1 col-xl-10 col-lg-10 col-12 text-end d-flex justify-content-between shadow-lg bg-body" style="z-index:1;">
        <div class="d-flex justify-content-between col-12">
        <?php if (count($items)!=0): ?>
            <div class="me-auto my-auto col-9"><p class="my-auto">RM 
                <input class="border-0 bg-body" value="0.00" readonly="readonly" type="text" id="total_amount" disabled ></p>
            </div>
           
            <div class="my-auto">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" id="checkout-btn">Checkout</button>
            </div>
            <?php else: ?>
                <div class="me-auto">
                    <h1 class="my-auto">Nothing in cart</h1>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Make Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close_payment">
                    </button>
                </div>
                
                <div class="modal-body" id="test">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>
    </div>
    </main>

    <?php
} 
require_once 'layout.php';
?>
<script>
    document.getElementById('select-all').onclick = function() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
            var input = document.getElementsByName("item");
            var total = 0;
            for (var i = 0; i < input.length; i++) {
                if (input[i].checked) {
                    total += parseFloat(input[i].value);
                }
            }
            document.getElementById("total_amount").value = total.toFixed(2);
        }
        
}

</script>

<script>
function totalIt() {
  var input = document.getElementsByName("item");
  var total = 0;
  var cart_items_id=[];
  for (var i = 0; i < input.length; i++) {
    if (input[i].checked) {
      total += parseFloat(input[i].value);
      cart_items_id.push(input[i].id);
    }
  }
  document.getElementById("total_amount").value = total.toFixed(2);
  
}

let checkoutBtn = document.getElementById('checkout-btn')

checkoutBtn.addEventListener('click', function(e) {
    let amount = parseFloat(document.getElementById('total_amount').value);

    paypal.Buttons({
    createOrder: function(data,actions){
        return actions.order.create({
            intent: "CAPTURE",
            purchase_units: [{
                amount: { value: parseFloat(amount) }
            }]
        })
    },
    onApprove: function(data,actions){
        return actions.order.capture().then( function(orderData) {
            alert("Transaction completed thank you " + orderData.payer.name.given_name);

            var input = document.getElementsByName("item");
            var qty = document.getElementsByName("quantity");
            var cart_items_id=[];
            var qty_list = [];
            for (var i = 0; i < input.length; i++) {
                if (input[i].checked) {
                cart_items_id.push(input[i].id);
                qty_list.push(qty[i].value);
                }
            }
            console.log(qty_list);
            window.location.href = "../controllers/users/remove_Cart.php?id="+cart_items_id;
        })
    }
    }).render("#paypal-button-container");
})

</script>

<script>
    close = document.getElementById('close_payment');
    close.addEventListener('click',function(){
        location.reload();
    })
</script>