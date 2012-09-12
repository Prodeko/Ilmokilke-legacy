jQuery(document).ready(function() {
	function addFieldForm(fieldsDiv, $newLinkDiv, htmlClass) { // Funktio lisää annettuun kenttälistaan annetun 
	    // Get the data-prototype we explained earlier
	    var prototype = fieldsDiv.attr('data-prototype');
	
	    // Replace '$$name$$' in the prototype's HTML to
	    // instead be a number based on the current collection's length.
	    var newForm = prototype.replace(/\$\$name\$\$/g, fieldsDiv.children().length);
	
	    // Display the form in the page in a div, before the "Add a field" link div
	    var $newFormDiv = $('<div class="well form-inline ' + htmlClass + '"></div>').append(newForm);
	    $newLinkDiv.before($newFormDiv);
	    
	    // add a delete link to the new form
	    addDeleteLink($newFormDiv);
	    createToolTips();
	}
	
	function addDeleteLink($fieldFormDiv) {	// Funktio lisää annettuun diviin nappulan, jolla sen voi poistaa
	    var $removeFormButton = $('<button href="#" class="close">&times;</button>');
	    $fieldFormDiv.prepend($removeFormButton);

	    $removeFormButton.on('click', function(e) {
	        // prevent the link from creating a "#" on the URL
	        e.preventDefault();
	        $(this).remove();
	        
	        //Show a confirmation dialog
	        var $confirmationDialog = $('<div class="alert alert-error fade in">' +
	        		'<p>Haluatko varmasti poistaa tämän?</p>' + 
	        		'</div>');
	        var $okButton = $('<button type="button" class="btn btn-danger">OK</button>');
	        $okButton.on('click', function(e) {
	        	e.preventDefault();
	        	$fieldFormDiv.remove();
	        });
	        var $cancelButton = $('<button type="button" class="btn">Peruuta</button>');
	        $cancelButton.on('click', function(e) {
	        	e.preventDefault();
	        	$($confirmationDialog).alert('close');
	        	addDeleteLink($fieldFormDiv);
	        });
	        $confirmationDialog.append($okButton).append($cancelButton);
	        $fieldFormDiv.append($confirmationDialog);	        
	    });
	}
	
	function addAddButton(fieldsDiv, text, buttonHtmlClass, formDivHtmlClass) { // Lisää lisäysnappulan annetulla sisällöllä annettuun diviin.
		var $addButton = $('<a href="#" class="btn ' + buttonHtmlClass + '">' + text + '</a>');
		var $addButtonDiv = $('<div></div>').append($addButton);
		
		fieldsDiv.append($addButtonDiv);
		
		$addButton.on('click', function(e) {
	        // prevent the link from creating a "#" on the URL
	        e.preventDefault();

	        // add a new tag form (see next code block)
	        addFieldForm(fieldsDiv, $addButtonDiv, formDivHtmlClass);
	    });
		
	}
	function createToolTips(){
		$('a.flagprivate').each( function() {
	    	$(this).tooltip();
	    });
	}	
	//Päivitetään summaryn infokentän arvoon jäljellä olevien merkkien määrä.
	$('textarea#event_summary').keyup(function(){
    	var charLength = $(this).val().length;
    	if (charLength <= 160) {
    		$('span#charcount').attr('class', 'alert alert-info');
    		if(charLength === 159) {
    			$('span#charcount').html(160 - charLength + ' merkki jäljellä.');
    		}
    		else {
    			$('span#charcount').html(160 - charLength + ' merkkiä jäljellä.');
    		}
    	}
    	
    	if(charLength > 160) {
    		$('span#charcount').attr('class', 'alert alert-error');
    		$('span#charcount').html("Liian pitkä kuvaus (" + charLength +" merkkiä). Lyhyt kuvaus saa olla korkeintaan 160 merkkiä pitkä!");
    	}
    });
	
	// Get the div that holds the collection of fields
	var freeTextFieldsDiv = $('div.freeTextFields');
	var multipleChoiceFieldsDiv = $('div.multipleChoiceFields');
	var quotasDiv = $('div.quotas');
	
    // Lisää poistonappulat kaikille olemassaoleville kentille.
    freeTextFieldsDiv.find('div.freeTextField').each(function() {
        addDeleteLink($(this));
    });
    multipleChoiceFieldsDiv.find('div.multipleChoiceField').each(function() {
        addDeleteLink($(this));
    });
    quotasDiv.find('div.quota').each(function() {
    	addDeleteLink($(this));
    });
	
    //Täytetään summaryn info-kenttään jäljellä olevien merkkien määrä
    $('span#charcount').html(160 - $('textarea#event_summary').val().length + ' merkkiä jäljellä.');    
    // Lisää "lisää kenttä" -nappulat teksti- ja monivalintakentille.
    addAddButton(freeTextFieldsDiv, 'Lisää tekstikenttä', 'add_textfield_button', 'freeTextField');
    addAddButton(multipleChoiceFieldsDiv, 'Lisää monivalintakenttä', 'add_mcfield_button', 'multipleChoiceField');
    addAddButton(quotasDiv, 'Lisää kiintiö', 'add_quota_button', 'quota');
    createToolTips();
    
    //Lisätään päivämääräkenttiin datepicker-widget
    $('.datepicker').datepicker(
    		{
    			format: 'dd.mm.yyyy'
    		});
    //Formatoidaan aikakentät (Symfony ei jostain syystä tue tätä)
    $('.timefield').attr('value', function() {
    	return $(this).attr('value').substr(0,5).replace(':','.');
    });

});


