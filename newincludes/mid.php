
	            <div class="alertText hideDiv"><b style="display:block;">Please select same size as previous proof</b> *Using a previously submitted file will result in prints the exact size of your last order. If you select a different frame size than the previous file was designed for, your final prints will not fit the frame. If you plan to use a different frame size, you will need to use to tool to design and submit a new photo. We recommend proofing any changes prior to placing a final order.</div>

	            <div id="sectionUpload">
		            <div id="pfapp_dpi_warning">
		            	The photo you selected is too small and not recommended.
		                Try to select a smaller frame size or select a larger photo.
		            </div>
		            <label for="pfapp_picture_upload">Photo:</label>
		            <div class="field" id="pfapp_upload_field">
		                <input type="file" name="UserPhoto" id="pfapp_picture_upload" class="input">
		            </div>
		            <div id="pfapp_loading_bar">&nbsp;</div>
		            <div id="pfapp_loading_wait">Please be patient, uploading large pictures might take a couple of minutes.</div>
	            

		            <label for="pfapp_picture_zoom">Photo Zoom:</label>
		            <div class="field" id="pfapp_range_slider">
		                <input type="range" name="PhotoZoom" id="pfapp_photo_zoom" min="0" max="100"  class="input" value="<?PHP printValue('PhotoZoom'); ?>">
		            </div>
		            
	            </div>

	            

	            <div id="buttonNext" class="newButton3"> Next</div>

	    </div><!--end of form div 1-->



	        <div id="pfapp_form_div-next" class="hideDiv">
	        	<div class="newButton"  id="buttonBack" >Back</div>



	            
