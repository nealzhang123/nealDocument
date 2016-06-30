jQuery(document).ready(function(){
	jQuery.post(
			'http://www.etongapp.com/stacktech_stat_insert.php', 
			{
				'post_id': ram_obj.pi,
				'blog_id': ram_obj.bi,
			}, 
			function(response){
				//console.log(response);
			}
		);
});