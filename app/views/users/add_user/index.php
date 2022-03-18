<?php
    require_once './includes/components/header.php';
?>

<div class="wrapper row m-0 justify-content-end">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box col-md-10">
        
        <section class="content mt-5">
            <a href="/users">back to all users</a>
            <h1 class="title">Create User</h1>
            <h4>Fill the form below to create a new user.</h4>
            <hr>
            <form id="newUserForm" class="row g-4 mt-4 justify-content-between">
                <div class="form-group dual mt-0 mb-4">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label">Enter first name <span>(Required)</span></label>
                        <input type="text" class="custom-form" name="firstName" id="firstName" placeholder="Enter first name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Enter last name <span>(Required)</span></label>
                        <input type="text" class="custom-form" name="lastName" id="lastName" placeholder="Enter last name" required>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="col-md-6">
                        <label for="phoneNumber" class="form-label">Enter phone number <span>(Required)</span></label>
                        <input type="tel" class="custom-form" name="phoneNumber" id="phoneNumber" placeholder="08120323923" required>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Enter an email address <span>(Required)</span></label>
                        <input type="email" class="custom-form" name="email" id="email" placeholder="example@email.com" required>
                    </div>
                </div>
                <!-- <div class="form-group mb-4">
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Pick a Gender <span>(Required)</span></label>
                        <select id="gender" name="gender" class="custom-form" required>
                            <option value="" disabled selected hidden>Choose...</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div> -->
                <div class="form-group mb-4">
                    <div class="col-md-6">
                        <label for="sector" class="form-label">Select a Sector <span>(Required)</span></label>
                        <select id="sector" name="sector" class="custom-form" required>
                            <option value="" disabled selected hidden>Choose...</option>
                            <option>Highway Construction</option>
                            <option>Railway Construction</option>
                            <option>Power Generation</option>
                            <option>Power Transmission</option>
                            <option>Water Supply</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="col-md-6">
                        <label for="designaton" class="form-label">Choose a designation <span>(Required)</span></label>
                        <select id="designaton" name="designaton" class="custom-form" required>
                            <option value="" disabled selected hidden>Choose...</option>
                            <option value="budgeting officer" data-rank="level 1">Budgeting Officer</option>
                            <option value="director" data-rank="Level 2">Director</option>
                            <option value="secretariat" data-rank="Level 3">Secretariat</option>
                        </select>
                        <input type="hidden" name="rank" id="rank" class="custom-form"/>
                    </div>
                </div>
                <div class="form-group dual mb-4">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Enter a password <span>(Required)</span></label>
                        <input type="password" class="custom-form" name="password" id="password" placeholder="*****" required>
                        <span class></span>
                    </div>
                    <div class="col-md-6">
                        <label for="confirmPassword" class="form-label">Enter password again for confirmation <span>(Required)</span></label>
                        <input type="password" class="custom-form" name="confirmPassword" id="confirmPassword" placeholder="*****" required>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <div class="col-12">
                        <button type="submit" id="btn-submit" class="btn custom-btn">Save User Data</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>