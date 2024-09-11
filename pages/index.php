<?php include '../includes/header.php'; ?>
<?php include '../includes/db.php'; ?>

<h1>Explore our Products</h1>
<?php

// Pagination settings
$limit = 6; // Number of products per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Sorting settings
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name';
$order = "ASC";
if ($sort_by == 'price_desc') {
    $order = "DESC";
}

// Fetch products
if (isset($_GET['category'])) {
    $category_id = $_GET['category'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY $sort_by $order LIMIT $start, $limit");
    $stmt->execute([$category_id]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY $sort_by $order LIMIT $start, $limit");
    $stmt->execute();
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch total products for pagination
$total_stmt = $pdo->prepare("SELECT COUNT(*) FROM products");
$total_stmt->execute();
$total_products = $total_stmt->fetchColumn();
$total_pages = ceil($total_products / $limit);
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <!-- Add categories and other filters here -->
            <h5>Categories</h5>
            <ul class="list-group">
            <li class="list-group-item"><a href="index.php">All Products</a></li>
            <?php
            $stmt = $pdo->query('SELECT * FROM categories');
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<li class="list-group-item"><a href="index.php?category=' . $row['id'] . '">' . $row['name'] . '</a></li>';
            }
            ?>
        </ul>
        </div>
        <div class="col-md-9">
        <div class="d-flex justify-content-between mb-3">
                <h2>Products</h2>
                <form method="GET" class="form-inline">
                    <label for="sort_by" class="mr-2">Sort by:</label>
                    <select name="sort_by" id="sort_by" class="form-control" onchange="this.form.submit()">
                        <option value="name" <?php echo $sort_by == 'name' ? 'selected' : ''; ?>>Name</option>
                        <option value="price" <?php echo $sort_by == 'price' ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_desc" <?php echo $sort_by == 'price_desc' ? 'selected' : ''; ?>>Price: High to Low</option>
                    </select>
                </form>
            </div>
            <div class="row">
                <?php foreach ($products as $row): ?>
                    <div class="col-md-4">
                        <div class="card">
                        <img src="/ecommerce/images/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
            
                            <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <p class="card-text"><?php echo $row['description']; ?></p>
                                <p class="card-text">Ksh.<?php echo $row['price']; ?></p>
                                <a href="product.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Product</a>
                            </div>
                        </div>
                        </div>
                <?php endforeach; ?>
            </div>
            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&sort_by=<?php echo $sort_by; ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&sort_by=<?php echo $sort_by; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo $page == $total_pages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&sort_by=<?php echo $sort_by; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>


<?php include '../includes/footer.php'; ?>
