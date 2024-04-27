<?php
function buildQueryString() {
    $queryString = "";
    if (isset($_GET['user'])) {
        $queryString .= "&user=" . $_GET['user'];
    }
    if (isset($_GET['date_from'])) {
        $queryString .= "&date_from=" . $_GET['date_from'];
    }
    if (isset($_GET['date_to'])) {
        $queryString .= "&date_to=" . $_GET['date_to'];
    }
    return $queryString;
}
function displayChecksTable($data, $users, $currentPage, $totalPages){
    echo "<div class='container w-50 mx-auto mt-5'>";
    echo 
    "<form class='row'>
        <div class='col-lg-3 col-sm-6'>
            <select name='user' id='user' class='form-select'>
                <option selected value=''>All</option>";
                foreach($users as $user) {
                    echo "<option>{$user['username']}</option>";
                }
                echo "
            </select>
        </div>
        <div class='col-lg-3 col-sm-6 d-flex justify-content-center'>
            <label for='date_from'>From: </label>
            <input class='form-control' type='date' id='date_from' name='date_from'>
        </div>
        <div class='col-lg-3 col-sm-6 d-flex justify-content-center'>
            <label for='date_to'>To: </label>
            <input class='form-control' type='date' id='date_to' name='date_to'>
        </div>
        <div class='col-lg-3 col-sm-6'>
            <input class='btn btn-info' type='submit' value='Filter'>
        </div>

    </form>";
    echo "<table class='table table-striped'>";
    echo 
    "<tr>
        <th style='text-align: center;'>Name</th>
        <th style='text-align: center;'>Total Amount</th>
        <th></th>
    </tr>";
    foreach ($data as $check) {
        echo "<tr>";
        echo "<td style='text-align: center;'>{$check['username']}</td>";
        echo "<td style='text-align: center;'>{$check['total_amount']}</td>";
        echo "<td style='text-align: center;'>
        <a class='btn btn-info' href='/'>Details</a>
        </td>";
        echo "</tr>";
    }
    echo "</table>";

    // Pagination
    echo "<nav aria-label='Page navigation example' class='d-flex justify-content-center'>
        <ul class='pagination'>";
        if ($currentPage > 1) {
            $firstLink = "?page=1" . buildQueryString();
            echo "<li class='page-item'><a class='page-link' href='$firstLink'>First</a></li>";
            $prevLink = "?page=".($currentPage - 1) . buildQueryString();
            echo "<li class='page-item'><a class='page-link' href='$prevLink'>Previous</a></li>";
        }
        
        for ($i = 1; $i <= $totalPages; $i++) {
            $pageLink = "?page=".$i . buildQueryString();
            echo "<li class='page-item ".($currentPage == $i ? 'active' : '')."'><a class='page-link' href='$pageLink'>".$i."</a></li>";
        }
        
        if ($currentPage < $totalPages) {
            $nextLink = "?page=".($currentPage + 1) . buildQueryString();
            echo "<li class='page-item'><a class='page-link' href='$nextLink'>Next</a></li>";
            $lastLink = "?page=".$totalPages . buildQueryString();
            echo "<li class='page-item'><a class='page-link' href='$lastLink'>Last</a></li>";
        }
    echo "</ul>
    </nav>";
    echo "</div>";
}
function displayOrderTable() {
    // Function to display order table
}
?>
