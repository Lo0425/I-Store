<?php
require_once '../connection.php';
require_once '../../views/layout2.php'; 
$itemName = $_POST['itemName'];
$quantity = $_POST['quantity'];
$category = $_POST['category'];
$description = $_POST['description'];
$price = $_POST['price'];
$short_description = explode(" ",$description);
$short_description_result = "";

if($category=="shirt"){
    $shirt_size = $_POST['shirt_size'];
}

$extensions = ['jpg','jpeg','svg','png','gif'];

$img_name = $_FILES['image']['name'];
$img_size = $_FILES['image']['size'];
$img_tmpname = $_FILES['image']['tmp_name'];

$img_type = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
$is_img = false;

$image_folder = '/public/'.time().'-'.$img_name;

if(in_array($img_type, $extensions)){
    $is_img = true;
}else{
    ?>
    <script>
        Swal.fire({ icon: 'error',
        title: 'Please upload an image',
        text: '',
        }).then(okay => {
        if (okay) {
            window.location.href = "/views/addItem.php";
        }
        });
    </script>
<?php 
}

if($itemName==""){
    ?>
    <script>
    Swal.fire({ icon: 'error',
    title: 'Please enter your product name',
    text: '',
    }).then(okay => {
    if (okay) {
        window.location.href = "/views/addItem.php";
    }
    });
</script>
<?php
}




if($is_img && $img_size > 0 && count($short_description)<=10){
    if($category=="shirt"){
        $query = "INSERT INTO inventoryforsale (itemName, Quantity, Category, description, image, price ,size) VALUES ('$itemName','$quantity','$category','$description','$image_folder','$price','$shirt_size');";
        mysqli_query($cn, $query);
        ?>
        <script>
            Swal.fire({ icon: 'success',
            title: 'Product added',
            text: '',
            }).then(okay => {
            if (okay) {
                window.location.href = "/views/shop.php";
            }
            });

        </script>
    <?php
    }else{
        $query = "INSERT INTO inventoryforsale (itemName, Quantity, Category, description, image, price) VALUES ('$itemName','$quantity','$category','$description','$image_folder', $price);";
        mysqli_query($cn, $query);

        ?>
        <script>
            Swal.fire({ icon: 'success',
            title: 'Product added',
            text: '',
            }).then(okay => {
            if (okay) {
                window.location.href = "/views/shop.php";
            }
            });

        </script>
        <?php
        
    }

} else if($is_img && $img_size > 0 && count($short_description)>10){
    for($i=0; $i<10; $i++){
        $short_description_result .= $short_description[$i]." ";
    }

    if($category == 'shirt'){
        $query = "INSERT INTO inventoryforsale (itemName, Quantity, Category, description, short_description, image, price ,size) VALUES ('$itemName','$quantity','$category','$description','$short_description_result','$image_folder','$price','$shirt_size');";  
        mysqli_query($cn, $query);
    ?>
        <script>
            Swal.fire({ icon: 'success',
            title: 'Product added',
            text: '',
            }).then(okay => {
            if (okay) {
                window.location.href = "/views/shop.php";
            }
            });

        </script>
<?php
    }else{
        $query = "INSERT INTO inventoryforsale (itemName, Quantity, Category, description, short_description, image, price) VALUES ('$itemName','$quantity','$category','$description','$short_description_result','$image_folder', $price);";
        mysqli_query($cn, $query);
        ?>
        <script>
            Swal.fire({ icon: 'success',
            title: 'Product added',
            text: '',
            }).then(okay => {
            if (okay) {
                window.location.href = "/views/shop.php";
            }
            });

        </script>
        <?php
    }
    
}

move_uploaded_file($img_tmpname, '../../public/'.time().'-'.$img_name);
mysqli_close($cn);


?>


