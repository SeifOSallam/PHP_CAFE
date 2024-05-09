<?php

function paginate($currentPage, $totalPages, $buildQueryString) {
    if ($totalPages <= 1) {
        return;
    }
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
}


?>