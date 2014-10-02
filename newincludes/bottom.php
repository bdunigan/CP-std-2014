	            
	            <div class="field" id="imageapprovebox">
	            		<input type="checkbox" id="imageapprove" name="imageapprove" value="<?PHP printValue('MatchProof'); ?>"> I approve this image for printing
	            </div>
 
				 
				<div id="personalFields" style="margin-bottom:20px;">

	            <div id="orderNumber" class="hideDiv field">
	            <label for="pfapp_order_number" style="width:230px;"><a href="#" class="tips tipTwo" title="title">Previous Proof Order Number:</a></label>
	                <input type="text" name="OrderNumber" id="pfapp_order_number" class="input" value="<?PHP printValue('OrderNumber'); ?>">
	            </div>

		            <label>Name</label>
		            <div class="field">
		                <input type="text" name="FirstName" id="pfapp_fname" class="input half" value="<?PHP printValue('FirstName'); ?>">
		                <input type="text" name="LastName" id="pfapp_lname" class="input half" value="<?PHP printValue('LastName'); ?>">
		                <label class="small" for="pfapp_fname">First</label>
		                <label class="small" for="pfapp_lname">Last</label>
		            </div>
		            
		            
		            <div class="field">
		            	<label for="pfapp_email">Email</label>
		                <input type="email" name="Email" id="pfapp_email" class="input" value="<?PHP printValue('Email'); ?>">
		            </div>
	            </div>

	            <div id="proofBuyBox">
			        <div id="buyProofBtn" class="newButton3"> Buy a Single Proof for <span id="samplePrice">$ 5.00</span></div> 
			        <p class="small">----------------------------------- or -----------------------------------</p>
		   		</div>

	            <div class="field" style="margin-top:20px;">
	            	<h3 id="priceTxt" style="margin-bottom:0px;">Retail Price: <span style="font-size:18px;">$ 0.35</span></h3>
	            	<label for="pfapp_email">Quantity</label>
	                <input type="text" name="qty" id="pfapp_qty" class="input" style="width:50px; margin-right:10px;">
	                <div id="buyBtns" class="newButton2" > Place Full Order</div> 
	            </div>

	            
	            
	            <input type="hidden" value="Submit" id="pfSubmit" />
	        </form>
	        
	       <!--FORM 2-->
	       <form method="post" action="http://www.cardsandpockets.com/photosavethedate.aspx" id="sampleForm" target="sampleBuyiframe">
						<input name="variationid" type="hidden" id="variationid" value="64885"/>
						<input name="quantity" type="hidden" value="1" maxlength="10" size="3" id="variationqty" /></label>
				 		<input type="hidden" name="addtocart" id="sampleCart" />
				</form>	

	        <!--FORM 3-->
	       <form method="post" action="http://www.cardsandpockets.com/photosavethedate-sample.aspx" id="proofForm" target="sampleBuyiframe">
						<input name="variationid" type="hidden" id="proofvariationid" value="64899"/>
						<input name="quantity" type="hidden" value="1" maxlength="10" size="3"  /></label>
				 		<input type="hidden" name="addtocart" id="sampleCart" />
				</form>	

				<iframe  name="sampleBuyiframe" height="100" style="visibility:hidden" scrolling="no" frameborders="0" id="sampleBuyiframe"></iframe>
	    </div><!--end of form div 2-->
	</div><!--end of frame one-->
</div>




</body>
</html> 


