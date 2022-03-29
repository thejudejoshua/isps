<?php
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <?php require_once './includes/components/topNav.php';?>
        <section class="content">
            <div class="top-title d-flex justify-content-between full-width align-items-center">
                <div class="">
                    <h2 class="title p3">All Unapproved Projects</h2>
                </div>
            </div>
            <hr>
            <?php
                if(empty($data['projectsList']))
                {
                    echo '
                        <div class="full-width text-align-center d-flex flex-column v50h justify-content-center">
                            <p class="h4 notice"><i class="las la-exclamation-triangle"></i><br/>There are no projects to approve. When the budgeting officer adds a project, it will appear here.</p>
                        </div>
                    ';
                }else{
                    echo'
                    <table>
                        <thead>
                            <tr>
                                <th><h4>Project Name</h4></th>
                                <th><h4>Project Sector</h4></th>
                                <th><h4>Project Score</h4></th>
                                <th><h4>Added by</h4></th>
                                <th><h4>Date Added</h4></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    foreach ($data['projectsList'] as $key => $project) {
                        echo'
                            <tr>
                                <td><h5>'.$project['name'].'</h5></td>
                                <td><p class="p5">'.$project['sector'].'</p></td>
                                <td><p class="p5">'.$project['score'].'</p></td>
                                <td><p class="p5">'.$project['added_by'].'</p></td>
                                <td><p class="p5">'.date('d M, Y', strtotime( $project['date_added'])).'</p></td>
                                <td>
                                    <a href="/projects/view/'.$project['sector'].'/'.$project['name'].'/'.$project['id'].'" class="action view-project">View</a>
                                </td>
                            </tr>
                        ';
                    };
                    echo '
                        </tbody>
                    </table>
                    ';
                }
            ?>
        </section>
        <?php
        if(!empty($data['emptyMetrics'])){
            echo '
                <div class="modal full-width text-align-center d-flex flex-column justify-content-center align-items-center">
                    <div class="modal-content">
                        <div class="modal-content-text">
                            <p class="h4 notice"><i class="las la-exclamation-triangle"></i><br/>You have an incomplete project upload. Do you want to continue from where you stopped?</p>
                        </div>
                        <div class="modal-content-cta d-flex flex-row justify-content-center align-items-center">
                            <a class="btn tertiary" href="#" id="modal-close">I\'ll do that later</a>
                            <a class="btn" href="/projects/metrics/'.$data['emptyMetrics'][0]['name'].'/'.$data['emptyMetrics'][0]['id'].'/'.$data['emptyMetrics'][0]['sector'].'" id="go-metrics">Okay, I\'ll finish it now</a>
                        </a>
                    </div>
                </div>
            ';
        }
        ?>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>