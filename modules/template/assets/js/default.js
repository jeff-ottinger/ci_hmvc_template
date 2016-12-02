$(document).ready(function() {
	$('.ik-searchbox, .ik-ddsearchbox').submit(function(e) {
		e.preventDefault();
		window.location.href = '/search/?q=' + $(this).find('.search').val();
	});
	$(".expert[data-toggle='tooltip']").tooltip({
		html: true
	});

	function errorMsg(message) {
		bootbox.alert({
			title: 'Error',
			message: message
		});
	}
	$('.loginlink').click(function() {
		bootbox.dialog({
			title: "Login to Your Account",
			message: `
				<form id="loginform">
					<div class="loginerror"></div>
					<fieldset class="form-group">
						<label for="loginusername">Username</label>
						<input type="text" class="form-control" name="loginusername" id="loginusername" placeholder="Enter Username">
					</fieldset>
					<fieldset class="form-group">
						<label for="loginpassword">Password</label>
						<input type="password" class="form-control" name="loginpassword" id="loginpassword" placeholder="Password">
					</fieldset>
				</form>
				<div class="login-help">
					<a href="#">Register</a> <span style="vertical-align:bottom;line-height:10px;">&dot;</span> <a href="#">Forgot Password</a>
				</div>
			`,
			buttons: {
				login: {
					label: 'Log In',
					callback: function() {
						$.post('/auth/authenticate', $('#loginform').serialize(), function(
							response) {
							if (response.success) {
								window.location.href = "/home";
							} else {
								$('.loginerror').html('Invalid Username or Password!');
							}
						}, 'json');
					}
				}
			}
		});
		$('#loginform').keypress(function(e) {
			if (e.keyCode == 13) {
				$('[data-bb-handler="login"]').click();
			}
		});
	});
	$(document).on('click', '.makeoffer', function() {
		var itemid = $(this).attr('data-id');
		bootbox.dialog({
			title: "Make an Offer",
			message: `
				<form id="offerform">
					<input type="hidden" name="itemid" id="itemid" value="${itemid}"/>
<?php
	if ($this->ion_auth->logged_in()){
		$user=$this->ion_auth->user()->row();
?>
					<input type="hidden" name="email" id="email" value="<?php echo $user->email;?>"/>
					<input type="hidden" name="name" id="name" value="<?php echo $user->first_name . ' ' . $user->last_name;?>"/>
<?php
	}else{
?>
					<fieldset class="form-group">
						<label for="name">Contact Name</label>
						<input type="text" class="form-control" name="name" id="name" />
					</fieldset>
					<fieldset class="form-group">
						<label for="email">Contact Email</label>
						<input type="email" class="form-control" name="email" id="email" />
					</fieldset>
<?php
	}
?>
					<fieldset class="form-group">
						<label for="phone">Contact Phone Number</label>
						<input type="text" class="form-control" name="phone" id="phone" />
					</fieldset>
					<fieldset class="form-group">
						<label for="offer">Offer Amount</label>
						<div class="input-group">
							<span class="input-group-addon">$</span>
							<input type="number" value="0" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" name="offer" id="offer" />
						</div>
					</fieldset>
					<fieldset class="form-group">
						<label for="expiredate">Expire Date</label>
						<div class="input-group date" data-provide="datepicker" data-orientation="auto" data-autoclose="true">
							<input type="text" class="form-control" id="date" name="date"><span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
						</div>
					</fieldset>
					<fieldset class="form-group">
						<label for="message">Message To Seller</label>
						<textarea id="message" name="message" class="form-control"></textarea>
					</fieldset>
				</form>
			`,
			buttons: {
				offer: {
					label: 'Submit Offer',
					callback: function() {
						$.post('/offer/addOffer', $('#offerform').serialize()).then(
							function() {
								$.get('/offer/getOffer/' + itemid, function(response) {
									$('.currentoffer[data-id=' + itemid + '] .offer').html(
										'$' + parseFloat(response.offer).toFixed(2).replace(
											/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
								}, "json");
							});
					}
				}
			}
		});
	});
	$(document).on('click', '.buynow', function() {
		var itemid = $(this).attr('data-id');
		bootbox.dialog({
			title: "Purchase Request",
			message: `
				<form id="buynowform">
					<input type="hidden" name="itemid" id="itemid" value="${itemid}"/>
<?php
	if ($this->ion_auth->logged_in()){
		$user=$this->ion_auth->user()->row();
?>
					<input type="hidden" name="email" id="email" value="<?php echo $user->email;?>"/>
					<input type="hidden" name="name" id="name" value="<?php echo $user->first_name . ' ' . $user->last_name;?>"/>
<?php
	}else{
?>
					<fieldset class="form-group">
						<label for="name">Contact Name</label>
						<input type="text" class="form-control" name="name" id="name" />
					</fieldset>
					<fieldset class="form-group">
						<label for="email">Contact Email</label>
						<input type="email" class="form-control" name="email" id="email" />
					</fieldset>
<?php
	}
?>
					<fieldset class="form-group">
						<label for="phone">Contact Phone Number</label>
						<input type="text" class="form-control" name="phone" id="phone" />
					</fieldset>
					<fieldset class="form-group">
						<label for="message">Message To Seller</label>
						<textarea id="message" name="message" class="form-control"></textarea>
					</fieldset>
				</form>
			`,
			buttons: {
				offer: {
					label: 'Submit Purchase Request',
					callback: function() {
						$.post('/offer/buyNow', $('#buynowform').serialize()).then(
							function() {
								location.reload();
							});
					}
				}
			}
		});
	});
});
