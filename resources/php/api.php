<?php
if(!isset($_GET['request'])){
	die();
}

require('master.php');
$db = new database();
$courses = new courses();
$lecturer = new lecturer();

$request = $_GET['request'];
if($request =='add_course'){
	$courses->add_new_course($_GET['level'],$_GET['code'],$_GET['title'],$_GET['unit'],$_GET['scope'],$_GET['lecturer']); 
	die();
	}
else if($request == 'edit_course'){
	$courses->edit_course($_GET['level'],$_GET['code'],$_GET['title'],$_GET['unit'],$_GET['scope'],$_GET['lecturer']); 
	die();
	}
else if($request == 'delete_course'){
	$courses->delete_course($_GET['code']); 
	die();
}
else if($request == 'allocate_courses'){
	$courses->allocate_courses($_GET['level']);
die();	
}
else if($request == 'add_lecturer'){
	$lecturer->add_lecturer($_GET['title'],$_GET['last_name'],$_GET['initial'],$_GET['spec']);
}
else if($request == 'all-lecturers'){
	$lecturers = $lecturer->get_lecturers();
	?>
	<h2>Lecturers (<?php echo count($lecturers)?>)</h2>
	<table>
		<thead>
			<tr>
				<td>Title</td>
				<td>Last Name</td>
				<td>Initials</td>
				<td>Specialization</td>
				<td>Courses in Field/Courses Handling</td>
			</tr>	
		</thead>		
		<tbody>
		<?php
		if(count($lecturers) > 0){
		$l = 0;
		while($l < count($lecturers)){
			?>
			<tr>
				<td><?php echo $lecturers[$l]['title']?></td>
				<td><?php echo $lecturers[$l]['last_name']?></td>
				<td><?php echo $lecturers[$l]['initial']?></td>
				<td><?php echo $lecturers[$l]['specialization']?></td>
				<td><?php echo $lecturers[$l]['courses_handling']?></td>
			</tr>				
			<?php
			$l++;
		}
		}
		else{
			echo "<h4 class=\"text-center\">No Lecturer added yet</h4>";
		}
		?>
		</tbody>
		</table>
		<?php
}
else{
switch($request){
	case 'all-courses':
	$all_courses = $courses->get_courses('all');
	$course_displaying = "All ".config::$department." Courses";
	$no_course = "There is no course added yet";
	break;
	case '100l-courses':
	$all_courses = $courses->get_courses(100);
	$course_displaying = "100 Level Courses";
	$no_course = "There is no 100 Level course added yet";

	break;case '200l-courses':
	$all_courses = $courses->get_courses(200);
	$course_displaying = "200 Level Courses";
	$no_course = "There is no 200 Level course added yet";
	break;
	case '300l-courses':
	$all_courses = $courses->get_courses(300);
	$course_displaying = "300 Level Courses";
	$no_course = "There is no 300 Level course added yet";

	break;
	case '400l-courses':
	$all_courses = $courses->get_courses(400);
	$course_displaying = "400 Level Courses";
	$no_course = "There is no 400 Level course added yet";


	break;
	default;
	$all_courses = $courses->get_courses('all');
	$course_displaying = "All ".config::$department." Courses";
	$no_course = "There is no course added yet";

	break;
	
}
$courses_loaded = count($all_courses);
?>
<div>
	<h2><?php echo $course_displaying." (".$courses_loaded.")" ?> 
			<button class="btn btn-primary" style="float:right" onclick="allocate_course('<?php echo $request ?>')">Allocate courses automatically</button>
	</h2>
</div>
<?php
if($courses_loaded == 0){
	?>
	<div class="text-center">
		<h4><?php  echo $no_course ?></h4>
	</div>
	<?php
}
?>
<table>
	<thead>
		<tr>
			<td>Course Code</td>
			<td>Course Title</td>
			<td>Unit</td>
			<td>Level</td>
			<td>Scope</td>
			<td>Lecturer(s)</td>
			<td>Tools</td>
		</tr>	
	</thead>
	<tbody>
		<?php
		$c = 0;
		while($c < $courses_loaded){
			?>
		<tr>
			<td><?php  echo $all_courses[$c]['code']?></td>
			<td><?php  echo $all_courses[$c]['title']?></td>
			<td><?php  echo $all_courses[$c]['unit']?></td>
			<td><?php  echo $all_courses[$c]['level']?></td>
			<td>
				<?php  $scopes = split(', ',$all_courses[$c]['scope']);
						$lecturers = split(', ',$all_courses[$c]['lecturer_in_charge']);
				
				?>
				<ul>
					<?php
					for($sc = 0; $sc<count($scopes); $sc++){
						echo ($scopes[$sc] == "" ? '' : "<li>".$scopes[$sc]."</li>");
					}
					?>
				</ul>
			</td>
			<td>
				<ul>
						<?php
						for($lc = 0; $lc<count($lecturers); $lc++){
							echo ($lecturers[$lc] == "" ? '' : "<li>".$lecturers[$lc]."</li>");
						}
						?>
					</ul>
				</td>
			<td class="tools">
			<span style="margin:0px 5px">
				<span class="glyphicon glyphicon-pencil" style="cursor:pointer; color:blue" title="edit <?php echo $all_courses[$c]['code'] ?>" data-action="edit-course" data-course-code="<?php echo $all_courses[$c]['code'] ?>" onclick="show_edit_course_dialog(this)"></span>
			</span>
			
			<span style="margin:0px 5px">
				<span class="glyphicon glyphicon-trash" style="cursor:pointer; color:red" title="delete <?php echo $all_courses[$c]['code'] ?>" data-action="edit-course" data-course-code="<?php echo $all_courses[$c]['code'] ?>" onclick="confirm_delete_course(this) "></span>
			</span> 
			</td>
		</tr>
		
			<?php
			$c++;
		}
		?>
	</tbody>
</table>

<?php

}
