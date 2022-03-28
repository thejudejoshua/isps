<?php
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box v100h">
        <section class="content mt-5">
            <div class="top-title d-flex justify-content-between align-items-center">
                <div class="">
                    <h1 class="title">All Users</h1>
                    <p class="p5">All created users are displayed here</p>
                </div>
                <a href="/users/add" class="btn">+ Add User</a>
            </div>
            <hr>
            <table>
                <thead>
                    <tr>
                        <th><h3>Name</h3></th>
                        <th><h3>Sector</h3></th>
                        <th><h3>Designation</h3></th>
                        <th><h3>Date Added</h3></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data['usersList'] as $key => $user) {
                            echo'
                                <tr>
                                    <td><h5>'.$user['firstName'].' '.$user['lastName'].'<span class="p5">'.$user['email'].'</span></h5></td>
                                    <td><p class="p5">'.$user['sector'].'</p></td>
                                    <td><p class="p5">'.$user['designation'].'</p></td>
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