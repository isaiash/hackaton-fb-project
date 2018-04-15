<?php
	session_start();

	if (!isset($_SESSION['access_token'])) {
		header('Location: login.php');
		exit();
	}
?>


<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css"> 
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img style="max-width:220px; margin-top: 12px; margin-left: 80px;" src="img/logo_name_white.png">
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" role="form">
    <div class="checkbox">
 		<label class="text-primary"><input  type="checkbox" value="">Help</label>
    </div>
    <div class="checkbox">
  		<label class="text-primary"><input type="checkbox" value="">entertainment</label>
    </div>

            <button type="submit" class="btn btn-success">Accept</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Acá va el mapa</h1>
        
      </div>
    </div>

   
   <nav class="navbar navbar-fixed-bottom navbar-inverse " role="navigation">
      <div class="container">
        <div class="navbar-header">
        	 <div class="col-md-4 text-center">
				<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalNorm">
				<a href="#">
					<span class="glyphicon glyphicon-plus" style="color:white"></span>
				</a>
				</button>
			</div>    

        </div>

      </div>
    </nav>

<!-- 
<img src= "<?php echo $_SESSION['userData']['picture']['url'] ?>">  -->










<!-- Modal -->
<div class="modal fade" id="myModalNorm" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    New event
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                
                <form role="form">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name of group</label>
                      <input type="email" class="form-control"
                      id="exampleInputEmail1" placeholder="Enter email"/>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Limit</label>
                      <input type="password" class="form-control"
                          id="exampleInputPassword1" placeholder="Password"/>
                  </div>
                  <div class="checkbox">
                    <label>
                        <input type="checkbox"/> Visible location
                    </label>
                  </div>
                  
                </form>
                
                
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" class="btn btn-primary">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>






        
      








        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>
    </body>
</html>
