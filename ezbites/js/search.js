// Search script
function get() {
	$.post('data.php', { ingSearchfield: ingForm.ingSearchfield.value },
		function(output) {
			$('#searchResults').html(output).slideDown();	
		});
}
