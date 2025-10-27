<?php
$visWidth = 650;
$visHeight = 620;
$css = ".hmRowText {
	font-weight:bold;
	text-anchor:end;
	font-size:11pt;
}

.axis text {
  font: 11px sans-serif;
  stroke-width: 0;
}
.axisValue {
	stroke-width:3;
}

.axis line,
.axis path {
  fill: none;
  shape-rendering: crispEdges;
}

.trh { font-weight:bold; }
.main { width:980px; }
.res1 { width:480px; float:left; }
.res2 { width:480px; float:right; }
.copyright { text-align:center; font-size:90%; clear:both; }
legend { font-size:120%; font-weight:bold; }
";
?><html>
<head>
<style>
* { font-family:tahoma; }
</style>
<script src="d3.v3.js" charset="utf-8"></script>
<script src="d3.scale.logit.js" charset="utf-8"></script>
<link rel="stylesheet" href="../pathome/jquery-ui.css">
<script src="../pathome/js/jq.min.js"></script>
<script src="../pathome/jquery-ui.min.js"></script>
<script src="../pathome/js/jq.fileDownload.min.js"></script>
<script>
function d3nomogram(id, obs, axes, pred, width, height, margin, anim, duration) {
	//Width and height
	if (typeof width == "undefined")  width = 900;
	if (typeof height == "undefined")  height = 500;
	if (typeof dur == "undefined")  dur = 300;
	if (typeof margin == "undefined")  margin = [20, 20, 30, 40];
	if (typeof anim == "undefined")  anim = true;
	
	var colors = [
		"#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",
		"#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"
	];
	var textMax = 0;
	var pointMin = 999999999;
	var pointMax = -99999999;
	var totalMin = 0;
	var totalMax = 0;
	var totalPoint = 0;
	var points = new Array();
	var nFixedAxisT = 1;
	var nFixedAxisB = 2;
	var nFixedAxis = nFixedAxisT + nFixedAxisB;
	var nObs = obs.length;
	
	// Height of each axis
	var axisHeight = (height-margin[0]-margin[2]) / (nObs+nFixedAxis);
			
	for (var i in axes) {
		pointMin = Math.min(pointMin, axes[i][3]);
		pointMax = Math.max(pointMax, axes[i][4]);
	}
	d3.select(id).html("");
	
	// Generate SVG
	this.svg = d3.select(id).append("svg")
		.attr("width", width)
		.attr("height", height);
		
	// Generate main group
	this.dataGroup = this.svg.append("svg:g");
	
	//
	// Top-side fixed axis label
	//
 
	// Point
	this.hTextPoint = this.dataGroup.append("svg:text")
		.text("Point")
		.attr("class", "hmRowText");
 
	//
	// Variable axes label
	//
	this.hTextVar = this.dataGroup.selectAll("#axes").data(axes).enter().append("svg:text")
		.text(function(d,i) { return d[0]; })
		.attr("class", "hmRowText")
		.attr("opacity", 0)
		.attr("fill", function(d,i) { return colors[i]; })
		.each(function(d) {
			textMax = Math.max(textMax,this.getBBox().width);
		});
	if (anim == true)
		this.hTextVar.transition()
			.delay(function(d,i) { return dur * i; })
			.duration(dur)
			.attr("opacity", 1);
	else
		this.hTextVar.attr("opacity", 1);
	
	//
	// Bottom-side fixed axis label
	//
 
	// Total point
	this.hTextTotalPt = this.dataGroup.append("svg:text")
		.text("Total Point")
		.attr("class", "hmRowText");

	// Predictor
	this.hTextPred = this.dataGroup.append("svg:text")
		.text("Prediction")
		.attr("class", "hmRowText");
	
	// Get the maximum width of axis hTextVars
	var textMax = Math.max(
			this.hTextPred.node().getBBox().width, Math.max(
				this.hTextTotalPt.node().getBBox().width,
				Math.max(
					this.hTextPoint.node().getBBox().width, textMax
				))) + margin[3];
			
	// Move to right all of the axis hTextVars
	this.hTextPoint
		.attr("transform", function(d,i){
			return "translate("+(textMax-20)+","+(axisHeight*0.5)+")";
		});
	this.hTextVar
		.attr("transform", function(d,i){
			return "translate("+(textMax-20)+","+axisHeight*(i+1.5)+")";
		});
	this.hTextTotalPt
		.attr("transform", function(d,i){
			return "translate("+(textMax-20)+","+axisHeight*(nObs+1.5)+")";
		});
	this.hTextPred
		.attr("transform", function(d,i){
			return "translate("+(textMax-20)+","+axisHeight*(nObs+2.5)+")";
		});
 
	// Generate axes group
	this.axesGroup = this.svg.append("svg:g");
	
	// Create scale function for point mapping
	var fScalePoint = d3.scale.linear()
		.domain( [pointMin, pointMax] )
		.range( [textMax, width-margin[1]] );
	
	//
	// Top-side fixed axis
	//
	this.axesGroup.append("svg:g")
		.attr("stroke", "#222")
		.attr("class", "axis")
		.call(
			d3.svg.axis()
				.scale(fScalePoint)
				.orient("bottom")
		)
		.attr("transform", "translate(0,"+(axisHeight*0.5)+")");
	
	//
	// Variable axes
	//
	for (var i in axes) {
		var aAx				= axes[i];
		var fScaleAxis		= null;
		var fScaleCalcPt	= null;
		i = parseInt(i);
		var val				= aAx.length == 6 ?
			Math.round(aAx[5](obs[i])*1000)/1000 :
			obs[i];

		if (aAx[2] == null && aAx[1].length) {
			// Ordinal scale
			fScaleAxis = d3.scale.ordinal()
				.domain( aAx[1] )
				.rangePoints(
					[fScalePoint(aAx[3]),fScalePoint(aAx[4])]
				);
			fScaleCalcPt = d3.scale.ordinal()
				.domain( aAx[1] )
				.rangePoints( [aAx[3], aAx[4]] );
		} else {
			fScaleAxis = d3.scale.linear()
				.domain( [aAx[1], aAx[2]] )
				.range(
					[fScalePoint(aAx[3]), fScalePoint(aAx[4])]
				);
			
			fScaleCalcPt = d3.scale.linear()
				.domain( [aAx[1], aAx[2]] )
				.range( [aAx[3], aAx[4]] );
		}
		var posY	= axisHeight*(i+1.5);
		var posObs	= fScaleAxis(val);
		if (typeof posObs == "undefined")
			posObs	= fScaleAxis( fScaleAxis.domain()[val] );
		
		var nTick = (fScaleAxis.range()[1]-fScaleAxis.range()[0])/40;
		if (nTick < 2) nTick = 2;
		
		// Drawing observation on point axis
		this.axesGroup.append("svg:circle")
			.attr("r", 2)
			.attr("transform", "translate("+posObs+","+(axisHeight*0.5)+")");
 
		// Add axis
		var hAxis = this.axesGroup.append("svg:g")
			.attr("transform", function(d) {
				return "translate(0,"+posY+")";
			})
			.attr("class", "axis")
			.attr("stroke", colors[i])
			.attr("opacity", 0)
			.call(
				d3.svg.axis()
					.scale(fScaleAxis)
					.orient("bottom")
					.ticks(nTick)
			);
			       
		// Drawing observation on axis
		var hCircle = this.axesGroup.append("svg:circle")
			.attr("r", 3)
			.attr("opacity", 0)
			.attr("transform", "translate("+posObs+","+posY+")");
		
		// Connect two circles
		var hLineConnect =this.axesGroup.append("svg:line")
			.attr("x1", posObs)
			.attr("x2", posObs)
			.attr("y1", axisHeight*0.5)
			.attr("y2", posY)
			.attr("opacity", 0)
			.attr("style", "stroke:rgb(255,0,0);stroke-width:0.5")
			.style("stroke-dasharray", ("5, 5"));
		
		var hLineValue = null;
		if (aAx[2] == null && aAx[1].length) {
			hLineValue = this.axesGroup.append("svg:line")
				.attr("x1", fScaleAxis(aAx[1][0]))
				.attr("x2", fScaleAxis(aAx[1][0]))
				.attr("y1", posY)
				.attr("y2", posY)
				.attr("style", "stroke:"+colors[i]+";stroke-width:5");
		} else {
			hLineValue = this.axesGroup.append("svg:line")
				.attr("x1", fScaleAxis(aAx[1]))
				.attr("x2", fScaleAxis(aAx[1]))
				.attr("y1", posY)
				.attr("y2", posY)
				.attr("style", "stroke:"+colors[i]+";stroke-width:5");
		}
		
		// Animation
		if (anim == true) {
			hAxis.transition().delay(dur * i)
				.duration(dur)
				.attr("opacity", 1);
 
			hCircle.transition().delay(dur * i)
				.duration(dur)
				.attr("opacity", 1);
		
			hLineConnect.transition().delay(dur * i)
				.duration(dur)
				.attr("opacity", 1);
 
			hLineValue.transition().delay(dur * i)
				.duration(dur)
				.attr("x2", posObs);
		} else {
			hAxis.attr("opacity", 1);
			hCircle.attr("opacity", 1);
			hLineConnect.attr("opacity", 1);
			hLineValue.attr("opacity", 1);
		}
		
		if (aAx[2] != null) {
			var obsText = this.axesGroup.append("svg:text")
				.text(function(d) {return val;})
				.attr("class", "obsText")
				.attr("fill", function(d) {return colors[i];})
				.attr("transform", "translate("+(posObs+3)+","+(posY-3)+")");
		}
 
		points[i]	= fScaleCalcPt(val);
		if (typeof points[i] == "undefined")
			points[i] = fScaleCalcPt(fScaleAxis.domain()[val]);
		totalMin += aAx[3];
		totalMax	+= aAx[4];
		totalPoint	+= points[i];
	}
	var fScaleTotal = d3.scale.linear()
		.domain([0, totalMax])
		.range([textMax, width-margin[1]]);
	
	//
	// Bottom-side fixed axis
	//

	// Add total point axis
	this.axesGroup.append("svg:g")
		.attr("transform", function(d) {
			return "translate(0,"+axisHeight*(nObs+1.5)+")";
		})
		.attr("class", "axis")
		.attr("stroke", "#222")
		.call(
			d3.svg.axis()
				.scale(fScaleTotal)
				.orient("bottom")
		);
	
	// Add prediction axis
	var fScalePred = d3.scale.logit()
		.domain([-5, totalPoint])
		.range([textMax, width-margin[1]]);
	this.axesGroup.append("svg:g")
		.attr("transform", function(d) {
			return "translate(0,"+axisHeight*(nObs+2.5)+")";
		})
		.attr("class", "axis")
		.attr("stroke", "#222")
		.call(
			d3.svg.axis()
				.scale(fScalePred)
				.orient("bottom")
		);

	var calcTotalScale = d3.scale.linear()
		.domain([0, totalPoint])
		.range([textMax, fScaleTotal(totalPoint)]);
	for (var i in points) {
		var curLine = this.axesGroup.append("svg:line")
			.attr("x1", function(d) {
				if (i == 0) {
					return textMax;
				} else {
					var width = calcTotalScale(points[0]);
			      
					for (var j=1 ; j<i ; j++) {
						width += calcTotalScale(points[j])-(textMax);
					}
					return width;
				}
			})
			.attr("x2", function(d) {
				if (i == 0) {
					return textMax;
				} else {
					var width = calcTotalScale(points[0]);
			      
					for (var j=1 ; j<i ; j++) {
						width += calcTotalScale(points[j])-(textMax);
					}
					return width;
				}
			})
			.attr("y1", axisHeight*(nObs+1.5))
			.attr("y2", axisHeight*(nObs+1.5))
			.attr("style", "stroke:"+colors[i]+";stroke-width:5");
		if (anim == true)
			curLine.transition().delay(dur * i)
				.duration(dur)
				.attr("x2", function(d) {
					var width = calcTotalScale(points[0]);
					for (var j=1 ; j<=i ; j++) {
						width += calcTotalScale(points[j])-(textMax);
					}
					return width;
				});
		else curLine.attr("x2", function(d) {
				var width = calcTotalScale(points[0]);
				for (var j=1 ; j<=i ; j++) {
					width += calcTotalScale(points[j])-(textMax);
				}
				return width;
			});
	}

	// Add prediction bar
	this.axesGroup.append("svg:circle")
		.attr("transform", "translate("+fScalePred(pred)+","+axisHeight*(nObs+2.5)+")")
		.attr("r", 3);
	this.axesGroup.append("svg:line")
		.attr("x1", textMax)
		.attr("x2", fScalePred(pred))
		.attr("y1", axisHeight*(nObs+2.5))
		.attr("y2", axisHeight*(nObs+2.5))
		.attr("style", "stroke:red;stroke-width:5;");
	
}
function prob(n, coef, conv) {
	var pred = coef[0];
	for (var i=0 ; i<n.length ; i++) {
	var val = $(n[i]).val();
	if (!val.length) return n[i]+" is empty!";
	if (typeof eval("conv[\""+n[i]+"\"]") != 'undefined') {
		val = Number(val);
		eval("val = conv[\""+n[i]+"\"](Number(val))");
	}
	pred += val * coef[i+1];
	}
//	console.log("Prob " + pred);
	return 1/(1+Math.exp(-pred));
}
function calc() {
	var invav = [ "#ageval", ":radio[name='sex']:checked", "#logcea", "#logca199", "#mainduct", "#cystsize", ":radio[name='muralnodule']:checked" ];
	var inva = [ -5.964893, 0.01094, 0.259659, 0.31324, 0.451022, 0.156631, 0.01518, 0.999965 ];
	var invax = [
		[ "Age", 20, 90, inva[1]*20, inva[1]*90 ],
		[ "Sex", ["None", "Male", "Female"], null, inva[2]*0, inva[2]*2 ],
		[ "log(CEA)", 0, Math.log(200), inva[3]*0, inva[3]*Math.log(200), Math.log ],
		[ "log(CA19-9)", 0, Math.log(5000), inva[4]*0, inva[4]*Math.log(5000), Math.log ],
		[ "Main duct size", 0, 20, inva[5]*0, inva[5]*20 ],
		[ "Cyst size", 0, 200, inva[6]*0, inva[6]*200 ],
		[ "Mural nodule", ["No", "Yes"], null, inva[7]*0, inva[7]*1 ]
	];

	var maliv = [ "#ageval", "#logcea", "#logca199", "#mainduct", "#cystsize", ":radio[name='muralnodule']:checked" ];
	var mali = [ -4.562976, 0.018464, 0.24484, 0.222167, 0.185497, 0.017445, 1.194933 ];
	var malix = [
		[ "Age", 20, 90, mali[1]*20, mali[1]*90 ],
		[ "log(CEA)", 0, Math.log(200), mali[2]*0, mali[2]*Math.log(200), Math.log ],
		[ "log(CA19-9)", 0, Math.log(5000), mali[3]*0, mali[3]*Math.log(5000), Math.log ],
		[ "Main duct size", 0, 20, mali[4]*0, mali[4]*20 ],
		[ "Cyst size", 0, 200, mali[5]*0, mali[5]*200 ],
		[ "Mural nodule", ["No", "Yes"], null, mali[6]*0, mali[6]*1 ]
		];

	var invaprob = prob(invav, inva, {
		"#logcea" : Math.log,
		"#logca199" : Math.log });
	var maliprob = prob(maliv, mali, {
		"#logcea" : Math.log,
		"#logca199" : Math.log });

	if (invaprob !== Number(invaprob) ||
		maliprob !== Number(maliprob))
		$("#comment").val(invaprob);
	else {
		$("#invaprob").val(Math.round(invaprob*10000)/100);
		$("#maliprob").val(Math.round(maliprob*10000)/100);
	}

	// Extract values
	var obs = [];
	for (var i=1 ; i<inva.length ; i++)
	obs.push( $(invav[i-1]).val() );
	d3nomogram("#invanomo", obs, invax, Math.log(invaprob/(1-invaprob)), 440);	

	obs = [];
	for (var i=1 ; i<mali.length ; i++)
	obs.push( $(maliv[i-1]).val() );
	d3nomogram("#malinomo", obs, malix, Math.log(maliprob/(1-maliprob)), 440);
}
$(function() {
	$("#age").slider({
		min: 30,
		max: 100,
		value: 50,
		slide: function(event, ui) {
			$("#ageval").val(ui.value);
		}
		});
		$("#ageval")
		.val($("#age").slider("value"))
		.change(function() {
			$("#age").slider("value", $(this).val());
		});
	$("button").button();
});
function downvis(id, fmt) {
	var svgelem = $('#'+id+" > svg");
	var w = svgelem.width();
	var h = svgelem.height();
	var serializer = new XMLSerializer();
	var str = '';
	if (svgelem.length == 0) {
		if (typeof $preparingFileModal != 'undefined') $preparingFileModal.dialog('close');
		$('#error-modal').dialog({ modal: true });
		return;
	}
	for (var i=0 ; i<svgelem.length ; i++)
		str += serializer.serializeToString(svgelem[i]);
	var S_svg = "width="+w+"&height="+h+"&svg="+encodeURIComponent("<"+"?xml version=\"1.0\" encoding=\"UTF-8\"?><svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" width=\""+w+"\" height=\""+h+"\"><defs><style type=\"text/css\"><![CDATA[\n")+"<?=urlencode($css)?>"+encodeURIComponent("]]></style></defs>"+str+"</svg>")+"&format="+fmt;

	// Prepare modal dialog
	var $preparingFileModal = $("#preparing-file-modal");
	$preparingFileModal.dialog({ modal: true });

	$.fileDownload('../pathome/convert.php', {
		successCallback: function (url) {
			$preparingFileModal.dialog('close');
		},
		failCallback: function (responseHtml, url) {
			$preparingFileModal.dialog('close');
			$('#error-modal').dialog({ modal: true });
		},
		httpMethod: 'POST',
        data: S_svg
	});
	return false; 
}
</script>
<style>
<?php
echo $css;
?>
</style>
</head>
<body>
<!-- Download modal dialog using jQuery UI -->
<div id="preparing-file-modal" title="Preparing report..." style="display: none;">
	Preparing visualization...
	<div class="ui-progressbar-value ui-corner-left ui-corner-right" style="width: 100%; height:22px; margin-top: 20px;"></div>
</div>
<div id="error-modal" title="Error" style="display: none;">
	Failed to generate visualization...
</div>
<h1>Pancreatic cancer IPMN malignancy & invasiveness calculator</h1>
<div class='main'>
	<fieldset>
	<legend>Observed values</legend>
	<table>
		<tr>
		<td class='trh'>Age</td>
		<td>
			<div style='float:left;width:200px;'>
			<div id='age'></div>
			</div>
			<div style='float:left;margin-left:20px;'><input type='text' id='ageval' name='ageval' size='3' /></div>
		</td>
		</tr>
		<tr>
		<td class='trh'>Sex</td>
		<td>
			<input type='radio' id='sex' name='sex' value='1' checked /> Male
			<input type='radio' id='sex' name='sex' value='2' /> Female<br />
		</td>
		</tr>
		<tr>
		<td class='trh'>CEA value</td>
		<td>
			<input type='text' id='logcea' /> Raw value, range: 1~200<br />
		</td>
		</tr>
		<tr>
		<td class='trh'>CA19-9 value</td>
		<td>
			<input type='text' id='logca199' /> Raw value, range: 1~5000<br />
		</td>
		</tr>
		<tr>
		<td class='trh'>Main duct size</td>
		<td>
			<input type='text' id='mainduct' /> mm, range: 0~20<br />
		</td>
		</tr>
		<tr>
		<td class='trh'>Cyst size</td>
		<td>
			<input type='text' id='cystsize' /> mm, range: 0~200<br />
		</td>
		</tr>
		<tr>
		<td class='trh'>Mural nodule</td>
		<td> 
			<input type='radio' id='muralnodule' name='muralnodule' value='0' checked /> No
			<input type='radio' id='muralnodule' name='muralnodule' value='1' /> Yes<br />
		</td>
		</tr>
		<tr height='50'>
		<td colspan='2'>
			<input type='button' value='   Calculate   ' onclick="calc()" />
		</td>
		</tr>
	</table>
	</fieldset>
	<br />
	<div class='res1'>
	<fieldset>
		<legend>Malignancy result</legend>
		Probability of malignancy : <input type='text' id='maliprob' size=3 readonly />%<br />&nbsp;
		<div id="malinomo"></div>
		<button onclick="downvis('malinomo', 'tif')">TIFF</button>
		<button onclick="downvis('malinomo', 'png')">PNG</button>
		<!--<button onclick="downvis('malinomo', 'svg')">SVG</button>-->
	</fieldset>
	</div>
	<div class='res2'>
	<fieldset>
		<legend>Invasiveness result</legend>
		Probability of invasiveness : <input type='text' id='invaprob' size=3 readonly />%<br />
		<input type='text' id='comment' style='border:0;color:red;' />
		<div id="invanomo"></div>
		<button onclick="downvis('invanomo', 'tif')">TIFF</button>
		<button onclick="downvis('invanomo', 'png')">PNG</button>
		<!--<button onclick="downvis('invanomo', 'svg')">SVG</button>-->
	</fieldset>
	</div>
	<div id="my"></div>
	<div class='copyright'>
	<br />
	Created by Sungyoung Lee, BIBS Labratory, Seoul National University<br />
	Version 0.2.0 by March 3, 2015.<br />
	Contact: tspark@stats.snu.ac.kr
	</div>
</div>

</body>
</html>