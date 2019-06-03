/**
 * Deals plugin for Craft CMS
 *
 * DealsFieldType JS
 *
 * @author    Stephen Hamilton
 * @copyright Copyright (c) 2016 Stephen Hamilton
 * @link      http://www.shtc.co.uk
 * @package   Deals
 * @since     1.0.0
 */

 ;(function ( $, window, document, undefined ) {

    var pluginName = "DealsFieldType",
        defaults = {
        };

    // Plugin constructor
    function Plugin( element, options ) {
        this.element = element;

        this.options = $.extend( {}, defaults, options) ;

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {

        init: function(id) {
            var _this = this;

            $(function () {

				/* -- _this.options gives us access to the $jsonVars that our FieldType passed down to us */
				// set listener
				var id = '#' + _this.options.namespace + 'enabled';
				$(_this.element).find(id).on('click', _this.check.bind(_this));
				// do initial check
				_this.check();
				
            });
        },

        check: function(id) {
            var _this = this;

            $(function () {

				/* -- _this.options gives us access to the $jsonVars that our FieldType passed down to us */
				
				var id = '#' + _this.options.namespace + 'enabled';
				var enabled = $(_this.element).find(id).is(":checked");
				if(enabled){
					_this.enable();
				}else{
					_this.disable();
				}

            });
        },

        enable: function(id) {
            var _this = this;

            $(function () {

				/* -- _this.options gives us access to the $jsonVars that our FieldType passed down to us */
				var fields = $(_this.element).find("input[type='text']");
				fields.removeAttr("disabled");
				fields.removeClass("disabled");

            });
        },

        disable: function(id) {
            var _this = this;

            $(function () {

				/* -- _this.options gives us access to the $jsonVars that our FieldType passed down to us */
				var fields = $(_this.element).find("input[type='text']");
				fields.attr("disabled", "disabled");
				fields.addClass("disabled");

            });
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );
