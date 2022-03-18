<?php
    require_once './includes/components/header.php';
?>

<body>
    <section id="cover" class="d-flex align-items-center">
        <div id="mainContainer" class="d-flex align-items-center">
            <div id="main" class="form-content">
                <h3 class="mb-1">Sign in to ISPS</h3>
                <p class="contact mb-5">If you do not have sign in credentials, please contact an admin</p>
                <form action="#" class="signin-form">
                    <div class="form-group mb-4">
                        <div class="rem">
                            <label class="form-label mb-2" for="name">EMAIL <span>(Required)</span></label>
                            <input type="email" name="email" class="custom-form" placeholder="example@gmail.com" required>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div class="rem">
                            <label class="form-label mb-2" for="password">PASSWORD  <span>(Required)</span></label>
                            <input type="password" name="password" class="custom-form" placeholder="*****" required>
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
            <div id="imgBox">
                <img src="/includes/assets/img/coat_of_arms.png"/>
            </div>
        </div>
    </section>
    <!-- <script src="js/bootstrap.js"></script> -->
</body>

<?php
    require_once './includes/components/footer.php';
?>