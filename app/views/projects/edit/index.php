<?php
    $title = 'Add a new project';
    require_once './includes/components/header.php';
?>

    <div class="wrapper d-flex">
        <?php require_once './includes/components/sideNav.php';?>
        <div class="content-box">
            <?php require_once './includes/components/topNav.php';?>
            <section class="content">
                <a href="/projects">back to all projects</a>
                <hr>
                <div class="top-title d-flex justify-content-between full-width align-items-center">
                    <div class="">
                        <h2 class="title p3">Edit <?=$data['project']?></h2>
                        <p class="p5 subtitle">Edit the details for this project by clearing the old values and entering new ones.</p>
                    </div>
                </div>
                <hr>
                <form id="editProjectForm" class="d-flex flex-column">
                    <div class="">
                        <div class="form-group">
                            <div class="full-width">
                                <label for="projectName" class="form-label">Project Name <span>(Required)</span></label>
                                <input type="text" class="form-control" name="projectName" id="projectName" value="<?=$data['project']?>" placeholder="E.g. Construction of Ninth Mile" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="full-width">
                                <label for="projectDescription" class="form-label">Project Description <span>(Required)</span></label>
                                <textarea class="form-control" name="projectDescription" id="projectDescription" rows="4" placeholder="E.g. XYZ Project Description" required><?=$data['projectData'][0]['description']?></textarea>
                            </div>
                        </div>
                        <div class="form-group dual">
                            <div class="">
                                <label for="projectStartYear" class="form-label">Project Start Year <span>(Required)</span></label>
                                <input type="number" class="form-control" name="projectStartYear" id="projectStartYear" min="1920" max="2100" placeholder="E.g. 2022" value="<?=$data['projectData'][0]['startYear']?>" required>
                            </div>
                            <div class="">
                                <label for="projectDuration" class="form-label">Project Duration (In Years) <span>(Required)</span></label>
                                <input type="number" class="form-control" name="projectDuration" id="projectDuration" min="0" placeholder="E.g. 4" value="<?=$data['projectData'][0]['duration']?>" required>
                            </div>
                            <div class="">
                                <label for="projectCost" class="form-label">Project Cost (₦) <span>(Required)</span></label>
                                <input type="text" class="form-control number-input" name="projectCost" id="projectCost" placeholder="E.g. 2,309,332" value="<?=number_format($data['projectData'][0]['cost'], '0', '.', ',')?>" required>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <div class="full-width">
                                <label for="projectSector" class="form-label">Project Sector</label>
                                <input type="text" class="form-control" name="projectSector" id="projectSector" value="<?=$_SESSION['sector']?>" placeholder="E.g. Power Generator" readonly required>
                            </div>
                            <div class="">
                                <label for="projectState" class="form-label">Project State <span>(Required)</span></label>
                                <input type="text" class="form-control state" name="projecState" id="projectState" placeholder="E.g. Adamawa">
                                <div class="show-off"></div>
                            </div>
                            <div class="">
                                <div class="col-md-4">
                                    <label for="projectLga" class="form-label">Project LGA</label>
                                    <select type="text" class="form-control lga" name="projectLGA" id="projectLga" placeholder="E.g. Gombi" required>
                                        <option selected hidden disabled>Select LGA...</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="form-group">
                        <div class="full-width">
                            <fieldset>
                                <legend class="form-sep">Project Origin Information</legend>
                                <div class="form-group dual">
                                    <div class="">
                                        <label for="originState" class="form-label">Project Origin State <span>(Required)</span></label>
                                        <input type="text" class="form-control state" value="<?=$data['projectData'][0]['origin_state']?>" name="originState" id="originState" placeholder="E.g. Adamawa" required>
                                        <div class="show-off"></div>
                                    </div>
                                    <div class="">
                                        <div class="col-md-4">
                                            <label for="originLGA" class="form-label">Project Origin LGA <span>(Required)</span></label>
                                            <select type="text" class="form-control lga" name="originLGA" id="originLGA" placeholder="E.g. Gombi" required>
                                                <?php
                                                    $project = new Project();
                                                    $listLGAs= $project->getLGA($data['projectData'][0]['origin_state']);
                                                    foreach($listLGAs as $key => $lga)
                                                    {
                                                        $lga = array_filter(array_slice($lga, 4));
                                                        foreach($lga as $local_government)
                                                        {
                                                            echo '
                                                                    <option value="'.$local_government.'"'; $data['projectData'][0]['origin_lga'] == $local_government ? print 'selected' : print ''; echo'>'.$local_government.'</option>
                                                                ';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group dual">
                                    <div class="">
                                        <label for="originLongitude" class="form-label">Project Origin Longitude</label>
                                        <input type="text" class="form-control lng" value="<?=$data['projectData'][0]['origin_latitude']?>" name="originLongitude" id="originLongitude" readonly placeholder="E.g. 3.4000">
                                    </div>
                                    <div class="">
                                        <div class="col-md-4">
                                            <label for="originLatitude" class="form-label">Project Origin Latitude</label>
                                            <input type="text" class="form-control lat" value="<?=$data['projectData'][0]['origin_latitude']?>" name="originLatitude" id="originLatitude" readonly placeholder="E.g. 6.4500">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset id="mid-box">
                                <legend class="form-sep">Project Midway Information (if any)</legend>
                                <div class="form-group dual">
                                    <label for="midway" class="form-label">Number of midway points:</label>
                                    <div class="midway-actions">
                                        <span id="minus">-</span>
                                        <input readonly type="number" class="form-control" name="midwayPoints" id="midway" min="0" max="3" value="<?=$data['projectData'][0]['midway_points']?>" placeholder="0">
                                        <span id="plus">+</span>
                                    </div>
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
                                                <div class="rem mid-content edit">
                                                    <div class="form-group dual">
                                                        <div class="">
                                                            <label for="midwayState" class="form-label">Midway State 1</label>
                                                            <input type="text" class="form-control state" name="midwayState[]" id="midwayState" value="'.$midway.'" placeholder="E.g. Adamawa">
                                                            <div class="show-off"></div>
                                                        </div>
                                                        <div class="">
                                                            <label for="midwayLGA" class="form-label">Midway LGA '.($key + 1).'</label>
                                                            <select class="form-control lga" name="midwayLGA[]" id="midwayLGA" placeholder="">';
                                                                $midwayListLGAs= $project->getLGA($midway);
                                                                foreach($midwayListLGAs as $key => $lga)
                                                                {
                                                                    $lga = array_filter(array_slice($lga, 4));
                                                                    foreach($lga as $local_government)
                                                                    {
                                                                        echo '
                                                                                    <option value="'.$local_government.'"'; $midwayCities[$key] == $local_government ? print 'selected default' : print ''; echo'>'.$local_government.'</option>
                                                                                ';
                                                                    }
                                                                }echo '
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group dual">
                                                        <div class="">
                                                            <label for="midwayLongitude" class="form-label">Midway Longitude 1</label>
                                                            <input type="text" class="form-control lng" name="midwayLongitude[]" id="midwayLongitude" value="'.$midwayLongs[$key].'" readonly="" placeholder="E.g. 10. 12212322">
                                                        </div>
                                                        <div class="">
                                                            <label for="midwayLatitude" class="form-label">Midway Latitude 1</label>
                                                            <input type="text" class="form-control lat" name="midwayLatitude[]" id="midwayLatitude" readonly="" value="'.$midwayLats[$key].'" placeholder="E.g. 10. 12212322">
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
                                        }
                                        
                                    }
                                ?>
                            </fieldset>
                            <fieldset>
                                <legend class="form-sep">Project Destination Information</legend>
                                <div class="form-group dual">
                                    <div class="">
                                        <label for="destState" class="form-label">Project Destination State <span>(Required)</span></label>
                                        <input type="text" class="form-control state" value="<?=$data['projectData'][0]['destination_state']?>" name="destinationState" id="destState" placeholder="E.g. Adamawa" required>
                                        <div class="show-off"></div>
                                    </div>
                                    <div class="">
                                        <div class="col-md-4">
                                            <label for="destinationLGA" class="form-label">Project Destination LGA <span>(Required)</span></label>
                                            <select type="text" class="form-control lga" name="destinationLGA" id="destinationLGA" placeholder="E.g. Gombi" required>
                                                <?php
                                                    $destinationLGAs= $project->getLGA($data['projectData'][0]['destination_state']);
                                                    foreach($destinationLGAs as $key => $lga)
                                                    {
                                                        $lga = array_filter(array_slice($lga, 4));
                                                        foreach($lga as $local_government)
                                                        {
                                                            echo '
                                                                        <option value="'.$local_government.'"'; $data['projectData'][0]['destination_lga'] == $local_government ? print 'selected' : print ''; echo'>'.$local_government.'</option>
                                                                    ';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group dual">
                                    <div class="">
                                        <label for="destinationLongitude" class="form-label">Project Destination Longitude</label>
                                        <input type="text" class="form-control lng" value="<?=$data['projectData'][0]['destination_longitude']?>" name="destinationLongitude" id="destinationLongitude" readonly placeholder="E.g. 3.4000">
                                    </div>
                                    <div class="">
                                        <div class="col-md-4">
                                            <label for="destinationLatitude" class="form-label">Project Destination Latitude</label>
                                            <input type="text" class="form-control lat" value="<?=$data['projectData'][0]['destination_latitude']?>" name="destinationLatitude" id="destinationLatitude" readonly placeholder="E.g. 6.4500">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </diV>
                    <div class="form-group">
                        <input type="hidden" class="form-control lat" value="<?=$data['projectData'][0]['project_id']?>" name="project_id">
                        <button type="submit" class="btn" id="btn-submit">Edit Project Metrics</button>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <?php
    require_once './includes/components/footer.php';
?>