<?php
    $title = 'Login';
    require_once './includes/components/header.php';
?>

<body id="login">
    <section id="cover" class="d-flex v100h justify-content-center align-items-center">
        <div class="main-image d-flex flex-column justify-items-end justify-content-end">
            <div class="system-own d-flex align-items-end">
                <img src="/includes/assets/img/Coat_of_arms.png">
                <p class="paragraphsdescriptions">Federal Ministry of Finance, Budgeting and National Planning</p>
            </div>
            <h2>Infrastructure Selection & Prioritization System</h2>
        </div>
        <div id="mainContainer">
            <img id="animation-image" src="/includes/assets/img/account.png">
            <div id="main" class="form-content">
                <div class="title">
                    <h1 class="h1">Sign in</h1>
                    <p class="description paragraphsdescriptions">If you do not have sign in credentials, please contact an admin.</p>
                </div>
                <hr/>
                <form action="#" class="d-flex flex-column signin-form full-width">
                    <div class="form-group">
                        <div class="full-width">
                            <label class="form-label" for="name"><i class="las la-envelope"></i>EMAIL <span>(Required)</span></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="full-width">
                            <label class="form-label" for="password"><i class="las la-lock"></i>PASSWORD  <span>(Required)</span></label>
                            <input type="password" name="password" id="password" class="password form-control" placeholder="*****" required><span id="toggle-pass" class="las la-eye"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <span id="forgotPass"><a href="#">I don't remember my password</a></span>
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" id="btn-submit" class="btn submit full-width">Continue<i class="las la-arrow-right"></i></button>
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