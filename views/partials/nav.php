<nav class="navbar navbar-expand-lg bg-light shadow-sm sticky-top">
  <div class="container d-flex justify-content-between">
    <div class="col-xl-3 col-lg-3 col-sm-12 col-12 d-flex justify-content-between">
      <div class="col-xl-12 col-lg-12 col-sm-3 col-6">
        <a class="navbar-brand" href="/views/shop.php"><img id="icon" src="../../images/lolgo.png"></a>
        </div>
        <div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        </div>
    </div>

    <div class="collapse navbar-collapse ms-4 " id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2">
        

          <li class="nav-item mt-1">
            <a id="nav" <?php if($_SERVER['SCRIPT_NAME']=="/views/shop.php") { ?>  class="nav-link active" style="text-decoration:underline 3px red; text-underline-width:2px; text-underline-offset:4px;" <?php   }  ?> class="nav-link" href="/views/shop.php">Shop</a>
          </li>
          <li class="nav-item mt-1">
            <a id="nav" <?php if($_SERVER['SCRIPT_NAME']=="/views/rental_shop.php") { ?>  class="nav-link active" style="text-decoration:underline 3px red; text-underline-width:2px; text-underline-offset:4px;" <?php   }  ?> class="nav-link" href="/views/rental_shop.php">Rental Shop</a>
          </li>
          <?php 
            if(isset($_SESSION['user_info']) && $_SESSION['user_info']['isAdmin']==True):
        ?>

          <li class="nav-item mt-1">
          <a id="nav" <?php if($_SERVER['SCRIPT_NAME']=="/views/addItem.php") { ?>  class="nav-link active" style="text-decoration:underline 3px red; text-underline-width:2px; text-underline-offset:4px;" <?php   }  ?> class="nav-link" href="/views/addItem.php">Add New Item</a>
          </li>
        <?php
            endif;
        ?>

        <?php
            if(isset($_SESSION['user_info'])):
        ?>

        <?php if( $_SESSION['user_info']['isAdmin']=="0"): ?>
            
          <li class="nav-item mt-1">
            <a id="nav" <?php if($_SERVER['SCRIPT_NAME']=="/views/cart.php") { ?>  class="nav-link active" style="text-decoration:underline 3px red; text-underline-width:2px; text-underline-offset:4px;" <?php   }  ?> class="nav-link" href="/views/cart.php">Cart <span class="badge bg-warning"><?php ?></span></a>
          </li>
        <?php endif; ?>

        <li class="nav-item dropdown mt-1">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['user_info']['username']?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php if($_SESSION['user_info']['isAdmin']=="0"):?>
              <li><a class="dropdown-item" href="/views/purchase_history.php">Purchased History</a></li>
              <li><a class="dropdown-item" href="/views/rent_status.php">Rent Status</a></li>
            <?php else: ?>
              <li><a class="dropdown-item" href="/views/purchase_order.php">Purchase Order</a></li>
              <li><a class="dropdown-item" href="/views/rental_request.php">Rental Request</a></li>
            <?php endif; ?>
            <li><hr class="dropdown-divider"></li>
            <a class="dropdown-item" href="/controllers/users/logout.php">Logout</a>
          </ul>
        </li>

            
        <?php
            else:
        ?>
            <li class="nav-item mt-1" >
              <a id="nav" <?php if($_SERVER['SCRIPT_NAME']=="/index.php") { ?>  class="nav-link active " style="text-decoration:underline 3px red; text-underline-width:2px; text-underline-offset:4px;" <?php   }  ?> class="nav-link" aria-current="page" href="/">LOGIN</a>
            </li>
            <li class="nav-item mt-1">
                <a id="nav" <?php if($_SERVER['SCRIPT_NAME']=="/views/signup.php") { ?>  class="nav-link active" style="text-decoration:underline 3px red; text-underline-width:2px; text-underline-offset:4px;" <?php   }  ?> class="nav-link" href="/views/signup.php">Register</a>
            </li>
        <?php
            endif;
        ?>
      </ul>
          <!-- <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12" id="search_bar">
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn " type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
          </div> -->
      </div>

  </div>
</nav>

