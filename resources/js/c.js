document.querySelector('button#add-new-course').addEventListener('click',function(e){
	var modal = new Modal();
	 modal.header = "<h2 class=\"text-center\">New Course</h2>";
	 modal.createModal();
	 modal.showModal();
	 var get_form = new useAjax('resources/php/course_form.php?a=new');
	 	 get_form.go(function(responseCode,responseText){
		 if(responseCode == 204){
			 modal.contentHolder().innerHTML = responseText;
		 }
	 });
}); 

 function addNewCourse(form,action){
	 var form_container = form.parentNode;
	 var course_form = form_container.innerHTML;
  var level = form.querySelector("select[name='level']").value;
  var code = form.querySelector("input[name='course_code']").value;
  var title = form.querySelector("input[name='course_title']").value;
  var unit = form.querySelector("input[name='course_unit']").value;
  var lecturer = form.querySelector("select[name='course_lecturer']").value;
  
  var scope = "";
  
  var scopes = form.querySelector("div.course-scopes").querySelectorAll("[data-role='indicator']");
  for(var s = 0;s<scopes.length;s++){
	  scope += (scopes[s].getAttribute('data-checked') == 'true' ? scopes[s].getAttribute('value')+', ' : '');
  }
    var feedback_container = form_container.querySelector('#feedback-container');
  
  	 feedback_container.innerHTML = "<h4 class=\"text-center\" >please wait...</h4>";
  var url = "resources/php/api.php?request="+action+"&level="+level+"&code="+code+"&title="+title+"&unit="+unit+"&scope="+scope+"&lecturer="+lecturer;
 var addcourse = new useAjax(url);
	 addcourse.go(function(responseCode,responseText){
		 if(responseCode == 204){			 
			 if(action=='edit_course'){
				 new Modal().closeModal();
				feedback_container.innerHTML = "<h2>Course updated</h2>";
				 refresh();
			 }else{
				 feedback_container.innerHTML = "<h2>Add New Course</h2>";
			 }
			 alert(responseText);
		 }
		 	
	 });
 }
 
 function show_edit_course_dialog(btn){
	 courseCode = btn.getAttribute('data-course-code');
	 var modal = new Modal();
	 modal.header = "<h2 class=\"text-center\">Edit Course</h2>";
	 modal.createModal();
	 modal.showModal();
	 var get_edit_course_form = new useAjax('resources/php/course_form.php?a=edit&code='+courseCode);
	 	 get_edit_course_form.go(function(responseCode,responseText){
		 if(responseCode == 204){
			 modal.contentHolder().innerHTML = responseText;
		 }
	 });	 
 }
 
 function confirm_delete_course(btn){
	 courseCode = btn.getAttribute('data-course-code');
	 modal = new Modal();
	 modal.header = "<h2 class=\"text-center\">Delete Course</h2>";
	 modal.createModal();
	 modal.showModal();
	 modal.contentHolder().innerHTML = "<div class='text-center'><h3>Are you sure you want to delete "+courseCode+"</h3><button class='btn btn-primary' style='margin:10px' onclick=\"delete_course('"+courseCode+"')\">Yes</button><button class='btn btn-danger' style='margin:10px' onclick=\"delete_course('000')\">No</button></div>";

 }
	  function delete_course(courseCode){
		  if(courseCode == '000'){//if the delete was aborted
			   new Modal().closeModal();
		  }
		  else{
	  var d = new useAjax('resources/php/api.php?request=delete_course&code='+courseCode);
	 	 d.go(function(responseCode,responseText){
		 if(responseCode == 204){
			alert(responseText);
			new Modal().closeModal();
			 refresh();
		 }
	 });
		  }
 }
 function allocate_course(level){
	  var d = new useAjax('resources/php/api.php?request=allocate_courses&level='+level);
	 	 d.go(function(responseCode,responseText){
		 if(responseCode == 204){
			 alert(responseText);
			  refresh();
		 }
	 });
 }
