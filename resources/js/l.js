document.querySelector('button#add-new-lecturer').addEventListener('click',function(e){
	var modal = new Modal();
	 modal.header = "<h2 class=\"text-center\">New Lecturer</h2>";
	 modal.createModal();
	 modal.showModal();
	 var get_form = new useAjax('resources/php/lecturer_form.php?a=new');
	 	 get_form.go(function(responseCode,responseText){
		 if(responseCode == 204){
			 modal.contentHolder().innerHTML = responseText;
		 }
	 });
}); 

 function addNewLecturer(form,action){
	 var form_container = form.parentNode;
	 var course_form = form_container.innerHTML;
  var title = form.querySelector("select[name='title']").value;
  var last_name = form.querySelector("input[name='last_name']").value;
  var initial = form.querySelector("input[name='initial']").value;
   var specializations = "";
  
  var scopes = form.querySelector("div.course-scopes").querySelectorAll("[data-role='indicator']");
  for(var s = 0;s<scopes.length;s++){
	  specializations += (scopes[s].getAttribute('data-checked') == 'true' ? scopes[s].getAttribute('value')+', ' : '');
  }
  
  var feedback_container = form_container.querySelector('#feedback-container');
  
  	 feedback_container.innerHTML = "<h4 class=\"text-center\" >please wait...</h4>";
  
  var addlecturer = new useAjax("resources/php/api.php?request="+action+"&title="+title+"&last_name="+last_name+"&initial="+initial+"&spec="+specializations);
	 addlecturer.go(function(responseCode,responseText){
		 if(responseCode == 204){
				 feedback_container.innerHTML = "<h2>Add New Lecturer</h2>";
				 alert(responseText);
			 }
	 });
 }
 
 function show_edit_lecturer_dialog(btn){
	 id = btn.getAttribute('data-lecturer-id');
	 var modal = new Modal();
	 modal.header = "<h2 class=\"text-center\">Edit Course</h2>";
	 modal.createModal();
	 modal.showModal();
	 var get_edit_course_form = new useAjax('resources/php/lecturer_form.php?a=edit&id='+id);
	 	 get_edit_course_form.go(function(responseCode,responseText){
		 if(responseCode == 204){
			 modal.contentHolder().innerHTML = responseText;
		 }
	 });	 
 }
 
 function confirm_delete_course(btn){
	 courseCode = btn.getAttribute('data-course-code');
	 modal = new Modal();
	 modal.header = "<h2 class=\"text-center\">Edit Course</h2>";
	 modal.createModal();
	 modal.showModal();
	 modal.contentHolder().innerHTML = "<div class='text-center'><h3>Are you sure you want to delete "+courseCode+"</h3><button class='btn btn-primary' style='margin:10px' onclick=\"delete_course('"+courseCode+"')\">Yes</button><button class='btn btn-danger' style='margin:10px' onclick=\"delete_course('000')\">No</button></div>";

 }
	  function delete_course(courseCode){
		  if(courseCode == '000'){
			   new Modal().closeModal();
		  }
		  else{
	  var d = new useAjax('resources/php/api.php?request=delete_course&code='+courseCode);
	 	 d.go(function(responseCode,responseText){
		 if(responseCode == 204){
			 modal.contentHolder().innerHTML = responseText;
		 }
	 });
		  }
 }
