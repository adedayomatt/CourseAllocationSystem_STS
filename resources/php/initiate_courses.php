<?php
/*******************This part is to set up the database and the tables****************/
$_connection = mysqli_connect(config::$db_host,config::$db_user,config::$db_password);
$db_name = str_replace(array(' ',','),'_',config::$department);
	mysqli_select_db($_connection,config::$department);
if($_connection){
	$_create_db = mysqli_query($_connection,"CREATE DATABASE IF NOT EXISTS ".$db_name." DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci");
		
	if($_create_db){
		
	mysqli_select_db($_connection,config::$department);
	
	$_create_courses_table = mysqli_query($_connection,"CREATE TABLE `courses`
						   (`course_code` char(20) NOT NULL,
						  `course_title` char(255) NOT NULL,
						  `course_unit` int(1) NOT NULL,
						  `level` int(3) NOT NULL,
						  `course_scope` varchar(1000) NOT NULL,
						  `lecturer_in_charge` char(255) NOT NULL)
						ENGINE=InnoDB DEFAULT CHARSET=latin1;");
						
	
	$_add_course_primary_key = mysqli_query($_connection,"ALTER TABLE `courses` ADD PRIMARY KEY (`course_code`)");
		

	
	$_create_lecturer_table = mysqli_query($_connection,"CREATE TABLE `lecturer` 
							(`id` int(50) NOT NULL,
							  `title` char(10) NOT NULL,
							  `last_name` char(255) NOT NULL,
							  `initial` char(5) NOT NULL,
							  `specialization` char(255) NOT NULL)
							  ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Lecturer''s entity'");
	
	$_add_lecturer_primary_key = mysqli_query($_connection,"ALTER TABLE `lecturer` ADD PRIMARY KEY (`id`)");
	
	if(mysqli_num_rows(mysqli_query($_connection,"SELECT id FROM lecturer")) == 0){//if no lecturer record exist yet
//Add all lecturers initially
$lecturers = array(
				array('title' => 'Dr.','last_name' => 'Agwuegbo', 'initial' => 'S.O.N', 'specialization' => 'Stochastic Processes, Time Series Analysis'),
				array('title' => 'Prof.','last_name' => 'Asiribo', 'initial' => 'O.E', 'specialization' => 'Experimental Design, Biometry'),
				array('title' => 'Prof.','last_name' => 'Amahia', 'initial' => 'G.N', 'specialization' => 'Sample Survey, Statistical Inference'),
				array('title' => 'Prof.','last_name' => 'Adekeye', 'initial' => 'K.S', 'specialization' => 'Statistical Quality Control'),
				array('title' => 'Dr.','last_name' => 'Agunbiade', 'initial' => 'D.A', 'specialization' => 'Econometrics'),
				array('title' => 'Dr.','last_name' => 'Apantaku', 'initial' => 'F.S', 'specialization' => 'Sample Survey, Statistical Inference'),
				array('title' => 'Dr.','last_name' => 'Dawodu', 'initial' => 'G.A', 'specialization' => 'Statistical Modelling and Computing'),
				array('title' => 'Dr.','last_name' => 'Olayiwola', 'initial' => 'O.M', 'specialization' => 'Sample Survey, Statistical Inference'),
				array('title' => 'Dr.','last_name' => 'Akintunde', 'initial' => 'A.A', 'specialization' => 'Stochastic Processes, Time Series Analysis'),
				array('title' => 'Mrs.','last_name' => 'Wale-Orojo', 'initial' => 'O.A', 'specialization' => 'Experimental Design, Sample Survey'),
				array('title' => 'Mr.','last_name' => 'Yusuff', 'initial' => 'K.M', 'specialization' => 'Experimental Design and Analysis')
				);

	$_add_lecturer_stmt = mysqli_prepare($_connection,"INSERT INTO `lecturer` (`id`, `title`, `last_name`, `initial`, `specialization`) VALUES(?,?,?,?,?)");
							mysqli_stmt_bind_param($_add_lecturer_stmt, 'issss', $id,$title,$last_name,$initial,$spec);
		for($l = 0; $l< count($lecturers); $l++){
			$id = time() + rand(1000,9999);
			$title = $lecturers[$l]['title'];
			$last_name = $lecturers[$l]['last_name'];
			$initial = $lecturers[$l]['initial'];
			$spec = $lecturers[$l]['specialization'];
		mysqli_stmt_execute($_add_lecturer_stmt);
		}
	}

	if(mysqli_num_rows(mysqli_query($_connection,"SELECT course_code FROM courses")) == 0){//if no course exist yet	
//Add all courses initially
$courses = array(
		array('code' => 'STS 104','title' => 'Statistical Computing I','unit' => '2','level' => '100','scope' => 'Statistical Modelling and Computing','lecturer' => ''),
		array('code' => 'STS 112','title' => 'Statistical Inference I','unit' => '3','level' => '100','scope' => 'Statistical Inference','lecturer' => ''),
		array('code' => 'STS 122','title' => 'Basic Statistical Methods','unit' => '3','level' => '100','scope' => 'Statistical Modelling and Computing, Sample Survey, Statistical Inference','lecturer' => ''),
		array('code' => 'STS 192','title' => 'Laboratory for Statistical Inference','unit' => '1','level' => '100','scope' => 'Statistical Inference','lecturer' => ''),
	
		array('code' => 'STS 201','title' => 'Statistics for Agric. and Biological Sciences','unit' => '3','level' => '200','scope' => 'Sample Survey, Statistical Inference','lecturer' => ''),
		array('code' => 'STS 203','title' => 'Statistics for Physical Sciences and Engineering','unit' => '3','level' => '200','scope' => 'Sample Survey, Statistical Inference, Probability','lecturer' => ''),
		array('code' => 'STS 204','title' => 'Statistical Computing II','unit' => '2','level' => '200','scope' => 'Statistical Modelling and Computing','lecturer' => ''),
		array('code' => 'STS 211','title' => 'Probability II','unit' => '3','level' => '200','scope' => 'Probability','lecturer' => ''),
		array('code' => 'STS 212','title' => 'Statistical Inference II','unit' => '3','level' => '200','scope' => 'Statistical Inference','lecturer' => ''),
		array('code' => 'STS 213','title' => 'Distribution Theory I','unit' => '2','level' => '200','scope' => 'Distribution Theory','lecturer' => ''),
		array('code' => 'STS 214','title' => 'Socio-Econome=ic Statistics','unit' => '3','level' => '200','scope' => 'General Statistics','lecturer' => ''),
		array('code' => 'STS 215','title' => 'Biomteric Methods I','unit' => '2','level' => '200','scope' => 'Biometry','lecturer' => ''),
		array('code' => 'STS 292','title' => 'Statistical Inference Laboratory II','unit' => '2','level' => '200','scope' => 'Statistical Inference','lecturer' => ''),
		
		array('code' => 'STS 301','title' => 'Statistical Inference III','unit' => '3','level' => '300','scope' => 'Statistical Inference','lecturer' => ''),
		array('code' => 'STS 305','title' => 'Statistical Computing III','unit' => '2','level' => '300','scope' => 'Statistical Modelling and Computing','lecturer' => ''),
		array('code' => 'STS 317','title' => 'Survey Methods and Sampling Theory','unit' => '2','level' => '300','scope' => 'Sample Survey','lecturer' => ''),
		array('code' => 'STS 321','title' => 'Statistical Quality Control I','unit' => '2','level' => '300','scope' => 'Statistical Quality Control','lecturer' => ''),
		array('code' => 'STS 323','title' => 'Design and Analysis of Experiment I','unit' => '2','level' => '300','scope' => 'Experimental Design and Analysis','lecturer' => ''),
		array('code' => 'STS 325','title' => 'Regression Analysis and Analysis of Variance I','unit' => '2','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'STS 327','title' => 'Operations Research I','unit' => '2','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'STS 391','title' => 'Laboratory for Operations Research','unit' => '1','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'STS 329','title' => 'Theory of Games','unit' => '3','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'STS 337','title' => 'Linear Models','unit' => '3','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'STS 341','title' => 'Demography I','unit' => '3','level' => '300','scope' => 'Demography','lecturer' => ''),
		array('code' => 'STS 392','title' => 'Industrial Training and Field Work','unit' => '4','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'STS 394','title' => 'Inspection Visitation','unit' => '4','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'STS 396','title' => 'SIWES Report','unit' => '4','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'STS 398','title' => 'Seminar','unit' => '4','level' => '300','scope' => '','lecturer' => ''),
		
		array('code' => 'STS 411','title' => 'Probability Theory IV','unit' => '3','level' => '400','scope' => 'Probability','lecturer' => ''),
		array('code' => 'STS 413','title' => 'Distribution Theory II','unit' => '3','level' => '400','scope' => 'Distribution Theory','lecturer' => ''),
		array('code' => 'STS 423','title' => 'Design and Analysis of Experiment II','unit' => '3','level' => '400','scope' => 'Experimental Design and Analysis','lecturer' => ''),
		array('code' => 'STS 425','title' => 'Regression Analysis of Variance II','unit' => '3','level' => '400','scope' => 'Statistical Modelling and Computing','lecturer' => ''),
		array('code' => 'STS 461','title' => 'Stochastic Processes','unit' => '3','level' => '400','scope' => 'Stochastic Processes','lecturer' => ''),
		array('code' => 'STS 472','title' => 'Econometrics Methods','unit' => '3','level' => '400','scope' => 'Econometrics','lecturer' => ''),
		array('code' => 'STS 473','title' => 'Time Series Analysis','unit' => '3','level' => '400','scope' => 'Time Series Analysis','lecturer' => ''),
		array('code' => 'STS 493','title' => 'Laboratory for Design and Analysis of Experiments II','unit' => '1','level' => '400','scope' => 'Experimental Design','lecturer' => ''),
		array('code' => 'STS 495','title' => 'Laboratory for Regression Analysis and Analysis of Variance','unit' => '3','level' => '400','scope' => 'Statistical Modelling and Computing','lecturer' => ''),
		array('code' => 'STS 415','title' => 'Biomteric Methods II','unit' => '3','level' => '400','scope' => 'Biometry','lecturer' => ''),
		array('code' => 'STS 417','title' => 'Sampling Techniques','unit' => '3','level' => '400','scope' => 'Sampling Techniques','lecturer' => ''),
		array('code' => 'STS 441','title' => 'Demography II','unit' => '3','level' => '400','scope' => 'Demography','lecturer' => ''),
		array('code' => 'STS 412','title' => 'Statistical Inference IV','unit' => '3','level' => '400','scope' => 'Statistical Inference','lecturer' => ''),
		array('code' => 'STS 414','title' => 'Non Parametric Methods','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'STS 482','title' => 'Multivariate Methods','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'STS 492','title' => 'Laboratory for Statistical Inference IV','unit' => '3','level' => '400','scope' => 'Statistical Inference','lecturer' => ''),
		array('code' => 'STS 498','title' => 'Seminar','unit' => '1','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'STS 499','title' => 'Project','unit' => '6','level' => '400','scope' => '','lecturer' => ''),
	);
		
	$_add_course_stmt = mysqli_prepare($_connection,"INSERT INTO `courses` (`course_code`, `course_title`, `course_unit`, `level`, `course_scope`, `lecturer_in_charge`) VALUES(?,?,?,?,?,?)");
					mysqli_stmt_bind_param($_add_course_stmt, 'ssiiss', $code,$title,$unit,$level,$scope,$lecturer);
		
		for($c = 0; $c< count($courses); $c++){
			$code = $courses[$c]['code'];
			$title = $courses[$c]['title'];
			$unit = $courses[$c]['unit'];
			$level = $courses[$c]['level'];
			$scope = $courses[$c]['scope'];
			$lecturer = $courses[$c]['lecturer'];
		mysqli_stmt_execute($_add_course_stmt);
		}		
	}	
		
		}
		mysqli_close($_connection);
}
else{
	echo "<h2 class=\"text-center\">Something went wrong</h2>";
}
/*******************************************************************************************/
