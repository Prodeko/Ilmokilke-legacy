$(function() {
	//Tarkista, onko lomakkeeseen tullut virheitä edellisestä lähetyksestä
	if ($('.formerror:parent').length == 0) {
		//Jos virheitä ei ole tullut tai sivu ladataan ensimmäistä kertaa, tee lomakkeesta modaali, ja piilota se
		$("#subscriptionmodal").modal('hide');
	} else {
		//Jos virheitä on tullut, tee lomakkeesta modaali ja näytä se.
		$("#subscriptionmodal").modal('show');
	}
});