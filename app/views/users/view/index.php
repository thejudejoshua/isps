<?php
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box v100h">
        <?php
            foreach ($data['userDataList'] as $user) {
                echo '
                    <section class="content mt-5">
                        <a href="/users">back to all users</a>
                        <hr>
                        <h1 class="title">'.$user['firstName'].' '.$user['lastName'].'</h1>
                        <h4>Role: '.$user['designation'].'</h4>
                        <h4>Level: '.$user['level'].'</h4>
                        <h4>Sector: '.$user['sector'].'</h4>
                        <h4>Added by: <a href="#">'.$user['added_by'].'</a></h4>
                        <h4>Date added: '.date('d M, Y', strtotime( $user['date_added'])).'</h4>
                        <hr>
                        <h4>Number of Projects added: 0</h4>
                        <h4>Number of Users added: 0</h4>
                        <hr>
                        <a href="#" id="btn-submit" class="action">Suspend</a>
                    </section>
                ';
            }
        ?>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>