<?php if (isset($recipe)) { ?>
<div class="col-12">
    <div class="card">
        <div class="d-flex flex-wrap">
            <div class="img-square-wrapper">
                <img class="" src="http://via.placeholder.com/100x100" alt="Card image cap">
            </div>
            <div class="card-body">
                <h4 class="card-title"><?php echo $recipe->title; ?></h4>
                <p class="card-text"><?php echo $recipe->description; ?></p>
            </div>
        </div>
    </div>
</div>
<?php } ?>