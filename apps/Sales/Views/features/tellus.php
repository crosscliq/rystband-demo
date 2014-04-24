<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ryst</title>
<!-- Load CSS -->
<link href="/sales/css/style.css" rel="stylesheet" type="text/css" />
<!-- Load Icon Font -->
<link rel="shortcut icon" type="image/x-icon" href="/sales/img/favicon.ico">
<link href="/sales/css/webfont.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="/sales/css/default.css" id="theme_base">
<link rel="stylesheet" href="/sales/css/default.date.css" id="theme_date">
<link rel="stylesheet" href="/sales/css/default.time.css" id="theme_time">
<!-- Load jQuery library -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<!-- Load js -->
<script type="text/javascript" src="/sales/js/custom.js"></script>
</head>
<!-- Start Body -->
<body class="full blur">

		<!-- Start Elements -->
		<section>

			<!-- Text -->

			<h2><span class="color">Interested in pricing?<br/></span>First, Tell us about <b>you</b>...</h2>
			<br>
			
			<div class="width-wrapper">
				
				<div class="full">
				
					<form  method="post">
						<div id="you">
						<input type="text" class="input" placeholder="Your Name"></br>
						<input type="email" class="input" placeholder="Your@email"></br>
						<input type="text" class="input" placeholder="Your Company Name"></br>
						<input type="tel" class="input" placeholder="Your Phone #"></br>
						<input type="submit" class="btn" value="Next">			
						</div>
						<div id="event" style="display:none;">
						<input type="text" class="input" placeholder="Event Name"></br>
						<select name="type" class="select">
							<option>Event Type</option>
							<option>Festival</option>
							<option>Race (running)</option>
							<option>Convention / tradeshow</option>
							<option>Branding activation</option>
 							<option>HR training</option>
							<option>Golf tournament</option>
							<option>Sporting event </option>
						</select>
						</br>

						<input type="datetime" class="input" id="date" placeholder="Event Date"></br>
						<input type="number" class="input" placeholder="# of Attendees ( Estimated )"></br>
						<input type="text" class="input" placeholder="Venue Name"></br>
						<input type="number" class="input" placeholder="# of locations"></br>
						<select name="type" class="select">
							<option>On-site Support Required?</option>
							<option>Yes</option>
							<option>No</option>
						</select><br/>
						<input type="submit" class="btn" value="Request More Information">			
						</div>
					</form>
				</div>

			</div>
			<div class="clear"></div>




		</section>
		<!-- End Elements -->
    <script src="/sales/js/picker.js"></script>
    <script src="/sales/js/picker.date.js"></script>
    <script src="/sales/js/picker.time.js"></script>
<script type="text/javascript">

	$(document).ready( function() {

		$( '#date' ).pickadate({
		    weekdaysShort: [ 'Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa' ],
		    showMonthsShort: true,
		    today: '',
                  clear: '',
		})


		$('#you .btn').click( function(e) {
		  e.preventDefault();
		  $('h2').html('Now, Tell us about your <b>event</b>...');
		  $('#you').fadeOut(100);
		  $('#you').css('margin-left','-100%');
		  $('#event').fadeIn();
	})

	});
</script>


</body>
<!-- End Body -->
</html>