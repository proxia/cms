
var SortTable =
{
	moveUp: function (event)
	{
		var el = event.element().up(1);

		SortTableManipulator.moveNodeUp(el);
		SortTableManipulator.fixOrder();
		SortTableManipulator.deselectAllNodes();
		el.addClassName('selected');
	},

	moveDown: function (event)
	{
		var el = event.element().up(1);

		SortTableManipulator.moveNodeDown(el);
		SortTableManipulator.fixOrder();
		SortTableManipulator.deselectAllNodes();
		el.addClassName('selected');

	},

	moveToTop: function (event)
	{
		var el = event.element().up(1);

		SortTableManipulator.moveNodeToTop(el);
		SortTableManipulator.fixOrder();
		SortTableManipulator.deselectAllNodes();
		el.addClassName('selected');

	},

	moveToBottom: function (event)
	{
		var el = event.element().up(1);

		SortTableManipulator.moveNodeToBottom(el);
		SortTableManipulator.fixOrder();
		SortTableManipulator.deselectAllNodes();
		el.addClassName('selected');

	}
};

var SortTableManipulator =
{
	moveNodeUp: function (el)
	{
		if ( el.previous() )
			el.previous().insert({ before: el.remove() });
	},

	moveNodeDown: function (el)
	{
		if ( el.next() )
			el.next().insert({ after: el.remove() });
	},

	moveNodeToTop: function (el)
	{
		if ( el.previousSiblings().last() )
			el.previousSiblings().last().insert({ before: el.remove() });
	},

	moveNodeToBottom: function (el)
	{
		if ( el.nextSiblings().last() )
			el.nextSiblings().last().insert({ after: el.remove() });
	},

	fixOrder: function ()
	{
		$$('ul#Content input').each
		(
			function (el, i)
			{
				el.value = i + 1;
			}
		);
	},

	selectNode: function (el)
	{

	},

	getItems: function ()
	{
		output = "";
		$$('ul#Content li').each
		(
			function (el)
			{
				item_id = el.getAttribute("px:item_id");
				item_type = el.getAttribute("px:item_type");
				output += "&item[]="+item_type+"_"+item_id;
			}
		)
		return output;
	},

	deselectAllNodes: function ()
	{
		$$('ul#Content li').each
		(
			function (el)
			{
				el.removeClassName("selected");
			}
		)
	}


};

/******************************************************************************/
/******************************************************************************/
/******************************************************************************/

function attachEventHandlers()
{
	$$('ul#Content div.controlls').each
	(
		function (el)
		{
			el.getElementsBySelector('img').each
			(
				function (el)
				{
					if ( el.src.indexOf('arrow_up') != -1 )
						el.observe('click', SortTable.moveUp);
					else if ( el.src.indexOf('arrow_down') != -1 )
						el.observe('click', SortTable.moveDown);
					else if ( el.src.indexOf('arrow_top') != -1 )
						el.observe('click', SortTable.moveToTop);
					else if ( el.src.indexOf('arrow_bottom') != -1 )
						el.observe('click', SortTable.moveToBottom);
				}
			);
		}
	);
}

Event.observe
(
	window,
	'load',

	function ()
	{
		attachEventHandlers();
	}
);