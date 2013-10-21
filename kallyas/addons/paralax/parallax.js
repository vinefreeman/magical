;
/**
 * Class for making 3D parallax using CSS transform
 * @author Tomáš Růžička <tomasruzicka@abdoc.net>
 * @version 1.0
 */
//var $ = jQuery.noConflict();
//(function($){
	
var Parallax = function(opt)
{
	this.$container = null;
	this.$layers = jQuery();
	if ( typeof opt === 'object' )
	{
		if ( opt.container )
		{
			this.$container = jQuery(opt.container);
		}

		if ( typeof opt.layers === 'object' && opt.layers.constructor === Array )
		{
			for ( var i = 0, l = opt.layers.length; i < l; ++i )
			{
				var layer = opt.layers[i];
				this.$layers = this.$layers.add(jQuery(layer['selector']).data('ratio', layer['ratio'] || 0).data('ratioX', layer['ratioX'] || layer['ratio'] || 0).data('ratioY', layer['ratioY'] || layer['ratio'] || 0));
			}
		}
	}

	this.init();
};
Parallax.prototype.init = function()
{
	var self = this,
			pos = this.$container.css('position'),
			width = this.$container.width(),
			height = this.$container.height();

	if ( pos !== 'relative' && pos !== 'absolute' )
	{
		this.$container.css('position', 'relative');
	}

	this.$container.bind('mousemove', function(e)
	{
		//console.log('move', e.pageX, this.offsetLeft, this);
		//self.$layers.css('right', - (width - e.pageX) * .08);
		//self.$layers.css('bottom', - (height - e.pageY) * .04);

		self.$layers.each(function(index, element)
		{
			var $this = jQuery(this);
			//$this.css('right', - (width - e.pageX) * $this.data('ratio'));
			var x = (width / 2 - e.pageX) * ($this.data('ratioX') || $this.data('ratio')),
					y = (height / 2 - e.pageY) * ($this.data('ratioY') || $this.data('ratio'));
			$this.css('-webkit-transform', 'translate3d(' + x + 'px,' + y + 'px,0)');
			$this.css('-moz-transform', 'translate(' + x + 'px,' + y + 'px)');
			$this.css('-ms-transform', 'translate(' + x + 'px,' + y + 'px)');
			$this.css('-o-transform', 'translate(' + x + 'px,' + y + 'px)');
		});
	});
};
//})(jQuery);