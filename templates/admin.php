<?php
    $controller = new Controller();
?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <h2><?php echo isset($type) ? $type : ''; ?></h2>
    <a class="btn btn-dark" href="<?php echo isset($url) ? BASE_URL . $url . '.php?action=new' : ''; ?>">Nieuw <?php echo isset($singular) ? $singular : ''; ?></a>
</div>
<?php if (isset($tableHeaders) && isset($url) && isset($type)) { ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <?php
                    foreach ($tableHeaders as $tableHeader) {
                        ?>
                        <th scope="col"><?php echo $tableHeader; ?></th>
                        <?php
                    }
                ?>
                <th class="text-center" scope="col">Acties</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    $data = array();
                    switch ($type) {
                        case "Recepten":
                            $data = $controller->getRecipes(-1, 2147483647); //2147483647 is max limit for int on PHP 32 bit, but this should probably be changed
                            break;
                        case "Ingrediënten":
                            $data = $controller->getIngredients();
                            break;
                        case "Categorieën":
                            $data = $controller->getCategories();
                            break;
                    }

                    if (!empty($data)) {
                        foreach ($data as $row) {
                            $arrRow = (array)$row;
                            array_shift($arrRow); //Remove first key from array to not show ID
                            if ($type === "Ingrediënten" || $type === "Categorieën") {
                                array_pop($arrRow);
                                if ($type === "Ingrediënten") {
                                    array_pop($arrRow);
                                }
                            }
                            ?>
                            <tr>
                                <?php
                                    foreach ($arrRow as $value) {
                                        if (!is_array($value)) {
                                            ?>
                                                <td><?php echo $value; ?></td>
                                            <?php
                                        }
                                    }
                                ?>
                                <td align="center">
                                    <a href="<?php echo BASE_URL . $url; ?>.php?action=edit&id=<?php echo $row->ID; ?>" class="text-primary"><i class="fa fa-fw fa-edit"></i></a> |
                                    <a href="<?php echo ADMIN_URL; ?>?action=delete&id=<?php echo $row->ID; ?>&type=<?php echo $type; ?>" class="text-danger" onclick="return confirm('Weet je zeker dat je dit wilt verwijderen?');"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
<?php } ?>