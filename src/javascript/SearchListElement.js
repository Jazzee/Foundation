/**
 * SearchLIst element function
 * Handles the creation of the autocomplete search list
 * @param {jQuery} the select list element
 */
function SearchListElement(element){
  this.selectListElement = $(element);
  this.container;
  this.items = this.getItems();
  this.init();
  this.noResultsMessage = "Leave Blank";
  this.allowBlankSelection = false;
};


/**
 * Setup the container and structure for the search list
 * @return {jQuery}
 */
SearchListElement.prototype.init = function(){
  var self = this;
  this.container = this.selectListElement.parent();
  this.selectListElement.hide();
  this.container.prepend($('<div>').addClass('box').width('100%'));
  if(this.selectListElement.val() == ''){
    this.createSearchBox();
  } else {
    var val = this.selectListElement.val();
    this.selectValue(val, $("option[value='" + val + "']", this.selectListElement).text());
  }
};

/**
 * Get the items from the select list options
 * @return Array
 */
SearchListElement.prototype.getItems = function(){
  var self = this;
  var items = [];
  $('option', this.selectListElement).each(function(){
    var option = $(this);
    var item = {
      value: option.attr('value'),
      label: option.html(),
      metadata: option.attr('data-metadata'),
      searchList: self
    }
    items.push(item);
  });
  return items;
};

/**
 * Create the search list and parse the options
 */
SearchListElement.prototype.createSearchBox = function(){
  var self = this;
  self.selectListElement.val(''); //default to nothing
  var input = $('<input>');
  $(input).autocomplete({
    delay: 0,
    source: function(request, response){
      var results = [];
      $(request.term.split(" ")).each(function(){
        if(this.length > 0){
          var matcher = new RegExp($.ui.autocomplete.escapeRegex(this), "i");
          results = results.concat($.grep( self.items, function(item,index){
              return (matcher.test(item.metadata) || matcher.test(item.label));
          }));
        }
      });
      if (!results.length) {
        results = [self.noResultsMessage];
      }
      response(results);
    },
    select: function( event, ui ) {
      if (!self.allowBlankSelection && ui.item.label === self.noResultsMessage) {
        event.preventDefault();
      } else {
        self.selectValue(ui.item.value, ui.item.label);
      }
      return false;
    },
    focus: function (event, ui) {
      if (!self.allowBlankSelection && ui.item.label === self.noResultsMessage) {
        event.preventDefault();
      }
      return false;
    }
  });
  $('.box', self.container).empty();
  $('.box', self.container).append(input);
};

/**
 * Create the search list and parse the options
 */
SearchListElement.prototype.selectValue = function(value, label){
  var self = this;
  self.selectListElement.val(value);
  $('.box', self.container).empty();
  if(label != self.noResultsMessage){
    $('.box', self.container).append(label);
  }
  var button = $('<button>').button({
    icons: {
      primary: "ui-icon-close"
    },
    text: false
  });
  button.bind('click', function(){
    self.createSearchBox();
  });
  $('.box', self.container).append(button);
};

/**
 * Set the no results found message
 * @param String
 */
SearchListElement.prototype.setNoResultsFoundMessage = function(message){
  this.noResultsMessage = message;
};