$(document).ready(function() {
    $('#next_1').click(function() {
    	$.ajax({
    		type: 'POST',
    		dataType: 'json',
    		url: '/signup/validate/step/1/',
    		data: $('#signup').serialize(),
    		success: function(response) {
    			if (response.status == 'ok') {
    				$('#step_1 .errors').html('');
    				$('#step_1').hide();
    				$('#step_2').show();
    				$('.steps li.active').removeClass('active');
    				$('.steps li:nth-child(2)').addClass('active');
    				$('div.title').hide();
    				$('div.header > div.login-link').hide();
    			}
    			else
    			{
    				$('#step_1 .errors').html(response.errors);
    			}
    		}
    	});
    	return false;
    });

    $('#next_2').click(function() {
    	$.ajax({
    		type: 'POST',
    		dataType: 'json',
    		url: '/signup/validate/step/2/',
    		data: $('#signup').serialize(),
    		success: function(response) {
    			if (response.status == 'ok') {
    				$('#step_2 .errors').html('');
    				$('#signup').submit();
    			} else {
    				$('#step_2 .errors').html(response.errors);
    			}
    		}
    	});
    	return false;
    });

    $('#agree').change(function() {
    	$('#next_2').toggleClass('disabled').toggleDisabled();
    });
});

function choose(val)
{
	$('#User_gender').val(val);
	$('.gender-select li.active').removeClass('active');
	$('.gender-select li:nth-child(' + (val + 1) + ')').addClass('active');
}