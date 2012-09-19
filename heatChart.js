;(function( $, window, document ){

	var pluginName = 'heatChart',
		defaults = {
			dataTag: "td",
			applyTo: "background",
			theta: 220,
			offset: 0,
			saturation: 70,
			lightness: 50,
			alpha: 1,
			reverse: false,
			blackAndWhite: false,
			discreet: false,
			steps: 10,
			colorModel: 'hsla'
		};
	var methods = {
		get_number_from_html : function( jq_obj ) {
			return parseFloat($(jq_obj).html());
		},
		hslToRgb: function(h,s,l){
		    var r, g, b;
		    h /= 360;
		    s /= 100;
		    l /= 100;
		
		    if(s == 0){
		        r = g = b = l;
		    } else {
		        function hue2rgb(p, q, t){
		            if(t < 0) t += 1;
		            if(t > 1) t -= 1;
		            if(t < 1/6) return p + (q - p) * 6 * t;
		            if(t < 1/2) return q;
		            if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;
		            return p;
		        }
		
		        var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
		        var p = 2 * l - q;
		        r = hue2rgb(p, q, h + 1/3);
		        g = hue2rgb(p, q, h);
		        b = hue2rgb(p, q, h - 1/3);
		    }

		    return [r * 255, g * 255, b * 255];
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
				this.values.push({element: this.children[i], value: value, scaled_val: null});
				if( value > this.max ) { this.max = value; }
				if( value < this.min ) { this.min = value; }
			}
		}

		for ( i=0; i<this.values.length; i++ ){
			var unscaled_val = this.values[i].value;
			var element = this.values[i].element;
			var scaled_val = (unscaled_val - this.min)/(this.max - this.min);
			scaled_val = this.options.reverse ? 1 - scaled_val : scaled_val;

			//Currently no need for this
			//this.values[i].scaled_val = scaled_val;

			var h = scaled_val * this.options.theta;
			// h = Math.abs(360 - (h - (this.options.offset + this.options.theta )));
			var s = (this.options.colorModel == "grayscale") ? 0 : this.options.saturation;
			var l = this.options.lightness;

			
			if(this.options.colorModel == 'rgb' || this.options.colorModel == 'grayscale'){
				if(this.options.colorModel == 'grayscale'){
					var shade = Math.round(scaled_val * 255);
					var rgb = [shade,shade,shade];
				} else {
					var rgb = this.methods.hslToRgb(h,s,l);
				}
				$(element).css( this.options.applyTo, 'rgb(' + Math.round(rgb[0]) + ', ' + Math.round(rgb[1]) + ', ' + Math.round(rgb[2]) + ')');
			
			} else if(this.options.colorModel == 'hsla'){
				//hsl and hsla have the same browser support, so just use hsla
				$(element).css( this.options.applyTo, 'hsla(' + h + ', ' + s + '%, ' + l + '%, ' + this.options.alpha + ')');
			}

			// if(this.options.discreet){
			// 	if(this.options.blackAndWhite){
			// 		var increments = 1 / this.options.steps;
			// 		var steps =  Math.floor(scaled_val / increments);
			// 		if(steps == this.options.steps){ steps--; }
			// 		var stepped_value = increments * steps;
			// 		console.log('increments: ' + increments);
			// 		console.log('steps: ' + steps);
			// 		console.log('stepped_value: ' + stepped_value);
			// 		console.log(hue);
			// 		var hue = Math.floor(stepped_value * 255);
			// 		$(element).css( this.options.applyTo, 'rgb(' + hue + ', ' + hue + ', ' + hue + ')');
			// 	} else {
			// 		//TKTKTKTKTK
			// 	}
			// } else {
			// 	if(this.options.blackAndWhite){
			// 		var hue = Math.floor(( scaled_val ) * 255 );
			// 		$(element).css( this.options.applyTo, 'rgb(' + hue + ', ' + hue + ', ' + hue + ')');
			// 	} else {
			// 		var hue = Math.abs(Math.floor(scaled_val * this.options.theta) - this.options.theta);
			// 		hue = Math.abs(360 - (hue - (this.options.offset + this.options.theta )));
			// 		$(element).css( this.options.applyTo, 'hsla(' + hue + ', ' + this.options.saturation + '%, ' + this.options.lightness + '%, ' + this.options.alpha + ')');
			// 	}
			// }
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