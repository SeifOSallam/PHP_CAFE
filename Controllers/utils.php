<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<?php

function display_table($rows){

    echo "<table class='table'> <tr> <th>Name</th> <th>Room Number</th> <th>Image</th> <th>Edit</th> <th>Delete</th> </tr>";
    foreach ($rows as $row){
        $user_id = $row['id'];
        $delete_url = "delete_user.php?id={$user_id}";
        $edit_url = "update_form.php?id={$user_id}";

        echo "<tr>";
        
        echo "<td>".$row['username']."</td>";
        echo "<td>".$row['room_id']."</td>";
        echo "<td><img src='../assets/".$row['image']."' style='max-width: 100px; max-height: 100px;' /></td>";
        echo "<td><a href='{$edit_url}' class='btn btn-warning'>Edit</a></td>";
        echo "<td><a href='{$delete_url}' class='btn btn-danger'>Delete</a></td>";
        
        echo "</tr>";
    }
    echo "</table>";

}
?>

