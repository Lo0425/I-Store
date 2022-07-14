<?php 
$title = "Login";
function get_content(){
?>

<div class="container" id="register">

    <div class="text-center my-auto col-5 mx-auto p-5" id="parcel_gif">
        <img class="img-fluid" id="rotate" src="/images/logoIcon.png">

    </div>

    <div class="container bg-body py-5 rounded-5 mx-auto shadow col-12 col-lg-7 col-xl-6">
        <div class="col-md-6 mx-auto">
            <h1 class="pb-3 text-center fw-bolder ">Login</h1>
            <div class="d-flex justify-content-center">
                <h6 class="pe-1 my-auto">New to I-STORE?</h6>
                <a class="ps-1 my-auto text-decoration-none" href="/views/signup.php">Register an account</a>
            </div>
            <form method="POST" action="./controllers/users/login.php" class="mt-3 mx-auto">
                <div class="mb-3">
                    <input type="text" name="username" placeholder="Username" class="form-control form-control-lg">
                </div>
                <div class="mb-4 d-flex" id="pass">
                        <input type="password" name="password" placeholder="Password" id="password" class="form-control form-control-lg input-field">
                        <div class="my-auto" id="passcheck">
                            <input type="checkbox" id="btn-check" onclick="showPass()" class="btn-check">
                            <label for="btn-check" class="fa-solid fa-eye" onclick="reviewPass()"  id="reviewPass"></label>
                        </div>
                </div>
                <div class="mb-3" id="btn">
                    <button class="btn btn-primary col-12 fw-bolder">LOG IN</button>
                </div>
            </form>
        </div>
    </div>

</div>



<?php
}
require_once './views/layout.php';
?>

<script>
    document.getElementById("password")

</script>

<script>
    function showPass(){
        var x = document.getElementById("password");
        if(x.type === "password"){
            x.type = "text";
        }else{
            x.type = "password" ;
        }
    }

    function reviewPass(){
        var x = document.getElementById("reviewPass");
        console.log(x.className);
        if(x.className === "fa-solid fa-eye"){
            x.className = "fa-solid fa-eye-slash";
        }else{
            x.className = "fa-solid fa-eye";
        }
    }
</script>