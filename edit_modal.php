<div class="modal fade" id="editModal<?= $row->product_id ?>" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <input type="hidden" value="<?= $row->product_id ?>" name="product_id">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Product Name" name="product_name" value="<?= $row->product_name ?>">
                    </div>
                    <div class="mb-3">
                        <select class="form-select" aria-label="Default select example" name="category">
                            <option selected disabled>Open this category menu</option>
                            <?php
                            foreach ($category_list as $gategory) {
                            ?>
                                <option value="<?= $gategory->category_id  ?>"><?= $gategory->category_name ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control" placeholder="Price" name="price" value="<?= $row->price ?>">
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control" placeholder="Quantity" name="quantity" value="<?= $row->quantity ?>">
                    </div>
                    <div class="mb-3">
                        <input type="Date" class="form-control" placeholder="Date Purchased" name="created_at" value="<?= $row->created_at ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="edit_product">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>