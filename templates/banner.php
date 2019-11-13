<section class="container-fluid d-flex justify-content-center align-items-center mb-5 banner"<?php echo isset($bgImage) ? var_dump($bgImage) . ' style="background-image:url(' . $bgImage . ');"' : ''; ?>>
    <?php if (isset($title)) { ?>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="text-white"><?php echo $title; ?></h1>            
                </div>
            </div>
        </div>
    <?php } ?>
</section>