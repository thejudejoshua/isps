<?php
    require_once './includes/components/header.php';
?>

    <div class="wrapper d-flex">
        <?php require_once './includes/components/sideNav.php';?>
        <div class="content-box v100h">

            <section class="content mt-5">
                <a href="/projects">back to all projects</a>
                <hr>
                <h2>Add project Metrics</h2>
                <hr>
                <div class="title-description">
                    <span class="p4 description"><span>Project name:</span> <?= $data['project']?></span>
                    <span class="p4 description"><span>Project Sector:</span> <?= $data['sector']?></span>
                </div>
                <hr>
                <form id="newProjectMetricsForm" class="d-flex flex-column">
                    <?php
                        foreach ($data['metricsData'] as $key => $metrics) {
                            $metrics_data = (array)json_decode($metrics['metrics_data']);
                            foreach ($metrics_data as $key => $metrics) {
                                $metrics_data = (array) $metrics;
                                foreach($metrics_data as $key => $metrics){
                                    echo '
                                        <fieldset>
                                            <legend>'.$key.'</legend>';
                                            foreach ($metrics as $key => $form_groups) {
                                                $form_data = (array)$form_groups;
                                                echo '
                                                    <div class="form-group">
                                                        <div class="full-width">
                                                            <label for="'.str_replace(',', '', $form_data['label']).'" class="form-label">'.$form_data['label'].' <span>(Required)</span></label>';
                                                        if($form_data['element'] == 'select'){
                                                            echo'
                                                            <select class="form-control" name="'.str_replace(',', '', $form_data['label']).'" id="'.str_replace(',', '', $form_data['label']).'">
                                                                <option value="" selected hidden default>Select an option...</option>';
                                                                $select_options = (array)$form_data['options'];
                                                                foreach ($select_options as $key => $option) {
                                                                    echo '
                                                                        <option value="'.$option.'" data-value="'.$key.'">'.$key.'</option>
                                                                    ';
                                                                }
                                                            echo'
                                                            </select></div></div>';
                                                        }else{
                                                            echo '
                                                                <input class="form-control" placeholder="Enter '.$form_data['label'].'" type="'.$form_data['type'].'" name="'.str_replace(',', '', $form_data['label']).'" id="'.str_replace(',', '', $form_data['label']).'"';
                                                                    $data_score = (array)$form_data['data-score'];
                                                                    foreach ($data_score as $key => $data_option) {
                                                                        echo '
                                                                            data-'.$key.'='.$data_option.'
                                                                        ';
                                                                    }
                                                                echo'></div></div>
                                                            ';
                                                        }
                                            }echo'
                                        </fieldset>
                                    ';
                                }
                            }
                        }
                    ?>
                    
                    <div class="form-group">
                        <button type="submit" class="btn" id="btn-submit">Save Project Metrics</button>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <?php
    require_once './includes/components/footer.php';
?>