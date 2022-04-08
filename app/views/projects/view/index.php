<?php
    $title = 'View Projects';
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <?php require_once './includes/components/topNav.php';?>
        <section class="content">
            <a href="<?=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/projects' ?>">Back to projects list</a>
            <hr>
            <div class="top-title d-flex justify-content-between full-width align-items-center">
                <div class="">
                    <h2 class="title p3"><?= $data['project'] ?></h2>
                    <input type="hidden" id="project_id" value="<?= $data['projectData'][0]['project_id']?>">
                </div>
                <div class="">
                    <?=$_SESSION['designation'] == 'director' ? ' <a href="/projects/edit/'.$data['projectData'][0]['sector'].'/'.$data['projectData'][0]['name'].'/'.$data['projectData'][0]['project_id'].'" class="btn secondary">Edit project</a>' : ''?>
                    <?=$data['projectData'][0]['approved'] == '0' && $_SESSION['designation'] != 'budgeting officer' && $data['projectData'][0]['suspended'] == '0' ? '<a class="btn approve">Approve project</a>' : ''?>
                    <?php
                        if($_SESSION['designation'] != 'budgeting officer'){
                            if($data['projectData'][0]['suspended'] == '0'){
                                echo'
                                    <a href="/projects/add" class="btn danger suspend">Suspend project</a>
                                ';
                            }else{
                                echo '
                                    <a class="btn activate">Reactivate project</a>
                                ';
                            }
                        }
                    ?>
                </div>
            </div>
            <hr>
            <div class="row proj-info">
                <div class="info_top d-flex justify-content-between align-items-center">
                    <div class="info_top_left d-flex flex-wrap">
                        <div class="details full-width">
                            <span class="d-block p-name mb-2">Construction Type:</span>
                            <span class="p-data">
                                <?= $data['projectMetricsData'][0]['Construction_Type']?>
                            </span>
                        </div>
                        <div class="details full-width">
                            <span class="d-block p-name mb-2">Project Description:</span>
                            <span class="p-data">
                                <?= $data['projectData'][0]['description']?>
                            </span>
                        </div>
                        <div class="details">
                            <span class="d-block p-name mt-3 mb-2">Project Sector:</span>
                            <span id="sect" class="p-data">
                                <?= $data['projectData'][0]['sector']?>
                            </span>
                        </div>
                        <div class="details">
                            <span class="d-block p-name mt-3 mb-2">Project Start Year:</span>
                            <span class="p-data">
                                <?= $data['projectData'][0]['startYear']?>
                            </span>
                        </div>
                        <div class="details">
                            <span class="d-block p-name mt-3 mb-2">Project Origin State:</span>
                            <span class="p-data">
                                <?= $data['projectData'][0]['origin_state']?>
                            </span>
                        </div>
                        <div class="details">
                            <span class="d-block p-name mt-3 mb-2">Project Origin City:</span>
                            <span class="p-data">
                                <?= $data['projectData'][0]['origin_lga']?>
                            </span>
                            <span class="p-data h5">
                                <?= '('.$data['projectData'][0]['origin_latitude'].', '.$data['projectData'][0]['origin_longitude'].')' ?>
                            </span>
                        </div>
                        <?php
                            if($data['projectData'][0]['midway_points'] >= 1)
                            {
                                $midwayStates = explode(',', $data['projectData'][0]['midway_state']);
                                $midwayCities = explode(',', $data['projectData'][0]['midway_lga']);
                                $midwayLongs = explode(',', $data['projectData'][0]['midway_longitude']);
                                $midwayLats = explode(',', $data['projectData'][0]['midway_latitude']);

                                foreach ($midwayStates as $key => $midway) {
                                    echo '
                                        <div class="details">
                                            <span class="d-block p-name mt-3 mb-2">Project Midway State ('.($key + 1).')</span>
                                            <P class="p-data">
                                                '.$midway.'
                                            </p>
                                        </div>
                                        <div class="details">
                                            <span class="d-block p-name mt-3 mb-2">Project Midway City ('.($key + 1).')</span>
                                            <P class="p-data">
                                                '.$midwayCities[$key].'
                                            </p>
                                            <P class="p-data h5">
                                                ('.$midwayLats[$key].', '.$midwayLongs[$key].')
                                            </p>
                                        </div>
                                    ';
                                }
                            }
                        ?>
                        <div class="details">
                            <span class="d-block p-name mt-3 mb-2">Project Destination State:</span>
                            <span class="p-data">
                                <?= $data['projectData'][0]['destination_state']?>
                            </span>
                        </div>
                        <div class="details">
                            <span class="d-block p-name mb-2">Project Destination City:</span>
                            <span class="p-data">
                                <?= $data['projectData'][0]['destination_lga']?>
                            </span>
                            <span class="p-data h5">
                                <?= '('.$data['projectData'][0]['destination_latitude'].', '.$data['projectData'][0]['destination_longitude'].')' ?>
                            </span>
                        </div>
                    </div>
                    <div class="info_top_right">
                        <div class="box">
                            <div class="circular-progress">
                                <div class="single-chart">
                                    <svg viewBox="0 0 36 36" class="circular-chart blue">
                                    <path class="circle-bg"
                                        d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                    />
                                    <path class="circle"
                                        stroke-dasharray="<?=number_format((($data['projectData'][0]['score']/$data['totalMetricsScore']) * 100), '2','.','')?>, 100"
                                        d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                    />
                                    <text x="18" y="20.35" class="percentage"><?=$data['projectData'][0]['score']?>/<?=$data['totalMetricsScore']?></text>
                                    </svg>
                                </div>
                            </div>
                            <?= $data['project_rank'] != '' ? '<p class="rank">Project Rank - <span id="rank">'.$data['project_rank'].'</span>/<span id="total">'.$data['project_rank_overall'].'</span></p>' : '';?>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="info_bottom d-flex flex-column">
                    <div class="info_bottom_title full-width">
                        <h2 class="mb-4 assess-cat">Assessment Categories</h2>
                    </div>
                    <div class="info_bottom_body full-width d-flex flex-wrap">
                        <?php
                            foreach($data['metricsData'] as $key => $val){
                                foreach($val as $key => $metrics){
                                    echo '
                                    <fieldset>
                                        <legend>'.$key.'</legend>';
                                    foreach($metrics as $key => $label){
                                        foreach ($data['projectMetricsData'][0] as $formDataKey => $value) {
                                            $newDataKey = str_replace('_', ' ', $formDataKey); //remove the underscore from the form-input names as in the $array
                                            if($newDataKey === $label['label']){
                                                if($label['element'] == 'select')
                                                {
                                                    echo '
                                                        <div class="full-width">
                                                            <div class="span-hold d-flex justify-content-between align-content-end">
                                                                <span class="p-name d-block p5">'.$label['label'].':<br/><span>'.$value.'</span></span>
                                                                <span class="p-name d-block">('.$data['projectMetricsScore'][0][$formDataKey].'/'.max($label['options']).')</span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width:'.number_format((($data['projectMetricsScore'][0][$formDataKey]/max($label['options'])) * 100), '0','.','').'%;">
                                                            </div>
                                                        </div>
                                                    ';
                                                }else
                                                {
                                                    if($label['label'] == 'GDP of local economy (state)' || $label['label'] == 'Cost Effectiveness (cost/average daily traffic)' || $label['label'] == 'Project cost (amount to be spent by government)'){
                                                        $naira = '₦';
                                                    }else{
                                                        $naira = '';
                                                    }
                                                    echo '
                                                        <div class="full-width">
                                                            <div class="span-hold d-flex justify-content-between align-content-end">
                                                                <span class="p-name d-block p5">'.$label['label'].':<br/><span>'.$naira.' '.number_format($value, '0', '', ',').'</span></span>
                                                                <span class="p-name d-block">('.$data['projectMetricsScore'][0][$formDataKey].'/'.max($label['data-score']).')</span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width:'.number_format((($data['projectMetricsScore'][0][$formDataKey]/max($label['data-score'])) * 100), '0','.','').'%;">
                                                            </div>
                                                        </div>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                    echo'
                                    </fieldset>
                                    ';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <div class="info_cta_left">
                    <?=$_SESSION['designation'] == 'director' ? ' <a href="/projects/edit/'.$data['projectData'][0]['sector'].'/'.$data['projectData'][0]['name'].'/'.$data['projectData'][0]['project_id'].'" class="btn secondary">Edit project</a>' : ''?>
                    <?=$data['projectData'][0]['approved'] == '0' && $_SESSION['designation'] != 'budgeting officer' && $data['projectData'][0]['suspended'] == '0' ? '<a class="btn approve">Approve project</a>' : ''?>
                </div>
                <div class="info_cta_right">
                    <?php
                        if($_SESSION['designation'] != 'budgeting officer'){
                            if($data['projectData'][0]['suspended'] == '0'){
                                echo'
                                    <a href="/projects/add" class="btn danger suspend">Suspend project</a>
                                ';
                            }else{
                                echo '
                                    <a class="btn activate">Reactivate project</a>
                                ';
                            }
                        }
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>