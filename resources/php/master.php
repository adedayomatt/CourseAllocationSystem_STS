<?php
require('config.php');
if (!function_exists('split')) {
	function split($delimiter, $string) {
		return explode($delimiter, $string);
	}
}
require('initiate_courses.php');

class database{
public $connection;
	function __construct(){
		GLOBAL $db_name;
		$this->connection = new MySQLi(config::$db_host,config::$db_user,config::$db_password,$db_name);
		if ($this->connection->connect_error) {
			echo "There was an error connecting to the database";
			die();
		}
	}
	function query($q){
		$obj = $this->connection->query($q);
			if(!$this->connection->error){
				return $obj;
			}
			else{
?>
	<div class="text-center">
	<h2>Something isn't right</h2>
	<i><?php echo $this->connection->error ?></i>
	<h4>check your configuration in config.php and make sure <b>department</b> is set <br/><br/> <a href="READ ME.txt">read this system guide </a></h4>
	</div>
	<?php	
	die();
				}
	}
}
class lecturer{
	function add_lecturer($title,$last_name, $initial,$specialization){
		GLOBAL $db;
		$id = time();
		if($title == "" || $last_name == "" || $initial == "" || $specialization == ""){
			echo "Some Fields are missing";
			}		
		else{
			if($db->query("SELECT id FROM lecturer WHERE (title = '$title' AND last_name = '$last_name' AND initial = '$initial')")->num_rows >= 1){
				echo "$title. $last_name $initial already exist";
			}
			else{
				$db->query("INSERT INTO lecturer (id,title,last_name,initial,specialization) VALUES($id,'$title','$last_name','$initial','$specialization')");
				if($db->connection->affected_rows == 1){
			 echo "$title $last_name $initial added successfully";
				}
				else{
					echo "Failed to add $title. $last_name $initial record";
				}
			}
		}
	}
	function get_lecturers(){
		GLOBAL $db;
		$lecturers = array();
		$get_lecturers = $db->query("SELECT CONCAT(title,' ',last_name,' ',initial) AS lecturer_name,id,title,last_name,initial,specialization FROM lecturer ORDER BY title DESC");
		$i = 0;
		while($l = $get_lecturers->fetch_array(MYSQLI_ASSOC)){
			$lecturers[$i]['id'] = $l['id']; 
			$lecturers[$i]['title'] = $l['title']; 
			$lecturers[$i]['last_name'] = $l['last_name']; 
			$lecturers[$i]['initial'] = $l['initial']; 
			$lecturers[$i]['specialization'] = $l['specialization']; 
			$lecturers[$i]['lecturer_name'] = $l['lecturer_name']; 
			$lecturers[$i]['courses_handling'] = ""; 
			$get_courses = $db->query("SELECT course_code FROM courses WHERE (lecturer_in_charge LIKE '%".$l['lecturer_name']."%')");
			while($courses = $get_courses->fetch_array(MYSQLI_ASSOC)){
				$lecturers[$i]['courses_handling'] .= $courses['course_code'].', ';
			}
			$i++;
		}
		return $lecturers;
	}
}
class courses{

function scopes(){
	
return array(
			'Sampling Technique',
			'Experimental Design and Analysis',
			'Statistical Inference',
			'Time Series Analysis',
			'Biometry',
			'Stochastic Processes',
			'Demography',
			'Sample Survey',
			'Statistical Modelling and Computing',
			'Statistical Quality Control',
			'General Statistics',
			'Distribution Theory',
			'Probability'
						);
}
	function get_courses($level){
		GLOBAL $db;
		$courses = array();
		$i = 0;
		if($level == 'all'){
		$get_courses = $db->query("SELECT * FROM courses ORDER BY course_code ASC");
		}
		else{
		$get_courses = $db->query("SELECT * FROM courses WHERE level = $level ORDER BY course_code ASC");
		}
		while($c = $get_courses->fetch_array(MYSQLI_ASSOC)){
			$courses[$i]['code'] = $c['course_code'];
			$courses[$i]['title'] = $c['course_title'];
			$courses[$i]['unit'] = $c['course_unit'];
			$courses[$i]['scope'] = $c['course_scope'];
			$courses[$i]['level'] = $c['level'];
			$courses[$i]['lecturer_in_charge'] = $c['lecturer_in_charge'];
			$i++;
		}
		return $courses;
	}
	function get_course($code){
		GLOBAL $db;
			$course = array();
		$get_course = $db->query("SELECT * FROM courses WHERE course_code = '$code'");
		if($get_course->num_rows == 1){
			$c = $get_course->fetch_array(MYSQLI_ASSOC);
			$course['code'] = $c['course_code'];
			$course['title'] = $c['course_title'];
			$course['unit'] = $c['course_unit'];
			$course['scope'] = $c['course_scope'];
			$course['level'] = $c['level'];
			$course['lecturer_in_charge'] = $c['lecturer_in_charge'];
		}
		else{
			echo "<strong>$code</strong> not found";
		}
		return $course;
	}
	function add_new_course($level,$code,$title,$unit,$scope,$lecturer){
		if($level == "" || $code=="" || $title=="" || $unit=="" || $scope=="" || $lecturer==""){
			echo "Some Fields are Missing";
			die();
			}
			GLOBAL $db;
			if($db->query("SELECT course_code FROM courses WHERE course_code = '$code'")->num_rows == 1){
			echo "$code already exist";
			}
			else{
			$db->query("INSERT INTO courses (course_code,course_title,course_unit,level,course_scope,lecturer_in_charge) VALUES('$code','$title',$unit,$level,'$scope','$lecturer')");
			if($db->connection->affected_rows == 1){
				 echo "$code added successfully";
			}
			else{
				echo "$code was not added successfully";
			}
			}
	}
	function edit_course($level,$code,$title,$unit,$scope,$lecturer){
		GLOBAL $db;
if($level == "" || $code=="" || $title=="" || $unit=="" || $scope=="" || $lecturer==""){
			echo "Some Fields are Missing";
			die();
			}
		$db->query("UPDATE courses SET course_code = '$code',course_title = '$title',course_unit = $unit,level = $level,course_scope = '$scope',lecturer_in_charge = '$lecturer' WHERE course_code = '$code'");
		if($db->connection->affected_rows == 1){
		 echo "$code edited" ;
		}
		else{
			echo "No change was made to $code";
		}
	}
	function delete_course($code){
		GLOBAL $db;

		$db->query("DELETE FROM courses WHERE course_code = '$code'");
		if($db->connection->affected_rows == 1){

		echo "$code deleted" ;
		}
		else{
			echo "$code was unable to be deleted";
		}
	}
	function allocate_courses($level){
		GLOBAL $db;
		switch($level){
		case 'all-courses':
	$q = "SELECT course_code,course_scope FROM courses";
	break;
	case '100l-courses':
		$q = "SELECT course_code,course_scope FROM courses WHERE level = 100";

	break;
	case '200l-courses':
		$q = "SELECT course_code,course_scope FROM courses WHERE level = 200";
	break;
	case '300l-courses':
		$q = "SELECT course_code,course_scope FROM courses WHERE level = 300";
	break;
	case '400l-courses':
			$q = "SELECT course_code,course_scope FROM courses WHERE level = 200";

	break;
	default;
			$q = "SELECT course_code,course_scope FROM courses";
	break;
	}
	$get_courses = $db->query($q);
	$assigned = 0;
	while($c = $get_courses->fetch_array(MYSQLI_ASSOC)){
		$code = $c['course_code'];
		$scope = $c['course_scope'];
		$scope_array = split(', ',$scope);
		$lecturer = "";
		//get specialized lectrurer
		$get_lecturer = $db->query("SELECT CONCAT(title,' ',last_name,' ',initial) AS lecturer_name,specialization FROM lecturer");
		while($l = $get_lecturer->fetch_array(MYSQLI_ASSOC)){
			$specialization_array = split(', ',$l['specialization']);//split specializations into array
	
			for($s = 0 ; $s < count($scope_array); $s++){
				if(in_array($scope_array[$s],$specialization_array)){//if course scope is part of the lecturer specialization
					$lecturer .= $l['lecturer_name'].', ';
					break;
				}
			}
		}
		//assign the course to the lecturer
		if($lecturer  != ""){
		$db->query("UPDATE courses SET lecturer_in_charge = '$lecturer' WHERE course_code = '$code'");
		if($db->connection->affected_rows == 1){
			$assigned++;
		}
		}
	}
	echo "$assigned courses assigned to lectures";
	}	
}
