<?php
require_once('connection.php');

$newConnection->addProduct();
$newConnection->editProduct();
$newConnection->deleteProduct();
$newConnection->addCategory();
$newConnection->useLogout();
$products = $newConnection->getAllProducts();
$category_list =  $newConnection->listOfCategories();

if (isset($_POST['search_btn']) && !empty($_POST['search_input'])) {
    $products = $newConnection->searchProducts();
}

if (isset($_POST['filterDate_btn'])) {
    $products = $newConnection->filterByDate();
}

if (isset($_POST['filter_btn']) && !empty($_POST['filter_input'])) {
    $products = $newConnection->filterProducts();
}

if (!isset($_SESSION['name'])) {
    header('Location: login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">

    <title>Prelim</title>
</head>

<body>
    <div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addCategoryModalLabel">Add Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="category_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="add_category">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg bg-transparent">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white" href="#"><?= $_SESSION['name'] ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                Add Category
            </button>
            <form action="" method="post">
                <button type="submit" name="user_out" class="btn btn-success ms-5" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    Logout
                </button>
            </form>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                <form class="d-flex" role="search" action="" method="POST">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_input">
                    <button class="btn btn-success" type="submit" name="search_btn">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Product Name" name="product_name">
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
                            <input type="number" class="form-control" placeholder="Price" name="price">
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" placeholder="Quantity" name="quantity">
                        </div>
                        <div class="mb-3">
                            <input type="Date" class="form-control" placeholder="Date Purchased" name="created_at">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="add_product">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <?php
        if (isset($_SESSION["create"])) {
        ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION["create"];
                unset($_SESSION["create"]);
                ?>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-flex justify-content-between mt-2 mb-2">
        <div>
            <form action="" method="POST" class="d-flex align-items-center">
                <select class="form-select me-2" aria-label="Default select example" style="width: auto;" name="filter_input">
                    <option selected disabled>Filter Option</option>
                    <option value="All">All Products</option>
                    <?php
                    foreach ($category_list as $gategory) {
                    ?>
                        <option value="<?= $gategory->category_name ?>"><?= $gategory->category_name ?></option>
                    <?php
                    }
                    ?>
                    <option value="In Stock">In Stock</option>
                    <option value="Out Stock">Out Stock</option>
                </select>
                <button type="submit" class="btn btn-dark" name="filter_btn">Apply Filter</button>
            </form>
        </div>

        <form action="" method="POST" class="d-flex align-items-center gap-2">
            <div>
                <input type="text" class="form-control" id="emailInput1" placeholder="From" name="start_date">
            </div>
            <div>
                <input type="text" class="form-control" id="emailInput2" placeholder="To" name="end_date">
            </div>
            <button type="submit" class="btn btn-dark" name="filterDate_btn">Apply Date Range</button>
        </form>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fa-solid fa-bag-shopping"></i> Add Products
        </button>
    </div>

    <main class="container">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Product Id</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Date Purchase</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($products)) {
                    foreach ($products as $row) {
                ?>
                        <tr>
                            <th scope="row"><?= $row->product_id ?></th>
                            <td><?= $row->product_name ?></td>
                            <td><?= htmlspecialchars($newConnection->getCategoryNameById($row->category_id)) ?></td>
                            <td>₱ <?= $row->price ?></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked"
                                        <?php if ($row->quantity > 0) echo 'checked'; ?> disabled>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        <?php if ($row->quantity > 0): ?>
                                            In Stock <?= $row->quantity ?>x
                                        <?php else: ?>
                                            Out of Stock <?= $row->quantity ?>x
                                        <?php endif; ?>
                                    </label>
                                </div>

                            </td>
                            </td>
                            <td><?= $row->created_at ?></td>
                            <td class="d-flex gap-2 justify-content-center">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row->product_id ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                <form action="" method="POST">
                                    <button class="btn btn-danger" value="<?php echo $row->product_id ?>" name="delete_product"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                            <?php include('edit_modal.php') ?>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='8'>No products found.</td></tr>";
                }
                ?>

            </tbody>
        </table>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>