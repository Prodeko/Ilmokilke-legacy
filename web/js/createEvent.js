jQuery(document).ready(function() {
	function addFieldForm(collectionHolder, $newLinkLi) {
	    // Get the data-prototype we explained earlier
	    var prototype = collectionHolder.attr('data-prototype');
	
	    // Replace '$$name$$' in the prototype's HTML to
	    // instead be a number based on the current collection's length.
	    var newForm = prototype.replace(/\$\$name\$\$/g, collectionHolder.children().length);
	
	    // Display the form in the page in an li, before the "Add a tag" link li
	    var $newFormLi = $('<li></li>').append(newForm);
	    $newLinkLi.before($newFormLi);
	    
	    // add a delete link to the new form
	    addFieldFormDeleteLink($newFormLi);
	}
	
	function addFieldFormDeleteLink($fieldFormLi) {
	    var $removeFormA = $('<a href="#">Poista tämä kenttä</a>');
	    $fieldFormLi.append($removeFormA);

	    $removeFormA.on('click', function(e) {
	        // prevent the link from creating a "#" on the URL
	        e.preventDefault();

	        // remove the li for the field form
	        $fieldFormLi.remove();
	    });
	}
	
	// Get the div that holds the collection of tags
	var collectionHolder = $('ul.freeTextFields');
	
	// setup an "add a field" link
	var $addFieldLink = $('<a href="#" class="add_field_link">Lisää kenttä</a>');
	var $newLinkLi = $('<li></li>').append($addFieldLink);
	
	
    // add a delete link to all of the existing field form li elements
    collectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });
	    
    // add the "add a field" anchor and li to the tags ul
    collectionHolder.append($newLinkLi);

    $addFieldLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addFieldForm(collectionHolder, $newLinkLi);
    });
});


