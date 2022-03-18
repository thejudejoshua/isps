<?php
    require_once './includes/components/header.php';
?>

<div class="wrapper row m-0 justify-content-end">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box col-md-10">
        <section class="content mt-5">
            <div class="top-title d-flex justify-content-between align-items-center">
                <div class="">
                    <h1 class="title">All Users</h1>
                    <h4>All created users are displayed here</h4>
                </div>
                <a href="/users/add_user" class="custom-btn">+ Add User</a>
            </div>
            <hr>
            <table>
                <thead>
                    <tr>
                        <th><h3>Name</h3></th>
                        <th><h3>Sector</h3></th>
                        <th><h3>Designation</h3></th>
                        <th><h3>Action</h3></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data['usersList'] as $key => $user) {
                            echo'
                                <tr>
                                    <td><h4>'.$user['firstName'].' '.$user['lastName'].'<span>Added on '.date('d M, Y', strtotime( $user['date_added'])).'</span></h4></td>
                                    <td><p>'.$user['sector'].'</p></td>
                                    <td><p>'.$user['designation'].'</p></td>
                                    <td>
                                        <a href="#" class="action">View</a>
                                        <a href="#" class="action">Delete</a>
                                    </td>
                                </tr>
                            ';
                            # code...
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