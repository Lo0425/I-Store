<?php 
$title = "AddItem";
function get_content(){
require_once '../controllers/connection.php';

?>


<main class="py-5">
<div class="container bg-body py-5 rounded-5 mx-auto text-center shadow col-lg-6 col-xl-6 col-sm-8 col-10 m-5">
    <h3>Add Item</h3>
        

        <div class="col-12">
            <div class="col-4 mx-auto">
                <select class="form-select mb-4" aria-label="Default select example" id="category_select">
                    <option selected disabled>Category</option>
                    <option value="sale">For Sale</option>
                    <option value="rent">For Rent</option>
                </select>
            </div>

            <div id="sale" class="hidden-form my-3">
                <h5 class="mb-3">Insert the product information</h5>

                <form action="../controllers/admin/addSaleItem.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 d-flex mx-auto col-10">
                        <div class="col-9 me-1">
                            <input type="text mb-3" class="form-control" placeholder="Item Name" name="itemName" required="required">
                        </div>
                        <div class="col-3">
                            <input type="number" class="form-control" placeholder="Quantity" name="quantity" required="required">
                        </div>
                    </div>

                    <div class="col-10 mb-3 mx-auto d-flex">
                        <div class="col-8 me-1">
                            <select class="form-select" aria-label="Default select example" name="category" id="product_category" required>
                                <option selected disabled value="">Category</option>
                                <option value="tools">Tools</option>
                                <option value="laptop">Laptop</option>
                                <option value="component">Component</option>
                                <option value="shirt">Shirt</option>
                                <option value="bundle">Bundle</option>

                            </select>
                        </div>
                        <div class="col-4">
                            <input type="number" step="0.01"  class="form-control" placeholder="RM" name="price" required="required">
                        </div>
                    </div>

                    <div class="col-10 mb-3 mx-auto d-flex">
                        <div class="col-12">
                            <select class="form-select" aria-label="Default select example" name="shirt_size" id="shirt_size" required>
                                <option selected disabled value="">Size</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>   
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-10 mb-3 mx-auto">
                        <input type="file" class="form-control" name="image" required="required">
                    </div>

                    <div class="mb-3 d-flex mx-auto col-10">
                        <div class="col-12 me-1">
                            <input type="text mb-3" class="form-control form-control-sm" placeholder="Product Description" name="description" required="required">
                        </div>
                    </div>

                    <div class="col-4 mx-auto">
                        <button class="btn btn-success form-control" name="submit">Submit</button>
                    </div>
                </form>
            </div>

            <div id="rent" class="hidden-form my-3">
                <h5 class="mb-3">Insert the product information</h5>

                <form action="../controllers/admin/addRentItem.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 d-flex mx-auto col-10">
                        <div class="col-12 me-1">
                            <input type="text mb-3" class="form-control" placeholder="Item Name" name="itemName" required="required">
                        </div>
                    </div>

                    <div class="col-10 mb-3 mx-auto d-flex">
                        <div class="col-8 me-1">
                            <select class="form-select" aria-label="Default select example" name="category" id="product_category" required>
                                <option selected disabled value="">Category</option>
                                <option value="tools">Tools</option>
                                <option value="laptop">Laptop</option>
                                <option value="component">Component</option>
                                <option value="space">Working Space</option>

                            </select>
                        </div>
                        <div class="col-4">
                            <input type="number" step="0.01"  class="form-control" placeholder="RM" name="price" required="required">
                        </div>
                    </div>


                    <div class="col-10 mb-3 mx-auto">
                        <input type="file" class="form-control" name="image" required="required" multiple>

                    </div>

                    <div class="mb-3 d-flex mx-auto col-10">
                        <div class="col-12 me-1">
                            <input type="text mb-3" class="form-control form-control-sm" placeholder="Product Description" name="description" required="required">
                        </div>
                    </div>

                    <div class="col-4 mx-auto">
                        <button class="btn btn-success form-control" name="submit">Submit</button>
                    </div>
                </form>
            </div>



            <div id="inventory" class="hidden-form">
                <h2>Inventory</h2>
            </div>
            
 
        </div>



</div>
</main>

<?php
}
require_once 'layout.php';
?>

<script>
    let sale = document.getElementById('sale')
    let rent = document.getElementById('rent')
    let inventory = document.getElementById('inventory')
    let category = document.getElementById('category_select')

    sale.style.display = 'none'
    rent.style.display = 'none'
    inventory.style.display = 'none'
    

    category.addEventListener('change', function(e) {
         let forms = document.querySelectorAll('.hidden-form')
         forms.forEach(form => {
             if(e.target.value == 'sale') {
                 sale.style.display = 'block';
                 rent.style.display = 'none';
                 inventory.style.display = 'none';             }
             if(e.target.value == 'rent') {
                sale.style.display = 'none';
                rent.style.display = 'block';
                inventory.style.display = 'none';
             } 
             if (e.target.value == 'inventory'){
                sale.style.display = 'none';
                rent.style.display = 'none';
                inventory.style.display = 'block'; 
             }
         })
    })


    let product_category = document.getElementById('product_category');
    let shirt_size = document.getElementById('shirt_size');

    shirt_size.style.display="none";
    shirt_size.disabled= true;

    product_category.addEventListener('change',function(e){
        if(product_category.value=="shirt"){
            
            shirt_size.style.display="block";
            shirt_size.disabled= false;

        }else{
            shirt_size.style.display = 'none';
            shirt_size.disabled= true;

        }
    })
</script>
            