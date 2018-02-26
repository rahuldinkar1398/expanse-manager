<?php
ob_start(); 
require("functions.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Expanse Tracking System</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link href="style.css" rel="stylesheet">

</head>
<body class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-app="app_expanse" ng-controller="ctrl_expanse">
<?php
$functions = new Functions();
if(@$_POST['add_record_form'])
	{
	  
	    $title=@$_POST['title'];
		$category=@$_POST['category'];
		$amount=@$_POST['amount'];
	    $db=$functions->add_record($title, $category, $amount);

	}
?>
	<div class="row navbar-inverse title-bar">
		<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
			<div class="row">
				<div class="col-xs-5 col-sm-6 col-md-6 col-lg-6 pad30">
					Expanse
				</div>
				<div class="col-xs-7 col-sm-6 col-md-6 col-lg-6 pad30" style="text-align: right;">
					<span ><span class="glyphicon glyphicon-user"></span> Rahul Dinkar</span>
				</div>
			</div>
		</div>
	</div>
	<div >
		<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2" >
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-3 col-md-push-9 col-lg-3 col-lg-push-9">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 widgets " data-toggle="modal" data-target="#myModal">
							<span class="glyphicon glyphicon-plus"></span> Add Expanse
						</div>
						<div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 widgets " ng-init="sumUpExpanse('all')">
							Total Expanse <br>  &#8377; {{total}}
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-8 col-md-pull-3 col-lg-8 col-lg-pull-3 ">
					<!-- <div class="row">
						<div class="col-xs-12 graph ">
							
						</div>
					</div> -->
					<div class="row">
						<div class="col-xs-12 table-expanse border">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-menu">
									<ul class="row">
										<li ng-click=sortTable("")><a href="#">All</a></li>
										<li ng-click=sortTable("entertainment")><a href="#">Entertainment</a></li>
										<li ng-click=sortTable("food")><a href="#">Food</a></li>
										<li ng-click=sortTable("grocery")><a href="#">Grocery</a></li>
										<li ng-click=sortTable("misc")><a href="#">Misc.</a></li>
									</ul>
								</div>
								<table class="table table-striped">
									<tr>
										<td><strong>Title</strong></td>
										<td><strong>Category</strong></td>
										<td><strong>Amount</strong></td>
										<td><strong>Date</strong></td>
									</tr>
									<tr ng-repeat=" x in expanse | filter: finder">
										<td>{{x.title}}</td>
										<td>{{x.category}}</td>
										<td>{{x.amount}}</td>
										<td>{{x.date}}</td>
									</tr>
									<tr  ng-if="(expanse | filter : finder).length < 1"><td colspan="4">Not any expanses.</td></tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- MODAL -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
    
			<div class="modal-content" style="border-radius: 0">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Expanse</h4>
				</div>
				<form method="post"  action="index.php">
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<input class="form-field col-xs-12" type="text" name="title" placeholder="Title" required>
								<select class="form-field col-xs-12 col-sm-6 col-md-5" name="category" required>
									<option disabled selected value="">Select Category</option>
									<option value="Entertainment">Entertainment</option>
									<option value="Food">Food</option>
									<option value="Grocery">Grocery</option>
									<option value="Vehicle">Vehicle</option>
									<option value="Misc">Miscellaneous</option>
								</select>
								<input class="form-field col-xs-12 col-sm-6 col-md-5 col-md-offset-2" type="number" name="amount" placeholder="Amount" required>
							</div>
						</div>
						<center></center>	
					</div>
					<div class="modal-footer">
						<input class="add-button " type="submit" name="add_record_form" value="Add">
					</div>
				</form>

			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	var app = angular.module('app_expanse', []);
	app.controller('ctrl_expanse', function($scope) {
		$scope.expanse = <?php echo $functions->display_expanse(); ?> ;
		expanse_array = $scope.expanse;

		$scope.sortTable= function(name){
			$scope.finder= name;
			if (name == "") {
				$scope.sumUpExpanse("all");
			} else {
				$scope.sumUpExpanse(name);
			}
			
		}

		$scope.sumUpExpanse= function(name){
			sum=0;
			for( var i =0; i<expanse_array.length; i++){
				if (expanse_array[i][2].toLowerCase()==name.toLowerCase() || name=="all") {
					sum+= parseInt(expanse_array[i][3]);
				}
			}
			$scope.total=sum;
		}

	});

</script>
