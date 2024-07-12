<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidate_id = $_POST['candidate_id'];
    $voter_id = $_SESSION['voter_id'];

    $url = 'https://vote-point.vercel.app/api/voters/vote';

    // $data = array(
    //     'voter_id' => $voter_id,
    //     'candidate_id' => $candidate_id
    // );
    // $jsonData = json_encode(['tool' => 'curl']);

    $data = json_encode(([
        'voterId' => $voter_id,
        'candidateId' => $candidate_id
    ]));

    $ch = curl_init($url);

    // Configure cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        echo 'Error: ' . curl_error($ch);
    } else {

        echo '<script> alert("Succesful voted")</script>';
        header('Location: index.php');
    }

    // Close cURL session
    curl_close($ch);
}
