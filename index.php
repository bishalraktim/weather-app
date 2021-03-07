<?php
    $value = "";
    $display = "";
    $error = "";
    if(isset($_POST["city"]) && $_POST["city"] !== "") {
        $city = str_replace(" ", "", $_POST["city"]);
        $value = $_POST["city"];

        $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $error = "That city could not be found!";
        } else {
            $page = file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
            $first = explode('(1&ndash;3 days):</div><p class="location-summary__text"><span class="phrase">', $page);
           
            if(sizeof($first) > 1) {
                $second = explode("</span></p></div>", $first[1]);
                if(sizeof($second) > 1) {
                    $display = $second[0];
                } else {
                    $error = "Oh! that city could not be found!";
                }
            } else {
                $error = "Oh! that city could not be found!"; 
            }
        }
    } else {
        $error = "Sorry, that city could not be found!";
    }
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="weather.css">

    <title>Weather-App</title>
</head>

<body>
    <h1>What's The Weather?</h1>
    <h5>Enter the name of the city.</h5>

    <form id="reg" method="post">
        <div id="input">
            <input type="text" class="form-control shadow-none border border-#bbc0c4" placeholder="Melbourne" 
                name="city" value="<?php echo $value; ?>">
        </div>
        <div id="button">
            <button type="submit" class="btn btn-info shadow-none">Submit</button>
        </div>
    </form>

    <div>
        <?php 
            if($display) {
                echo '<div class="alerts alert alert-success" role="alert">'.$display.'</div>';
            } else {
                echo '<div class="alerts alert alert-danger" role="alert">'.$error.'</div>';
            }
        ?>
    </div>

    <!-- jQuery, Popper and Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF"
        crossorigin="anonymous"></script>

    <!-- JavaScript-->
    <script type="text/javascript" src="weather.js"></script>
</body>

</html>