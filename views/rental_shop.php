<?php 
require_once '../views/layout.php';

$title = "Homepage";
function get_content(){
require_once '../controllers/connection.php';
?>

<?php 
$inventory_rent_query = "SELECT * FROM inventoryforrent;";
$inventory_rent_result = mysqli_query($cn, $inventory_rent_query);
$inventory_rent = mysqli_fetch_all($inventory_rent_result, MYSQLI_ASSOC);
?>

<?php
if(count($inventory_rent)>0):
?>
<main class="p-5 container">

    <div class="d-flex justify-content-center col-12">  
        <h1 class="mb-5 fw-bolder text-center pb-4 col-5" style="border-bottom: 4px solid red">RENTING AREA</h1>
    </div>

    <div class="row">
       
        <?php foreach ($inventory_rent as $rent): 

              

        $available_Date = date('Y-m-d', strtotime($rent['endDate']. ' +1 day'));
        $latest_Date = date('Y-m-d', strtotime($rent['endDate']. ' +7 day'));
        
        ?>

        <div class="col-xl-4 col-lg-4 mb-4" >
            <div class="card rounded-5 shadow-lg" style="min-height:300px;" data-id="<?php echo $rent['id'] ?>">
                <img src="<?php echo $rent['image'] ?>" class="card-img-top p-3" alt="..." id="img">
                <div class="card-body d-flex justify-content-between mx-3">
                    <h5 class="card-title col-8"><?php echo $rent['itemName'] ?></h5>
                    <p class="card-text col-4 text-end">RM <?php echo $rent['price'] ?> / day</p>
                </div>
 
                <div class="card-body mx-3">
                    <?php if($rent['short_description']!=""): ?>
                        <p class="card-text" id="short-desc<?php echo $rent['id'] ?>">
                            <?php echo $rent['short_description'] ?>... 
                            <button class="border-0 bg-transparent text-info" onclick="showMore(<?php echo $rent['id'] ?>)"><u>ReadMore</u></button>
                        </p>

                        <p class="card-text d-none" id="long-desc<?php echo $rent['id'] ?>">
                            <?php echo $rent['description']; ?>
                            <button class="border-0 bg-transparent text-info" onclick="showMore(<?php echo $rent['id'] ?>)"><u>Hide</u></button>
                        </p>
                        <?php else: ?>
                            <p class="card-text"><?php echo $rent['description'] ?></p>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['user_info']) && !$_SESSION['user_info']['isAdmin']): ?>
                            <div>
                                    
                                        <div class="input-group"> 

                                            <button type="button" class="btn btn-warning text-light col-12" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $rent['id'] ?>" data-bs-whatever="@mdo"><i class="fa-solid fa-cart-plus me-2"></i>Rent Now</button>

                                            <div class="modal fade" id="exampleModal<?php echo $rent['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Reservation Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form action="/controllers/users/addtocart_rent.php?productid=<?php echo $rent['id'] ?>" method="POST">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="mb-3 col-6 me-1">
                                                                    <label class="col-form-label">Start Date</label>
                                                                    <?php if($rent['startDate'] != "0000-00-00"): ?>
                                                                        <input type="date" class="form-control" name="date_to_rent" id="date_to_rent_<?php echo $rent['id'] ?>" min="<?php echo $available_Date ?>" max="<?php echo $latest_Date ?>" required>
                                                                    <?php else: ?>
                                                                        <input type="date" class="form-control" name="date_to_rent" id="date_to_rent_<?php echo $rent['id'] ?>" min="<?php echo date('Y-m-d') ?>" required>
                                                                    <?php endif; ?>
                                                                </div>

                                                                <div class="mb-3 col-6 me-1">
                                                                    <label class="col-form-label">End Date</label>
                                                                    <?php if($rent['endDate'] != "0000-00-00"): ?>
                                                                        <input type="date" class="form-control" name="date_to_return" id="date_to_return_<?php echo $rent['id'] ?>" min="<?php echo $available_Date ?>" required>
                                                                    <?php else: ?>
                                                                        <input type="date" class="form-control" name="date_to_return"
                                                                        id="date_to_return_<?php echo $rent['id'] ?>" min="<?php echo date('Y-m-d') ?>" required>
                                                                    <?php endif; ?>
                                                                </div>

                 
                                                            </div>
                                                       
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                <div class="my-auto">
                                                                    <button type="button" class="btn btn-success checkouts" data-bs-toggle="modal" data-bs-target="#paymentModal-<?php echo $rent['id'] ?>" id="checkout-btn" data-id="<?php echo $rent['id'] ?>">Checkout</button>
                                                                </div>

                                                            </div>
                                                            
                                                        </form>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal fade paypalModals" data-id="<?php echo $rent['id'] ?>" id="paymentModal-<?php echo $rent['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Make Payment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close_payment">
                                                    </button>
                                                </div>
                                                
                                                <div class="modal-body" id="test">
                                                    <?php echo $rent['itemName'] ?> 
                                                    <div id="paypal-button-container<?php echo $rent['id']?>"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               
                                </div>

                                <input type="hidden" value="<?php echo $rent['price'] ?>" id="price-<?php echo $rent['id']?>">
                        <?php elseif(isset($_SESSION['user_info']) && $_SESSION['user_info']['isAdmin']): ?>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-warning text-light me-1" data-bs-target="#editpost-<?php echo $rent['id'] ?>" data-bs-toggle="modal"><i class="fa-regular fa-pen-to-square"></i></button>
                                    <button class="btn btn-danger" data-bs-target="#deleteproduct-<?php echo $rent['id'] ?>" data-bs-toggle="modal"><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                        <?php endif; ?>

                        
                        <div class="modal" id="deleteproduct-<?php echo $rent['id'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure to delete this item?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-danger" href="/controllers/admin/delete_rent_product.php?id=<?php echo $rent['id']; ?>">Confirm</a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal" id="editpost-<?php echo $rent['id'] ?>">
                    <form action="/controllers/admin/editproduct_rent.php?id=<?php echo $rent['id']; ?>;" method="POST">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure to edit this item?</p>
                                        <div class="mb-3">
                                            <label for="itemName">ItemName</label>
                                            <input class="form-control" type="text" name="itemName" value="<?php echo $rent['itemName'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <input class="form-control" type="text" name="description" value="<?php echo $rent['description'] ?>">
                                        </div>
                                        <div class="mb-3 d-flex">
                                            <div class="mb-3 col-6 me-1">
                                                <label for="price">Price</label>
                                                <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $rent['price'] ?>">
                                            </div>
                                        </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success" type="submit">Edit</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                </div>

            </div>
        </div>

    <?php endforeach; ?>
    </div>
</main>

<?php endif; ?>

<?php } ?>
    <script>
        // alert('heyyy')
        // console.log(document.querySelectorAll('.checkouts'))
        // let rentId;
        let checkoutBtns = document.querySelectorAll('.checkouts')
        checkoutBtns.forEach(checkoutBtn => {
            checkoutBtn.addEventListener('click', function(e) {
                 let rentId = checkoutBtn.getAttribute('data-id')  
                  // let cards = document.querySelectorAll('.card')
                  // cards.forEach(card => {
                  //     rentId = card.getAttribute("data-id")
                  //     console.log(rentId)
                  // })

                  // let amount = parseFloat(document.getElementById('total_amount').value);
                  let startDate = document.getElementById(`date_to_rent_${rentId}`).value;
                  let endDate = document.getElementById(`date_to_return_${rentId}`).value;
                  let price = parseInt(document.getElementById(`price-${rentId}`).value);
          
                  var date1 = new Date(startDate);
                  var date2 = new Date(endDate);
          
                  var Difference_In_Time = date2.getTime() - date1.getTime();
                  
                  let Difference_In_Days = parseInt(Difference_In_Time / (1000 * 3600 * 24));
                  
                  // console.log(Difference_In_Days);
                  // console.log(price);
          
                  let amount = price * Difference_In_Days;
          
          
                  console.log(amount);
                  
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
                          
                          checkoutBtn.type = "submit";
                          checkoutBtn.click();
              
                        //   console.log(checkoutBtn.type)
                          // window.location.href = "../controllers/users/remove_Cart.php?id="+cart_items_id;
                          
                      })
                  }
                  }).render(`#paypal-button-container${rentId}`);

                  let modalFades = document.querySelectorAll('.paypalModals')
                  setTimeout(() => {

                      modalFades.forEach(modalFade => {
                          let rentId = modalFade.getAttribute("data-id")
                          if(modalFade.classList.contains('show')) {
                              document.body.addEventListener('click', function(e) {
                                  if(e.target.classList.contains('modal')) {
                                    window.location.reload()
                                  }
                              })
                          }
                      })
                  }, 500)
                  
              })
        })                    


    </script>


<script>
    close = document.getElementById('close_payment');
    close.addEventListener('click',function(){
        location.reload();
    })

    
</script>
