<?php
    $title = 'Compare Projects';
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <?php require_once './includes/components/topNav.php';?>
        <section class="content">
            <div class="top-title d-flex justify-content-between full-width align-items-center">
                <div class="">
                    <h2 class="title p3">Compare Projects</h2>
                    <p class="p5 subtitle">Select active projects within your sector to compare them.</p>
                </div>
            </div>
            <hr>
            <div class="compare-selects d-flex justify-content-between">
                <div class="form-group">
                    <div class="full-width">        
                        <label class="form-label" for="project-1">Project 1</label>
                        <select class="form-control compare-select" id="project-1">
                            <option default selected hidden>Select a project...</option>
                            <?php
                                foreach ($data['projectsList'] as $key => $projectList) {
                                    echo '<option id="'.str_replace(' ', '_', $projectList['name']).'" value="'.$projectList['name'].'" data-id="'.$projectList['id'].'">'.$projectList['name'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="full-width">
                        <label class="form-label" for="project-2">Project 2</label>
                        <select class="form-control compare-select" id="project-2">
                            <option default selected hidden>Choose from project 1...</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="full-width">              
                        <label class="form-label" for="project-3">Project 3</label>
                        <select class="form-control compare-select" id="project-3">
                            <option default selected hidden>Choose from project 2...</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="full-width">        
                        <label class="form-label" for="project-4">Project 4</label>
                        <select class="form-control compare-select" id="project-4">
                            <option default selected hidden>Choose from project 3...</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="compare-bottom d-flex flex-column hidden">
                <div class="compare-class">
                    <h5 id="score" class="text-align-center">SCORE</h5>
                    <div class="compare-class-section d-flex justify-content-between">
                        <div class="class1 full-width text-align-center">
                            <p class="val" id="score-1"></p>
                        </div>
                        <div class="class2 full-width text-align-center">
                            <p class="val" id="score-2"></p>
                        </div>
                        <div class="class3 full-width text-align-center">
                            <p class="val" id="score-3"></p>
                        </div>
                        <div class="class4 full-width text-align-center">
                            <p class="val" id="score-4"></p>
                        </div>
                    </div>
                </div>
                <div class="compare-class">
                    <h5 id="score" class="text-align-center">RANKING</h5>
                    <div class="compare-class-section d-flex justify-content-between">
                        <div class="class1 full-width text-align-center">
                            <p class="val" id="rank-1"></p>
                        </div>
                        <div class="class2 full-width text-align-center">
                            <p class="val" id="rank-2"></p>
                        </div>
                        <div class="class3 full-width text-align-center">
                            <p class="val" id="rank-3"></p>
                        </div>
                        <div class="class4 full-width text-align-center">
                            <p class="val" id="rank-4"></p>
                        </div>
                    </div>
                </div>
                <div class="compare-class">
                    <h5 id="score" class="text-align-center">FUNDING</h5>
                    <div class="compare-class-section d-flex justify-content-between">
                        <div class="class1 full-width text-align-center">
                            <p class="val" id="fund-1"></p>
                        </div>
                        <div class="class2 full-width text-align-center">
                            <p class="val" id="fund-2"></p>
                        </div>
                        <div class="class3 full-width text-align-center">
                            <p class="val" id="fund-3"></p>
                        </div>
                        <div class="class4 full-width text-align-center">
                            <p class="val" id="fund-4"></p>
                        </div>
                    </div>
                </div>
                <div class="compare-class">
                    <h5 id="score" class="text-align-center">POPULATION SERVED</h5>
                    <div class="compare-class-section d-flex justify-content-between">
                        <div class="class1 full-width text-align-center">
                            <p class="val" id="population-1"></p>
                        </div>
                        <div class="class2 full-width text-align-center">
                            <p class="val" id="population-2"></p>
                        </div>
                        <div class="class3 full-width text-align-center">
                            <p class="val" id="population-3"></p>
                        </div>
                        <div class="class4 full-width text-align-center">
                            <p class="val" id="population-4"></p>
                        </div>
                    </div>
                </div>
                <div class="compare-class">
                    <h5 id="score" class="text-align-center">CO2 EMITTED</h5>
                    <div class="compare-class-section d-flex justify-content-between">
                        <div class="class1 full-width text-align-center">
                            <p class="val" id="co2-1"></p>
                        </div>
                        <div class="class2 full-width text-align-center">
                            <p class="val" id="co2-2"></p>
                        </div>
                        <div class="class3 full-width text-align-center">
                            <p class="val" id="co2-3"></p>
                        </div>
                        <div class="class4 full-width text-align-center">
                            <p class="val" id="co2-4"></p>
                        </div>
                    </div>
                </div>
                <div class="compare-class">
                    <h5 id="score" class="text-align-center">JOBS CREATED</h5>
                    <div class="compare-class-section d-flex justify-content-between">
                        <div class="class1 full-width text-align-center">
                            <p class="val" id="jobs-1"></p>
                        </div>
                        <div class="class2 full-width text-align-center">
                            <p class="val" id="jobs-2"></p>
                        </div>
                        <div class="class3 full-width text-align-center">
                            <p class="val" id="jobs-3"></p>
                        </div>
                        <div class="class4 full-width text-align-center">
                            <p class="val" id="jobs-4"></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php
    require_once './includes/components/footer.php';
?>