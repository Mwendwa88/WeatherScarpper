<?php 

	$weather = "";
	$error = "";

	if(array_key_exists('city', $_GET)) {
		$city = str_replace(' ', '', $_GET['city']);
		$file_headers = @get_headers("https://www.weather-forecast.com/locations/" . 
                        $city . "/forecasts/latest");

		if($file_headers[0] == "HTTP/1.1 404 Not Found") {
            $error = "That city could not be found.";
		} 
		else{
			$forecastPage = file_get_contents("https://www.weather-forecast.com/locations/" . 
                            $city . "/forecasts/latest");

			$pageArray = 
               explode('Weather Today</h2> (1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">',
               $forecastPage);

			if(sizeof($pageArray) > 1) {
				$secondPageArray = explode('</span></p></td>', $pageArray[1]);

				if(sizeof($secondPageArray)> 1){
					$weather = $secondPageArray[0];
				}
				else{
					$error = "That city could not be found";
				}
		}
		else{
			$error = "That city could not be found";
			}

		}//end fileheaders are not empty! :)
	}
	else{
		$error = "That city could not be found";
	}//end of array key exists test
 ?>

 <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit= no">
	<meta http-equiv="x-ua-compatible"content="ie-edge" >
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" 
			integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css" type="text/css" >		
	<title>Weather Scrapper</title>
</head>
<body>
	<div class="container">
		<h1 class="label">Whats The Weather Where You Are!</h1>
		<form>
			<fieldset class="form-group">
				<label class="label" for="city">Enter Name Of City or Town.</label>
				<input  class="form-control" 
						type="text" 
						name="city" 
						id="city" 
						placeholder="E.g. Nairobi, Durban"
						value="<?php 
							if (array_key_exists('city' , $_GET)) {
								echo $_GET['city'];
							}
						 ?>">
				</fieldset>
				<button type="submit" class=" p-3 btn btn-warning">Submit</button>
		</form>

		<div id="weather">
			<?php 
				if ($weather) {
					echo '<div class="alert alert-success" role ="alert">'. $weather . '</div>';			
				} elseif ($error) {
					echo '<div class="alert alert-danger" role ="alert">'. $error . '</div>';
				}
			 ?>
		</div>
	</div> <!----endof div container-->


<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" 
		integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" 
		crossorigin="anonymous"></script>	
</body>
</html>