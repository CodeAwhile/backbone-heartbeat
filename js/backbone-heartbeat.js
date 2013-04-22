jQuery(function($){
	var template = _.template('<p>random: <%= random %></p><p>time: <%= time %></p>');
	var $container = $('#backbone-heartbeat-tests-container');
	$(document).on( 'heartbeat-tick.backbone-heartbeat-tests', function( e, data ){
		console.log(data['backbone-heartbeat-tests']);
		$container.html(template(data['backbone-heartbeat-tests']));
	}).on( 'heartbeat-send.backbone-heartbeat-tests', function( e, data){
		data['backbone-heartbeat-tests'] = 1;
	});
});