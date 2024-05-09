<?php
function display_table($rows, $currentPage, $totalPages) {
 
    echo "<table class='table'>  
            <thead class='thead-dark'> 
                <tr> 
                    <th>Product</th> 
                    <th>Price</th> 
                    <th>Available</th> 
                    <th>Image</th>
                    <th>Edit</th> 
                    <th>Delete</th> 
                </tr>
            </thead>";

    foreach ($rows as $row) {
        $id = $row['id'];
        $delete_url_temp = "../Controllers/product.php?id={$id}&action=delete";
        $edit_url_temp = "productForm.php?id={$id}&action=edit";

        echo "<tr>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['price']."</td>";

        if($row['stock'] == 0) {
            echo "<td>Unavailable</td>";
        } else {
            echo "<td>".$row['stock']."</td>";
        }

        echo "<td><img src='../assets/".$row['image']."' style='max-width: 100px; max-height: 100px;' /></td>";
        echo "<td><a href='{$edit_url_temp}' class='btn btn-warning'>Edit</a></td>";
        echo "<td><a href='{$delete_url_temp}' class='btn btn-danger'>Delete</a></td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<nav aria-label='Page navigation example' class='d-flex justify-content-center'>
            <ul class='pagination'>";

    if ($currentPage > 1) {
        $firstLink = "?page=1";
        echo "<li class='page-item'><a class='page-link' href='$firstLink'>First</a></li>";
        $prevLink = "?page=".($currentPage - 1);
        echo "<li class='page-item'><a class='page-link' href='$prevLink'>Previous</a></li>";
    }
    
    for ($i = 1; $i <= $totalPages; $i++) {
        $pageLink = "?page=".$i;
        echo "<li class='page-item ".($currentPage == $i ? 'active' : '')."'><a class='page-link' href='$pageLink'>".$i."</a></li>";
    }
    
    if ($currentPage < $totalPages) {
        $nextLink = "?page=".($currentPage + 1);
        echo "<li class='page-item'><a class='page-link' href='$nextLink'>Next</a></li>";
        $lastLink = "?page=".$totalPages;
        echo "<li class='page-item'><a class='page-link' href='$lastLink'>Last</a></li>";
    }

    echo "</ul></nav>";
}
?>
