<?php
    $title = 'Manage Sector Budget';
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <?php require_once './includes/components/topNav.php';?>
        <section class="content content-box-body">
            <div class="top-title d-flex justify-content-between full-width align-items-center">
                <div class="">
                    <h2 class="title p3">Manage Budget</h2>
                    <p class="p5 subtitle">Create, manage and distribute your sector's annual budget.</p>
                </div>
            </div>
            <hr>
            <div class="budget-body">
                <div class="d-flex justify-content-between">
                    <div class="budget-display">
                        <p id="display-year" class="p3 budget-info">Budget for <?= date("Y") ?>:</p>
                        <p id="display-year" class="h2 budget-info"><?= !empty($data['allBudget']) ? '&#8358; '.number_format($data['allBudget'][0]['amount'], '2') : 'Budget has not been set yet.' ?></p>
                    </div>
                    <div class="budget-actions d-flex justify-content-center align-items-center">
                        <span class="modal-open action" data-modal="edit-budget"><?= !empty($data['allBudget']) ? 'Edit Annual Budget' : 'Create Annual Budget' ?></span>
                        <span class="modal-open action" data-modal="see-budget">See past projects</span>
                    </div>
                </div>
                <div class="row">
                    <div class="modal fadeOut hidden full-width text-align-center d-flex flex-column justify-content-center align-items-center edit-budget">
                        <div class="modal-content">
                            <form class="full-width" id="budget-form">
                                <fieldset class="d-flex flex-column text-align-left">
                                    <?php
                                        if(empty($data['allBudget'])){
                                            echo'
                                                <legend>Create Annual Budget</legend>
                                                <div class="d-flex budget-top align-items-center flex-column">
                                                    <div class="full-width">
                                                        <label for="year" class="form-label">Year</label>
                                                        <input type="number" class="form-control" name="budget_year" id="year" value="'.date("Y").'" readonly required>
                                                    </div>
                                                    <!-- <div class="full-width">
                                                        <label for="sector" class="form-label">Sector</label>
                                                        <select id="sector" name="budget[sector]" class="form-control" required>
                                                            <option>Highway Construction</option>
                                                            <option>Railway Construction</option>
                                                            <option>Power Generation</option>
                                                            <option>Power Transmission</option>
                                                            <option>Water Supply</option>
                                                        </select>
                                                    </div> -->
                                                    <div class="full-width">
                                                        <label for="amount" class="form-label">Amount (&#8358;)</label>
                                                        <input type="text" class="form-control number-input" name="budget_amount" id="amount" data-type="currency" placeholder="E.g. &#8358;100,000,000,000" required>
                                                    </div>
                                                </div>
                                                <div class="modal-content-cta d-flex flex-row justify-content-center align-items-center">
                                                    <a class="btn tertiary modal-close" href="#" id="modal-close">Cancel</a>
                                                    <button type="submit" id="budget-create" class="btn">Create Annual Budget</button>
                                                </div>
                                            ';
                                        }else{
                                            echo'
                                                <legend>Edit Annual Budget</legend>
                                                <div class="d-flex budget-top align-items-center flex-column">
                                                    <div class="full-width">
                                                        <label for="year" class="form-label">Year</label>
                                                        <input type="number" class="form-control" name="budget_year" id="year" value="'.date("Y").'" readonly required>
                                                    </div>
                                                    <!-- <div class="full-width">
                                                        <label for="sector" class="form-label">Sector</label>
                                                        <select id="sector" name="budget[sector]" class="form-control" required>
                                                            <option>Highway Construction</option>
                                                            <option>Railway Construction</option>
                                                            <option>Power Generation</option>
                                                            <option>Power Transmission</option>
                                                            <option>Water Supply</option>
                                                        </select>
                                                    </div> -->
                                                    <div class="full-width">
                                                        <label for="amount" class="form-label">Amount (&#8358;)</label>
                                                        <input type="text" class="form-control number-input" name="budget_amount" id="amount" data-type="currency" placeholder="E.g. &#8358;100,000,000,000" value="'.number_format($data['allBudget'][0]['amount'], '2').'" required>
                                                    </div>
                                                </div>
                                                <div  class="modal-content-cta d-flex flex-row justify-content-left align-items-center">
                                                    <a class="btn tertiary modal-close" href="#" id="modal-close">Cancel</a>
                                                    <button type="submit" id="budget-create" class="btn">Update Annual Budget</button>
                                                </div>
                                            ';
                                        }
                                    ?>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="modal fadeOut hidden full-width text-align-center d-flex flex-column justify-content-center align-items-center see-budget">
                        <div class="modal-content">
                            <form class="full-width d-flex flex-column align-items-start" id="budget-list">
                                <?php
                                    if(empty($data['pastBudget'])){
                                        echo'
                                            <div class="empty full-width text-align-center d-flex flex-column v40h justify-content-center">
                                                <p class="p4 notice"><span><i class="las la-folder-open"></i></span><br/>Sorry, there are no past budget to see.</p>
                                                <div class="modal-content-cta d-flex flex-row justify-content-center align-items-center">
                                                    <a class="btn modal-close" href="#" id="modal-close">Close this pop-up</a>
                                                </div>
                                            </div>
                                        ';
                                    }else{
                                        echo'
                                        <div class="modal-content-cta d-flex flex-row justify-content-center align-items-center">
                                            <a class="btn tertiary modal-close" href="#" id="modal-close">x  Close this pop-up</a>
                                        </div>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th><h4>Budget Year</h4></th>
                                                    <th><h4>Budget Amount</h4></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        ';
                                        foreach ($data['pastBudget'] as $key => $budget) {
                                            echo'
                                                <tr>
                                                    <td></td>
                                                    <td><h4>'.$budget['year'].'</h4></td>
                                                    <td><h4>&#8358;'.number_format($budget['amount'], '2').'</h4></td>
                                                </tr>
                                            ';
                                        };
                                        echo '
                                            </tbody>
                                        </table>
                                        ';
                                    }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
                <fieldset class="d-flex flex-column">
                    <legend>Assign Budget to Projects in Execution List</legend>
                    <div id="assign-div" class="d-flex justify-content-between align-items-center">
                        <p class="p4">Amount Available: &#8358; <span class="funding-val"><?=number_format($data['allBudget'][0]['funds_available'], '2')?></span></p>
                        <div class="toggle-btns d-flex">
                            <button type="button" class="btn secondary" id="assign-evenly">Auto assign evenly</button>
                            <button type="button" class="btn secondary" id="assign-score">Auto assign by score</button>
                        </div>
                    </div>
                    <div id="execProjects">
                        <form class="full-width" id="budget-list-form">
                            <input id="fullBudget" name="fullBudget" type="hidden" class="form-control" value="<?=number_format($data['allBudget'][0]['amount'], '2')?>" readonly/>
                            <?php
                                if(!empty($data['executionList']))
                                {
                                    echo'
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th><h4>Project Name</h4></th>
                                                    <th><h4>Funding Required (&#8358;)</h4></th>
                                                    <th><h4>Shortfall (&#8358;)</h4></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    ';
                                    foreach ($data['executionList'] as $key => $project) {
                                        echo'
                                            <tr>
                                                <td></td>
                                                <td><h4>'.$project['name'].'</h4></td>
                                                <td><input id="funding" name="funding[]" type="text" class="form-control number-input" data-score="'.$project['score'].'" data-cost="'.$project['cost'].'" value="'.number_format($project['funding'], '2').'"/></td>
                                                <td>
                                                    <input id="shortfall" name="shortfall[]" type="text" class="form-control number-input" value="'.number_format($project['shortfall'], '2').'" readonly/>
                                                    <input name="project-id[]" type="hidden" class="form-control" value="'.$project['project_id'].'" readonly/>
                                                    <input id="budget-id" name="budget-id" type="hidden" class="form-control" value="'.$project['id'].'" readonly/>
                                                </td>
                                            </tr>
                                        ';
                                    };
                                    echo '
                                            </tbody>
                                        </table>
                                    ';
                                }else
                                {
                                    echo '
                                        <div class="empty full-width text-align-center d-flex flex-column v50h justify-content-center">
                                            <p class="p4 notice"><span><i class="las la-folder-open"></i></span><br/>There are no projects found in execution list for your sector.</p>
                                        </div>
                                    ';
                                }
                            ?>
                            <div  class="">
                                <input id="leftBudget" name="budget-left" value="<?=$data['allBudget'][0]['funds_available']?>" type="hidden" class="form-control" readonly/>
                                <button type="submit" id="budget-dist-save" class="btn">Update Budget Distribution</button>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
        </section>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>