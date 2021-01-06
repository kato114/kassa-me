$(function(){
	
	$("#loginForm").on("submit", function(event){
		event.preventDefault();
		//alert("submitting");
		var $this = $(this);
		var $form = $this;
		var form_data = $form.serializeArray();
		form_data.push({ name: "action", value: "ere_update_money_laundering_ajax" });
		var $alert_title = $this.text();
		if ($form.valid()) {
			$.ajax({
				type: "POST",
				url: "auth.php",
				dataType: "json",
				data: form_data,
				beforeSend: function () {
					$('body').loading({
									  onStart: function(loading) {
										loading.overlay.slideDown(400);
									  },
									  onStop: function(loading) {
										loading.overlay.slideUp(400);
									  }
									});
				},
				success: function (response) {
					console.dir(response);
					//response = JSON.parse(response);					
					$("body").loading('stop')
					if (response.status == 0) {
						pop_alert('Success', response.message, 'success');
						redirect_to("account/");
					} else {
						pop_alert('Error', response.message, 'error', false);
					}
				},
				error: function (err) {
					console.dir(err);
					$.toast({
								heading: 'Error',
								text: err.statusText,
								position: 'mid-center',
								icon: 'error'						
							
							});
					$("body").loading('stop')//KASSAME.close_loading(0);
				},
			});
		}

	})
	$("#signupForm").on("submit", function(event){
		event.preventDefault();
		//alert("submitting");
		var $this = $(this);
		var $form = $this;
		var form_data = $form.serializeArray();
		form_data.push({ name: "action", value: "ere_update_money_laundering_ajax" });
		/*console.log("here");
		console.log(form_data);
		return;*/
		var $alert_title = $this.text();
		if ($form.valid()) {
			var password = jQuery("input[name=password").val();
			const passRegex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/
			if (!passRegex.test(password)) {
				pop_alert('Error', 'Password must be at least 12 characters long and contain 1 lowercase letter, 1 uppercase letter, 1 digit and 1 special symbol.', 'error', false);
				return;
			}
			$.ajax({
				type: "POST",
				url: "register.php",
				dataType: "json",
				data: form_data,
				beforeSend: function () {
					$('body').loading({
									  onStart: function(loading) {
										loading.overlay.slideDown(400);
									  },
									  onStop: function(loading) {
										loading.overlay.slideUp(400);
									  },
									  message: 'Signing up...'
									});//KASSAME.show_loading();
				},
				success: function (response) {
					console.dir(response);
					//response = JSON.parse(response);					
					$("body").loading('stop')
					if (response.status == 0) {
						//pop_alert('Success', response.message, 'success', false);
						pop_alert('Success', response.message, 'success', 10000);
						window.setTimeout(function(){
							redirect_to("index.php");
						}, 10000);							
					} else {
						pop_alert('Error', response.message, 'error', false);
					}
				},
				error: function (err) {
					console.dir(err);
					pop_alert('Error', err.statusText, 'error');
					$("body").loading('stop')
				},
			});
		}

	})	
	$("#forgotForm").on("submit", function(event){
		event.preventDefault();
		//alert("submitting");
		var $this = $(this);
		var $form = $this;
		var form_data = $form.serializeArray();
		form_data.push({ name: "action", value: "reset_form_ajax" });
		var $alert_title = $this.text();
		if ($form.valid()) {
			$.ajax({
				type: "POST",
				url: "resetreq.php",
				dataType: "json",
				data: form_data,
				beforeSend: function () {
					$('body').loading({
									  onStart: function(loading) {
										loading.overlay.slideDown(400);
									  },
									  onStop: function(loading) {
										loading.overlay.slideUp(400);
									  },
									  message: 'Sending request...'
									});
				},
				success: function (response) {
					console.dir(response);				
					$("body").loading('stop')
					if (response.status == 0) {
						pop_alert('Success', response.message, 'success', 10000);
						window.setTimeout(function(){
							redirect_to("index.php");
						}, 10000);						
					} else {
						pop_alert('Error', response.message, 'error', false);
					}
				},
				error: function (err) {
					console.dir(err);
					pop_alert('Error', err.statusText, 'error', false);
					$("body").loading('stop')
				},
			});
		}

	})
	$("#resetForm").on("submit", function(event){
		event.preventDefault();
		//alert("submitting");
		var $this = $(this);
		var $form = $this;
		var form_data = $form.serializeArray();
		form_data.push({ name: "action", value: "reset_form_ajax" });
		var $alert_title = $this.text();
		if ($form.valid()) {
			var password = jQuery("input[name=new_password").val();
			const passRegex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/
			if (!passRegex.test(password)) {
				pop_alert('Error', 'Password must be at least 12 characters long and contain 1 lowercase letter, 1 uppercase letter, 1 digit and 1 special symbol.', 'error', false);
				return;
			}			
			$.ajax({
				type: "POST",
				url: "resetreq.php",
				dataType: "json",
				data: form_data,
				beforeSend: function () {
					$('body').loading({
									  onStart: function(loading) {
										loading.overlay.slideDown(400);
									  },
									  onStop: function(loading) {
										loading.overlay.slideUp(400);
									  },
									  message: 'Resetting password...'
									});
				},
				success: function (response) {
					console.dir(response);				
					$("body").loading('stop')
					if (response.status == 0) {
						pop_alert('Success', response.message, 'success', 10000);
						setTimeout(function(){
							redirect_to("index.php");
						}, 5000)
					} else {
						pop_alert('Error', response.message, 'error', false);
					}
				},
				error: function (err) {
					console.dir(err);
					pop_alert('Error', err.statusText, 'error', false);
					$("body").loading('stop')
				},
			});
		}

	})	
})

function pop_alert(heading, text, icon, timer=5000){
	
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