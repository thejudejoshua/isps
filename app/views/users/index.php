<?php
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <?php require_once './includes/components/topNav.php';?>
        <section class="content mt-5">
            <div class="top-title d-flex justify-content-between full-width align-items-center">
                <div class="">
                    <h2 class="title p3">All Users</h2>
                </div>
                <a href="/users/add" class="btn">+ Add User</a>
            </div>
            <hr>
            <table>
                <thead>
                    <tr>
                        <th><h4>Name</h4></th>
                        <th><h4>Designation</h4></th>
                        <th><h4>Added By</h4></th>
                        <th><h4>Date Added</h4></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data['usersList'] as $key => $user) {
                            echo'
                                <tr>
                                    <td><h5>'.$user['firstName'].' '.$user['lastName'].'<span class="p5">'.$user['email'].'</span></h5></td>
                                    <td><p class="p5">'.$user['designation'].'</p></td>
                                    <td><p class="p5">'.$user['added_by'].' <span class="p5">('.$user['designation'].')<span></p></td>
                                    <td><p class="p5">'.date('d M, Y', strtotime( $user['date_added'])).'</p></td>
                                    <td>
                                        <a href="/users/view?role='.$user['designation'].'&id='.$user['id'].'" class="action view-user">View</a>
                                        <a href="#" class="action">Delete</a>
                                    </td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>