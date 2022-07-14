<?php
require_once '../connection.php';
require_once '../../views/layout2.php';

session_start();
$productId = $_GET['productid'];
$qty = $_POST['qty'];
$qty = intval($qty);
// $pid = $_POST['productId'];
$id = $_SESSION['user_info']['id'];


// inventoryforsale.id AS p_id, inventoryforsale.itemName, inventoryforsale.price, inventoryforsale.size,


$query = "SELECT cart.id, cart.user_id, cart_items.cart_id, cart_items.product_id, cart_items.quantity,inventoryforsale.Quantity, inventoryforsale.id AS p_id, inventoryforsale.itemName, inventoryforsale.price, inventoryforsale.size  FROM cart LEFT JOIN cart_items ON cart.id = cart_items.cart_id LEFT JOIN inventoryforsale ON inventoryforsale.id = cart_items.product_id WHERE cart.user_id=$id";

$result = mysqli_query($cn, $query);
$carts = mysqli_fetch_all($result,MYSQLI_ASSOC);
$read_cart = "SELECT * FROM cart WHERE user_id = $id;";
$read_cart_result = mysqli_query($cn, $read_cart);
$read_carts = mysqli_fetch_assoc($read_cart_result); 

$query_forsale = "SELECT * FROM inventoryforsale WHERE id = $productId";
$result_forsale = mysqli_query($cn, $query_forsale);
$forsale = mysqli_fetch_assoc($result_forsale);



// if(count($read_carts)>0){
//     echo count($read_carts);
// }else{
//     echo "No";
// }
$ori_qty = intval($forsale['Quantity']);
if($qty > $ori_qty){
    ?>
    <script>
    Swal.fire({ icon: 'error',
              title: 'Insufficient of product',
              text: 'The quantity stock we have for <?php echo $forsale['itemName'] ?> is <?php echo $forsale['Quantity'] ?>',
              }).then(okay => {
              if (okay) {
                  window.location.href = "/views/shop.php";
              }
              });
    
    </script>
    <?php

}else if($qty <= 0) {
    ?>
    <script>
    Swal.fire({ icon: 'error',
              title: 'Purchase item quantity must atleast 1',
              text: '',
              }).then(okay => {
              if (okay) {
                  window.location.href = "/views/shop.php";
              }
              });
    
    </script>
    <?php
}else{
    if(isset($read_carts)){
        $cart_id = $carts[0]['id'];
        $query_items = "SELECT * FROM cart_items WHERE product_id = $productId AND cart_id = $cart_id;";
        $result_items = mysqli_query($cn, $query_items);
        $items = mysqli_fetch_assoc($result_items);
        // var_dump($items);
        // // die();
        if(isset($items)){
            $product_id = $carts[0]['id'];
            $qty = $qty + intval($items['quantity']);
            $query_cart_items = "UPDATE cart_items SET quantity = $qty WHERE product_id = $productId;";
            mysqli_query($cn,$query_cart_items);
        }else{
            $cart_id = $carts[0]['id'];
    
            $query_cart_items = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES ($cart_id, $productId, $qty);";
            mysqli_query($cn,$query_cart_items);
        }
    }else{
        $query_cart = "INSERT INTO cart (user_id) VALUES ($id);";
        mysqli_query($cn,$query_cart);
        $last_id = mysqli_insert_id($cn);
        
        $query_cart_items = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES ($last_id, $productId, $qty);";
        mysqli_query($cn,$query_cart_items);

    }
        ?>
        <script>
            Swal.fire({ icon: 'success',
            title: 'Added to cart',
            text: '',
            }).then(okay => {
            if (okay) {
                window.location.href = "/views/shop.php";
            }
            });

        </script>


        <?php
}




mysqli_close($cn);
// ?>
