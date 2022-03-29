<?php
    require_once './includes/components/header.php';
?>

    <div class="wrapper d-flex">
        <?php require_once './includes/components/sideNav.php';?>
        <div class="content-box">

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
                    <div class="form-group">
                        <div class="full-width">
                            <?php
                                foreach ($data['metricsData'] as $key => $metrics) {
                                    $metrics_data = json_decode($metrics['metrics_data'], TRUE);
                                    foreach ($metrics_data as $key => $metrics_data) {
                                        foreach($metrics_data as $key => $metrics){
                                            echo '
                                                <fieldset>
                                                    <legend>'.$key.'</legend>';
                                                    foreach ($metrics as $key => $form_data) {
                                                        echo '
                                                            <div class="form-group">
                                                                <div class="full-width">
                                                                    <label for="'.str_replace(' ', '_', $form_data['label']).'" class="form-label">'.$form_data['label'].' <span>(Required)</span></label>';
                                                                if($form_data['element'] == 'select'){
                                                                    echo'
                                                                    <select class="form-control" name="'.str_replace(' ', '_', $form_data['label']).'" id="'.str_replace(' ', '_', $form_data['label']).'">
                                                                        <option value="" selected hidden default>Select an option...</option>';
                                                                        foreach ($form_data['options'] as $key => $option) {
                                                                            echo '
                                                                                <option value="'.$key.'" data-value="'.$option.'">'.$key.'</option>
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
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="project_id" id="id" value="<?=$data['id']?>"/>
                        <input type="hidden" name="sector" id="sector" value="<?=$data['sector']?>"/>
                        <button type="submit" class="btn" id="btn-submit">Save Project Metrics</button>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <?php
    require_once './includes/components/footer.php';
?>