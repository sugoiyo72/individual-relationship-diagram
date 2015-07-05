(function () {

	var width = document.querySelector("#irdDisplay").clientWidth;
	var height = 800;

	var color = d3.scale.category20();

	var relationshipData = {};

	var radius = d3.scale.sqrt()
		.range([0, 6]);


	var svg = d3.select("#irdDisplay").append("svg")
		.attr("width", width)
		.attr("height", height);

	var newirdSimulation = function (newRelationship, example) {
		// Might be super dirty, but it works! .. Yes this comment was abstracted.
		$('#irdDisplay').empty();
		svg = d3.select("#irdDisplay").append("svg")
					.attr("width", width)
					.attr("height", height);
		if (example)
			newRelationship = newRelationship[example];
		newRelationship = $.extend(true, {}, newRelationship);
		individualRelationship(newRelationship);
		
	};

	window.loadMoleculeExample = function () {
		newirdSimulation (relationshipData, $('#relationshipData').val().trim());
	};

	$.getJSON("/user/relationjson/" + target_user_id, function(json) {
		json.default.nodes[0].x = width / 2;
		json.default.nodes[0].y = height / 2;
		relationshipData = json;
		newirdSimulation (relationshipData, 'default');
	});

	var linkText;

	// individualRelationship
	var individualRelationship = function(graph) {
		var nodesList, linksList;
		nodesList = graph.nodes;
		linksList = graph.links;

		var force = d3.layout.force()
			.nodes(nodesList)
			.links(linksList)
			.size([width, height])
			.gravity(-0.05)
			.charge(-600)
			.linkStrength(function (d) { return d.bondType ? d.bondType * 2 + 1 : 1;})
			.linkDistance(function(d) { return radius(d.source.size) + radius(d.target.size) + (d.bondType ? 250 - d.bondType * 60 : 10); })
			.on("tick", tick);

		var links = force.links(),
			nodes = force.nodes(),
			link = svg.selectAll(".link"),
			node = svg.selectAll(".node");

		buildRelationship();

		function buildRelationship () {
			// Update link data
			link = link.data(links, function (d) {return d.id; });

			// Create new links
			link.enter().insert("g", ".node")
				.attr("class", "link")
				.each(function(d) {
					// Add bond line
					d3.select(this)
						.append("line")

					d3.select(this)
						.filter(function(d) { return d.bondType >= 1; }).append("line")
						.style("stroke-width", function(d) { return (d.bondType * 3 - 2) * 2 + "px"; });

					d3.select(this)
						.filter(function(d) { return d.bondType >= 2; }).append("line")
						.style("stroke-width", function(d) { return (d.bondType * 2 - 2) * 2 + "px"; })
						.attr("class", "double");

					d3.select(this)
						.filter(function(d) { return d.bondType >= 3; }).append("line")
						.attr("class", "triple");

			});

			// Delete removed links
			link.exit().remove(); 

			// Update node data
			node = node.data(nodes, function (d) {return d.id; });

			// Create new nodes
			node.enter().append("g")
				.attr("class", "node")
				.each(function(d) {

					// Add node mask
					d3.select(this)
						.filter(function(d) { return d.nodetype === "person";})
						.append("clipPath")
						.attr("id", function(d) { return "clip" + d.id;})
						.append("circle")
						.attr("cx", 0)
						.attr("cy", 0)
						.attr("r", 40);

					// Add node image
					d3.select(this)
						.filter(function(d) { return d.nodetype === "person";})
						.append("image")
						.attr("xlink:href", function(d) { return d.url;})
						.attr("x", -40)
						.attr("y", -40)
						.attr("width", 80)
						.attr("height", 80)
						.attr("clip-path", function(d) { return "url(#clip" + d.id + ")";});

					// Add node name
					d3.select(this)
						.filter(function(d) { return d.nodetype === "person";})
						.append("text")
						.attr("dx", 30)
						.attr("dy", 30)
						.text(function(d) { return d.name });

					// Add node circle
					d3.select(this)
						.filter(function(d) { return d.nodetype === "introduced";})
						.append("foreignObject")
						.attr("x", -120)
						.attr("y", -120)
						.attr("width", 240)
						.attr("height", 240)
						.append("xhtml:div")
						.attr("class", "graph-svg-component")
						.attr("id", function(d) { return "introduced" + d.id ;})
						.text(function(d) { return d.introduced['feature'] ;});

					d3.select(this)
						.call(force.drag);
				});

			// Delete removed nodes
			node.exit().remove();


			linkText = svg.selectAll(".link")
				.append("text")
				.attr("class", "link-label")
				.attr("font-family", "verdana")
				.attr("fill", "Black")
				.style("font", function(d) { return "normal "+(d.bondType * 5 + 10)+"px verdana"})
				.attr("dy", ".35em")
				.attr("text-anchor", "middle")
				.text(function(d) {
					return d.text;
				});

			force.start();

			$.each(graph.introductions, function(i, introduction) {
				$("#introduced"+introduction.id).html(introduction.div);
				var scale = 300 - ((12 - introduction.bondType) *10);
			});
		}
		// buildRelationship end

		function tick() {
			//Update old and new elements
			link.selectAll("line")
				.attr("x1", function(d) { return d.source.x; })
				.attr("y1", function(d) { return d.source.y; })
				.attr("x2", function(d) { return d.target.x; })
				.attr("y2", function(d) { return d.target.y; });

				node.attr("transform", function(d) {return "translate(" + d.x + "," + d.y + ")"; });

			linkText.attr("x", function(d) {
				return ((d.source.x + d.target.x)/2);
			})
			.attr("y", function(d) {
				return ((d.source.y + d.target.y)/2);
			});

		}
	};
	// individualRelationship end
})();
