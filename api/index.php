<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    if (!isset($_SESSION['voter_id'])) {
        header('Location: signup.php');
        exit; 
    }
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote For Climatic Youth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            margin: 16px;
            box-shadow: 2px 2px 12px #aaa;
        }
        .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }
    </style>
</head>
<body>
<?php


$url = 'https://vote-point.vercel.app/api/candidates';

// Fetch the data using cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit;
}

curl_close($ch);

// Decode the JSON response
$data = json_decode($response, true);
echo '<div class="container">';
// Check if data is an array
if (is_array($data)) {
    // Loop through the data and create HTML cards
    echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
    foreach ($data as $item) {
        echo '<div class="col">';
        echo '<div class="card">';
        echo '<img src="' . htmlspecialchars($item['image']) . '" alt="Card image cap" class="bd-placeholder-img card-img-top" width="100%">';
        echo '<div class="card-body">';
        echo '<h3 class="card-text">' . htmlspecialchars($item['name']) . '</h3>';
        // echo '<p>' . htmlspecialchars($item['description']) . '</p>'; 
        echo '<form method="post" action="vote.php">';
        echo '<input type="hidden" name="candidate_id" value="' . htmlspecialchars($item['_id']) . '">';
        echo '<div class="text-center"><button type="submit" class="btn btn-success">Vote Me</button></div>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';  // Closing the col div
    }
    echo '</div>';  // Closing the row div
}

else {
    echo 'No data found or invalid data format.';
}
echo '</div>'; 
?>

</body>
   
</html>