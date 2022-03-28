<?php
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <section class="content">
            <div class="top-title d-flex justify-content-between align-items-center">
                <div class="">
                    <h2 class="title">All Projects</h2>
                    <p class="p5">All projects created on this system are displayed here</p>
                </div>
                <a href="/projects/add" class="btn">+ Add a New Project</a>
            </div>
            <hr>
            <?php
                if(empty($data['projectsList']))
                {
                    echo '
                        <div class="full-width text-align-center d-flex flex-column v50h justify-content-center">
                            <p class="h4 notice"><i class="las la-exclamation-triangle"></i><br/>There are no projects added here yet. Use the "Add a New Project" button to add a new project!</p>
                        </div>
                    ';
                }else{
                    echo'
                    <table>
                        <thead>
                            <tr>
                                <th><h3>Project Name</h3></th>
                                <th><h3>Project Sector</h3></th>
                                <th><h3>Project Score</h3></th>
                                <th><h3>Date Added</h3></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    foreach ($data['projectsList'] as $key => $project) {
                        echo'
                            <tr>
                                <td><h5>'.$project['name'].'<span class="p5">₦ '.number_format($project['cost'], 0, '.', ',').'</span></h5></td>
                                <td><p class="p5">'.$project['sector'].'</p></td>
                                <td><p class="p5">'.$project['score'].'</p></td>
                                <td><p class="p5">'.date('d M, Y', strtotime( $project['date_added'])).'</p></td>
                                <td>
                                    <a href="/projects/view/'.$project['id'].'/'.$project['sector'].'" class="action view-project">View</a>
                                    <a href="#" class="action">Delete</a>
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
                <div class="modal full-width text-align-center d-flex flex-column v100h justify-content-center align-items-center">
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