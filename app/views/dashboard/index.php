<?php
    $title =  'Dashboard';
    require_once './includes/components/header.php';
?>

<div class="wrapper">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <?php require_once './includes/components/topNav.php';?>
        <div class="content-box-body">
            <div class="row">
                <div class="main_welcome">
                    <div class="main_welcome_desc">
                        <h2>Hello, <?=$_SESSION['name']?>.</h2>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-12 col-sm-12 main_overview">
                    <div class="row">
                        <div class="main_overview_head main_section_head">
                            <h3 id="dashboard-section-header">Overview</h3>
                            <p class="p5">This is an overview of sector projects</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="main_overview_container d-flex">
                            <div class="main_overview_card flex-column d-flex align-items-center">
                                <div class="main_overview_card-top d-flex align-items-center full-width">
                                    <div class="left d-flex align-items-center">
                                        <i class="las la-history"></i>
                                    </div>
                                    <div class="right">
                                        <p class="count h1" data-value="<?=$data['allNewProjects']?>"><?=$data['allNewProjects']?></p>
                                        <p class="p5">New Projects</p>
                                    </div>
                                </div>
                                <div class="main_overview_card-bottom full-width">
                                    <!-- <a href="#">View Projects</a> -->
                                </div>
                            </div>
                            <div class="main_overview_card flex-column d-flex align-items-center">
                                <div class="main_overview_card-top d-flex align-items-center full-width">
                                    <div class="left d-flex align-items-center">
                                        <i class="las la-check"></i>
                                    </div>
                                    <div class="right">
                                        <p class="count h1" data-value="<?=$data['activeProjects']?>"><?=$data['activeProjects']?></p>
                                        <p class="p5">Active Projects</p>
                                    </div>
                                </div>
                                <div class="main_overview_card-bottom full-width">
                                    <a href="/projects">View Projects</a>
                                </div>
                            </div>
                            <div class="main_overview_card flex-column d-flex align-items-center">
                                <div class="main_overview_card-top d-flex align-items-center full-width">
                                    <div class="left d-flex align-items-center">
                                        <i class="las la-ban"></i>
                                    </div>
                                    <div class="right">
                                        <p class="count h1" data-value="<?=$data['suspendedProjects']?>"><?=$data['suspendedProjects']?></p>
                                        <p class="p5">Suspended Projects</p>
                                    </div>
                                </div>
                                <div class="main_overview_card-bottom full-width">
                                    <a href="/projects/suspended">View Projects</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="main_section d-flex full-width justify-content-between">
                    <div class="main_section-left">
                        <div class="main_section_head">
                            <h3 id="dashboard-section-header">Happening in your sector</h3>
                            <p class="p5">This shows you the activities performed in your sector</p>
                        </div>
                        <div class="main_section_body">
                            <?php
                                // if(is_array($data['notifications'])){
                                //     foreach($data['notifications'] as $notifications){
                                //         $vendors = new Vendors();
                                //         $time_past = $vendors->time_Ago(strtotime(date('Y-m-d H:i:s', strtotime( $notifications['date_added']) + 7 * 3600 )));
                                //         echo '
                                //         <li>
                                //             <span>'.$notifications['action'].'</span>
                                //             <span>'.$time_past.'</span>
                                //         </li>';
                                //     }
                                // }else{
                                    echo '
                                        <div class="empty d-flex justify-content-center align-items-center flex-column">
                                            <div class="empty-icon">
                                                <i class="las la-bell-slash"></i>
                                            </div>
                                            <p class="p5">Nothing has happened in your sector yet. Add a project to get started</p>
                                        </div>
                                    ';
                                // }
                            ?>
                        </div>
                    </div>
                    <div class="main_section-right">
                        <div class="main_section_head">
                            <h3 id="dashboard-section-header">Project Regions</h3>
                            <p class="p5">This displays your sector projects by regions</p>
                        </div>
                        <div class="main_section_body">
                            <?php
                                if(count($data['getChartRegions']) > 0){
                                    echo '
                                        <script>
                                            var chartRegions = '.json_encode($data["getChartRegions"]).'
                                        </script>
                                        <canvas id="pieChart"></canvas>
                                    ';
                                }else{
                                    echo '
                                        <div class="empty d-flex justify-content-center align-items-center flex-column">
                                            <div class="empty-icon">
                                                <i class="las la-globe"></i>
                                            </div>
                                            <p class="p5">Nothing has happened in your sector yet. Add a project to get started</p>
                                        </div>
                                    ';
                                }
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/includes/assets/js/chart.min.js"></script>
<script>
    var data = {labels: [], count: [] }

    for (let i = 0; i < chartRegions.length; i++) {        
        data.labels.push(chartRegions[i]['region'])
        data.count.push(chartRegions[i]['count'])
    }

    var canvasP = document.getElementById("pieChart");
    var ctxP = canvasP.getContext('2d');
    var myPieChart = new Chart(
        ctxP, {
        type: 'doughnut',
        data: {
            labels: data.labels,
            datasets: [{
                data: data.count,
                backgroundColor: ["#64B5F6", "#1dbd47", "#002c91", "#FFC107", "#db3737", "#a56e2a"],
                hoverBackgroundColor: ["#B2EBF2", "#95e0a8", "#698ad5", "#ffd557", "#e56d6d", "#b98e59"]
            }]
        },
        options: {
            responsive: false,
            spacing: 0,
            borderRadius: 2,
            legend: {
                display: true,
                position: "right"
            }
        }
    })
</script>

<?php
    require_once './includes/components/footer.php';
?>