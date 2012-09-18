;(function( $, window, document ){

	var pluginName = 'heatChart',
		defaults = {
			dataTag: "td",
			applyTo: "background",
			theta: 220,
			offset: 0,
			saturation: 60,
			lightness: 50,
			alpha: 1,
			reverse: false,
			blackAndWhite: false,
			discreet: false,
			steps: 10
		};
	var methods = {
		get_number_from_html : function( jq_obj ) {
			return parseFloat($(jq_obj).html());
		}
	}

	function Plugin( element, options ){
		this.element = element;

		this.options = $.extend( {}, defaults, options);
		this.methods = methods;

		this._defaults = defaults;
		this._name = pluginName;

		this.init();
	}

	Plugin.prototype.init = function () {
		this.max = 0;
		this.min = Infinity;
		this.values = new Array();

		this.children = $(this.element).find(this.options.dataTag);

		for ( i=0; i<this.children.length; i++ ){
			var value = this.methods.get_number_from_html(this.children[i]);
			if( !isNaN(value) ){
				this.values.push({element: this.children[i], value: value});
				if( value > this.max ) { this.max = value; }
				if( value < this.min ) { this.min = value; }
			}
		}

		for ( i=0; i<this.values.length; i++ ){
			var element = this.values[i].element;
			var value = this.values[i].value;
			
			if(this.options.reverse){
				value = 1 - value;
			}

			if(this.options.discreet){
				if(this.options.blackAndWhite){
					var increments = 1 / this.options.steps;
					var steps =  Math.floor(value / this.max / increments);
					if(steps == this.options.steps){ steps--; }
					var stepped_value = increments * steps;
					console.log('increments: ' + increments);
					console.log('steps: ' + steps);
					console.log('stepped_value: ' + stepped_value);
					console.log(hue);
					var hue = Math.floor(stepped_value * 255);
					$(element).css( this.options.applyTo, 'rgb(' + hue + ', ' + hue + ', ' + hue + ')');
				} else {
					//TKTKTKTKTK
				}
			} else {
				if(this.options.blackAndWhite){
					var hue = Math.floor(( value / this.max ) * 255 );
					$(element).css( this.options.applyTo, 'rgb(' + hue + ', ' + hue + ', ' + hue + ')');
				} else {
					var hue = Math.abs(Math.floor(value / this.max * this.options.theta) - this.options.theta);
					hue = Math.abs(360 - (hue - (this.options.offset + this.options.theta )));
					$(element).css( this.options.applyTo, 'hsla(' + hue + ', ' + this.options.saturation + '%, ' + this.options.lightness + '%, ' + this.options.alpha + ')');
				}
			}
		}
	};

  	$.fn[pluginName] = function ( options ) {
  	        return this.each(function () {
  	            if (!$.data(this, 'plugin_' + pluginName)) {
  	                $.data(this, 'plugin_' + pluginName, 
  	                new Plugin( this, options ));
  	            }
  	        });
  	    }
})( jQuery, window, document );