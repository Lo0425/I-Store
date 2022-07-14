<?php
require_once '../connection.php';
require_once '../../views/layout2.php';

session_start();
$id = $_GET['id'];
$qty_list = [];
$product_id_list=[];
$ori_qty_list = [];
$remainder_list = [];
$final_product_id =[];
$final_ori_qty = [];
$final_qty_list = [];
$user_id = $_SESSION['user_info']['id'];


$str_id = preg_split ("/\,/", $id); 


for($i=0;$i<count($str_id);$i++){
    $qty_query = "SELECT quantity FROM cart_items WHERE id=$str_id[$i];";
    $qty_result = mysqli_query($cn,$qty_query);
    $qty = mysqli_fetch_assoc($qty_result);
    array_push($qty_list, $qty);

    $product_id_query = "SELECT product_id FROM cart_items WHERE id=$str_id[$i];";
    $product_id_result = mysqli_query($cn,$product_id_query);
    $product_id = mysqli_fetch_assoc($product_id_result);
    array_push($product_id_list,  $product_id);
}

for($i=0;$i<count($product_id_list); $i++){
    array_push($final_product_id,intval($product_id_list[$i]['product_id']));
}

// var_dump($final_product_id);


for($i=0;$i<count($final_product_id);$i++){
    $ori_qty_query = "SELECT Quantity FROM inventoryforsale WHERE id= $final_product_id[$i];";
    $ori_qty_result = mysqli_query($cn, $ori_qty_query);
    $ori_qty = mysqli_fetch_all($ori_qty_result, MYSQLI_ASSOC);
    array_push($ori_qty_list, $ori_qty);
}
// var_dump(intval($ori_qty_list[0][0]['Quantity']));
// var_dump(intval($ori_qty_list[1][0]['Quantity']));

for($i=0; $i<count($ori_qty_list); $i++){
    array_push($final_ori_qty,intval($ori_qty_list[$i][0]['Quantity']));
}

// var_dump($final_ori_qty);

// var_dump(intval($qty_list[0]['quantity']));
for($i=0; $i<count($qty_list); $i++){
    array_push($final_qty_list,intval($qty_list[$i]['quantity']));
}

// var_dump($final_qty_list);



for($i=0;$i<count($str_id);$i++){
    $remainder = $final_ori_qty[$i] - $final_qty_list[$i];
    array_push($remainder_list, $remainder);
}

// // var_dump($remainder_list[0]);
// // var_dump($final_product_id);
// var_dump($qty_list);

for($i=0;$i<count($str_id);$i++){
    
    $query = "DELETE FROM cart_items WHERE id=$str_id[$i];";
    mysqli_query($cn,$query);
    $query_substract =  "UPDATE inventoryforsale SET Quantity = $remainder_list[$i] WHERE id = $final_product_id[$i];";
    mysqli_query($cn,$query_substract);
}
    


$query_cart_id = "SELECT id FROM cart WHERE user_id = $user_id;";
$cart_id_result = mysqli_query($cn, $query_cart_id);
$cart_id = mysqli_fetch_assoc($cart_id_result);
$cart_id = $cart_id['id'];

$query_read = "SELECT * FROM cart_items WHERE cart_id = $cart_id;";
$read_result = mysqli_query($cn,$query_read);
$read = mysqli_fetch_all($read_result, MYSQLI_ASSOC);

if(count($read)==0){
    $delete_query = "DELETE FROM cart WHERE user_id=$user_id;";
    mysqli_query($cn,$delete_query);
}

$query_read_order = "SELECT * FROM orders WHERE user_id = $user_id;";
$result_read_order = mysqli_query($cn, $query_read_order);
$read_order = mysqli_fetch_assoc($result_read_order);
$order_id;


    if(isset($read_order)) {
        $order_id = $read_order['id']; 
        for($i=0;$i<count($str_id);$i++){
            $query_orders_items = "INSERT INTO order_detail (order_id, product_id, quantity, status) VALUES ($order_id, $final_product_id[$i], $final_qty_list[$i],'Pending');";
            mysqli_query($cn,$query_orders_items);
        }
    } else {
        $query_order = "INSERT INTO orders (user_id) VALUES ($user_id);";
        mysqli_query($cn,$query_order);
        $last_id = mysqli_insert_id($cn);
        
        for($i=0;$i<count($str_id);$i++){
        $query_orders_items = "INSERT INTO order_detail (order_id, product_id, quantity, status) VALUES ($last_id, $final_product_id[$i], $final_qty_list[$i], 'Pending');";
        mysqli_query($cn,$query_orders_items);
    }
}

mysqli_close($cn);
?>
<script>
Swal.fire({ icon: 'success',
    title: 'Payment Success',
    text: '',
    }).then(okay => {
    if (okay) {
        window.location.href = "/views/cart.php";
    }
    });

</script>
