<?php
    $title = 'Error 404';
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <?php require_once './includes/components/topNav.php';?>
        <section class="content content-box-body">
            <div class="full-width v70h text-align-center d-flex flex-column justify-content-center">
                <p class="h0">404</p><p class="h3">NOT FOUND</p><br/><p class="p4 notice">The requested resource could not be found. Click <a href="<?=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : explode('/', str_replace('-', ' ', filter_var(str_replace(' ', '-', rtrim($_GET['url'], '/')), FILTER_SANITIZE_URL)))[0]?>">here</a> to return to a working link</p>
            </div>
        </section>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>