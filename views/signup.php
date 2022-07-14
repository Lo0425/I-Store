<?php 
$title = "Register";
function get_content(){
?>

<div class="container" id="register">
    <div id="parcel_gif" class="text-center my-auto col-lg-5 col-12 p-5">
        <img class="img-fluid" id="rotate" src="/images/logoIcon.png">
    </div>

    <div class="container bg-body py-5 rounded-5 mx-auto shadow col-12 col-lg-7">
        <div class="col-md-8 mx-auto">
            <h1 class="pb-3">Register</h1>
            <form method="POST" action="/controllers/users/signup.php" class="mt-3 mx-auto">
                <div class="mb-3">
                    <input type="text" name="username" placeholder="Username" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="address" placeholder="House Address" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <input type="tel" name="phoneNumber" placeholder="Phone Number | Example: xxx-xxxxxxx" class="form-control form-control-lg" pattern="[0-9]{3}-[0-9]{7}" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password"  placeholder="Password" class="form-control form-control-lg" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password2" placeholder="Confirm Password" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3" id="btn">
                    <a href="../index.php" class="mt-1 text-decoration-none" id="btn1">I have an account</a>
                    <button class="btn btn-primary col-12 col-lg-4">Register</button>
                    <a href="../index.php" class="text-end text-decoration-none mt-2" id="btn2">I have an account</a>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
}
require_once 'layout.php';
?>