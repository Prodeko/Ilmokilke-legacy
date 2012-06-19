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
	}
	
	function addDeleteLink($fieldFormDiv) {	// Funktio lisää annettuun diviin nappulan, jolla sen voi poistaa
	    var $removeFormButton = $('<button href="#" class="close">&times;</button>');
	    $fieldFormDiv.prepend($removeFormButton);

	    $removeFormButton.on('click', function(e) {
	        // prevent the link from creating a "#" on the URL
	        e.preventDefault();

	        // remove the li for the field form
	        $fieldFormDiv.remove();
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
	
	// Get the div that holds the collection of fields
	var freeTextFieldsDiv = $('div.freeTextFields');
	var multipleChoiceFieldsDiv = $('div.multipleChoiceFields');
	
    // Lisää poistonappulat kaikille olemassaoleville kentille.
    freeTextFieldsDiv.find('div.freeTextField').each(function() {
        addDeleteLink($(this));
    });
    multipleChoiceFieldsDiv.find('div.multipleChoiceField').each(function() {
        addDeleteLink($(this));
    });
	    
    // Lisää "lisää kenttä" -nappulat teksti- ja monivalintakentille.
    addAddButton(freeTextFieldsDiv, 'Lisää tekstikenttä', 'add_textfield_button', 'freeTextField');
    addAddButton(multipleChoiceFieldsDiv, 'Lisää monivalintakenttä', 'add_mcfield_button', 'multipleChoiceField');
});


