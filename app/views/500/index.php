<?php
    $title = 'Error 500';
    require_once './includes/components/header.php';
?>

<div class="wrapper d-flex">
    <?php require_once './includes/components/sideNav.php';?>
    <div class="content-box">
        <?php require_once './includes/components/topNav.php';?>
        <section class="content content-box-body">
            <div class="full-width v70h text-align-center d-flex flex-column justify-content-center">
                <p class="h0">500</p><p class="h3">INTERNAL SERVER ERROR</p><br/><p class="p4 notice">The was a problem with the server. Don't worry it's not your fault. Click <a href="<?=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : explode('/', str_replace('-', ' ', filter_var(str_replace(' ', '-', rtrim($_GET['url'], '/')), FILTER_SANITIZE_URL)))[0]?>">here</a> to return to a working link. And if it persists, try again after a while.</p>
            </div>
        </section>
    </div>
</div>                

<?php
    require_once './includes/components/footer.php';
?>