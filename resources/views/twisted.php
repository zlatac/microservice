<!DOCTYPE html>
<html lang="en">
<head>
  <title>TwistedLoveBox</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#f42424">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
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
        background-image: radial-gradient(circle farthest-side at center bottom, #ff3b3b, #a70000 125%);
        background-color: #ff3b3b;
        }
      .bg-1 {
          background-color: #f7f7f9;
      }
      .nav-white {
          color: #ffffff !important;
      }
      .bg-2 {
        background-image: radial-gradient(circle farthest-side at center bottom, #ff3b3b, #a70000 125%);
        background-color: #ff3b3b;
      }
      .allwhite,.home {
         color: white; 
      }
      .sizeup {
         font-size: 200px;
         color: rgba(255, 190, 0, 0.67);
      }
      .home {
          background: url(https://images.pexels.com/photos/42389/pexels-photo-42389-large.jpeg) no-repeat center center fixed;
          background-size: cover;
          background-color: #fff;
      }
      .btn-white {
          color: #fff;
          background-color: rgba(255, 255, 255, 0);
          border-color: #fff;
      }
      .btn-white:hover {
         background-color: rgba(255, 69, 69, 0.46);
         color: #fff;
      }
      #paynow, #upload_complete { 
        border: 1px solid #3c763d;
        padding-bottom: 23px;
        background-color: #fff;
      }
      #success {
         background-color: #929292;
         color: #fff;
         background: url(https://images.pexels.com/photos/157879/gift-jeans-fashion-pack-157879-large.jpeg) no-repeat center center fixed;
          background-size: cover;
          font-size: x-large;
    
      }
      #rules,#about,.med-font {
          font-size: medium;
      }
      .icon-bar{
          background-color: #fff !important;
      }
      #rules {
          border-top: 3px solid #f42424;
      }
      #send {
          border-top: 3px solid #fdd152;
      }
    
  </style>
</head>
<body ng-app="app">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                </button>
                <a class="nav-white navbar-brand" href="#"><span class="glyphicon glyphicon-gift"></span> TwistedLoveBox</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav navbar-right">
                <li><a class="nav-white" href="#about">About</a></li>
                <li><a class="nav-white" href="#rules">Rules</a></li>
                <li><a class="nav-white" href="#send">Send Gift</a></li>
                <li><a class="nav-white" href="#contact">Contact</a></li>
              </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid text-center home">
        <h2 ng-controller="control_love" ng-mouseover="hey()" ng-cloak>Share The Love {{bad}}</h2>
        <div boo></div>
        <a href="#send"><button class="btn btn-white">START</button></a>
    </div> 
    <div class="container-fluid text-center" id="about">
        <h2>ABOUT</h2>
        <p>"Friends are the siblings God never gave us."</p>
        <p>- Mensius</p>
        <p>We believe in friendships, love and physical connections. 
            Our mission is to connect the world one gift at a time.</p>
        <p>Stay connected with loved ones near and far with your creativity.</p>
    </div>
    <!--Message Form-->
    <div class="container-fluid bg-1" id="send">
       <h2 class="col-sm-12 text-center">Send Your Gift</h2>
       <div class="col-sm-4 text-center med-font">
           <span class="glyphicon glyphicon-gift sizeup"></span>
            <p>$10 (Free shipping)</p>
            <p>Reaction - PRICELESS</p>
       </div>
       <div class="col-sm-6" ng-controller="control_love">
            <form id="deez" enctype="multipart/form-data">
              <div class="form-group">
                <label for="usr">Receiver's Name:</label>
                <input type="text" class="form-control" name="rname" required>
              </div>
              <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="usr">Receiver's Address:</label>
                    <input type="text" class="form-control" id="email" name="address" required>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                  </div>
                  <div class="form-group col-sm-3 col-xs-6">
                    <label for="usr">City:</label>
                    <input type="text" class="form-control" id="email" name="city" required>
                  </div>
                  <div class="form-group col-sm-3 col-xs-6">
                    <label for="usr">Province:</label>
                    <select class="form-control" id="sel1" name="province">
                        <option>AB</option>
                        <option>BC</option>
                        <option>MB</option>
                        <option>NB</option>
                        <option>NL</option>
                        <option>NS</option>
                        <option>NT</option>
                        <option>NU</option>
                        <option selected>ON</option>
                        <option>QC</option>
                        <option>SK</option>
                        <option>YT</option>                        
                    </select>
                  </div>
              </div>
              <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="email">Sender's Email:</label>
                    <input type="email" class="form-control" id="pwd" name="email" ng-model="s_email" required>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="exampleInputFile">Upload Image:</label>
                    <input type="file" class="form-control" id="exampleInputFile" name="imgfile" required>
                  </div>
              </div>
              <div class="row">
                  
                  <div class="form-group col-sm-6">
                    <label for="exampleInputFile">Message:</label>
                    <select class="form-control" name="msg" id="msg" ng-model="msgVal" ng-change="showMsg(msgVal)">
                        <option ng-repeat="x in Msg">{{x}}</option>
                    </select>
                  </div>
                  <div class="form-group hide col-sm-6" id="custom">
                    <label for="comment">Custom Message:</label>
                    <textarea class="form-control" rows="2" id="pwd" name="msgcustom"></textarea>
                  </div>
                  <div class="form-group col-sm-6">
                        <label for="discount">Discount Code (Optional):</label>
                        <input type="text" class="form-control" id="discount" name="discount" ng-model="discount_code">
                  </div>
              </div>
             <span class="btn btn-default btn-primary pull-right" ng-click="contact('deez')">SUBMIT</span>
              
           </form>
           <div class="payment text-center hide" id="paynow">
<!--                <img src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_cc_144x47.png" alt="Pay Now">-->
               <h3 class="text-success">Next Step... <span class="glyphicon glyphicon-ok-circle"></span></h3>
               <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" id="pal">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="9Y4ZQGVYGAYWC">
                    <input type="hidden" name="address_override" value="1">
                    <input type="hidden" name="email" value="{{s_email}}">
                    <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_cc_144x47.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
               </form>

           </div>
           <div class="text-center hide" id="upload_complete">
               <h3 class="text-success">Upload Complete <i class="glyphicon glyphicon-ok-circle"></i></h3>
               <h3 class="text-success">You don't have to pay Moti <i class="glyphicon glyphicon-heart-empty"></i></h3>
        
           </div>
       </div>
    </div>
    <!--Rules-->
    <div class="container-fluid" id="rules">
        <div class="col-sm-8 med-font">
            <h2 class="">RULES</h2>
            <p>Be creative and wild with your pictures.</p>
            <p>The sender's face must be in the picture you upload so the receiver truly knows who sent the gift.</p>
            <p>No sexually explicit pictures.</p>
        </div>
        <div class="col-sm-4 text-center">
            <span class="glyphicon glyphicon-send sizeup"></span>
        </div>        
    </div>
    <!--SUCCESS-->
    <div class="container-fluid text-center" id="success">
        <h2><span class="glyphicon glyphicon-envelope"></span></h2> 
        <p>2 - 3 business days for processing and shipping.</p>
    </div> 
    <!--Contact-->
    <div ng-controller="control_love" class="container-fluid bg-2 allwhite" id="contact">
        <h2 class="text-center">CONTACT</h2>
        <div class="col-sm-6 col-sm-offset-3">
            <form action="/mail" id="talktome" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="usr">Name:</label>
                <input type="text" class="form-control" name="name" ng-model="form.name" required>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" ng-init="form._token = '<?php echo csrf_token(); ?>'"/>
              </div>
              
              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" ng-model="form.email" required>
              </div>
              <div class="form-group">
                <label for="comment">Message:</label>
                <textarea class="form-control" rows="2" name="message" required ng-model="form.message"></textarea>
              </div>
                <span ng-click="contact('talktome')" class="btn btn-white pull-right">SEND</span>
            </form>
       </div>
    </div>

<script>
$(document).ready(function(){
  // Add scrollspy to <body>
  $('body').scrollspy({target: ".navbar", offset: 50});   

  // Add smooth scrolling on all links inside the navbar
  $("#myNavbar a").on('click', function(event) {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
          // Prevent default anchor click behavior
          event.preventDefault();

          // Store hash
          var hash = this.hash;

          // Using jQuery's animate() method to add smooth page scroll
          // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
          $('html, body').animate({
            scrollTop: $(hash).offset().top
          }, 800, function(){

            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
          });
        }  // End if
      });
        
});


//ANGULAR JS MIGRATION
var myapp = angular.module('app',[]);

var ctrl = myapp.controller('control_love',['$scope','$http','confirm_it','post_it',function($scope,$http,confirm_it,post_it){
    $scope.greeting = "Now";
    $scope.bad = "";
    $scope.hey = function(){this.bad = this.greeting;}
    $scope.form = {};
    $scope.discount =  null;
    $scope.showMsg = function custom_msg(opt){

           let custom = angular.element(document.querySelector("#custom"));
           let custom_val = angular.element(document.querySelector("#custom textarea[name='msgcustom']"));
           if(opt == "*Custom message*"){
               custom.addClass("show");
               custom.removeClass("hide");
            } else{
               custom.addClass("hide");
               custom.removeClass("show");
               custom_val.val("");
             }
    };
    $scope.Msg = ['With all my heart','Straight from the heart.','I thought of you today.','You deserve this.',
                  'For all the times you\'ve been by my side, here is a token to say thank you.',
                  'Because words are not enough to express how I feel about you.','*Custom message*'
                 ];
    $scope.contact = function(id){
        //This function submits gift data and contact us info
        //id is the form id we are submitting
        //url is the api handling the form on the server
        console.log($scope.form);
        let textarea = '';
        //Set visual confirmation data for the form being submitted
        switch(id){
            case 'talktome':
                textarea = ',#'+id+' textarea';
                var btn_msg = 'Sending...';
                var url = 'mail';
                break;
            case 'deez':
                var btn_msg = 'Saving...';
                var url = 'form';
                break;
        }
        //Get the necessary input elements we want to validate and validate its not empty
        let z = document.querySelectorAll('#'+id+' input:not([type="hidden"])'+textarea);
        let a = 0;
        for(let i=0; i < z.length; i++){
            if(z[i].value == "" && z[i].name !== 'discount'){
                angular.element(z[i]).parent().addClass("has-error");
                angular.element(z[i]).attr("placeholder","Required");
                a++;
            } else{
                angular.element(z[i]).parent().removeClass("has-error");
              }
        }

        //When all data we need is provided we can begin Ajax POST calls
        if(a == 0 && $scope.discount !== 'motilovebox'){
            confirm_it("#" + id, btn_msg);
            z = angular.element(document.querySelectorAll('#'+id));
            z = new FormData(z[0]);
            post_it(url,z);
        }
        
           

    }
}]);

ctrl.factory('confirm_it',[function(){
    return function(a,b){
    //a is the html form Id we need
    //b is the message we want to display on the button
    var z = angular.element(document.querySelector(a + " span.btn"));
    z.addClass("btn-success");
    z.removeClass("btn-primary btn-white");
    z.html(b);
    }
}]);
    
ctrl.factory('post_it',['$http','confirm_it',function($http,confirm_it){
    return function(url,z){
        $http.post('/'+url, z, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        }).then(function(response){finale(response.data);console.log(response);});
        //$http.post('/mail', $scope.form).then(function(response){console.log(response);});
        
        function finale(result){
            if(result.toString() === "Insertion successful."){
                let discount = document.querySelector('input[name="discount"]').value;
                if(discount !== 'motilovebox'){
                    // if its not moti's discount code let them PAY
                angular.element(document.querySelector("#deez")).addClass("hide");
                angular.element(document.querySelector(".payment")).removeClass("hide");
                window.location = "#send";
                }else{
                    // when its MOTI she doesnt have to pay this time
                    angular.element(document.querySelector("#deez")).addClass("hide");
                    angular.element(document.querySelector("#upload_complete")).removeClass("hide");
                    window.location = "#send";
                }
            } else if(result.toString() === "Email sent"){
                btn_msg = 'SENT <span class="glyphicon glyphicon-ok"></span>';
                confirm_it("#contact",btn_msg);

              } else{
                    alert("Failed to save info. Sorry :(");
                }

        }
    }
}]);
    
</script>
</body>
</html>