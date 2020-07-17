
//Copiar ip

new ClipboardJS('.btn');
			
var btn = document.getElementById('copy');
	btn.addEventListener('click', function () {
		btn.innerHTML = "Copiado!";
		setTimeout(() => {
			btn.innerHTML = "<i class='fas fa-gamepad'></i> JOGUE AGORA";
		}, 1500);
	});