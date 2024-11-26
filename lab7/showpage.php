<?php

function PokazPodstrone($id, $link) {
    // Ensure $id is sanitized to prevent SQL injection
    $id_clear = mysqli_real_escape_string($link, htmlspecialchars($id));

    // Query to fetch the page content
    $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
    $result = mysqli_query($link, $query);

    // Check if the query succeeded
    if (!$result) {
        die('Query failed: ' . mysqli_error($link));
    }

    $row = mysqli_fetch_array($result);

    // Handle page not found or content retrieval
    if (empty($row['id'])) {
        $web = '[nie_znaleziono_strony]';
    } else {
        $web = $row['page_content'];
    }

    return $web;
}

?>
