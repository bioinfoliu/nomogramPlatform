<?php
$visWidth = 650;
$visHeight = 620;
$css = ".ZX {
	font-weight:bold;
	text-anchor:end;
	font-size:11pt;
}

.hmBoldText { font-weight:bold; }

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
text { font-size:70%; }

.ZU { font-weight:bold; }
.main { width:980px; }
.res1 { width:980px; float:left; }
.ZY { text-align:center; font-size:90%; clear:both; }
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
function wrap(text, width) {
  var T = text[0];
  var aBCRrect = T.map(function(v) { return v.getBoundingClientRect(); });
  var rects = aBCRrect.filter(function(v) { return v.width > 0; });
  var ridxs = T.map(function(v,i) { return i; }).filter(function(i) { return aBCRrect[i].width > 0; });
  if (rects[1].left > rects[0].left) for (var i=1 ; i<rects.length ; i++) {
	  if (rects[i].left < rects[i-1].right) {
		  var c1 = rects[i-1].left + rects[i-1].width/2;
		  var c2 = rects[i].left + rects[i].width/2;
		  T[ridxs[i]].setAttribute("x", T[ridxs[i]].getAttribute("x") + rects[i].width/2);
		  T[ridxs[i-1]].setAttribute("x", T[ridxs[i-1]].getAttribute("x") - rects[i-1].width/2);
	  }
  } else for (var i=rects.length-2 ; i>=0 ; i--) {
	  if (rects[i+1].right > rects[i].left) {
		  var c1 = rects[i].left + rects[i].width/2;
		  var c2 = rects[i+1].left + rects[i+1].width/2;
		  T[ridxs[i+1]].setAttribute("x", T[ridxs[i+1]].getAttribute("x") - rects[i+1].width/2);
		  T[ridxs[i]].setAttribute("x", T[ridxs[i]].getAttribute("x") + rects[i].width/2);
	  }
  }
}
function d3nomogram(id, obs, axes, pred, width, height, margin, anim, duration) {
	//Width and height
	if (typeof width == "undefined")  width = 900;
	if (typeof height == "undefined")  height = 500;
	if (typeof dur == "undefined")  dur = 300;
	if (typeof margin == "undefined")  margin = [20, 30, 30, 40];
	if (typeof anim == "undefined")  anim = true;
	
	var colors = [
		"#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",
		"#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf", "red", "blue",
	];
	var bUsePointNorm = true;
	var textMax = 0;
	var pointMin = 999999;
	var pointMax = -999999;
	var totalMin = bUsePointNorm ? 0 : axes[0];
	var totalMax = bUsePointNorm ? 0 : axes[0];
	var rawTotalMin = axes[0];
	var rawTotalMax = axes[0];
	var totalPoint = axes[0];
	var points = [ axes[0] ];
	var nFixedAxisT = 1;
	var nFixedAxisB = 2;
	var nFixedAxis = nFixedAxisT + nFixedAxisB;
	var nObs = obs.length;

	// Height of each axis
	var axisHeight = (height-margin[0]-margin[2]) / (nObs+nFixedAxis);
			
	for (var i in axes) {
		if (i == "0") continue;
		if (typeof axes[i][3] == 'object') {
			for (var j in axes[i][3]) if (axes[i][3].hasOwnProperty(j)) {
				pointMax = Math.max(pointMax, axes[i][3][j]);
				pointMin = Math.min(pointMin, axes[i][3][j]);
			}
		} else {
			pointMax = Math.max(pointMax, axes[i][4]);
			pointMin = Math.min(pointMin, axes[i][3]);
		}
	}
	console.log("Point range ", pointMin, " ~ ", pointMax);
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
	var B_showTotalPoint = true;
	if (B_showTotalPoint) this.hTextTotalPt = this.dataGroup.append("svg:text")
		.text("Total Point")
		.attr("class", "hmRowText hmBoldText");

	// Predictor
	this.hTextPred = this.dataGroup.append("svg:text")
		.text("Prediction")
		.attr("class", "hmRowText hmBoldText");
	
	// Get the maximum width of axis hTextVars
	if (B_showTotalPoint)
		textMax = Math.max(
			this.hTextPred.node().getBBox().width, Math.max(
				this.hTextTotalPt.node().getBBox().width,
				Math.max(
					this.hTextPoint.node().getBBox().width, textMax
				))) + margin[3];
	else
		textMax = Math.max(
			this.hTextPred.node().getBBox().width,
				Math.max(
					this.hTextPoint.node().getBBox().width, textMax
				)) + margin[3];
			
	// Move to right all of the axis hTextVars
	this.hTextPoint
		.attr("transform", function(d,i){
			return "translate(0,"+(axisHeight*0.5)+")";
		});
	this.hTextVar
		.attr("transform", function(d,i){
			return "translate(0,"+axisHeight*(i+0.5)+")";
		});
	if (B_showTotalPoint)
		this.hTextTotalPt
			.attr("transform", function(d,i){
				return "translate(0,"+axisHeight*(nObs+1.5)+")";
			});
	this.hTextPred
		.attr("transform", function(d,i){
			return "translate(0,"+axisHeight*(nObs+2.5)+")";
		});
 
	// Generate axes group
	this.axesGroup = this.svg.append("svg:g");
	
	// Create scale function for point mapping
	var fScalePoint = null;
	var fScalePointNorm = null;
	if (bUsePointNorm) {
		fScalePoint = d3.scale.linear()
			.domain( [pointMin, pointMax] )
			.range( [0, 100] );
		fScalePointNorm = d3.scale.linear()
			.domain( [0, 100] )
			.range( [textMax, width-margin[1]] );
	} else
		fScalePoint = d3.scale.linear()
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
				.scale(fScalePointNorm ? fScalePointNorm : fScalePoint)
				.orient("bottom")
		)
		.attr("transform", "translate(0,"+(axisHeight*0.5)+")");
	
	//
	// Variable axes
	//
	for (var i=1 ; i<axes.length ; i++) {
		var aAx				= axes[i];
		var fScaleAxis		= null;
		var fScaleCalcPt	= null;
		var obsi = parseFloat(obs[i-1]);
		var val				= typeof aAx[5] == 'function' ?
			Math.round(aAx[5](obsi)*1000)/1000 : obs[i-1];

		if (aAx[2] == null && aAx[1].length) {
			var tm = [], tm2 = [];
			var adj = false;
/*			if (fScalePointNorm && fScalePointNorm(fScalePoint(aAx[3][aAx[1][0]])) != textMax) {
				tm.push(fScalePointNorm(0));
				tm2.push(pointMin);
				adj = true;
			}*/
			for (var j=0 ; j<aAx[1].length ; j++) {
				tm.push(fScalePointNorm ? fScalePointNorm(fScalePoint(aAx[3][aAx[1][j]])) : fScalePoint(aAx[3][aAx[1][j]]));
				tm2.push(aAx[3][aAx[1][j]]);
			}				
			// Ordinal scale
			fScaleAxis = d3.scale.ordinal()
				.domain( adj ? [ "" ].concat(aAx[1]) : aAx[1] )
				.range(tm);
			fScaleCalcPt = d3.scale.ordinal()
				.domain( adj ? [ "" ].concat(aAx[1]) : aAx[1] )
				.range(tm2);
		} else {
			fScaleAxis = d3.scale.linear()
				.domain( aAx[2].length !== undefined ? aAx[2] : [0, aAx[2]] )
				.range(
					fScalePointNorm ?
						[fScalePointNorm(fScalePoint(aAx[3])), fScalePointNorm(fScalePoint(aAx[4]))] :
						[fScalePoint(aAx[3]), fScalePoint(aAx[4])]
				);
			
			fScaleCalcPt = d3.scale.linear()
				.domain( aAx[2].length !== undefined ? aAx[2] : [aAx[1], aAx[2]] )
				.range( [aAx[3], aAx[4]] );
		}
		var posY	= axisHeight*(i+0.5);
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
		wrap(hAxis.selectAll(".tick text"));
			       
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
				.attr("x1", fScalePointNorm ? fScaleAxis(fScalePointNorm(0)) : fScalePoint(0))
				.attr("x2", fScalePointNorm ? fScaleAxis(fScalePointNorm(0)) : fScalePoint(0))
				.attr("y1", posY)
				.attr("y2", posY)
				.attr("style", "stroke:"+colors[i]+";stroke-width:5");
		} else {
			hLineValue = this.axesGroup.append("svg:line")
				.attr("class", "lineValue")
				.attr("x1", fScaleAxis(aAx[2].length !== undefined ? 0 : aAx[1]))
				.attr("x2", fScaleAxis(aAx[2].length !== undefined ? 0 : aAx[1]))
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
				.text(function(d) {return Math.round(val*100)/100;})
				.attr("class", "obsText")
				.attr("fill", function(d) {return colors[i];})
				.attr("transform", "translate("+(posObs+3)+","+(posY-3)+")");
		}
 
		points[i]	= fScaleCalcPt(val);
		if (typeof points[i] == "undefined")
			points[i] = fScaleCalcPt(fScaleAxis.domain()[val]);
		else if (points[i] != points[i])
			points[i] = 0;
		if (typeof aAx[3] == 'object') {
			var tMin = 99999999;
			var tMax = -99999999;
			for (var j in aAx[3]) if (aAx[3].hasOwnProperty(j)) {
				var v = aAx[3][j];
				if (tMin > v) tMin = v;
				if (tMax < v) tMax = v;
			}
			totalMin	+= bUsePointNorm ? fScalePoint(tMin) : tMin;
			totalMax	+= bUsePointNorm ? fScalePoint(tMax) : tMax;
			rawTotalMin	+= tMin;
			rawTotalMax	+= tMax;
			if (bUsePointNorm)
				console.log(aAx[0] + " point range " + fScalePoint(tMin) + " ~ " + fScalePoint(tMax));
			else
				console.log(aAx[0] + " point range " + tMin + " ~ " + tMax);
		} else {
			totalMin	+= bUsePointNorm ? fScalePoint(aAx[3]) : aAx[3];
			totalMax	+= bUsePointNorm ? fScalePoint(aAx[4]) : aAx[4];
			rawTotalMin	+= aAx[3];
			rawTotalMax	+= aAx[4];
		}
		totalPoint	+= points[i];
	}
	var fScaleTotal = d3.scale.linear()
		.domain([bUsePointNorm ? 0 : totalMin, totalMax])
		.range([textMax, width-margin[1]]);
	
	//
	// Bottom-side fixed axis
	//

	// Add total point axis
	if (B_showTotalPoint) this.axesGroup.append("svg:g")
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
	console.log("Total point max " + totalPoint);
	var fScalePred = d3.scale.logit()
		.domain([-5, totalMax])
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
		.domain([bUsePointNorm ? 0 : totalMin, totalMax])
		.range([textMax, fScaleTotal(totalMax)]);
		
	if (B_showTotalPoint) for (var i=1 ; i<points.length ; i++) {
		var curLine = this.axesGroup.append("svg:line")
			.attr("x1", function(d) {
				var width = calcTotalScale(bUsePointNorm ? 0 : points[1]);
			  
				for (var j=1 ; j<i ; j++) {
					width += calcTotalScale(fScalePoint(points[j]))-(textMax);
				}
				return width;
			})
			.attr("x2", function(d) {
				var width = calcTotalScale(bUsePointNorm ? 0 : points[1]);
			  
				for (var j=1 ; j<i ; j++) {
					width += calcTotalScale(fScalePoint(points[j]))-(textMax);
				}
				return width;
			})
			.attr("y1", axisHeight*(nObs+1.5))
			.attr("y2", axisHeight*(nObs+1.5))
			.attr("style", "stroke:"+colors[i]+";stroke-width:5");
		if (anim == true)
			curLine.transition().delay(dur * i)
				.duration(dur)
				.attr("x2", function(d) {
					var width = calcTotalScale(bUsePointNorm ? 0 : points[1]);
				  
					for (var j=1 ; j<=i ; j++) {
						width += calcTotalScale(fScalePoint(points[j]))-(textMax);
					}
					return width;
				});
		else curLine.attr("x2", function(d) {
				var width = calcTotalScale(bUsePointNorm ? 0 : points[1]);
			  
				for (var j=1 ; j<=i ; j++) {
					width += calcTotalScale(fScalePoint(points[j]))-(textMax);
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
function prob(n, acc, conv) {
	var pred = n[0];
	for (var i=1 ; i<n.length ; i++) {
	  var a = acc[i-1];
	  var val = $(a).val();
	  if (!val.length) return a+" is empty!";
	  if (typeof eval("conv[\""+a+"\"]") != 'undefined') {
		val = Number(val);
		eval("val = conv[\""+a+"\"](Number(val))");
	  }
	  if (n[i][4] === undefined)
		pred += n[i][3][val];
	  else
		pred += val * n[i][1];
	}
//	console.log("Prob " + pred);
	return 1/(1+Math.exp(-pred));
}
function calc() {
	var maliv = [ "#age", "input[id=sex]:checked", "#mainduct", "#cystsize", "input[id=muralnodule]:checked", "input[id=location]:checked" ];
	var malix = [
		-4.282007,
		[ "Age", 0.017752, [20,100], 0.017752*20, 0.017752*100, null ],
		[ "Gender", ["Male", "Female"], null, {"Male":0, "Female":0.198873} ],
		[ "Main duct size", 0.212188, [0,20], 0.212188*0, 0.212188*20, null ],
		[ "Cyst size", 0.019172, [0,100], 0.019172*0, 0.019172*100, null ],
		[ "Mural nodule", ["No", "Yes"], null, {"No":0, "Yes":0.869144} ],
		[ "Location", ["Body/Tail", "Head", "Diffuse"], null, {"Body/Tail":-0.307606, "Head":0, "Diffuse":0.430588} ],
	];

	var maliprob = prob(malix, maliv, {});

	if (maliprob !== Number(maliprob))
		$("#comment").val(maliprob);
	else {
		$("#maliprob").val(Math.round(maliprob*10000)/100);
	}

	// Extract values
	var obs1 = [];
	for (var i=0 ; i<maliv.length ; i++)
		obs1.push( $(maliv[i]).val() );
	d3nomogram("#malinomo", obs1, malix, Math.log(maliprob/(1-maliprob)), 450);	
}
$(function() {
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
<h1>Pancreatic cancer IPMN malignancy calculator</h1>
<div class='main'>
	<fieldset>
	<legend>Observed values</legend>
	<table>
		<tr>
			<td class='ZU'>Age</td>
			<td>
				<input type='text' id='age' /> year, range: 20~100<br />
			</td>
		</tr>
		<tr>
			<td class='ZU'>Sex</td>
			<td>
				<input type='radio' id='sex' name='sex' value='Female' checked /> Female
				<input type='radio' id='sex' name='sex' value='Male' /> Male
				<br />
			</td>
		</tr>
		<tr>
			<td class='ZU'>Main duct size</td>
			<td>
				<input type='text' id='mainduct' /> mm, range: 0~20<br />
			</td>
		</tr>
		<tr>
			<td class='ZU'>Cyst size</td>
			<td>
				<input type='text' id='cystsize' /> mm, range: 0~100<br />
			</td>
		</tr>
		<tr>
			<td class='ZU'>Mural nodule</td>
			<td>
				<input type='radio' id='muralnodule' name='muralnodule' value='No' checked /> No
				<input type='radio' id='muralnodule' name='muralnodule' value='Yes' /> Yes
				<br />
			</td>
		</tr>
		<tr>
			<td class='ZU'>Location</td>
			<td>
				<input type='radio' id='location' name='location' value='Body/Tail' checked /> Body/Tail
				<input type='radio' id='location' name='location' value='Head' /> Head
				<input type='radio' id='location' name='location' value='Diffuse' /> Diffuse
				<br />
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
		<br />
		<br /><br />
		<div id="malinomo"></div>
		<button onclick="downvis('malinomo', 'tif')">TIFF</button>
		<button onclick="downvis('malinomo', 'png')">PNG</button>
		<!--<button onclick="downvis('malinomo', 'svg')">SVG</button>-->
	</fieldset>
	</div>
	<div id="my"></div>
	<div class='ZY'>
	<br />
	Created by Sungyoung Lee, Center for Precision Medicine, Seoul National University Hospital<br />
	Version 0.1.0 as of Oct 8, 2019.<br />
	Contact: tspark@stats.snu.ac.kr
	</div>
</div>

</body>
</html>