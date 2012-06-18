jQuery(document).ready(function() {
	function addFieldForm(fieldsDiv, $newLinkDiv, divClass) { // Funktio lisää annettuun kenttälistaan annetun 
	    // Get the data-prototype we explained earlier
	    var prototype = fieldsDiv.attr('data-prototype');
	
	    // Replace '$$name$$' in the prototype's HTML to
	    // instead be a number based on the current collection's length.
	    var newForm = prototype.replace(/\$\$name\$\$/g, fieldsDiv.children().length);
	
	    // Display the form in the page in an li, before the "Add a tag" link li
	    var $newFormDiv = $('<div class="' + divclass + '"></div>').append(newForm);
	    $newLinkDiv.before($newFormDiv);
	    
	    // add a delete link to the new form
	    addDeleteLink($newFormDiv);
	}
	
	function addDeleteLink($fieldFormDiv) {	// Funktio lisää annettuun diviin nappulan, jolla sen voi poistaa
	    var $removeFormLink = $('<a href="#" class="btn">Poista tämä kenttä</a>');
	    $fieldFormDiv.append($removeFormLink);

	    $removeFormLink.on('click', function(e) {
	        // prevent the link from creating a "#" on the URL
	        e.preventDefault();

	        // remove the li for the field form
	        $fieldFormDiv.remove();
	    });
	}
	
	// Get the div that holds the collection of tags
	var freeTextFieldsDiv = $('div.freeTextFields');
	
	// setup an "add a field" link
	var $addTextFieldLink = $('<a href="#" class="btn add_field_link">Lisää teksikenttä</a>');
	var $newTextFieldLinkDiv = $('<div></div>').append($addTextFieldLink);
	
	
    // add a delete link to all of the existing field form li elements
    freeTextFieldsDiv.find('div.freeTextField').each(function() {
        addDeleteLink($(this));
    });
	    
    // add the "add a field" anchor and div to the fields div
    freeTextFieldsDiv.append($newLinkDiv);

    $addTextFieldLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addFieldForm(freeTextFieldsDiv, $newTextFieldLinkDiv, 'freeTextField');
    });
});


