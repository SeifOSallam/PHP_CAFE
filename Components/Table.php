<?php
function display_in_table($rows, $columnNames, $numColumns, $filterKeys, $delete_url, $edit_url){
    echo "<table class='table'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>";
    foreach ($columnNames as $columnName) {
        echo "<th scope='col'>{$columnName}</th>";
    }
    echo "<th scope='col'>Edit</th><th scope='col'>Delete</th></tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($rows as $row){
        echo "<tr>";
        $id = $row['id'];
        $delete_url_temp = "{$delete_url}?id={$id}&action=delete";
        $edit_url_temp = "{$edit_url}?id={$id}&action=edit";
        
        foreach ($row as $key => $value){
            if (!in_array($key, $filterKeys)) {
                if ($key === "image") {
                    echo "<td><img width='100' height='100' src='../assets/images/{$value}'></td>";
                } else {
                    echo "<td>{$value}</td>";
                }
            }
        }
        echo "<td><a href='{$edit_url_temp}' class='btn btn-warning'>Edit</a></td>";
        echo "<td><a href='{$delete_url_temp}' class='btn btn-danger'>Delete</a></td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
}
?>
