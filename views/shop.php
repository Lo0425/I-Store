<?php 
require_once './layout.php';

$title = "Homepage";
function get_content(){
require_once '../controllers/connection.php';
$inventory_sale_query = "SELECT * FROM inventoryforsale;";
$inventory_sale_result = mysqli_query($cn, $inventory_sale_query);
$inventory_sale = mysqli_fetch_all($inventory_sale_result, MYSQLI_ASSOC);
?>

<main class="p-5 container">
    <div class="d-flex justify-content-center col-12">
        <h1 class="mb-5 fw-bolder text-center pb-4 col-5" style="border-bottom: 4px solid red">SHOPPING AREA</h1>
    </div>

    <div class="row">

    <?php foreach ($inventory_sale as $sale): ?>
        <?php if($sale['Category']=='shirt'){?>

            <div class="col-xl-4 col-lg-4 mb-4" >
            <div class="card rounded-5 shadow-lg" style="min-height:450px;">
                <img src="<?php echo $sale['image'] ?>" class="card-img-top p-3" alt="..." id="img">
                <div class="card-body d-flex justify-content-between mx-3">
                    <h5 class="card-title col-8"><?php echo $sale['itemName'] ?></h5>
                    <p class="card-text col-4 text-end">RM <?php echo $sale['price'] ?></p>
                </div>
                <div class="card-body mx-3 d-flex justify-content-between"> 
                    <p class="card-text col-3">Size: <?php echo $sale['size'] ?></p>
                    <p>Qty: <?php echo $sale['Quantity'] ?></p>
        
                </div>
                <div class="card-body mx-3">
                    <?php if($sale['short_description']!=""): ?>
                        <p class="card-text" id="short-desc<?php echo $sale['id'] ?>">
                            <?php echo $sale['short_description'] ?>... 
                            <button class="border-0 bg-transparent text-info" onclick="showMore(<?php echo $sale['id'] ?>)"><u>ReadMore</u></button>
                        </p>

                        <p class="card-text d-none" id="long-desc<?php echo $sale['id'] ?>">
                            <?php echo $sale['description']; ?>
                            <button class="border-0 bg-transparent text-info" onclick="showMore(<?php echo $sale['id'] ?>)"><u>Hide</u></button>
                        </p>
                        <?php else: ?>
                            <p class="card-text"><?php echo $sale['description'] ?></p>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['user_info']) && !$_SESSION['user_info']['isAdmin']): ?>
                                <div>
                                    <form action="/controllers/users/addtocart.php?productid=<?php echo $sale['id'] ?>" method="POST">
                                        <div class="input-group"> 
                                            <input type="number" name="qty" placeholder="Qty" min="1" max="<?php echo $sale['Quantity'] ?>" class="form-control" required="required">
                                          
                                            <button class="btn btn-success text-light me-1">
                                                <i class="fa-solid fa-cart-plus me-2"></i>Add to Cart
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <?php elseif(isset($_SESSION['user_info']) && $_SESSION['user_info']['isAdmin']): ?>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-warning text-light me-1" data-bs-target="#editproduct-<?php echo $sale['id'] ?>" data-bs-toggle="modal"><i class="fa-regular fa-pen-to-square"></i></button>
                                    <button class="btn btn-danger" data-bs-target="#deleteproduct-<?php echo $sale['id'] ?>" data-bs-toggle="modal"><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                        <?php endif; ?>

                        <div class="modal" id="deleteproduct-<?php echo $sale['id'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure to delete this post?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-danger" href="/controllers/admin/delete_product.php?id=<?php echo $sale['id']; ?>">Confirm</a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal" id="editproduct-<?php echo $sale['id'] ?>">
                            <form action="/controllers/admin/editproduct.php?id=<?php echo $sale['id']; ?>;" method="POST">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure to edit this post?</p>
                                                <div class="mb-3">
                                                    <label for="itemName">ItemName</label>
                                                    <input class="form-control" type="text" name="itemName" value="<?php echo $sale['itemName'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description">Description</label>
                                                    <input class="form-control" type="text" name="description" value="<?php echo $sale['description'] ?>">
                                                </div>
                                                <div class="mb-3 d-flex justify-content-between">
                                                    <div class="mb-3 col-4 me-1">
                                                        <label for="price">Price</label>
                                                        <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $sale['price'] ?>">
                                                    </div>
                                                    <div class="mb-3 col-3 me-1">
                                                        <label for="size">Size</label>
                                                        <select class="form-select" aria-label="Default select example" name="shirt_size" id="shirt_size">
                                                            <option selected value="<?php echo $sale['size'] ?>"><?php echo $sale['size'] ?></option>
                                                            <option value="XS">XS</option>
                                                            <option value="S">S</option>
                                                            <option value="M">M</option>
                                                            <option value="L">L</option>
                                                            <option value="XL">XL</option>
                                                            <option value="XXL">XXL</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-4">
                                                        <label for="qty">Quantity</label>
                                                        <input type="number" class="form-control" name="qty" required="required" value="<?php echo $sale['Quantity'] ?>">
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


        <?php }else{ ?>

            <!-- Not Shirt -->

        <div class="col-xl-4 col-lg-4 mb-4" >
            <div class="card rounded-5 shadow-lg" style="min-height:450px;">
                <img src="<?php echo $sale['image'] ?>" class="card-img-top p-3" alt="..." id="img">
                <div class="card-body d-flex justify-content-between mx-3">
                    <h5 class="card-title col-8"><?php echo $sale['itemName'] ?></h5>
                    <p class="card-text col-4 text-end">RM <?php echo $sale['price'] ?></p>
                </div>
                <div class="d-flex justify-content-between card-body">
                    <div>

                    </div>
                    <div class="col-3 mx-3 text-end card-text">
                        <p>Qty: <?php echo $sale['Quantity'] ?></p>
                    </div>
                </div>
                <div class="card-body mx-3">
                    <?php if($sale['short_description']!=""): ?>
                        <p class="card-text" id="short-desc<?php echo $sale['id'] ?>">
                            <?php echo $sale['short_description'] ?>... 
                            <button class="border-0 bg-transparent text-info" onclick="showMore(<?php echo $sale['id'] ?>)"><u>ReadMore</u></button>
                        </p>

                        <p class="card-text d-none" id="long-desc<?php echo $sale['id'] ?>">
                            <?php echo $sale['description']; ?>
                            <button class="border-0 bg-transparent text-info" onclick="showMore(<?php echo $sale['id'] ?>)"><u>Hide</u></button>
                        </p>
                        <?php else: ?>
                            <p class="card-text"><?php echo $sale['description'] ?></p>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['user_info']) && !$_SESSION['user_info']['isAdmin']): ?>
                            <div>
                                    <form action="/controllers/users/addtocart.php?productid=<?php echo $sale['id'] ?>" method="POST">
                                        <div class="input-group"> 
                                            <input type="number" name="qty" placeholder="Qty" min="1" max="<?php echo $sale['Quantity'] ?>" required="required" class="form-control">
                                            <button class="btn btn-success text-light me-1">
                                                <i class="fa-solid fa-cart-plus me-2"></i>Add to Cart
                                            </button>
                                        </div>
                                    </form>

                                </div>
                        <?php elseif(isset($_SESSION['user_info']) && $_SESSION['user_info']['isAdmin']): ?>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-warning text-light me-1" data-bs-target="#editpost-<?php echo $sale['id'] ?>" data-bs-toggle="modal"><i class="fa-regular fa-pen-to-square"></i></button>
                                    <button class="btn btn-danger" data-bs-target="#deleteproduct-<?php echo $sale['id'] ?>" data-bs-toggle="modal"><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                        <?php endif; ?>

                        
                        <div class="modal" id="deleteproduct-<?php echo $sale['id'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure to delete this post?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-danger" href="/controllers/admin/delete_product.php?id=<?php echo $sale['id']; ?>">Confirm</a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal" id="editpost-<?php echo $sale['id'] ?>">
                    <form action="/controllers/admin/editproduct.php?id=<?php echo $sale['id']; ?>;" method="POST">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure to edit this post?</p>
                                        <div class="mb-3">
                                            <label for="itemName">ItemName</label>
                                            <input class="form-control" type="text" name="itemName" value="<?php echo $sale['itemName'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <input class="form-control" type="text" name="description" value="<?php echo $sale['description'] ?>">
                                        </div>
                                        <div class="mb-3 d-flex">
                                            <div class="mb-3 col-6 me-1">
                                                <label for="price">Price</label>
                                                <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $sale['price'] ?>">
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label for="qty">Quantity</label>
                                                <input type="number" class="form-control" name="qty" value="<?php echo $sale['Quantity'] ?>">
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

    <?php }endforeach; ?>
    </div>
</main>


<?php } ?>

<script>

    function showMore(id){
        var x = document.getElementById(`long-desc${id}`);
        var y = document.getElementById(`short-desc${id}`);
        if (x.className == "card-text"){
            x.className = "card-text d-none";
            y.className = "card-text";
        }else{
            x.className = "card-text";
            y.className = "card-text d-none";
        }
    }

</script>