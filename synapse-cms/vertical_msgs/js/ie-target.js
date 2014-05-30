$(document).ready(function()
{
(function($) 
	{
	$.fn.haccordion=function() 
		{
			if(($.browser.msie) && ($.browser.version=='7.0'))	
			{
				return this.each(function() 
				{
					var $this=$(this);
					$(this).find('ul li a.header').bind('click',function() 
					{
						$this.find('ul li.block').removeClass('target');
						$(this).parent('li.block').addClass('target');
					});
			});
			};
		};
	})(jQuery);
	$('.qlabs_accordion').haccordion();
})