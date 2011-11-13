var opts = {
   	  lines: 12, // The number of lines to draw
   	  length: 7, // The length of each line
   	  width: 4, // The line thickness
   	  radius: 10, // The radius of the inner circle
   	  color: '#000', // #rgb or #rrggbb
   	  speed: 1, // Rounds per second
   	  trail: 30, // Afterglow percentage
   	  shadow: false // Whether to render a shadow
};
$.fn.spin = function(opts) {
	this.each(function() {
    	var $this = $(this),
        data = $this.data();
		
      	if (data.spinner) {
        	data.spinner.stop();
        	delete data.spinner;
      	}
      	if (opts !== false) {
        	data.spinner = new Spinner($.extend({color: $this.css('color')}, opts)).spin(this);
      	}
    });
    return this;
};