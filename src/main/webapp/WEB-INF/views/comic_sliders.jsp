	<script>
	$(function() {
		$( "#slider_overall" ).slider({
			value: $('input[name=overall]').val(),
			min: 0,
			max: 5,
			step: 1,
			slide: function( event, ui ) {
				$( "#amount" ).val( "$" + ui.value );
				$('input[name=overall]').val(ui.value);
			}
		});
		$( "#amount" ).val( "$" + $( "#slider_overall" ).slider( "value" ) );
		
	});
	
	$(function() {
		$( "#slider_art" ).slider({
			value: $('input[name=art]').val(),
			min: 0,
			max: 5,
			step: 1,
			slide: function( event, ui ) {
				$( "#amount" ).val( "$" + ui.value );
				$('input[name=art]').val(ui.value);
			}
		});
		$( "#amount" ).val( "$" + $( "#slider_art" ).slider( "value" ) );
	});
	
	$(function() {
		$( "#slider_story" ).slider({
			value: $('input[name=story]').val(),
			min: 0,
			max: 5,
			step: 1,
			slide: function( event, ui ) {
				$( "#amount" ).val( "$" + ui.value );
				$('input[name=story]').val(ui.value);
			}
		});
		$( "#amount" ).val( "$" + $( "#slider_story" ).slider( "value" ) );
	});
	
	$(function() {
		$( "#slider_likely_to_buy_next" ).slider({
			value: $('input[name=likely_to_buy_next]').val(),
			min: 0,
			max: 5,
			step: 1,
			slide: function( event, ui ) {
				$( "#amount" ).val( "$" + ui.value );
				$('input[name=likely_to_buy_next]').val(ui.value);
			}
		});
		$( "#amount" ).val( "$" + $( "#slider_likely_to_buy_next" ).slider( "value" ) );
	});
	</script>