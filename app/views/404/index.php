<?php
    $title = 'Error 404';
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <section class="content">
            <div class="full-width v70h text-align-center d-flex flex-column justify-content-center">
                <p class="h0">404</p><p class="h4 notice">The requested resource could not be found. Click <a href="/dashboard">here</a> to return to a working link</p>
            </div>
        </section>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>