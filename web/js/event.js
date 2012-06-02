$(function() {
	//Tarkista, onko lomakkeeseen tullut virheitä edellisestä lähetyksestä
	//(Jos virheitä on tullut, .formerror - luokan diveillä on sisältöä, eli joku niistä on :parent)
	if ($('.formerror:parent').length == 0) {
		//Jos virheitä ei ole tullut tai sivu ladataan ensimmäistä kertaa, tee lomakkeesta modaali, ja piilota se
		$("#subscriptionmodal").modal('hide');
	} else {
		//Jos virheitä on tullut, tee lomakkeesta modaali ja näytä se.
		$("#subscriptionmodal").modal('show');
		//Lisää jokaiselle virheitä sisältävälle fieldsetille luokka 'error' (muuttaa ne punaisiksi)
		$('.formerror:parent').closest('fieldset').addClass('error');
	}
});