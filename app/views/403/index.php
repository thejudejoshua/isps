<?php
    $title = 'Error 403';
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <section class="content">
            <div class="full-width v70h text-align-center d-flex flex-column justify-content-center">
                <p class="h0">403</p><p class="h3">ACCESS DENIED</p><br/><p class="h4 notice">You do not have the access to view this page.</br> Click <a href="<?=$_SERVER['HTTP_REFERER']?>">here</a> to return to your access level working link</p>
            </div>
        </section>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>