<?php
    $title = 'Add new User';
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <?php require_once './includes/components/topNav.php';?>
        <section class="content content-box-body">
            <a href="/users">back to all users</a>
            <hr>
            <div class="top-title d-flex justify-content-between full-width align-items-center">
                <div class="full-width">
                    <h2 class="title p3">Add new user</h2>
                    <p class="p5 subtitle">Fill the form below to create a new user.</p>
                </div>
            </div>
            <hr>
            <form id="newUserForm" class="d-flex flex-column">
                <div class="form-group dual">
                    <div class="">
                        <label for="firstName" class="form-label">Enter first name <span>(Required)</span></label>
                        <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter first name" required>
                    </div>
                    <div class="">
                        <label for="lastName" class="form-label">Enter last name <span>(Required)</span></label>
                        <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter last name" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="full-width">
                        <label for="phoneNumber" class="form-label">Enter phone number <span>(Required)</span></label>
                        <input type="tel" class="form-control" name="phoneNumber" id="phoneNumber" placeholder="08120323923" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="full-width">
                        <label for="email" class="form-label">Enter an email address <span>(Required)</span></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="example@email.com" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="full-width">
                        <label for="sector" class="form-label">Select a Sector <span>(Required)</span></label>
                        <?php
                            if($_SESSION['designation'] == "admin"){
                                echo'
                                <select id="sector" name="sector" class="form-control" required>
                                    <option value=" " disabled selected hidden>Choose a sector...</option>
                                    <option>Highway Construction</option>
                                    <option>Railway Construction</option>
                                    <option>Power Generation</option>
                                    <option>Power Transmission</option>
                                    <option>Water Supply</option>
                                </select>
                                ';
                            }else{
                                echo '
                                    <input type="sector" class="form-control" name="sector" id="sector" placeholder="Highway Constuction" value="'.$_SESSION['sector'].'" readonly>
                                ';
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="full-width">
                        <label for="designaton" class="form-label">Choose a designation <span>(Required)</span></label>
                        <select id="designaton" name="designaton" class="form-control" required>
                            <option value=" " disabled selected hidden>Choose a designation...</option>
                            <option value="budgeting officer">Budgeting Officer</option>
                            <?= $_SESSION['designation'] == 'secretariat' || $_SESSION['designation'] == 'admin' ? '<option value="director">Director</option><option value="secretariat">Secretariat</option>' : ''?>
                        </select>
                    </div>
                </div>
                <div class="form-group dual">
                    <div class="">
                        <label for="password" class="form-label"><i class="las la-lock"></i>Enter a password <span>(Required)</span></label>
                        <input type="password" class="password form-control" name="password" id="password" placeholder="*****" required>
                        <span id="toggle-pass" class="las la-eye"></span>
                    </div>
                    <div class="">
                        <label for="confirmPassword" class="form-label"><i class="las la-lock"></i>Enter password again for confirmation <span>(Required)</span></label>
                        <input type="password" class="password form-control" name="confirmPassword" id="confirmPassword" placeholder="*****" required>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <div class="col-12">
                        <button type="submit" id="btn-submit" class="btn">Save User Data</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>