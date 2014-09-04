


<script>

//------------Bryans New Script
$("document").ready(function() {

var selectedSize ='4.25x5.75';

	$("#buttonStart").click(function() {
		$('#frameTwo').removeClass( "hideDiv" );
		$('#frameOne').addClass( "hideDiv" );
	});

//Next Button
	$("#buttonNext").click(function() {
		$('#pfapp_form_div').addClass( "hideDiv" );
		$('#pfapp_form_div-next').removeClass( "hideDiv" );

		$('#pfapp_photo_tools').addClass( "hideDiv" );
		$("#overlayContainer").addClass( "hideDiv" );

		//if checked set the values to blank
		if($('#matchproof').is(':checked')) {
			//
		};
				

	});
//Back Button
	$("#buttonBack").click(function() {
		$('#pfapp_form_div-next').addClass( "hideDiv" );
		$('#pfapp_form_div').removeClass( "hideDiv" );	
		$("#overlayContainer").removeClass( "hideDiv" );

		$('#pfapp_photo_tools').removeClass( "hideDiv" );	

	});
$("#buyProofBtn").click(function() {$('#prooforderinput').attr({value:  'bozo'});	});


// Previous Proof
	$( "#matchproof" ).change(function() {
		if($('#matchproof').is(':checked')) {
			$('.alertText').removeClass( "hideDiv" );
			$('#matchproof').attr({value:  '1'});
			//$('#pfapp_user_image').css({display:  'none'});
			$('#pfapp_photo_tools').addClass( "hideDiv" );
			$("#sampleImg").removeClass( "hideDiv" );
			$('#orderNumber').removeClass( "hideDiv" );
			$('#imageapprovebox').addClass( "hideDiv" );
			$('#proofBuyBox').addClass("hideDiv");
	 		$("#sectionUpload")
	 		.animate(
				{'opacity': '0'},200 );


		} else{
			$('#matchproof').attr({value:  '0'});
			$('.alertText').addClass( "hideDiv" );
			//$('#pfapp_user_image').css({display:  'block'});
			$("#sampleImg").addClass( "hideDiv" );
			$('#pfapp_photo_tools').removeClass( "hideDiv" );
			$('#orderNumber').addClass( "hideDiv" );
			$('#imageapprovebox').removeClass( "hideDiv" );
			$('#proofBuyBox').removeClass("hideDiv");
			$("#sectionUpload")
			//.animate(
				//{'height': '400px'},500 )
			.animate(
				{'display': 'block'},10 )
	 		.animate(
				{'opacity': '1'},200 );
		}

	});

//approval image alert
	$( "#imageapprove" ).change(function() {
		 if($(this).is(':checked')) {

    
    $.fancybox.open([
        {
            href : '#inline1', 
            title: '',
            closeClick: false

            
        },
    ], {
        padding : 20
    });
    
    return false;
	}
	});


	
	$( "#pfapp_qty" ).keyup(function() {
		var amt = $(this).val();
		console.log(amt);
		$('#variationqty').attr({value:  amt});
		
		});

//style functions

$('.newButton').hover(function() {
    $(this).toggleClass( "newHover" );
  });

$('.newButton2').hover(function() {
    $(this).toggleClass( "newHover2" );
  });

$('.newButton3').hover(function() {
    $(this).toggleClass( "newHover3" );
  });




$('.tipOne').attr('title','Check this box if you previously submitted a proof order and you want to use that image for this order');
$('.tipTwo').attr('title','Your previous order number can be found in your confirmation email. ');


//cluetips 
$('a.tips').css({borderBottom: '1px solid #900'}).cluetip({
  splitTitle: '|',
  arrows: true,
  showTitle: false,
  mouseOutClose: true,
  delayedClose:     500,
  width: 200,
  dropShadow: false,
  cluetipClass: 'jtip'}
);




	    $('a.fncy-custom-close').click(function(e){
	        e.preventDefault();
	        $.fancybox.close();
   			 });	


//new form validate



$('#buyBtns').click(function() {
	if (ng.get('matchproof').checked) {
		ng.get('pfSubmit').fire_event('change');
	} else{
					 	//proof test

			 		 $.fancybox.open([
				        {
				            href : '#inline2', 
				            title: '',
				            closeClick: false

				            
				        },
				    ], {
				    padding : 20   
					});
	    $('a.noproof-close').click(function(e){
	        e.preventDefault();
	        $.fancybox.close();
	        ng.get('pfSubmit').fire_event('change');
   			 });	
	    $('a.noproof-agree').click(function(e){
	        e.preventDefault();
	        $.fancybox.close();
	        ng.get('buyProofBtn').fire_event('change');
   			 });	
	}
});

$('#buyProofBtn').click(function() {

$.fancybox.open([
				        {
				            href : '#inline3', 
				            title: '',
				            closeClick: false

				            
				        },
				    ], {
				    padding : 20   
					});

		    $('a.proof-close').click(function(e){
	        e.preventDefault();
	        $.fancybox.close();
	        ng.get('buyProofBtn').fire_event('change');
   			 });	

	});


});


</script>



<style>
	.hideDiv{display: none;}
	ul{list-style: none;}
	.alertText{font-size: 13px; color:#df5a5c;}
	a.tipOne, a.tipTwo{display: inline-block; line-height: 25px; background: url('images/question.gif') no-repeat right; padding-right: 30px; text-decoration: none; color:#000000; border: none !important;}
	.frameOverlay{ position: absolute; z-index: 1; pointer-events: none;}
	.basicFrame{ background-image: url('images/basic-overlay-a7.png'); width: 360px; height: 504px;}
	.scallopedFrame{ background-image: url('images/scalloped-overlay-a7.png'); width: 360px; height: 504px;}
	.squaresFrame{ background-image: url('images/squares-overlay-a7.png'); width: 360px; height: 504px;}
	.victorianFrame{ background-image: url('images/victorian-overlay-a7.png'); width: 360px; height: 504px;}
	.ornateFrame{ background-image: url('images/ornate-overlay-a7.png'); width: 360px; height: 504px;}
	.basicFrame2{ background-image: url('images/basic-overlay-a2.png'); width: 288px; height: 396px;}
	.scallopedFrame2{ background-image: url('images/scalloped-overlay-a2.png'); width: 288px; height: 396px;}
	.squaresFrame2{ background-image: url('images/squares-overlay-a2.png'); width: 288px; height: 396px;}
	.victorianFrame2{ background-image: url('images/victorian-overlay-a2.png'); width: 288px; height: 396px;}
	.ornateFrame2{ background-image: url('images/ornate-overlay-a2.png'); width: 288px; height: 396px;}
	#loadingContainer{ display:none; position: absolute; width:100%; height:100%; background-color: white; text-align: center; z-index: 3;}
	#personalFields{background: #eeeeee; padding:15px;}
	#priceTxt{font-size: 18px; }
	#priceTxt span{color: #df903c;}
	a.t1:link { background: url(http://cardsandpockets.com/images/2012/tooltip.gif); width: 13px; height: 13px; display: block; margin-left: 10px;}
	.newButton { background: #f8f8f8; border: 1px solid #c6c6c6; display: inline-block; line-height: 28px; padding: 0 12px; -webkit-border-radius: 2px; border-radius: 2px; cursor:pointer; margin: 10px 0; }
	.newHover { background: #e3e3e3; border: 1px solid #c6c6c6;display: inline-block; line-height: 28px;padding: 0 12px; -webkit-border-radius: 2px; border-radius: 2px; cursor:pointer; margin: 10px 0; ; }
	.newButton2 { background: #fab25d; border: 1px solid #c6c6c6; display: inline-block; line-height: 28px; padding: 0 12px; -webkit-border-radius: 2px; border-radius: 2px; cursor:pointer; margin: 10px 0; }
	.newHover2 { background: #dd8f3b; border: 1px solid #c6c6c6;display: inline-block; line-height: 28px;padding: 0 12px; -webkit-border-radius: 2px; border-radius: 2px; cursor:pointer; margin: 10px 0;  }
	.newButton3 { background: #b7d8cc; border: 1px solid #c6c6c6; display: inline-block; line-height: 28px; padding: 0 12px; -webkit-border-radius: 2px; border-radius: 2px; cursor:pointer; margin: 10px 0;  }
	.newHover3 { background: #8edbbf; border: 1px solid #c6c6c6;display: inline-block; line-height: 28px;padding: 0 12px; -webkit-border-radius: 2px; border-radius: 2px; cursor:pointer; margin: 10px 0;  }
	#inline1 a, #inline2 a, #inline3 a{text-decoration: none; color:#000000;}

</style>

</head>

<body>

<div style="width: 500px; display: none;" id="inline1">
		<h3>Alert</h3>
		<p>
		Print results can vary quite a bit from the colors that you see on your computer monitor. Colors also vary from monitor to monitor- what we see on our monitors may not match what you see on your own. Your file will be sent to print as it is submitted, and we can not predict the quality of results.
		</p>
		<a href="#" class="fncy-custom-close" >
		    <span class="newButton3">I Understand</span>
		</a>
	</div>

<div style="width: 500px; display: none;" id="inline2">
		<h3>Hi There!</h3>

<p>We noticed that you opted to NOT use a file from a previous order. We strongly recommend that you order a proof to ensure that you are happy with your final prints.  If you would prefer to skip a proof, there are some important things to be aware of.</p>

<p><b>First</b>, print results can vary quite a bit from the colors that you see on your computer monitor. Colors also vary from monitor to monitor- what we see on our monitors may not match what you see on your own. Your file will be sent to print as it is submitted, and we can not predict the quality of results.</p>

<p><b>Second</b>, a single file could have different print results on different printers. It is important to understand that our print results will likely not match results achieved with your home printer.</p>

<p><b>Finally</b>, different papers have unique properties that affect the way they each take ink. Since each paper is slightly different, print results will vary between types of paper. Also, a lot of one specific paper could have slightly varied elements throughout the lot. This can result in some very slight variance throughout a print order.</p>

		<a href="#" class="noproof-close" >
		    <span class="newButton3">I Understand</span>
		</a>
				<a href="#" class="noproof-agree" >
		    <span class="newButton2">Buy Single Proof for $3.00</span>
		</a>
	</div>

<div style="width: 500px; display: none;" id="inline3">
		<h3>We're almost done!</h3>
	 <p>We just want to make sure that you are aware of some important things before you place your final order.</p>

	<p>1. When a proof is ordered through our Print Shop, we keep a copy here in our records along with your file. We do our best to ensure that final prints match the proof as closely as possible.</p>

	<p>2. Please be aware that even with careful attention to your order, there may be a slight difference between your proof and your final order. Paper elements can vary slightly throughout and between lots, which can affect how the paper takes the ink. This can result in some very slight variance throughout the stack of prints, or between orders if you order more at a later date.</p>

	<p>3. We want you to love your final prints, and we only ship final prints that are within an acceptable industry tolerance for color.</p>


		<a href="#" class="proof-close" >
		    <span class="newButton2">Proceed to Place my Order</span>
		</a>
	</div>

<div id="pfapp_container">

	<div id="pfapp_drag_container">&nbsp;</div>
	<div id="frameTwo">
		<div id="pfapp_picture_div">
	    	
	        <div id="pfapp_picture_holder">
	        	<!--overlay image-->
	        	<img src="images/previous.jpg" style="margin-top:0px; margin-left:0px; position:relative; z-index:2;" border="0" class="hideDiv" id="sampleImg"/>


	            <div class="user_photo" id="pfapp_user_photo" style="margin-top:<?PHP echo $_POST['top']; ?>px; margin-left:<?PHP echo $_POST['left']; ?>px; padding-top:<?PHP echo $zm_pt; ?>px; padding-left:<?PHP echo $zm_pl; ?>px;">
	        	<img src="<?PHP echo $user_photo; ?>" style="margin-top:<?PHP echo $_POST['margintop']; ?>px; margin-left:<?PHP echo $_POST['marginleft']; ?>px;" border="0" alt="" id="pfapp_user_image">
	            </div>
	            <img border="0" src="<?PHP echo IMAGESPATH.'/frames/web/'.$_POST['FrameSize'].'.png'; ?>" alt="" class="picture_frame" id="pfapp_photo_frame">
	        </div>
	        <div id="pfapp_frame_title"></div>
	        <div id="pfapp_photo_tools" style="text-align:center;">
	        	<div id="pfapp_fit_photo" class="newButton">Fit to Frame</div>
	        	<div id="pfapp_center_photo" class="newButton">Center Photo</div>
	        </div>
	    </div>
	    <div id="pfapp_form_div">
	    	<form method="post" id="pfapp_form" enctype="multipart/form-data">
	        	<input type="hidden" name="form_action" value="<?PHP echo $form_action; ?>">
	            <input type="hidden" name="current_image" id="pfapp_current_image" value="<?PHP echo htmlentities($_SESSION['current_image']); ?>">
	            <input type="hidden" name="top" id="pfapp_top_input" value="<?PHP printValue('top'); ?>">
	            <input type="hidden" name="left" id="pfapp_left_input" value="<?PHP printValue('left'); ?>">
	            <input type="hidden" name="margintop" id="pfapp_margintop_input" value="<?PHP printValue('margintop'); ?>">
	            <input type="hidden" name="marginleft" id="pfapp_marginleft_input" value="<?PHP printValue('marginleft'); ?>">
	            <input type="hidden" name="margin" id="pfapp_margin_input" value="<?PHP printValue('margin'); ?>">
	            <input type="hidden" name="prooforder" id="prooforderinput" value="<?PHP printValue('OrderNumber'); ?>">

	            <div class="field">
	            		<input type="checkbox" id="matchproof" name="matchproof" value="<?PHP printValue('MatchProof'); ?>"> <a href="#" class="tips tipOne"  title="title">Please use file from previous order </a>
	            		
	            </div>
	            <label for="pfapp_frame_size_select" style="display:none;">Frame Size: <span id="pfapp_recommended" class="small"></span></label>
	            	<div class="field" style="display:none;">
	    <select name="FrameSize" id="pfapp_frame_size_select">
	       <!-- <option value="none">Select</option>
	       <?PHP echo printFrameSizesOptions(); ?>-->
			<option value="4.25x5.75" id="frameA7">A7 PocketFrame</option>
			<option value="4x5.5" id="frameA2">A2 Pocketframe</option>

	    </select>
	</div>
