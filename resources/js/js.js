main = document.querySelector("#main>#main-inner"); 
body = document.querySelector('body');
refresh_content = "";
 var menus = document.querySelectorAll("#side-menu>ul>li");
 var i = 0;
 while(i< menus.length){
	activate_menu(menus[i])
	 i++;
 }
 function activate_menu(menu){
	 menu.addEventListener('click',function(event){get_content(menu.getAttribute('id'))});
 }
function refresh(){
	get_content(refresh_content);
} 
 function get_content(content){
	 show_loading("Just a moment...");
		  var api = "resources/php/api.php?request="+content;
		  refresh_content = content;
	 var load = new useAjax(api);
	 load.go(function(responseCode,responseText){
		 if(responseCode == 204){
			 dismiss_loading();
			 main.innerHTML = responseText;
		 }
	 });

 }
 
 function show_loading(waiting_msg){
	 //first dismiss any existing one
	 dismiss_loading();
	 var waiting_wrapper = document.createElement('div');
	 waiting_wrapper.setAttribute('style','position:absolute;z-index:99;background-color:rgba(0,0,0,0.5);width:100%;height:100vh');
	  waiting_wrapper.setAttribute('id','loading-content');
	  
	 var waiting_inner = document.createElement('div');
	 waiting_inner.setAttribute("style","height:inherit;font-size:30px; text-align:center; background:url('resources/img/progress-circle.gif') center no-repeat; padding-top:150px");

	  var closer = document.createElement('span');
	 closer.setAttribute('style','cursor:pointer;float:right;font-size:40px; color:red');
	 closer.innerHTML = " &times ";
	 closer.addEventListener('click',function(event){
		 dismiss_loading();
	 });
	 
	 var waiting_message = document.createElement('h1');
	 waiting_message.setAttribute('style','color:white');
	 waiting_message.innerHTML = waiting_msg;
	 
	 waiting_inner.appendChild(waiting_message);
	 
	 waiting_wrapper.appendChild(closer);
	 waiting_wrapper.appendChild(waiting_inner);
	 
	 body.insertBefore(waiting_wrapper,body.firstChild);
	 document.querySelector('body').style.overflow = "hidden";
 }
 
 function dismiss_loading(){
	 if(document.querySelector("#loading-content") != null){
		 body.removeChild(document.querySelector("#loading-content"));
		  document.querySelector('body').style.overflow = "auto";

	 }
 }
 
 	 function activate_roundbox(label){
		var indicator = label.querySelector("[data-role = 'indicator']");
		 var value = indicator.getAttribute('value');
		 var status = indicator.getAttribute('data-checked');
		 if(status == 'false'){
			 indicator.style.backgroundColor = "green";
			 indicator.setAttribute('data-checked','true');
		 }
		 else{
			 indicator.style.backgroundColor = "unset";
			 indicator.setAttribute('data-checked','false');
		 }
		 
	 }
 
 

 
 
 
 
 
 