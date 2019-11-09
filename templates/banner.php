<section class="container-fluid banner"<?php echo isset($bgImage) ? var_dump($bgImage) . ' style="background-image:url(' . $bgImage . ');"' : ''; ?>>
    <?php if (isset($title)) { ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1><?php echo $title; ?></h1>            
                </div>
            </div>
        </div>
    <?php } ?>
</section>