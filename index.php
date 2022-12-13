<?php
include('layout/header.php');

$ProductsController = new ProductsController();
$data = $ProductsController->get();

if (isset($_POST["bulk_delete"])) {
    if (isset($_POST['delete'])) {
        $ProductsController->delete($_POST['delete']);
    }
}
?>
<main class="main">
    <div class="container-fluid px-0">
        <div class="content">
            <div class="">
                <div class="row g-3 mb-4">
                    <div class="col-auto">
                        <h2 class="mb-0">Products</h2>
                    </div>
                </div>
                <form method="post" action="">
                    <div id="products">
                        <div class="mb-4">
                            <div class="row g-3 px-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <input type="submit" value="MASS DELETE" class="btn btn-danger" name="bulk_delete">
                                    <a href="add-product.php" class="btn btn-primary">ADD</a>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white border-top border-bottom px-4 px-lg-6">
                            <div class="table-responsive ps-4">
                                <table class="table fs--1 mb-0">
                                    <thead>
                                        <tr>
                                            <th class="white-space-nowrap fs--1 align-middle">
                                                <div class="form-check mb-0 fs-0">
                                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                                </div>
                                            </th>
                                            <th class="sort white-space-nowrap align-middle" scope="col">ID</th>
                                            <th class="sort white-space-nowrap align-middle ps-4" scope="col">SKU</th>
                                            <th class="sort white-space-nowrap align-middle ps-4" scope="col">PRODUCT NAME</th>
                                            <th class="sort align-middle text-end ps-4" scope="col">PRICE</th>
                                            <th class="sort align-middle ps-4" scope="col">CATEGORY</th>
                                            <th class="sort align-middle ps-3" scope="col">PROPERTIES</th>
                                            <th class="sort align-middle ps-4" scope="col">PUBLISHED ON</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        <?php if(!empty($data)): foreach ($data as $row) :?>
                                            <tr class="">
                                                <td class="fs--1 align-middle">
                                                    <div class="form-check mb-0 fs-0"><input class="checkbox form-check-input delete-checkbox" type="checkbox" name='delete[]' value='<?= $row['product_id']; ?>'></div>
                                                </td>
                                                <td class="id align-middle white-space-nowrap ps-4"><?= $row['product_id']; ?></td>
                                                <td class="sku align-middle white-space-nowrap ps-4"><?= $row['product_sku']; ?></td>
                                                <td class="product align-middle ps-4"><a class="text-decoration-none mb-0" href="#!"><?= $row['product_name']; ?></a></td>
                                                <td class="price align-middle white-space-nowrap text-end fw-bold ps-4">$<?= $row['product_price']; ?></td>
                                                <td class="category align-middle white-space-nowrap text-600 fs--1 ps-4"><?= $row['producttype_name']; ?></td>
                                                <td class="attributes align-middle pb-2 ps-4">
                                                    <span class="badge badge-tag mb-2">
                                                        <?php if (!empty($row['dvd_size'])) : ?>
                                                            Size: <?= $row['dvd_size']; ?>MB
                                                        <?php endif; ?>
                                                        <?php if (!empty($row['book_weight'])) : ?>
                                                            Weight: <?= $row['book_weight']; ?>kg
                                                        <?php endif; ?>
                                                        <?php if (!empty($row['furniture_width']) && !empty($row['furniture_height']) && !empty($row['furniture_length'])) : ?>
                                                            Dimensions HxWxL: <?= $row['furniture_height']; ?>x<?= $row['furniture_width']; ?>x<?= $row['furniture_length']; ?>
                                                        <?php endif; ?>
                                                    </span>
                                                </td>
                                                <td class="time align-middle white-space-nowrap text-600 ps-4"><?= date('d-M-Y H:i:s', strtotime($row['product_created'])); ?></td>
                                            </tr>
                                        <?php endforeach;?>
                                        <?php else: ?>  
                                            <tr class="">
                                                <td colspan=7>No records to show.</td>
                                            </tr>
                                        <?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include('layout/footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#selectAll').on('click', function() {
            if (this.checked) {
                $('.checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
        $('.checkbox').on('click', function() {
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $('#selectAll').prop('checked', true);
            } else {
                $('#selectAll').prop('checked', false);
            }
        });
    });
</script>