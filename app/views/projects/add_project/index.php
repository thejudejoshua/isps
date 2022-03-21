<?php
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box col-md-10">
        
        <section class="content mt-5">
            <a href="/projects">back to all projects</a>
            <hr>
            <h1>Add new projects</h1>
            <p class="p5">Fill the form below to create a new project.</>
            <hr>
            <form id="newProjectForm" class="d-flex flex-column signin-form">
                <div class="form-group">
                    <div class="rem">
                        <label for="projectName" class="form-label">Project Name<span>(Required)</span></label>
                        <input type="text" class="form-control" name="projectName" id="projectName" placeholder="E.g. Construction of Ninth Mile" required>
                    </div>
                </div>
                <div class="col-12 m-0">
                    <label for="projectName" class="form-label">Project Name</label>
                    <input type="text" class="custom-form" name="projectName" id="projectName"
                        placeholder="Enter project name" required>
                </div>
                <div class="col-12">
                    <label for="projectDesc" class="form-label">Project Description</label>
                    <textarea class="custom-form" name="projectDescription" id="projectDesc" cols="30" rows="3"
                        placeholder="Enter project description" required></textarea>
                </div>
                <div class="col-4">
                    <label for="projectYear" class="form-label">Project Start Year</label>
                    <input type="number" class="custom-form" name="projectYear" id="projectYear" min="0"
                        placeholder="Enter start year" required>
                </div>
                <div class="col-4">
                    <label for="projectDur" class="form-label">Project Duration (In Years)</label>
                    <input type="number" class="custom-form" name="projectDuration" id="projectDur" min="0"
                        placeholder="Enter duration" required>
                </div>

                <div class="col-4">
                    <label for="projectCost" class="form-label">Project Cost (In Naira)</label>
                    <input type="number" class="custom-form" name="projectCost" id="projectCost" min="0"
                        placeholder="Enter cost" required>
                </div>

                <div class="col-md-4">
                    <label for="projectSector" class="form-label">Project Sector</label>
                    <select id="projectSector" name="projectSector" class="custom-form" required>
                        <option value="" disabled selected hidden>Choose...</option>
                        <option>Highway Construction</option>
                        <option>Railway Construction</option>
                        <option>Power Generation</option>
                        <option>Power Transmission</option>
                        <option>Water Supply</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="projectState" class="form-label">Project State</label>
                    <select name="projecState" id="projectState" class="custom-form" required>
                        <option value="" disabled selected hidden>Choose...</option>
                        <option>State</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="projectLga" class="form-label">Project LGA</label>
                    <select name="projectLGA" id="projectLga" class="custom-form" required>
                        <option value="" disabled selected hidden>Choose...</option>
                        <option>LGA</option>
                    </select>
                </div>

                <h3 class="form-sep">Project Origin Information</h3>

                <div class="col-md-6">
                    <label for="originState" class="form-label">Origin State</label>
                    <select name="originState" id="originState" class="custom-form">
                        <option selected>Choose...</option>
                        <option>State</option>
                    </select>
                </div>

                <div class="col-6">
                    <label for="originCity" class="form-label">Origin City</label>
                    <input type="text" class="custom-form" name="originCity" id="originCity"
                        placeholder="Enter Origin City">
                </div>
                <div class="col-6">
                    <label for="originLongitude" class="form-label">Origin Longitude</label>
                    <input type="text" class="custom-form" name="originLongitude" id="originLongitude"
                        placeholder="Enter Origin Longitude">
                </div>
                <div class="col-6">
                    <label for="originLatitude" class="form-label">Origin Latitude</label>
                    <input type="text" class="custom-form" name="originLatitude" id="originLatitude"
                        placeholder="Enter Origin Latitude">
                </div>

                <h3 class="form-sep">Project Midway Information (if any)</h3>

                <div class="col-12" id="mid-box">
                    <label for="midway" class="form-label">Number of midway points:</label>
                    <input type="number" class="custom-form" id="midway" min="0" max="3" placeholder="0">
                </div>

                <h3 class="form-sep">Project Destination Information</h3>

                <div class="col-md-6">
                    <label for="destState" class="form-label">Destination State</label>
                    <select name="destinationState" id="destState" class="custom-form">
                        <option selected>Choose...</option>
                        <option>State</option>
                    </select>
                </div>
                <div class="col-6">
                    <label for="destCity" class="form-label">Destination City</label>
                    <input type="text" class="custom-form" name="destinationCity" id="destCity"
                        placeholder="Enter Destination City">
                </div>
                <div class="col-6">
                    <label for="destLongitude" class="form-label">Destination Longitude</label>
                    <input type="text" class="custom-form" name="destinationLongitude" id="destLongitude"
                        placeholder="Enter Destination Longitude">
                </div>
                <div class="col-6">
                    <label for="destLatitude" class="form-label">Destination Latitude</label>
                    <input type="text" class="custom-form" name="destinationLatitude" id="destLatitude"
                        placeholder="Enter Destination Latitude">
                </div>

                <div class="col-12">
                    <!-- <button type="submit" id="proceedBtn" class="btn custom-btn">Next</button> -->
                    <a id="proceedBtn" href="highway-construction.html" class="btn custom-btn">Next</a>

                </div>
            </form>
            <form id="newUserForm" class="d-flex flex-column signin-form">
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
                    <div class="rem">
                        <label for="phoneNumber" class="form-label">Enter phone number <span>(Required)</span></label>
                        <input type="tel" class="form-control" name="phoneNumber" id="phoneNumber" placeholder="08120323923" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="rem">
                        <label for="email" class="form-label">Enter an email address <span>(Required)</span></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="example@email.com" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="rem">
                        <label for="sector" class="form-label">Select a Sector <span>(Required)</span></label>
                        <select id="sector" name="sector" class="form-control" required>
                            <option value="" disabled selected hidden>Choose...</option>
                            <option>Highway Construction</option>
                            <option>Railway Construction</option>
                            <option>Power Generation</option>
                            <option>Power Transmission</option>
                            <option>Water Supply</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="rem">
                        <label for="designaton" class="form-label">Choose a designation <span>(Required)</span></label>
                        <select id="designaton" name="designaton" class="form-control" required>
                            <option value="" disabled selected hidden>Choose...</option>
                            <option value="budgeting officer" data-rank="level 1">Budgeting Officer</option>
                            <option value="director" data-rank="Level 2">Director</option>
                            <option value="secretariat" data-rank="Level 3">Secretariat</option>
                        </select>
                        <input type="hidden" name="rank" id="rank" class="form-control"/>
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