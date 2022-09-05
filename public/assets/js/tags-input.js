$(function() {
  'use strict';

  $('#tags').tagsInput({
    'width': '100%',
    'height': '30%',
    'interactive': true,
    'defaultText': 'Add More',
    'removeWithBackspace': true,
    'minChars': 0,
    'maxChars': 30,
    'placeholderColor': '#666666'
  });
  $('#other_name').tagsInput({
    'width': '100%',
    'height': '30%',
    'interactive': true,
    'defaultText': 'Add More',
    'removeWithBackspace': true,
    'minChars': 0,
    'maxChars': 30,
    'placeholderColor': '#666666'
  });
 
});