
$(function() {
  'use strict';

  $("#wizard").steps({
    headerTag: "h2",
    bodyTag: "section",
    transitionEffect: "slideLeft"
  });

  $("#wizardVertical").steps({
    headerTag: "h2",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    stepsOrientation: 'vertical',
    labels: {
       
        finish: "Finish sas",
       
    },
    onStepChanged: function (event, currentIndex, priorIndex) {
         $( "#tenant" ).trigger( "click" );
     }, 
    onFinished: function (event, currentIndex) {
            $( "#tenant" ).trigger( "click" );
         }
  });

});