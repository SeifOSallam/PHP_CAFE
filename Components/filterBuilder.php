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
function buildQueryStringWithOrder() {
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
    if (isset($_GET['order'])) {
        $queryString .= "&order=" . $_GET['order'];
    }
    return $queryString;
}
function buildQueryStringWithCheck() {
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
    if (isset($_GET['check'])) {
        $queryString .= "&check=" . $_GET['check'];
    }
    return $queryString;
}
?>