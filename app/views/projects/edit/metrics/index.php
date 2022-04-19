<?php
$title = 'Edit Project Metrics';
require_once './includes/components/header.php';
?>

    <div class="wrapper d-flex">
        <?php require_once './includes/components/sideNav.php';?>
        <div class="content-box">
            <?php require_once './includes/components/topNav.php';?>
            <section class="content content-box-body">
                <a href="/projects/edit/<?= $data['projectData'][0]['sector']?>/<?= $data['projectData'][0]['name']?>/<?= $data['projectData'][0]['project_id']?>">Go back</a>
                <hr>
                <h2 class="p3">Edit project Metrics</h2>
                <hr>
                <div class="title-description">
                    <span class="p4 description"><span>Project name:</span><?= $data['projectData'][0]['name']?></span>
                    <span class="p4 description"><span>Project Sector:</span><?= $data['projectData'][0]['sector']?></span>
                </div>
                <hr>
                <form id="editProjectMetricsForm" class="d-flex flex-column">
                    <div class="form-group">
                        <div class="full-width">
                            <?php
                            foreach($data['metricsData'] as $key => $val){
                                foreach($val as $key => $metrics){
                                    echo '
                                    <fieldset>
                                        <legend>'.$key.'</legend>';
                                        foreach ($metrics as $key => $form_data) {
                                            if($form_data['label'] == 'GDP of local economy (state)' || $form_data['label'] == 'Cost Effectiveness (cost/average daily traffic)' || $form_data['label'] == 'Project cost (amount to be spent by government)'){
                                                $naira = ' (₦) ';
                                            }else{
                                                $naira = '';
                                            }
                                            echo '
                                                <div class="form-group">
                                                    <div class="full-width">
                                                        <label for="'.str_replace(' ', '_', $form_data['label']).'" class="form-label">'.$form_data['label'].''.$naira.' <span>';$form_data['label'] == 'Number of jobs created' || $form_data['label'] == 'Number of jobs that would be retained' || $form_data['label'] == 'Project cost (amount to be spent by government)' || $form_data['label'] == 'Investment Payback Period (in years)'? print '' : print '(Required)'; echo'</span></label>';
                                                    if($form_data['element'] == 'select'){
                                                        echo'
                                                        <select class="form-control" name="'.str_replace(' ', '_', $form_data['label']).'" id="'.str_replace(' ', '_', $form_data['label']).'">
                                                            <option value="" selected hidden default>Select an option...</option>';
                                                            foreach ($form_data['options'] as $key => $option) {
                                                                echo '
                                                                    <option value="'.$key.'"'; $data['projectMetricsData'][0][str_replace(' ', '_', $form_data['label'])] == $key ? print 'selected' : print ''; echo'>'.$key.'</option>
                                                                ';
                                                            }
                                                        echo'
                                                        </select></div></div>';
                                                    }else{
                                                        echo '
                                                            <input class="form-control number-input" placeholder="Enter '.$form_data['label'].'" type="text" name="'.str_replace(' ', '_', $form_data['label']).'" id="'.str_replace(' ', '_', $form_data['label']).'"';
                                                                foreach ($form_data['data-score'] as $key => $data_option) {
                                                                    echo '
                                                                        data-'.$key.'='.$data_option.'
                                                                    ';
                                                                }
                                                                $form_data['label'] == 'Number of jobs created' || $form_data['label'] == 'Number of jobs that would be retained' || $form_data['label'] == 'Project cost (amount to be spent by government)' ? print ' readonly value="'.number_format($data[$form_data['label']]).'"></div></div>' : print 'value="'.number_format($data['projectMetricsData'][0][str_replace(' ', '_', $form_data['label'])]).'"></div></div>
                                                        ';

                                                    }
                                        }echo'
                                    </fieldset>
                                    ';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group cta">
                        <div class="">
                            <input type="hidden" name="metrics_id" id="metrics_id" value="<?= $data['projectMetricsData'][0]['id']?>"/>
                            <input type="hidden" name="project_id" id="project_id" value="<?= $data['projectData'][0]['project_id']?>"/>
                            <input type="hidden" name="project_name" id="project_name" value="<?= $data['projectData'][0]['name']?>"/>
                            <input type="hidden" name="sector" id="sector" value="<?= $data['projectData'][0]['sector']?>"/>
                        </div>
                        <button type="submit" class="btn" id="btn-submit">Save Project Metrics</button>
                    </div>
                </form>
            </section>
        </div>
    </div>

<?php
require_once './includes/components/footer.php';
?>