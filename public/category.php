<?php
include 'header.php';
$controller = new Controller();
$categoryId = isset($_GET['id']) ? intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)) : '';
$category = !empty($categoryId) || $categoryId === 0 ? $controller->getCategoryById($categoryId) : '';
if (empty($category) || !$category || !$category instanceof Category) {
    header("Location: " . BASE_URL);
    die();
}
?>

<?php $controller->getTemplate('banner.php', array('title' => $category->getTitle(), 'bgImage' => IMAGE_PATH . 'banner-home.jpg')); ?>

    <section class="container">
        <div class="row">
            <div class="col-md-12 mb-4 text-center">
                <p><?php echo $category->getDescription(); ?></p>
            </div>
            <div class="col-md">
                <h2>Recepten</h2>
                <?php $controller->getTemplate('recipes.php', array('CategoryId' => $categoryId, 'count' => 10)); ?>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>