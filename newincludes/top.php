


<script>

//------------Bryans New Script
$("document").ready(function() {
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
		$('#guide-select').attr('checked', false);
		exampleImage();
		$('#photo-text').toggleClass( "hide" );
		$('#guide-box').toggleClass( "hide" );
		

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
		exampleImage();
		$('#photo-text').toggleClass( "hide" );
		$('#guide-box').toggleClass( "hide" );


	});
$("#buyProofBtn").click(function() {$('#prooforderinput').attr({value:  'bozo'});	});



//example default

var defaultLayout = $('#select-layout').attr('default');
if(defaultLayout == '5.75x4.25'){
	$('#frameA2').prop('selected', true);
}else{
}

//Example Select
    var current_size = $('#pfapp_frame_size_select').val();

//first load of example image
	function exampleImage() {
	   if(current_size == "4.25x5.75"){
				if($('#example-light').is(':checked')) {
					var alt1 =  $('#example-light').attr('valone');
					var alt3 =  $('#example-light').attr('valthree');

					if($('#guide-select').is(':checked')) {
						$("#pfapp_photo_frame").attr( "src", alt3 );
						$("#guide-text").removeClass( "hide" );
					}else{
						$("#pfapp_photo_frame").attr( "src", alt1 );
						$("#guide-text").addClass( "hide" ); 
					}
				} 
				if($('#example-dark').is(':checked')) {
					var alt1d=  $('#example-dark').attr('valone');
					var alt3d=  $('#example-dark').attr('valthree');
					if($('#guide-select').is(':checked')) {
						$("#pfapp_photo_frame").attr( "src", alt3d);
						$("#guide-text").removeClass( "hide" );
					}else{
						$("#pfapp_photo_frame").attr( "src", alt1d);
						$("#guide-text").addClass( "hide" ); 
					}
				}
			}if(current_size == "5.75x4.25"){
				if($('#example-light').is(':checked')) {
					var alt2 =  $('#example-light').attr('valtwo');
					var alt4 =  $('#example-light').attr('valfour');

					if($('#guide-select').is(':checked')) {
					$("#pfapp_photo_frame").attr( "src", alt4 );
					$("#guide-text").removeClass( "hide" );
					}else{
						$("#pfapp_photo_frame").attr( "src", alt2 );
						$("#guide-text").addClass( "hide" ); 
					}
				} 
				if($('#example-dark').is(':checked')) {
					var alt2d=  $('#example-dark').attr('valtwo');
					var alt4d=  $('#example-dark').attr('valfour');

					if($('#guide-select').is(':checked')) {
						$("#pfapp_photo_frame").attr( "src", alt4d);
						$("#guide-text").removeClass( "hide" );
					}else{
						$("#pfapp_photo_frame").attr( "src", alt2d);
						$("#guide-text").addClass( "hide" ); 
					}
				}			
			}		             
	}
	

setTimeout(function() { exampleImage(); }, 100);

    $('#pfapp_frame_size_select').change(function() {
		current_size = $(this).val();
		setTimeout(function() { exampleImage(); }, 10);
		if($('#matchproof').is(':checked')) {
			if(current_size == "4.25x5.75"){
				$("#sampleImg").removeClass( "hideDiv" );
				$("#sampleImg2").addClass( "hideDiv" );
			} if(current_size == "5.75x4.25"){
				$("#sampleImg2").removeClass( "hideDiv" );
				$("#sampleImg").addClass( "hideDiv" );
			}
		}
   });


	$("#select-example").change(function() {
		exampleImage();
	});


//Guides Selected
$( "#guide-select" ).change(function() {
	exampleImage();
 });


//choose paper



$('#paperSelect').change(function() {
	var paperSelected = $(this).val();
	var overAll = 18.95;
	var addon;
		if(paperSelected == 'heavy-white'){
			$("#variationid").attr( "value", '64885' );
			$("#proofvariationid").attr( "value", '64899' );
			addon = 0.00;
		}if(paperSelected == 'heavy-cream'){
			$("#variationid").attr( "value", '64886' );
			$("#proofvariationid").attr( "value", '64900' );
			addon = 0.00;
		}if(paperSelected == 'crystal'){
			$("#variationid").attr( "value", '64887' );
			$("#proofvariationid").attr( "value", '64901' );
			addon = 1.25;
		}if(paperSelected == 'opal'){
			$("#variationid").attr( "value", '64888' );
			$("#proofvariationid").attr( "value", '64902' );
			addon = 1.25;
		}if(paperSelected == 'quartz'){
			$("#variationid").attr( "value", '64889' );
			$("#proofvariationid").attr( "value", '64903' );
			addon = 1.25;
		}if(paperSelected == 'photo-matte'){
			$("#variationid").attr( "value", '64890' );
			$("#proofvariationid").attr( "value", '64904' );
			addon = 2.00;

		}if(paperSelected == 'photo-glossy'){
			$("#variationid").attr( "value", '64891' )
			$("#proofvariationid").attr( "value", '64905' );
			addon = 2.00;
		}
	var fix = (overAll + addon).toFixed(2);
	$('#priceTxt span').html(' $' + fix + ' ');

});






// Previous Proof
	$( "#matchproof" ).change(function() {
		if($('#matchproof').is(':checked')) {
			$('.alertText').removeClass( "hideDiv" );
			$('#matchproof').attr({value:  '1'});
			//$('#pfapp_user_image').css({display:  'none'});
			$('#pfapp_photo_tools').addClass( "hideDiv" );
			 if(current_size == "4.25x5.75"){
				$("#sampleImg").removeClass( "hideDiv" );
			} if(current_size == "5.75x4.25"){
				$("#sampleImg2").removeClass( "hideDiv" );
			}
			
			$('#orderNumber').removeClass( "hideDiv" );
			$('#select-example').addClass( "hide" );
			$('#imageapprovebox').addClass( "hideDiv" );
			$('#proofBuyBox').addClass("hideDiv");
	 		$("#sectionUpload")
	 		.animate(
				{'opacity': '0'},200 );


		} else{
			$('#matchproof').attr({value:  '0'});
			$('.alertText').addClass( "hideDiv" );
			$('#pfapp_photo_frame').css({top:  '0px'});
				$("#sampleImg2").addClass( "hideDiv" );
				$("#sampleImg").addClass( "hideDiv" );
				$('#select-example').removeClass( "hide" );

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


//if postcard  
$( "#select-card-type" ).change(function() {
	var cardSelection = $(this).val();
console.log(cardSelection);
	if(cardSelection == 'Single Sided with Envelope') {
		$('#env-select').removeClass( "hide" );	
		$('option:selected', 'select[name="select-envelope"]').removeAttr('selected');
		$('select[name="select-envelope"]').find('option[name="select"]').attr("selected",true);
		$('#optionPhotomatte').removeClass( "hide" );
		$('#optionPhotoglossy').removeClass( "hide" );
	}else{
		$('#env-select').addClass( "hide" );
		$('option:selected', 'select[name="select-envelope"]').removeAttr('selected');
		$('select[name="select-envelope"]').find('option[name="postcard"]').attr("selected",true);

		$('#optionPhotomatte').addClass( "hide" );
		$('#optionPhotoglossy').addClass( "hide" );
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


//Inline 4
	$( "#example-alert" ).click(function() {

		$.fancybox.open([
		{
			href : '#inline4', 
			title: '',
			closeClick: false


		},
		], {
			padding : 20
		});

		return false;
	});
// -- end of inline 4	

	
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
$('.tipThree').attr('title','This design features a “light” and “dark” visualization so that you can get a sense of how light or dark text will contrast against your photo. It is important to choose colors in the drop-down that will print well to show up against your unique photo. For example, light colors will show up better against a dark background, but darker colors should be selected if you have a light background. ');


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
	.alertText2{font-size: 13px; color:#bd8586; display: block; margin: 10px 0 0 20px;}
	a.tipOne, a.tipTwo, a.tipThree{display: inline-block; line-height: 25px; background: url('images/question.gif') no-repeat right; padding-right: 30px; text-decoration: none; color:#000000; border: none !important;}
	.field label {width: 130px; display: inline-block;}
	#select-example label{width: 230px; display: block;}
	#pfapp_range_slider label {width:80%;}
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
	#inline1 a, #inline2 a, #inline3 a, #inline4 a{text-decoration: none; color:#000000;}

	.fancybox-wrap{top: 100px !important;}

	#guide-box{padding: 30px; text-align: center; padding:20px; margin: 10px 40px; background-color: #f8f8f8;}
	#guide-box label {display: block; cursor: pointer;}
	#guide-text p{font-size:12px; text-align: left; }
	.p3{background:url(https://www.cardsandpockets.com/images/icons/16-message-warn2.png) no-repeat 4px 8px #FFEDD6; padding:8px 8px 8px 25px; font-size:11px;}
	.p4{background:url(https://www.cardsandpockets.com/images/icons/16-message-info.png) no-repeat 4px 8px #E9F0F7; padding:8px 8px 8px 25px; font-size:11px;}

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
		    <span class="newButton2">Buy Single Proof for $5.00</span> 
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

<div style="width: 500px; display: none;" id="inline4">
		<p>*This design features a “light” and “dark” visualization so that you can get a sense of how light or dark text will contrast against your photo. It is important to choose colors in the drop-down that will print well to show up against your unique photo. Light colors will show up better against a dark background, and darker colors should be selected if you have a light background.</p>
		</p>
		<a href="#" class="fncy-custom-close" >
		    <span class="newButton3">I Understand</span>
		</a>
	</div>


<div id="pfapp_container">

	<div id="pfapp_drag_container">&nbsp;</div>
	<div id="loadingContainer"><img src="images/cart-gif.gif" width="400" height="400" style="display:block; margin:auto;" id="loadingImage" ></div>

	<div id="frameTwo">
		<div id="pfapp_picture_div">
	    	
	        <div id="pfapp_picture_holder">
	        	<!--overlay image-->
	        	<img src="<?PHP echo $example1; ?>" style="margin-top:0px; margin-left:0px; position:relative; z-index:2;" border="0" class="hideDiv" id="sampleImg"/>
	        	<img src="<?PHP echo $example2; ?>" style="margin-top:0px; margin-left:0px; position:relative; z-index:2;" border="0" class="hideDiv" id="sampleImg2"/>


	            <div class="user_photo" id="pfapp_user_photo" style="margin-top:<?PHP echo $_POST['top']; ?>px; margin-left:<?PHP echo $_POST['left']; ?>px; padding-top:<?PHP echo $zm_pt; ?>px; padding-left:<?PHP echo $zm_pl; ?>px;">
	        	<img src="<?PHP echo $user_photo; ?>" style="margin-top:<?PHP echo $_POST['margintop']; ?>px; margin-left:<?PHP echo $_POST['marginleft']; ?>px;" border="0" alt="" id="pfapp_user_image">
	            </div>
	            <img border="0" src="<?PHP echo IMAGESPATH.'/frames/web/'.$_POST['FrameSize'] + $example.'.png'; ?>" alt="" class="picture_frame" id="pfapp_photo_frame">
	        </div>

	        <?php //SHOWS GUIDES ON ALL BUT 3 OF THE STD's
	         	$pageNum = substr($images_folder, 1, 7);
	         	if($pageNum != 'frame23' && $pageNum != 'frame22' && $pageNum != 'frame08')
	         		//echo '<div id="guide-box"><input type="checkbox" value="show-guides" id="guide-select" checked> Show Guides</div>';
	         	include 'guides.php';
	         ?>

	         <div id="photo-text" class="hide p3" style="font-size:14px; margin: 20px 60px;"><b>Please note that the above image will not change to reflect your text and color choices.</b>
	          <p>Our designers will create a custom file for you based on your colors, text, and photo once you submit the file to the print shop. We recommend ordering a proof to see how your customizations will look in print.</p></div>
	         
	        <div id="pfapp_frame_title" style="display:none;"></div>
	        <div id="pfapp_photo_tools" style="display:none;">
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



		<h3>Hi There</h3>
		<p>To see how your personal photo looks with this design, just upload and use the placement and zoom tools. The red and blue guidelines will help you place your photo. </p>

<p class="p4" style="font-size:12px; line-height:140%;">Please note that there is some slight variance in cutting and final cut pieces may not be cut in the exact place as your screen image.We recommend ordering a proof to see how your customizations will look in print.</p>
	            <div class="field">
	            		<input type="checkbox" id="matchproof" name="matchproof" value="<?PHP printValue('MatchProof'); ?>"> <a href="#" class="tips tipOne"  title="title">Please use file from previous order </a>
	            		
	            </div>
	            

