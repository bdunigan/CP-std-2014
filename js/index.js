ng.ready(function(){
	// global picture position to keep track of user drag and drop
	var user_photo_pos;
	var please_wait_timer;
	
	if (show_dpi_warning){
		ng.get('pfapp_dpi_warning').set_style('display', 'block');	
	}
	
	if (recommended_frame != ''){
		show_recommend_frame();	
	}
	
	// if browser doesn't support html5 range slider,
	// create one from javascript
	if (!ng.browser.support_input('range')){
		var inpt = ng.get('pfapp_photo_zoom');
		var holder = ng.create('div');
		ng.get('pfapp_range_slider').append_element(holder);
		
		var slider = new ng.Slider({
			object: holder,
			start: 0,
			end: 100,
			value: inpt.value,
			visible: true,
			width:(inpt.get_width() - 30),
			events: {
				onSlide: function(){
					ng.get('pfapp_photo_zoom').value = this.get_value();
					ng.get('pfapp_photo_zoom').fire_event('change');
				},
				onChange: function(){
					this.fire_event('onSlide');	
				}
			}
		});
		slider.set_input(inpt);
		inpt.set_style('display', 'none');
		
	}
	// adding form events
	ng.get('pfapp_frame_size_select').add_event('change', function(){
		set_frame_size(this.value, this.options[this.selectedIndex].innerHTML);
	});
	ng.get('pfapp_frame_size_select').fire_event('change');
	
	ng.get('pfapp_photo_zoom').add_event('change', function(){
		resize_user_photo(this.value);
	});
	
	ng.get('pfapp_fit_photo').add_event('click', function(){
		ng.get('pfapp_center_photo').fire_event('click');
		if (ng.defined(slider)){
			slider.set_value(100);	
		}
		else {
			ng.get('pfapp_photo_zoom').value = 100;
			ng.get('pfapp_photo_zoom').fire_event('change');
		}
	});
	
	ng.get('pfapp_center_photo').add_event('click', function(){
		user_photo_pos = null;
		
		ng.get('pfapp_top_input').value = 0;
		ng.get('pfapp_left_input').value = 0;
		
		ng.get('pfapp_user_photo').set_styles({
			marginTop: 0,
			marginLeft:0	
		});
	});

//------------Buy Sample Button

ng.get('buyProofBtn').add_event('change', function(evt){
		var errs = [];


		$('#loadingContainer').css({display:  'block'});

		if (ng.get('pfapp_frame_size_select').value == ''){
			errs.push(' - Frame Size');
		}

	// --------------BRYAN added validation 		
	 if (ng.get('matchproof').checked) {
					if (ng.get('pfapp_order_number').value == ''){
						errs.push(' - Order Number');	
					}
			 } else{
					if ((ng.get('pfapp_picture_upload').value == '') && (ng.get('pfapp_current_image').value == '')) {
						errs.push(' - Select a Photo');	
					}
					if (ng.get('pfapp_photo_zoom').value == ''){
						errs.push(' - Photo Zoom');	
					}else {
						var val = ng.get('pfapp_photo_zoom').value.to_int();
						if ((val < 0) || (val > 150)) {
							errs.push(' - Photo zoom must be between 0% to 105%');		
						}

					if (ng.get('imageapprove').checked){
						//do nothing
					}else{
						errs.push(' - Approve the image');	
					}	

					}
			 };


		if (ng.get('pfapp_fname').value == ''){
			errs.push(' - First Name');	
		}
		if (ng.get('pfapp_lname').value == ''){
			errs.push(' - Last Name');	
		}
		if (!ng.Validate.email(ng.get('pfapp_email').value)){
			errs.push(' - Email');
		}

		
		if (errs.length){
			$('#loadingContainer').css({display:  'none'});
			alert("The following fields are missing or invalid\n"+errs.join("\n"));
			evt.stop();	
		}  else{

		document.forms["proofForm"].submit();
		$('#loadingImage').attr({src:'images/ps-gif.gif'}).delay( 2000 );	

		$("#sampleBuyiframe").load(function() {	
				document.forms["pfapp_form"].submit();
			});

		}

	});



//--------- form validation

	
	ng.get('pfSubmit').add_event('change', function(evt){
		var errs = [];

	// --------------BRYAN added validation 		
	 if (ng.get('matchproof').checked) {

					if (ng.get('pfapp_order_number').value == ''){
						errs.push(' - Order Number');	
					}
			 } else{


					if ((ng.get('pfapp_picture_upload').value == '') && (ng.get('pfapp_current_image').value == '')) {
						errs.push(' - Select a Photo');	
					}
					if (ng.get('pfapp_photo_zoom').value == ''){
						errs.push(' - Photo Zoom');	
					}else {
						var val = ng.get('pfapp_photo_zoom').value.to_int();
						if ((val < 0) || (val > 150)) {
							errs.push(' - Photo zoom must be between 0% to 105%');		
						}

					if (ng.get('imageapprove').checked){
						//do nothing
					}else{
						errs.push(' - Approve the image');	
					}	

					}
			 };


		if (ng.get('pfapp_fname').value == ''){
			errs.push(' - First Name');	
		}
		if (ng.get('pfapp_lname').value == ''){
			errs.push(' - Last Name');	
		}
		if (!ng.Validate.email(ng.get('pfapp_email').value)){
			errs.push(' - Email');
		}

		if ($( "#pfapp_qty" ).val() < 10 ){
			errs.push(' - Quantity too small');
		}

		$('#loadingContainer').css({display:  'block'});

		if (ng.get('pfapp_frame_size_select').value == ''){
			errs.push(' - Frame Size');
		}
		
		if (errs.length){
			$('#loadingContainer').css({display:  'none'});
			alert("The following fields are missing or invalid\n"+errs.join("\n"));
			evt.stop();	
		}  else{

		document.forms["sampleForm"].submit();
		$('#loadingImage').attr({src:'images/ps-gif.gif'}).delay( 2000 );	

		$("#sampleBuyiframe").load(function() {	
				document.forms["pfapp_form"].submit();
			});

		}



	});





	
	// setting the user image drag to reposition image
	ng.get('pfapp_photo_frame').add_events({
		// custom event added for this ng installation
		preDragStart: function(evt){
			// setting the frame position to the current user photo
			// position so when the drag starts, it continue from last spot
			if (ng.defined(user_photo_pos)) {
				ng.get('pfapp_photo_frame').set_styles(user_photo_pos);
				(function(){
					ng.get('pfapp_photo_frame').set_styles({
						marginTop: 'auto',
						marginLeft: 'auto'
					});
				}.defer());
			}
		},
		
		onDrop: function(){
			ng.get('pfapp_drag_container').set_style('display', 'none');
			
			var t = ng.get('pfapp_photo_frame').get_style('marginTop').to_float();
			var l = ng.get('pfapp_photo_frame').get_style('marginLeft').to_float();
		
			user_photo_pos = {
				marginTop: t,
				marginLeft: l
			};
			
			ng.get('pfapp_user_photo').set_styles(user_photo_pos);
			ng.get('pfapp_user_photo').set_styles({opacity:100, top:0, left:0});
			
			ng.get('pfapp_photo_frame').set_styles({
				marginTop: 0,
				marginLeft: 0
			});
			
			ng.get('pfapp_top_input').value = t;
			ng.get('pfapp_left_input').value = l;
		},
		
		onDragStart: function(){
			ng.get('pfapp_drag_container').set_style('display', 'block');
		},
	});
	
	ng.get('pfapp_photo_frame').drag({
		style:ng.get('pfapp_user_photo'),
		drag_delay: 0,
		container: 'pfapp_drag_container',
		top: 'marginTop',
		left: 'marginLeft'
	});
	
	var file_change_event = function(evt){

		// adding the ajax field to the form
		var ajx_inpt = ng.create('input', {
			name: 'Ajax',
			type: 'hidden',
			value: 1
		})
		ng.get('pfapp_form').append_element(ajx_inpt);
		
		var xhr = new ng.XHR({
			events: {
				onsuccess: function(obj){
					// hiding the loading bar
					clearTimeout(please_wait_timer);
					
					ng.get('pfapp_upload_field').set_style('display', 'block');
					ng.get('pfapp_loading_bar').set_style('display', 'none');
					ng.get('pfapp_loading_wait').set_style('display', 'none');
					
					var json = ng.eval_json(obj.text);
					if (json.error) {
						alert(json.error);
					}
					if (json.dpi_warning){
						ng.get('pfapp_dpi_warning').set_style('display', 'block');	
					}
					else {
						ng.get('pfapp_dpi_warning').set_style('display', 'none');
					}
					if (json.recommended){
						recommended_frame = json.recommended;
						show_recommend_frame();	
					}
					
					if (json.image_width){
						image_width = json.image_width;
					}
					if (json.image_height){
						image_height = json.image_height;
					}
					if (json.file){
						ng.get('pfapp_user_image').src = 'about:Blank';
						ng.get('pfapp_user_image').src = json.file;
					}
					if (json.current_image){
						ng.get('pfapp_current_image').value = json.current_image;	
					}
					
					resize_user_photo(ng.get('pfapp_photo_zoom').value);
					
					var inpt = ng.create('input', {
						type: 'file', 
						id: 'pfapp_picture_upload',
						name: 'UserPhoto',
						className: 'input',
						events: {
							change: file_change_event	
						}
					});
					ng.get('pfapp_picture_upload').replace(inpt);
				},
				fail: function(){
					alert('An error has occure, please try again or hit the refresh button');	
				},
				timeout: function(){
					location.reload();	
				}
			}
		});
		
		xhr.submit_form('pfapp_form');
		
		ajx_inpt.remove_element();
		
		// showing the loading bar
		ng.get('pfapp_loading_bar').set_style('display', 'block');
		ng.get('pfapp_upload_field').set_style('display', 'none');
		// if it takes too long, show a please wait message
		please_wait_timer = (function(){
			ng.get('pfapp_loading_wait').set_style('display', 'block');
		}.delay(10000));
	};
	
	ng.get('pfapp_picture_upload').add_event('change', file_change_event);
	
	function resize_user_photo(w){
		if (w == '') return;
		// making sure the width is integer
		w = w.to_int();
		
		var container = ng.get('pfapp_user_photo');
		var img = ng.get(container.getElementsByTagName('img')[0]);
		
		var frm = ng.get('pfapp_frame_size_select').value;
		if (frm == '') return;
		
		// frame size in pixels
		frm = frm.split('x');
		var fw = frm[0] * 72;
		var fh = frm[1] * 72;
		
		var st_obj = {};
		var img_style = {};
		
		// checking if the picture vertical or horizontal and resize based on that
		if (image_width <= image_height){
			var w_pixel = fw * (w / 50);
			st_obj.width = w_pixel;
			img_style.width = w_pixel;
			img_style.height = Math.round(image_height * w_pixel/image_width);
		}
		else {
			var h_pixel = fh * (w / 50);
			st_obj.height = h_pixel;
			img_style.width = Math.round(image_width * h_pixel/image_height);
			img_style.height = h_pixel;
		}
		
		// calculating the top and left margins
		// so zoom is from the middle
		var m = (100 - w ) / 2;
		
		var pt_pixel = fh * (m / 100);
		var pl_pixel = fw * (m / 100);
		console.log("IMAGE RESIZE:" + pt_pixel + pl_pixel)
		
		ng.get('pfapp_margintop_input').value = 0;
		ng.get('pfapp_marginleft_input').value = 0;
		
		// check if we need to pull the images up and down if they are bigger than the frame
		img_style.marginTop = 0;
		if (img_style.height > fh){
			img_style.marginTop = Math.round((img_style.height - fh)/2) * -1;
		}
		ng.get('pfapp_margintop_input').value = img_style.marginTop;
		
		img_style.marginLeft = 0;
		if (img_style.width > fw){
			img_style.marginLeft = Math.round((img_style.width - fw)/2) * -1;
		}
		ng.get('pfapp_marginleft_input').value = img_style.marginLeft;
		
		st_obj.paddingTop = pt_pixel;
		st_obj.paddingLeft = pl_pixel;
		
		ng.get('pfapp_margin_input').value = m;
		
		// setting the image size
		img.set_styles(img_style);
		container.set_styles(st_obj);
		
		return img_style;
	};

	
	function set_frame_size(size, label){

		if (size == '') return;
		size = size.toLowerCase();
		var arr = size.split('x');
		var w = arr[0].trim().to_float();
		var h = arr[1].trim().to_float();
		
		// checking the dpi
		if (image_width > 0) {
			var dpi = image_width / w;
			if (dpi < MINDPI) {
				ng.get('pfapp_dpi_warning').set_style('display', 'block');	
			}
			else {
				ng.get('pfapp_dpi_warning').set_style('display', 'none');	
			}
		}
		
		// changing width to pixel

		w = w * 72;
		h = h * 72;
		
		ng.get('pfapp_picture_holder').set_styles({width: w, height:h});
		ng.get('pfapp_photo_frame').src = frame_images_path+size+'.png';
		
		// frame size title
		ng.get('pfapp_frame_title').set_html(label+' Selected');
		
		// resizing the photo to get the overall picture size
		var obj = resize_user_photo(ng.get('pfapp_photo_zoom').value);
		
		// setting the drag container size
		ng.get('pfapp_drag_container').set_styles({
			width: obj.width * 3,
			height: obj.height * 3,
			top: obj.height * -1,
			left: obj.width * -1
		});
	};
	
	// function to print the recommended frame size
	function show_recommend_frame(){
		ng.get('pfapp_recommended').set_html('');
		
		// if none recommended or if the user already selected
		// the recommended size, return
		if (recommended_frame == '') return;
		if (ng.get('pfapp_frame_size_select').value == recommended_frame) return;
		
		var opts = ng.get('pfapp_frame_size_select').options;
		for (var i=0; i<opts.length; i++){
			if (opts[i].value == recommended_frame) {
				ng.get('pfapp_recommended').set_html('Recommended size: '+opts[i].innerHTML);
				break;
			}
		}
	};
});