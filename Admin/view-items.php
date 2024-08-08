<?php 
    include_once 'components/connection.php';
    session_start();

    // Handle item deletion
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['item_id'])) {
        $id = intval($_GET['item_id']);
        
        try {
            $sql = "DELETE FROM `items` WHERE item_id = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            
            echo "<script>alert('Item deleted.');</script>";
            echo "<script>window.location.href='view-items.php'</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }

    // Pagination variables
    $items_per_page = 5;
    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($current_page - 1) * $items_per_page;

    // Get total number of items
    $sql = "SELECT COUNT(*) FROM items";
    $query = $conn->prepare($sql);
    $query->execute();
    $total_items = $query->fetchColumn();
    $total_pages = ceil($total_items / $items_per_page);

    // Fetch items for the current page
    $sql = "SELECT * FROM items LIMIT :offset, :items_per_page";
    $query = $conn->prepare($sql);
    $query->bindParam(':offset', $offset, PDO::PARAM_INT);
    $query->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Cakery</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="css/jquery-ui.css"> 
<!-- Fonts -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!-- Icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
</head> 

<body> 
    <div class="dashboard-container">
        <?php include 'components/sidemenu.php'?>
        <div class="dashboard-container2">
            <?php include 'components/header.php'?>

            <!-- breadcrumb -->
            <nav aria-label="breadcrumb" class="bd">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Items</li>
                </ol>
            </nav>
            <!-- breadcrumb -->

            <div class="main-container">
                <div class="user-container">
					<h2 style="text-align: center;">View Items</h2>
					<table>
						<thead>
							<tr>
							<th>Sr.</th>
							<th>Item name</th>
							<th>Desciption</th>
							<th>Image</th>
							<th>Quantity</th>
							<th>Weight</th>
							<th>Price</th>
							<th>Category</th>
                            <th>Actions</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$cnt = $offset + 1;
						if ($query->rowCount() > 0) {
							foreach ($results as $result) { ?>
								<tr>
									<td><?php echo htmlentities($cnt);?></td>
									<td><?php echo htmlentities($result->item_name);?></td>
									<td><?php echo htmlentities($result->item_des);?></td>
                                    <td><img src="../Admin/item-images/<?php echo htmlspecialchars($result->item_img); ?>" alt="Item Image" style="width: 100px;"></td>
                                    <td><?php echo htmlentities($result->quantity);?></td>
									<td><?php echo htmlentities($result->weight);?></td>
									<td><?php echo htmlentities($result->price);?></td>
									<td><?php echo htmlentities($result->category_id);?></td>
									<td>
										<a href="update-item.php?item_id=<?php echo htmlentities($result->item_id);?>">Edit</a> <span>/</span>
										<a href="view-items.php?action=delete&&item_id=<?php echo htmlentities($result->item_id)?>" onclick="return confirm('Do you really want to delete?')">Delete</a>
									</td>
								</tr>
						<?php $cnt++; } } ?>
						</tbody>
					</table>
				</div>

                <!-- Pagination -->
                <div class="pagination">
                    <?php if($current_page > 1): ?>
                        <a href="?page=<?php echo $current_page - 1; ?>">&laquo; Previous</a>
                    <?php endif; ?>

                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $current_page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>

                    <?php if($current_page < $total_pages): ?>
                        <a href="?page=<?php echo $current_page + 1; ?>">Next &raquo;</a>
                    <?php endif; ?>
                </div>
                <!-- End Pagination -->
            </div>
        <div>
    </div>        
</body>

</html>
