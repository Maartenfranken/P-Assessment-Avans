<h2>Categorieën</h2>
<div class="categories">
    <?php 
        $controller = new Controller();
        $categories = $controller->getCategories();
        if (!empty($categories)) { ?>
        <div class="list-group">
        <?php foreach ($categories as $category) { ?>
            <a href="" class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo $category->getName(); ?>
                <?php echo $category->getCount() > 0 ? '<span class="badge badge-primary badge-pill">' . $category->getCount() . '</span>': ''; ?>
            </a>
        <?php } ?>
        </ul>
        <?php 
        }
    ?>
</div>