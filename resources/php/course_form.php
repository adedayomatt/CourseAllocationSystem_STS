								<?php
								require('master.php');
								$db = new database(); 
								$courses = new courses();
								$lecturers = new lecturer();
								$course_scopes = $courses->scopes();
								if($_GET['a'] == 'edit'){
									$course_code = $_GET['code'];
									$action = 'edit_course';
									$get_course = $db->query("SELECT * FROM courses WHERE course_code = '$course_code'");
									if($get_course->num_rows == 1){
										$c = $get_course->fetch_array(MYSQLI_ASSOC);
										$course['code'] = $c['course_code'];
										$course['title'] = $c['course_title'];
										$course['unit'] = $c['course_unit'];
										$course['scope'] = $c['course_scope'];
										$course['level'] = $c['level'];
										$course['lecturer_in_charge'] = $c['lecturer_in_charge'];
										$course_scope_array = split(', ',$course['scope']);
									}
									else{
										echo "<strong>$course_code</strong> not found";
										die();
									}
								}
								else{
									$action = 'add_course';
								}
								
								?>
								<div id="add-new-course-wrapper">
								<div id="feedback-container"></div>
									<form id="add-new-course">
									
										<div class="form-group">
											<label>Level <?php echo (isset($course['level']) ? ':'.$course['level'] : '') ?></label>
											<select class="form-control" name="level">
												<option value="<?php echo ($action == 'edit_course' && isset($course['level']) ? $course['level'] : 100) ?>">Select Level</option>
												<option value="100">100 Level</option>
												<option value="200">200 Level</option>
												<option value="300">300 Level</option>
												<option value="400">400 Level</option>
											</select>
										</div>
										<div class="form-group">
											<label>Course code</label>
											<input type="text" name="course_code" class="form-control" value="<?php echo (isset($course['code']) ? $course['code'] : '') ?>"/>
										</div>
										<div class="form-group">
											<label>Course Title</label>
											<input type="text" name="course_title" class="form-control" value="<?php echo (isset($course['title']) ? $course['title'] : '') ?>"/>
										</div>
										<div class="form-group">
											<label>Unit</label>
											<input type="number" name="course_unit" class="form-control" value="<?php echo (isset($course['unit']) ? $course['unit'] : '') ?>"/>
										</div>

										<div class="form-group course-scopes">
											<label>Course Scope <?php echo (isset($course['scope']) ? ':'.$course['scope'] : '') ?></label>
											<br/>
											<?php
											$sc = 0;
											while($sc < count($course_scopes)){
												?>
											<div class="roundbox">
												<label onclick="activate_roundbox(this)">
												<span data-role="indicator" data-checked="<?php echo ($action == 'edit_course' && in_array($course_scopes[$sc],$course_scope_array) ? 'true' : 'false') ?>" value="<?php  echo $course_scopes[$sc] ?>"></span>  <?php  echo $course_scopes[$sc] ?></label>
											</div>	
											<?php
												$sc++;
											}
											?>
										</div>
												
										<div class="form-group">
											<label>Lecturer in charge <?php echo (isset($course['lecturer_in_charge']) ? ':'.$course['lecturer_in_charge'] : '') ?></label>
											<select name="course_lecturer" class="form-control">
												<option value = "<?php echo ($action == 'edit_course' && isset($course['lecturer_in_charge']) ? $course['lecturer_in_charge'] : '') ?>">Select lecturer</option>
												<?php
												$all_lecturers = $lecturers->get_lecturers();
												$l = 0;
												while($l < count($all_lecturers)){
													?>
													<option value = "<?php echo $all_lecturers[$l]['lecturer_name'] ?>"><?php echo $all_lecturers[$l]['lecturer_name'].' ('.$all_lecturers[$l]['specialization'].')' ?></option>
													<?php
													$l++;
												}
												?>
											</select>
										</div>
										<div class="form-group">
											<input type="button" onclick="addNewCourse(document.querySelector('form#add-new-course'),'<?php echo $action ?>')" class="btn btn-primary" value="<?php echo ($_GET['a'] == 'edit' ? 'Edit' : 'Add') ?>"/>
										</div>
									</form>
								</div>
