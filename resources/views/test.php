<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Theme Simply Me</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    .bg-1 { 
        background-color: #1abc9c; /* Green */
        color: #ffffff;
    }
    .bg-2 { 
        background-color: #bebebe; /* Green */
        color: #ffffff;
    }
    .bg-3 { 
        background-color: #5c6ef8; /* Green */
        color: #ffffff;
    }
    .bg-4 { 
        background-color: #1d1d1d; /* Green */
        color: #ffffff;
    }
    .container-fluid {
    padding-top: 70px;
    padding-bottom: 70px;
    }
    .navbar {
    padding-top: 15px;
    padding-bottom: 15px;
    border: 0;
    border-radius: 0;
    margin-bottom: 0;
    font-size: 12px;
    letter-spacing: 5px;
    }
    body {
    font: 20px "Montserrat", sans-serif;
    line-height: 1.5;
    color: #f5f6f7;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
            </button>
            <a class="navbar-brand" href="#">TwistedLoveBox</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#blank">WHO</a></li>
            <li><a href="#">WHAT</a></li>
            <li><a href="#">WHERE</a></li>
          </ul>
        </div>
    </div>
</nav>
<div class="container-fluid bg-1 text-center">
    <h3>Who Am I?</h3>
    <img class="img-circle img-responsive" src="https://www.w3schools.com/bootstrap/bird150.jpg" alt="Bird" style="display:inline;">
    <h3>I'm an adventurer</h3>
</div>

<div id="blank" class="container-fluid bg-2 text-center"> 
    <h2>Love It Like This</h2>
    <p>Talk to the hand bethel.</p>
    <button class="btn btn-default btn-lg"><span class="glyphicon glyphicon-search"></span> SEARCH</button>
</div>

<div class="container-fluid bg-3 text-center">
  <h3>Where To Find Me?</h3>
  <p>Lorem ipsum..</p>
  <div class="row">
    <div class="col-sm-4">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor 
            incididunt ut labore et doloremagna aliqua.
        </p>
        <img class="img-responsive" src="https://www.w3schools.com/bootstrap/birds1.jpg" alt="Bird" style="width:100%">
    </div>
    <div class="col-sm-4">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor 
            incididunt ut labore et doloremagna aliqua.
        </p>
        <img class="img-responsive" src="https://www.w3schools.com/bootstrap/birds1.jpg" alt="Bird" style="width:100%">
    </div>
    <div class="col-sm-4">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor 
            incididunt ut labore et doloremagna aliqua.
        </p>
        <img class="img-responsive" src="https://www.w3schools.com/bootstrap/birds1.jpg" alt="Bird" style="width:100%">
    </div>
  </div>
</div>
<footer class="container-fluid bg-4 text-center">
  <p>Bootstrap Theme Made By <a href="https://www.w3schools.com">www.w3schools.com</a></p> 
</footer>
</body>
</html>