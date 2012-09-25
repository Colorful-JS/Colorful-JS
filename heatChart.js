;(function( $, window, document ){

	var pluginName = 'colorful',
		defaults = {
			mapDataTo: ["h"],

			elementSelector: "td",
			preventionSelector: null,
			attributeToColor: "background",
			dataAttribute: 'html',
			
			hue: 0,
			theta: 220,
			portion: 0.25,
			offset: 0,
			colorModel: "hsla",
			colors: null,

			saturation: 70,
			lightness: 50,
			alpha: 1,

			reverse: false,

			stepwise: false,
			steps: 10,

			scale: "linear",
			min_val: null,
			max_val: null,

			addedClass: "js-colorful"
			
		};
	var methods = {
		get_number_from_element : function( jq_obj, dataAttribute ) {
			switch(dataAttribute) {
				case 'html':
					return parseFloat($(jq_obj).html());
					break;
				default:
					return parseFloat($(jq_obj).attr(dataAttribute));
					break;
			}
		},
		scale_feature : function( scale, unscaled_value, global_min, global_max ) {
			var scaled_value = null;
			switch(scale) {
				case 'linear':
					return (global_max - global_min) == 0 ? 0 : (unscaled_value - global_min)/(global_max - global_min);
					break;
				case 'log':
					unscaled_value = unscaled_value == 0 ? 0 : Math.log(unscaled_value);
					global_min = global_min == 0 ? 0 : Math.log(global_min);
					global_max = global_max == 0 ? 0 : Math.log(global_max);
					return (global_max - global_min) == 0 ? 0 : (unscaled_value - global_min)/(global_max - global_min);
					break;
			}
		},
		get_stepwise_value: function( scaled_value, step_count ) {
			var increments, steps;
			increments = 1 / step_count;
			steps =  Math.floor(scaled_value / increments);
			if(steps == step_count){ steps--; }
			return increments * steps;
		},
		get_shade : function ( scaled_value, spectrum_width ) {
			return Math.round(scaled_value * spectrum_width);
		},
		hslToRgb: function(h,s,l){
		    var r, g, b;
		    h /= 360;
		    s /= 100;
		    l /= 100;
		
		    if(s == 0){
		        r = g = b = l;
		    } else {
		        
		
		        var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
		        var p = 2 * l - q;
		        r = methods.hue2rgb(p, q, h + 1/3);
		        g = methods.hue2rgb(p, q, h);
		        b = methods.hue2rgb(p, q, h - 1/3);
		    }

		    return [r * 255, g * 255, b * 255];
		},
		hue2rgb : function (p, q, t){
		    if(t < 0) t += 1;
		    if(t > 1) t -= 1;
		    if(t < 1/6) return p + (q - p) * 6 * t;
		    if(t < 1/2) return q;
		    if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;
		    return p;
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

		// If the user has passed an array of colors to use
		if(this.options.colors){
			this.options.stepwise = true;
			this.options.steps = this.options.colors.length;
		}

		// Build our possible hues array if we're going with a discrete number of colors
		if(this.options.stepwise && this.options.colorModel != 'grayscale'){

			this.possible_hues = new Array();
			this.possible_sats = new Array();
			this.possible_lights = new Array();
			this.possible_alphas = new Array();

			if(this.options.colors){
				for(j=0; j<this.options.colors.length; j++){
					this.possible_hues.push(this.options.colors[j]);
				}
			} else {
				var d_theta = (this.options.portion / (this.options.steps - 1));
				for(j=1; j<this.options.steps - 1; j++){
					this.possible_hues.push(d_theta * j * 360);
					this.possible_sats.push(d_theta * j * 100);
					this.possible_lights.push(d_theta * j * 100);
					this.possible_alphas.push(d_theta * j);
				}
				this.possible_hues.unshift(0);
				this.possible_hues.push(this.options.portion * 360);

				this.possible_sats.unshift(0);
				this.possible_sats.push(this.options.portion * 100);

				this.possible_lights.unshift(0);
				this.possible_lights.push(this.options.portion * 100);

				this.possible_alphas.unshift(0);
				this.possible_alphas.push(this.options.portion * 100);
			}
			
		}

		// Get the elements to process
		this.children = $(this.element).find(this.options.elementSelector).not(this.options.preventionSelector);

		// Build our data array, and set our min and max properly
		for ( i=0; i<this.children.length; i++ ){
			var value = this.methods.get_number_from_element(this.children[i], this.options.dataAttribute);
			
			if( !isNaN(value) && (this.options.min_val == null || value > this.options.min_val) && (this.options.max_val == null || value < this.options.max_val) ){
				this.values.push({element: this.children[i], value: value, scaled_val: null});
				if( value > this.max ) { this.max = value; }
				if( value < this.min ) { this.min = value; }
			}
		}

		// Iterate through our elements and make the magic happen
		for ( i=0; i<this.values.length; i++ ){
			var unscaled_val, element, scaled_value, color, h, s, l, a;

			unscaled_value = this.values[i].value;
			element = this.values[i].element;

			// Feature Scaling
			scaled_value = this.methods.scale_feature(this.options.scale, unscaled_value, this.min, this.max);

			// Reverse if necessary
			scaled_value = this.options.reverse ? 1 - scaled_value : scaled_value;

			//Currently no need for this
			//this.values[i].scaled_val = scaled_val;
			h = this.options.hue;
			s = (this.options.colorModel == "grayscale") ? 0 : this.options.saturation;
			l = this.options.lightness;
			a = this.options.alpha;

			for( j=0; j<this.options.mapDataTo.length; j++) {
				
				switch(this.options.mapDataTo[j]){
					case('h'):
						h = ((scaled_value * this.options.portion * 360) + (this.options.offset * 360)) % 360;
						break;
					case('s'):
						// s = ((scaled_value * this.options.portion * 100) + (this.options.offset * 100)) % 100;
						s = scaled_value * 100;
						break;
					case('l'):
						// l = ((scaled_value * this.options.portion * 100) + (this.options.offset * 100)) % 100;
						l = scaled_value * 100;
						break;
					case('a'):
						// a = ((scaled_value * this.options.portion) + this.options.offset);
						a = scaled_value;
						break;
				}
			}
			

			if(this.options.stepwise && this.options.colorModel != 'grayscale'){
				var position = Math.floor(scaled_value / (1 / this.options.steps ));
				if(position == this.options.steps){ position--; }

				for( j=0; j<this.options.mapDataTo.length; j++) {
					
					switch(this.options.mapDataTo[j]){
						case('h'):
							h = (this.possible_hues[position] + this.options.offset) % 360;
							break;
						case('s'):
							s = (this.possible_sats[position] + this.options.offset) % 100;
							break;
						case('l'):
							l = (this.possible_lights[position] + this.options.offset) % 100;
							break;
						case('a'):
							a = (this.possible_alphas[position] + this.options.offset);
							break;
					}
				}
				
			}

			// RBG and Grayscale
			if(this.options.colorModel == 'rgb' || this.options.colorModel == 'grayscale'){
				var rgb;
				if(this.options.colorModel == 'grayscale'){
					var shade;
					if(this.options.stepwise){
						shade = this.methods.get_shade( this.methods.get_stepwise_value( scaled_value, this.options.steps ), 255 );
					} else {
						shade = this.methods.get_shade( scaled_value, 255 );
					}
					rgb = [shade,shade,shade];
				} else {
					rgb = this.methods.hslToRgb(h,s,l);
				}
				color = 'rgb(' + Math.round(rgb[0]) + ', ' + Math.round(rgb[1]) + ', ' + Math.round(rgb[2]) + ')';
			
			// HSLA
			} else if(this.options.colorModel == 'hsla'){
				color = 'hsla(' + h + ', ' + s + '%, ' + l + '%, ' + a + ')';
			}

			$(element).addClass( this.options.addedClass ).css( this.options.attributeToColor, color );
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