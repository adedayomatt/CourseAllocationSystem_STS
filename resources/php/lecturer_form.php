								<?php
								require('master.php');
								$db = new database(); 
								$courses = new courses();
								$course_scopes = $courses->scopes();

								if($_GET['a'] == 'new'){
											$action = 'add_lecturer';
								}
								else{
									echo "Invalid Request";
									die();
								}
								?>
								<div id="add-new-lecturer-wrapper">
								<div id="feedback-container"></div>
									<form id="add-new-lecturer">
									
										<div class="form-group">
											<label>Title <?php echo (isset($lecturer['title']) ? ':'.$lecturer['title'] : '') ?></label>
											<select class="form-control" name="title">
												<option value="<?php echo ($action == 'edit_lecturer' && isset($lecturer['title']) ? $lecturer['title'] : 'Mr.') ?>">Select Lecturer Title</option>
												<option value="Mr.">Mister (Mr.)</option>
												<option value="Mr.">Misress (Mrs.)</option>
												<option value="Dr.">Doctor (Dr.)</option>
												<option value="Prof.">Professor (Prof.)</option>
											</select>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<label>Lecturer's Name</label>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
													<input type="text" name="last_name" placeholder="Last Name" class="form-control" value="<?php echo (isset($lecturer['last_name']) ? $lecturer['last_name'] : '') ?>"/>
												</div>
												<div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-6 col-xs-6">
													<input type="text" name="initial" placeholder="Initials" class="form-control" value="<?php echo (isset($lecturer['initial']) ? $lecturer['initial'] : '') ?>"/>
												</div>
											</div>
										</div>
										
										<div class="form-group course-scopes">
											<label>Area of Specialization <?php echo (isset($course['scope']) ? ':'.$course['scope'] : '') ?></label>
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
											<input type="button" onclick="addNewLecturer(document.querySelector('form#add-new-lecturer'),'<?php echo $action ?>')" class="btn btn-primary" value="<?php echo ($_GET['a'] == 'edit' ? 'Edit' : 'Add') ?>"/>
										</div>
									</form>
								</div>