<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Register</title>
</head>
<body>
<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Register as voter</p>

                <form class="mx-1 mx-md-4" method="post">

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="form3Example1c" name="emailorphone" class="form-control" required minlength="10" />
                      <label class="form-label" for="form3Example1c">Your Email or Phone number</label>
                    </div>
                  </div>

                  <div class="form-check d-flex justify-content-center mb-5">
                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" required />
                    <label class="form-check-label" for="form2Example3c">
                      I agree to all statements in <a href="#!">Terms of service</a>
                    </label>
                  </div>

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="submit" name="submit" class="btn btn-success btn-lg">Continue</button>
                  </div>

                </form>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                <img src="https://i.ibb.co/m4wPTGh/undraw-election-day-w842-1.png"
                  class="img-fluid" alt="Sample image">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

</body>
</html>

<?php 
// Start session 
session_start();

if (isset($_POST['submit'])) {

    $emailorphone = $_POST['emailorphone'];

    // Prepare data to send via cURL
    // $data = array(
    //     "emailorPhone" => $emailorphone
    // );
    $jsonData = json_encode(['emailorPhone' => $emailorphone]);
    
    $url = 'https://vote-point.vercel.app/api/voters/register';

    // Initialize cURL session
    $ch = curl_init($url);

    // Configure cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        echo 'cURL Error: ' . curl_error($ch);
    } else {
        // Handle the response as needed
        echo 'Response: ' . $response;
        // Save session 
        $_SESSION['emailorphone'] = $emailorphone;

        // Redirect to the success page
        $responseData = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            // Extract the voter ID from the response
            if (isset($responseData['_id'])) {
                $voter_id = $responseData['_id'];
                $_SESSION['voter_id'] = $voter_id;
                header('Location: index.php');
                exit; // Ensure no further code is executed after redirection
            } else {
                echo 'Error: Voter ID not found in response';
            }
        } else {
            echo 'Error: Unable to parse JSON response';
        }
    }

    // Close cURL session
    curl_close($ch);
}
?>
