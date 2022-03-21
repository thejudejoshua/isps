<?php
    require_once './includes/components/header.php';
?>

<body>
    <section id="cover" class="d-flex justify-content-center align-items-center">
        <div id="mainContainer">
            <img id="animation-image" src="/includes/assets/img/account.png">
            <div id="main" class="form-content">
                <div class="title">
                    <h3 class="h2">Sign in</h3>
                    <p class="description p5">If you do not have sign in credentials, please contact an admin.</p>
                </div>
                <form action="#" class="d-flex flex-column signin-form rem">
                    <div class="form-group">
                        <div class="rem">
                            <label class="form-label" for="name"><i class="las la-envelope"></i>EMAIL <span>(Required)</span></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com" required>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="rem">
                            <label class="form-label" for="password"><i class="las la-lock"></i>PASSWORD  <span>(Required)</span></label>
                            <input type="password" name="password" id="password" class="password form-control" placeholder="*****" required><span id="toggle-pass" class="las la-eye"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a id="forgotPass" href="#">I don't remember my password</a>
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" id="btn-submit" class="custom-btn btn submit">Continue</button>
                    </div>

                </form>
            </div>
            <!-- <div id="imgBox">
                <img src="/includes/assets/img/coat_of_arms.png"/>
            </div> -->
        </div>
    </section>
    <!-- <script src="js/bootstrap.js"></script> -->
</body>

<?php
    require_once './includes/components/footer.php';
?>