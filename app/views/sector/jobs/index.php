<?php
    $title = 'Manage Jobs';
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <?php require_once './includes/components/topNav.php';?>
        <section class="content content-box-body">
            <div class="top-title d-flex justify-content-between full-width align-items-center">
                <div class="">
                    <h2 class="title p3">Sector Jobs</h2>
                    <p class="p5 subtitle">Here, you can set how much is spent on job creation in your sector.</p>
                </div>
                <!-- <a href="/budget/jobs/add" class="btn add-jobs">Add New Job Budget</a> -->
            </div>
            <hr>
            <div class="jobs-body">
                <div class="jobs-find">
                    <select class="form-control" id="jobs-sectorList">
                        <option default hidden selected>Choose a sector...</option>
                        <?php
                            if(is_array($data['sectorList'])){
                                foreach ($data['sectorList'] as $key => $sectors) {
                                    foreach ($sectors as $key => $sector) {
                                        echo '<option value="'.$sector.'">'.$sector.'</option>';
                                    }
                                }
                            }else{
                                echo '<option value="'.$data['sectorList'].'">'.$data['sectorList'].'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div id="jobs-stats-metrics">
                    <div class="full-width text-align-center d-flex flex-column v50h justify-content-center">
                        <p class="p4 notice"><span><i class="las la-clipboard"></i></span><br/>Select a sector to see the job budget set for that sector.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>