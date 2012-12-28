$(function() {
	
	jQuery.fn.reset = function () {
		  $(this).each (function() { this.reset(); });
		};
	
	function replaceRadioButtons($buttonDiv, $prototype) {
		//Funktio piilottaa radiobuttonit annetussa divissä ja korvaa ne pseudo-radiobuttoneilla prototyypissä annetun mallin mukaan.
		//Hae yksittäisen nappulan prototyyppi.
		var $button = $prototype.find("button").clone();
		
		//Poista prototyyppi-divistä kaikki turha
		$prototype.empty();
		$prototype.removeAttr("style");
		$prototype.removeAttr("id");
		
		//Lisää jokaista radiobuttonin labelia kohti nappula, jonka teksti on sama kuin labelilla
		$buttonDiv.find("label").each(function() {
			var $newButton = $button.clone().text($(this).text());
			var $oldInput = $(this).prev("input:radio");
			
			//Anna buttoneille eventhandleri, joka tsekkaa oikean radiobuttonin.
			$newButton.on("click", function() {
				$oldInput.attr("checked", "checked");
			});
			
			$prototype.append($newButton);
		});
		
		//Piilota vanhat radiobuttonit
		$buttonDiv.children().hide();
		//Liitä uudet radiobuttonit
		$buttonDiv.prepend($prototype);
	}
	
	function clearModal() {
		$('form').reset();
		$('button.active').removeClass('active');
	}
	
//	<table class="table table-striped table-bordered table-condensed">
//	<tbody>
//	    {% for registration in quota.getRegistrations %}
//		    {% set dataContent %}
//				{% for entry in registration.freeTextEntries %}
//					{% if not entry.field.flagPrivate %}
//						<p>{{ entry.field.name }}: {{ entry.content }}</p>
//					{% endif %}
//				{% endfor %} 
//				{% for entry in registration.multipleChoiceEntries %}
//					{% if not entry.field.flagPrivate %}
//						<p>{{ entry.field.name }}: {{ entry.selection }}</p>
//					{% endif %}
//				{% endfor %}
//			{% endset %}
//			<tr class="registered" data-content="{{ dataContent|e }}">
//				<td>{{ registration.firstName }} {{ registration.lastName }}</td>
//				<td class="w125">{{ registration.registrationTime|date("d.m.Y G.i.s") }}
//			</tr>
//		{% endfor %}
//	</tbody>
//	</table>
//	
	//Lataa ilmolistat ajaxilla
	$.getJSON("../ajax/2", function(data) {
		$.each(data, function(key,val) {
			var registrantTable = $('<h4>'+val.name+'</h4><table class="table table-striped table-bordered table-condensed"></table>')
			console.log(val.name);
			$('#registrationList').append(registrantTable);
		})
	})
	
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
	
	//Etsi kaikki radiobuttoneja sisältävät divit ja korvaava prototyyppi
	var $radioButtonDivs = $("div.controls:has(input:radio)");
	var $prototype = $("#radiobuttons-prototype");
	//Korvaa kaikki radiobuttonit tyylikkämillä napeilla
	$radioButtonDivs.each(function() {
		replaceRadioButtons($(this), $prototype.clone());
	});
	
	$("tr.registered").each(function() {
		if ($.trim($(this).attr("data-content")) != "") {
			$(this).popover({'placement': 'left'});
		}
	});
	$(".event").each(function() {
		if ($(this).attr("data-content") != "") {
			$(this).popover({'placement': 'top'});
		}
	});
	
	$('#event_description').html(function(){
		return linkify($(this).html());
	});
	$('#event_summary').html(function(){
		return linkify($(this).html());
	});
	
	$('form').submit(function(){
		//Disabloi ilmoittautumisnappula lomakketta lähettäessä, estää tuplailmoittautumisen vahingossa.
	    $('input[type=submit]', this).attr('disabled', 'disabled');
	});
	$('input#registration_firstName').keyup(function(){
		if ($(this).val() == 'Ilari') {
			$('.modal-body').append('<iframe width="500" height="315" src="http://www.youtube.com/embed/hdqHUms7vUw?autoplay=1#t=38s" frameborder="0" allowfullscreen></iframe>');
		}
	});
	
	//Ilmomodaali tyhjenee, kun se on riittävän pitkään ollut suljettuna
	var timeout;
	$('#subscriptionmodal').on('hide', function() {
		timeout = setTimeout(function(){ clearModal();}, 60000);
	});
	
	$('#subscriptionmodal').on('show', function() {
		clearTimeout(timeout);
	})
});