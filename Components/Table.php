<?php
function display_in_table($rows, $columnNames, $numColumns, $filterKeys, $delete_url, $edit_url, $currentPage, $totalPages){
    echo "<table class='table'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>";
    foreach ($columnNames as $columnName) {
        echo "<th scope='col'>{$columnName}</th>";
    }
    echo "<th scope='col'>Edit</th><th scope='col'>Delete</th></tr>";
    echo "</thead>";
    echo "<tbody>";

    if(isset($rows)){
        foreach ($rows as $row){
            echo "<tr>";
            $id = $row['id'];
            $delete_url_temp = "{$delete_url}?id={$id}&action=delete";
            $edit_url_temp = "{$edit_url}?id={$id}&action=edit";
          
            foreach ($row as $key => $value){
                if (!in_array($key, $filterKeys)) {
                    if ($key === "image") {
                        echo "<td><img width='100' height='100' src='../assets/{$value}'></td>";
                    } else {
                        echo "<td>{$value}</td>";
                    }
                }
            }
            echo "<td><a href='{$edit_url_temp}' class='btn btn-warning'>Edit</a></td>";
            echo "<td><a href='{$delete_url_temp}' class='btn btn-danger'>Delete</a></td>";
            echo "</tr>";

        }
    }

    echo "</tbody>";
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
    echo "</ul>
    </nav>";

}
?>
