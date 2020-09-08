(function() {
	function displayFields(role, els) {
		els.forEach(function(el) {
			el.parentElement.style.display = (role.value == 'student') ? 'block' : 'none';
		});
	}

	function events() {
		var role = document.getElementById("role");
		var mail = document.getElementById("email");
		var pwd  = document.getElementById("password");
		var els  = [mail, pwd];

		if (role && mail && pwd) {
			role.addEventListener("change", displayFields.bind(this, role, els));			
			displayFields(role, els);
		}
	}

	events();
})();