<html>
	<head>
		<!--CSS resources-->
		<link href="resources/mato/tools/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
		<link href="resources/mato/lib/animations/css/animations.css" type="text/css" rel="stylesheet" />
		<link href="resources/css/styles.css" type="text/css" rel="stylesheet" />
		
		<script type="text/javascript" language="javascript" src="resources/mato/tools/JQuery/jquery.min.js"></script>
		<script type="text/javascript" language="javascript" src="resources/mato/tools/bootstrap/js/bootstrap.min.js"></script>
		<!--Scripts from JMatt Library-->
		<script  type="text/javascript" language="javascript" src="resources/mato/lib/JMatt/global.js"></script>
		<script  type="text/javascript" language="javascript" src="resources/mato/lib/JMatt/modal.js"></script>
	
		<title>Course Allocation System</title>
	</head>
	<body>
		<div class="row" id="header">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				<img src="resources/img/funaab_logo.png" width="100px" height="auto"/>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<h1>Course Allocation System</h1>
				<h4><?php require('resources/php/config.php');
				echo (config::$department == "" ? "Unnamed Department" : config::$department.' Department')?></h4>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center" style="padding-top:30px">
			<span class="glyphicon glyphicon-repeat" style="color:white;font-size:30px;cursor:pointer" title="refresh" onclick="refresh()"></span>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="side-menu">
					<ul style="line-height:30px">
						<h2>Courses</h2>
								<button class="btn btn-default" id="add-new-course">
									<span class="glyphicon glyphicon-plus-sign"></span>  Add new course
								</button>
						<li id="all-courses">All Courses </li>
						<li id="100l-courses">100Level Courses</li>
						<li id="200l-courses">200Level Courses</li>
						<li id="300l-courses">300Level Courses</li>
						<li id="400l-courses">400Level Courses</li>
						<h2>Lecturers</h2>
						<button class="btn btn-default" id="add-new-lecturer">
									<span class="glyphicon glyphicon-plus-sign"></span>  Add new lecturer
								</button>
						<li  id="all-lecturers">All Lectures</li>
					</ul>
				</div>
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" id="main">
					<div id="main-inner">
						
					</div>
				</div>
			</div>
		</div>
	</body>
	<script  type="text/javascript" language="javascript" src="resources/js/js.js"></script>
	<script  type="text/javascript" language="javascript" src="resources/js/l.js"></script>
	<script  type="text/javascript" language="javascript" src="resources/js/c.js"></script>
	<script>
	//load all courses by default
		get_content('all-courses');
	</script>
</html>