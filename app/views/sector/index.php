<?php
    $title = 'Sector Summary';
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <?php require_once './includes/components/topNav.php';?>
        <section class="content content-box-body">
            <div class="top-title d-flex justify-content-between full-width align-items-center">
                <div class="">
                    <h2 class="title p3">Sector Summary</h2>
                </div>
            </div>
            <hr>
            <?php
                if(!empty($data['projectsList'])){
                    echo'
                        <div id="table-div">
                            <table id="summary-table">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Type</th>
                                        <th>Score</th>
                                        <th>Rank</th>
                                        <th>State</th>
                                        <th>LGA</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                    foreach($data['projectsList'] as $project)
                                    {
                                        echo '
                                            <tr>
                                                <td><h4>'.$project['name'].'</h4></td>
                                                <td><p class="p5">'.$project['Construction_Type'].'</p></td>
                                                <td><p class="p5">'.$project['score'].'</p></td>';
                                                foreach ($data['project_scores'] as $key => $value) {
                                                    if($project['id'] == $value['id'])
                                                    {
                                                        echo '<td><p class="p5">'.(array_search($value, $data['project_scores']) + 1).'</p></td>';
                                                    }
                                                };
                                            echo'
                                                <td><p class="p5">'.$project['project_state'].'</p></td>
                                                <td><p class="p5">'.$project['project_lga'].'</p></td>
                                            </tr>
                                        ';
                                    }
                                    echo '
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="summary-total">
                            <div class="row d-flex">
                                <div class="full-width">
                                    <fieldset class="field text-align-center">
                                        <legend>Total number of Projects</legend>
                                        <h5 id="projNum" class="val">'.count($data['projectsList']).'</h5>
                                    </fieldset>
                                </div>
                                <div class="full-width">
                                    <fieldset class="field text-align-center">
                                        <legend>Total cost of Projects</legend>
                                        <h5 id="projCost" class="val">';
                                            $total = 0;
                                            foreach ($data['projectsList'] as $projectListKey => $project) {
                                                $total += $project['cost'];
                                            }
                                            if ($total < 1000000) {
                                                // Anything less than a million
                                                $total = number_format($n);
                                            } else if ($total < 1000000000) {
                                                // Anything less than a billion
                                                $total = number_format($total / 1000000, 1) . 'M';
                                            } else if ($total < 1000000000000) {
                                                // Anything less than a trillion
                                                $total = number_format($total / 1000000000, 1) . 'B';
                                            } else {
                                                // At least a trillion
                                                $total = number_format($total / 1000000000000, 1) . 'T';
                                            }
                                            echo '&#8358;'.$total.'
                                        </h5>
                                    </fieldset>
                                </div>
                                <div class="full-width">
                                    <fieldset class="field text-align-center">
                                        <legend>Total funding provided</legend>
                                        <h5 id="budget" class="val">&#8358;1.1B</h5>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row d-flex">
                                <div class="full-width">
                                    <fieldset class="field text-align-center">
                                        <legend>Total number of jobs to be created</legend>
                                        <h5 id="jobsCreated" class="val">';
                                            $total = 0;
                                            foreach ($data['projectsList'] as $projectListKey => $project) {
                                                $total += $project['Number_of_jobs_created'];
                                            }
                                            echo number_format($total).'
                                        </h5>
                                    </fieldset>
                                </div>
                                <div class="full-width">
                                    <fieldset class="field text-align-center">
                                        <legend>Total number of jobs to be retained</legend>
                                        <h5 id="retJobs" class="val">';
                                            $total = 0;
                                            foreach ($data['projectsList'] as $projectListKey => $project) {
                                                $total += $project['Number_of_jobs_that_would_be_retained'];
                                            }
                                            echo number_format($total).'
                                        </h5>
                                    </fieldset>
                                </div>
                                <div class="full-width">
                                    <fieldset class="field text-align-center">
                                        <legend>Total co2 Emitted</legend>
                                        <h5 id="co2" class="val">';
                                            $total = 0;
                                            foreach ($data['projectsList'] as $projectListKey => $project) {
                                                $total += $project['Amount_of_Co2_Emmissions_from_the_project'];
                                            }
                                            echo number_format($total).'
                                        </h5>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row d-flex charts">
                                <div class="full-width">
                                    <fieldset class="field text-align-center">
                                        <legend>Geographical Distribution of Projects</legend>';
                                        $geoArray = array(); 
                                        $i = 0;
                                        foreach ($data['projectsList'] as $projectListKey => $project) {                                          
                                            $geoArray [$i]["count"]= $project['count'];
                                            $geoArray [$i]["region"]= $project['region'];
                                            $i++;
                                        }
                                       echo '
                                        <script>
                                            var chartRegions = '.json_encode($geoArray).'
                                        </script>
                                        <canvas id="geoPieChart"></canvas>
                                    </fieldset>
                                </div>
                                <div class="full-width">
                                    <fieldset class="field text-align-center">
                                        <legend>Component Weightings</legend>
                                        <canvas id="compWeightChart"></canvas>
                                    </fieldset>

                                </div>
                                <div class="full-width">
                                    <fieldset class="field text-align-center">
                                        <legend>Funding Type Distribution</legend>';
                                        
                                        $fundCount = array_count_values(array_column($data['projectsList'], 'Private/Public/Local_Participation')); 
                                        $fundLabel = array("Fully Private", "PPP", "Fully Government");
                                        
                                        $fundArray = array();
                                        $i = 0;
                                        foreach ($fundLabel as $key => $value) {
                                            $fundArray[$i]["count"] = isset($fundCount[$value]) ? $fundCount[$value] : 0;
                                            $fundArray[$i]["label"] = $value;
                                            $i++;
                                        }
                                        echo '
                                        <script>
                                            var chartFunds = '.json_encode($fundArray).'
                                        </script>
                                        <canvas id="fundingTypeChart"></canvas>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row d-flex charts">
                                <div class="full-width">
                                    <fieldset class="field text-align-center">
                                        <legend>Project Type Distribution</legend>';
                                        $i = 0;
                                        $metrics_label = [];
                                        foreach ($data['metricsData'] as $key => $metrics) {
                                            $metricsData = json_decode($metrics['metrics_data'], TRUE);
                                            foreach ($metricsData as $key => $metrics_data) {
                                                foreach($metrics_data as $key => $metrics){
                                                    foreach($metrics as $key => $metrics){
                                                        if($metrics['label'] == 'Construction Type')
                                                        {
                                                           foreach($metrics['options'] as $key => $construction_type)
                                                           {
                                                               $metrics_label[$i] = $key;
                                                               $i++;
                                                           };
                                                        }
                                                    }
                                                }
                                            }
                                        };

                                        $metricsCount = array_count_values(array_column($data['projectsList'], 'Construction_Type')); 
                                        $metricsArray = array();
                                        $i = 0;
                                        foreach ($metrics_label as $key => $value) {
                                            $metricsArray[$i]["count"] = isset($metricsCount[$value]) ? $metricsCount[$value] : 0;
                                            $metricsArray[$i]["label"] = $value;
                                            $i++;
                                        }
                                    echo '
                                        <script>
                                            var metricsArrayBarChart = '.json_encode($metricsArray).'
                                        </script>
                                        <canvas id="metricsArrayBarChart"></canvas>
                                    </fieldset>
                                </div>
                                <div class="half-width">
                                    <fieldset class="field text-align-center">
                                        <legend>Project Funding & Shortfalls</legend>';

                                        $projectFund = array();
                                        $i = 0;
                                        foreach ($data['executionList'] as $projectkey => $projectvalue)
                                        {
                                            $projectFund[$i]["funding"] = $projectvalue["funding"];
                                            $projectFund[$i]["shortfall"] = $projectvalue["shortfall"];
                                            $i++;
                                        }

                                        $total_funding = 0;
                                        $total_shortfall = 0;

                                        foreach ($projectFund as $projectfundkey => $projectfundvalue) {
                                            $total_funding += $projectfundvalue["funding"];
                                            $total_shortfall += $projectfundvalue["shortfall"];
                                        }

                                        $projectFunding = array($total_funding, $total_shortfall);
                                        $projectFundingLabels = array('Total Funding Provided', 'Funding Shortfalls');
                                        
                                        $fundingArray = array();
                                        $i = 0;
                                        foreach ($projectFundingLabels as $key => $value) {
                                            $fundingArray[$i]["count"] = $projectFunding[$key];
                                            $fundingArray[$i]["label"] = $value;
                                            $i++;
                                        }

                                        echo '
                                        <script>
                                            var projectShortfallTypeChart = '.json_encode($fundingArray).'
                                        </script>
                                        <canvas id="projectShortfallTypeChart"></canvas>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    ';
                }else{
                    echo '
                        <div class="empty full-width text-align-center d-flex flex-column v50h justify-content-center">
                            <p class="p4 notice"><span><i class="las la-chart-pie"></i></span><br/>There is no summary for your sector yet.<br/>Add a new project or '; echo $_SESSION['designation'] == 'budgeting officer' ? 'ask a superior to approve one' : 'approve one'; echo' to see your sector\'s summary!</p>
                        </div>
                    ';
                }
            ?>
        </section>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>