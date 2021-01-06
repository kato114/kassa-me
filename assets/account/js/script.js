$(function(){

	$("#newTransaction").on("submit", function(event){
		event.preventDefault();
		//alert("submitting");
		var $this = $(this);
		var $form = $this;
		var form_data = $form.serializeArray();
		/*console.log("here");
		console.log(form_data);
		return;*/
		var $alert_title = $this.text();
		if ($form.valid()) {
			$("#reqEmail").html($("#receiverEmail").val());
			$("#reqAmount").html($("#transValue").val());
			$("#reqNote").html($("#note").val());
			$('#confirmationBox').modal({
			  keyboard: false
			})			
		}

	 })
	$("#confirmTrans").on("click", function(event){
		event.preventDefault();
		var $this = $(this);
		var $form = $("#newTransaction");
		var form_data = $form.serializeArray();
		if ($form.valid()) {		
			$.ajax({
				type: "POST",
				url: "transreq.php",
				dataType: "json",
				data: form_data,
				beforeSend: function () {
					$('#confirmationBox').loading({
										  message: 'Sending...'
										});
				},
				success: function (response) {
					console.dir(response);
					//response = JSON.parse(response);					
					$("#confirmationBox").loading('stop')
					if (response.status == 0) {
						pop_alert('Success', response.message, 'success', 5000);
						window.setTimeout(function(){
							redirect_to("index.php");
						}, 5000);						
						//redirect_to("index.php");
					} else {
						pop_alert('Error', response.message, 'error');
					}
				},
				error: function (err) {
					console.dir(err);
					pop_alert('Error', err.statusText, 'error');
					$("#confirmationBox").loading('stop')
				},
			});
		}

	 });
	$("#confirmPay").on("click", function(event){
		event.preventDefault();
		var $this = $(this);
		var transaction_id = $("#transid").val();
		//alert(transaction_id);
		if (transaction_id !== undefined) {		
			$.ajax({
				type: "POST",
				url: "transpay.php",
				dataType: "json",
				data: {id:transaction_id},
				beforeSend: function () {
					$('#confirmationPayBox').loading({
										  message: 'Paying...'
										});
				},
				success: function (response) {
					console.dir(response);
					//response = JSON.parse(response);					
					$("#confirmationPayBox").loading('stop')
					if (response.status == 0) {
						pop_alert('Success', response.message, 'success', 10000);
						window.setTimeout(function(){
							redirect_to("index.php");
						}, 10000);
					} else {
						message = response.message;
						if(response._embedded != undefined)
							message = response._embedded.errors[0].message;
						pop_alert('Error', message, 'error');
					}
				},
				error: function (err) {
					console.dir(err);
					pop_alert('Error', err.statusText, 'error');
					$("#confirmationPayBox").loading('stop')
				},
			});
		}

	 })	 
	$("#newUpgradebtn").on("click", function(event){
		event.preventDefault();
		var $this = $("#newUpgrade");
		var $form = $this;
		var form_data = $form.serializeArray();
		console.dir(form_data);
		//alert("here");
		if ($form.valid()) {		
			$.ajax({
				type: "POST",
				url: "upgradeAcc.php",
				dataType: "json",
				data: form_data,
				beforeSend: function () {
					$('body').loading({
										  message: 'Sending...'
										});
				},
				success: function (response) {
					console.dir(response);
					//response = JSON.parse(response);					
					$("body").loading('stop')
					if (response.status == 0) {
						pop_alert('Success', response.message, 'success', 15000);
						setTimeout(function(){ redirect_to("index.php"); }, 15000);//redirect_to("index.php");
					} else {
						message = response.message;
						if(response._embedded != undefined)
							message = response._embedded.errors[0].message;
						pop_alert('Error', message, 'error');
					}
				},
				error: function (err) {
					console.dir(err);
					pop_alert('Error', err.statusText, 'error');
					$("body").loading('stop')
				},
			});
		}

	 });	 
	
	$("#newBOwner").on("submit", function(event){
		event.preventDefault();
		var $this = $("#newBOwner");
		var $form = $this;
		var form_data = $form.serializeArray();
		console.dir(form_data);
		//alert("newBOwner");
		//return;
		if ($form.valid()) {		
			$.ajax({
				type: "POST",
				url: "newBOwner.php",
				dataType: "json",
				data: form_data,
				beforeSend: function () {
					$('body').loading({
										  message: 'Sending...'
										});
				},
				success: function (response) {
					console.dir(response);
					//response = JSON.parse(response);					
					$("body").loading('stop')
					if (response.status == 0) {
						pop_alert('Success', response.message, 'success', 15000);
						setTimeout(function(){ redirect_to("index.php"); }, 15000);//redirect_to("index.php");
					} else {
						message = response.message;
						if(response._embedded != undefined)
							message = response._embedded.errors[0].message;
						pop_alert('Error', message, 'error');
					}
				},
				error: function (err) {
					console.dir(err);
					pop_alert('Error', err.statusText, 'error');
					$("body").loading('stop')
				},
			});
		}

	 });
	 
	 
	$("#bownCertify").on("submit", function(event){
		event.preventDefault();
		var $this = $("#bownCertify");
		var $form = $this;
		var form_data = $form.serializeArray();
		console.dir(form_data);
		//alert("bownCertify");
		//return;
		if ($form.valid()) {		
			$.ajax({
				type: "POST",
				url: "certifyBOwner.php",
				dataType: "json",
				data: form_data,
				beforeSend: function () {
					$('body').loading({
										  message: 'Sending...'
										});
				},
				success: function (response) {
					console.dir(response);
					//response = JSON.parse(response);					
					$("body").loading('stop')
					if (response.status == 0) {
						pop_alert('Success', response.message, 'success', 15000);
						setTimeout(function(){ redirect_to("index.php"); }, 15000);//redirect_to("index.php");
					} else {
						message = response.message;
						if(response._embedded != undefined)
							message = response._embedded.errors[0].message;
						pop_alert('Error', message, 'error');
					}
				},
				error: function (err) {
					console.dir(err);
					pop_alert('Error', err.statusText, 'error');
					$("body").loading('stop')
				},
			});
		}

	 });
	 
	//$(".dateBirth").inputmask("99/99/9999",{ "placeholder": "*" });
    $('#example').DataTable({
        "order": []
    });

	/* $('select').select2({
		placeholder: "Select your option",
		allowClear: true
	});*/
  var handler = Plaid.create({
    clientName: 'Kassa Me',
    countryCodes: ['US'],
    env: 'sandbox',
    key: 'aef1edcbe1428fdd489cce276e8da7',
    product: ['transactions'],
    webhook: 'https://kassame.com/webhook',
    language: 'en',
    onLoad: function() {
      // Optional, called when Link loads
    },
    onSuccess: function(public_token, metadata) {
		$('body').loading({
				message: 'Adding Funding source...'
		});		
		  $.post('./get_access_token', {
			public_token: public_token,
			metadata: metadata
		  }, function(response){
			  console.log("success", response);
				if (response.status == 0) {
					pop_alert('Success', response.message, 'success', false);
					$('body').loading("stop");
				} else {
					message = response.message;
					if(response._embedded != undefined){
						message = response._embedded.errors[0].message;
					}
					pop_alert('Error', message, 'error', false);
					$('body').loading("stop");
				}			  
		  }, "json").done(function( data ) {
			//alert( "Data Loaded: " + data );
			$('body').loading("stop");
			console.dir(data);		
		  }) .fail(function(err_data) {
			//alert( "error" );
			pop_alert('Error', err_data, 'error', false);
			$('body').loading("stop");
			console.dir(err_data);
		  })
		  .always(function() {
			//alert( "finished" );
		  });
	  
	  
    },
    onExit: function(err, metadata) {
      if (err != null) {
      }
    },
    onEvent: function(eventName, metadata) {
    }
  }); 
$("#fndSRC").on("click", function(event){
	event.preventDefault();
	//alert("Plaind Link");
	handler.open();
});
$(".fndSRCUpdate").on("click", function(event){
	event.preventDefault();
	  var handlerUpdate = Plaid.create({
		clientName: 'Kassa Me',
		countryCodes: ['US'],
		env: 'sandbox',
		key: 'aef1edcbe1428fdd489cce276e8da7',
		token: 'public-sandbox-211791d3-103b-4802-ac01-95213c4008ad',
		product: ['transactions'],
		webhook: 'https://kassame.com/webhook',
		language: 'en',
		onLoad: function() {
		  // Optional, called when Link loads
		},
		onSuccess: function(public_token, metadata) {
			$('body').loading({
					message: 'Adding Funding source...'
			});		
			  $.post('./get_access_token', {
				public_token: public_token,
				metadata: metadata
			  }, function(response){
				  console.log("success", response);
					if (response.status == 0) {
						pop_alert('Success', response.message, 'success', false);
						$('body').loading("stop");
					} else {
						message = response.message;
						if(response._embedded != undefined){
							message = response._embedded.errors[0].message;
						}
						pop_alert('Error', message, 'error', false);
						$('body').loading("stop");
					}			  
			  }, "json").done(function( data ) {
				//alert( "Data Loaded: " + data );
				$('body').loading("stop");
				console.dir(data);		
			  }) .fail(function(err_data) {
				//alert( "error" );
				pop_alert('Error', err_data, 'error', false);
				$('body').loading("stop");
				console.dir(err_data);
			  })
			  .always(function() {
				//alert( "finished" );
			  });
		  
		  
		},
		onExit: function(err, metadata) {
		  if (err != null) {
		  }
		},
		onEvent: function(eventName, metadata) {
		}
	  }); 	
	handlerUpdate.open();
});
$('#transValue').mask('000.000.000.000.000.00', {reverse: true});

$("#resendPending").on("click", function(event){
	event.preventDefault();
	//alert("Resending...");
		event.preventDefault();
		var $this = $("#resendTransForm");
		var $form = $this;
		var form_data = $form.serializeArray();
		console.dir(form_data);
		//alert("here");
		if ($form.valid()) {		
			$.ajax({
				type: "POST",
				url: "transresend.php",
				dataType: "json",
				data: form_data,
				beforeSend: function () {
					$('body').loading({
										  message: 'Sending...'
										});
				},
				success: function (response) {
					console.dir(response);
					//response = JSON.parse(response);					
					$("body").loading('stop')
					if (response.status == 0) {
						pop_alert('Success', response.message, 'success', false);
						//redirect_to("index.php");
					} else {
						message = response.message;
						if(response._embedded != undefined)
							message = response._embedded.errors[0].message;
						pop_alert('Error', message, 'error', false);
					}
				},
				error: function (err) {
					console.dir(err);
					pop_alert('Error', err.statusText, 'error');
					$("body").loading('stop')
				},
			});
		}	
});
	$("#confirmCC").on("click", function(event){
		event.preventDefault();
		var $this = $(this);
		var transaction_id = $("#transid").val();
		//alert(transaction_id);
		if (transaction_id !== undefined) {		
			$.ajax({
				type: "POST",
				url: "transpaycc.php",
				dataType: "json",
				data: {id:transaction_id},
				beforeSend: function () {
					$('#confirmationPayBox').loading({
										  message: 'Generating token...'
										});
				},
				success: function (response) {
					console.dir(response);
					//response = JSON.parse(response);					
					$("#confirmationPayBox").loading('stop')
					if (response.status == 0) {
						pop_alert('Success', response.message, 'success');
						redirect_to("https://api.demo.convergepay.com/hosted-payments?ssl_txn_auth_token="+response.token);
					} else {
						message = response.message;
						if(response._embedded != undefined)
							message = response._embedded.errors[0].message;
						pop_alert('Failed', message, 'error');
					}
				},
				error: function (err) {
					console.dir(err);
					pop_alert('Error', err.statusText, 'error');
					$("#confirmationPayBox").loading('stop')
				},
			});
		}

	 })	 


	$("input[name=new_controller").on("click", function(event){
		if($(this).val()=='no'){
			$("#controller_fields").fadeIn("slow"); 
			//alert("Checked!");
		}
		else{
			$("#controller_fields").fadeOut("slow"); 
			//alert("unchecked!");
		}
	});
	$("input[name=more_ownership").on("click", function(event){
		if($(this).val()=='yes'){
			$("#div_bo_count").fadeIn("slow"); 
			//alert("Checked!");
		}
		else{
			$("#div_bo_count").fadeOut("slow"); 
			//alert("unchecked!");
		}
	});	
	$("input[name=bo_count").on("click", function(event){
		if($(this).val()=='1'){
			$("#div_1st_bo").fadeIn("slow");
			$("#div_2st_bo").fadeOut("slow");			
			//alert("Checked!");
		}
		else{
			$("#div_1st_bo").fadeIn("slow"); 
			$("#div_2st_bo").fadeIn("slow"); 
			//alert("unchecked!");
		}
	});
	
	
});
function pop_alert(heading, text, icon, timer=false){
	
	$.toast({
		heading: heading,
		text: text,
		position: "mid-center",
		icon: icon,
		hideAfter: timer
	});

}
function redirect_to(location){
	window.location.href=location;
}