<?php
$visWidth = 650;
$visHeight = 620;
$css = ".ZX {
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

.ZU { font-weight:bold; }
.main { width:980px; }
.res1 { width:480px; float:left; }
.res2 { width:480px; float:right; }
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
var U=["undefined",Math.max];
function ZR(t,a,e,r,n,o,i,s,l){
	U[0]==typeof n&&(n=480),U[0]==typeof o&&(o=500),U[0]==typeof dur&&(dur=300),U[0]==typeof i&&(i=[20,20,30,40]),U[0]==typeof s&&(s=!0);
	var d=["#1f77b4","#ff7f0e","#2ca02c","#d62728","#9467bd","#8c564b","#e377c2","#7f7f7f","#bcbd22","#17becf","opacity","class","transform","style","translate","stroke","svg:text"],h=0,u=999999999,g=-99999999,c=0,p=0,f=0,v=new Array,x=1,m=2,y=x+m,A=a.length,D=(o-i[0]-i[2])/(A+y);
	for(var B in e)u=Math.min(u,e[B][3]),g=U[1](g,e[B][4]);
	d3.select(t).html(""),this.svg=d3.select(t).append("svg").attr("width",n).attr("height",o),this.dataGroup=this.svg.append("svg:g"),this.YC=this.dataGroup.append(d[16]).text("Point").attr(d[11],"ZX"),this.YD=this.dataGroup.selectAll("#axes").data(e).enter().append(d[16]).text(function(t,a){return t[0]}).attr(d[11],"ZX").attr(d[10],0).attr("fill",function(t,a){return d[a]}).each(function(t){h=U[1](h,this.getBBox().width)}),1==s?this.YD.transition().delay(function(t,a){return dur*a}).duration(dur).attr(d[10],1):this.YD.attr(d[10],1),this.YQ=this.dataGroup.append(d[16]).text("Total Point").attr(d[11],"ZX"),this.YB=this.dataGroup.append(d[16]).text("Prediction").attr(d[11],"ZX");
	var h=U[1](this.YB.node().getBBox().width,U[1](this.YB.node().getBBox().width,U[1](this.YC.node().getBBox().width,h)))+i[3];
	this.YC.attr(d[12],function(t,a){return d[14]+"("+(h-20)+","+.5*D+")"}),this.YD.attr(d[12],function(t,a){return d[14]+"("+(h-20)+","+D*(a+1.5)+")"}),this.YQ.attr(d[12],function(t,a){return d[14]+"("+(h-20)+","+D*(A+1.5)+")"}),this.YB.attr(d[12],function(t,a){return d[14]+"("+(h-20)+","+D*(A+2.5)+")"}),this.YA=this.svg.append("svg:g");
	var M=d3.scale.linear().domain([u,g]).range([h,n-i[1]]);
	this.YA.append("svg:g").attr(d[15],"#222").attr(d[11],"axis").call(d3.svg.axis().scale(M).orient("bottom")).attr(d[12],d[14]+"(0,"+.5*D+")");
	for(var B in e){var w=e[B],b=null,T=null;
	B=parseInt(B);
	var k=6==w.length?Math.round(1e3*w[5](a[B]))/1e3:a[B];
	null==w[2]&&w[1].length?(b=d3.scale.ordinal().domain(w[1]).rangePoints([M(w[3]),M(w[4])]),T=d3.scale.ordinal().domain(w[1]).rangePoints([w[3],w[4]])):(b=d3.scale.linear().domain([w[1],w[2]]).range([M(w[3]),M(w[4])]),T=d3.scale.linear().domain([w[1],w[2]]).range([w[3],w[4]]));
	var G=D*(B+1.5),$=b(k);U[0]==typeof $&&($=b(b.domain()[k]));
	var P=(b.range()[1]-b.range()[0])/40;
	2>P&&(P=2),this.YA.append("svg:circle").attr("r",2).attr(d[12],d[14]+"("+$+","+.5*D+")");
	var C=this.YA.append("svg:g").attr(d[12],function(t){return d[14]+"(0,"+G+")"}).attr(d[11],"axis").attr(d[15],d[B]).attr(d[10],0).call(d3.svg.axis().scale(b).orient("bottom").ticks(P)),z=this.YA.append("svg:circle").attr("r",3).attr(d[10],0).attr(d[12],d[14]+"("+$+","+G+")"),N=this.YA.append("svg:line").attr("x1",$).attr("x2",$).attr("y1",.5*D).attr("y2",G).attr(d[10],0).attr(d[13],d[15]+":rgb(255,0,0);stroke-width:0.5").style(d[15]+"-dasharray","5, 5"),R=null;
	if(R=null==w[2]&&w[1].length?this.YA.append("svg:line").attr("x1",b(w[1][0])).attr("x2",b(w[1][0])).attr("y1",G).attr("y2",G).attr(d[13],d[15]+":"+d[B]+";stroke-width:5"):this.YA.append("svg:line").attr("x1",b(w[1])).attr("x2",b(w[1])).attr("y1",G).attr("y2",G).attr(d[13],d[15]+":"+d[B]+";stroke-width:5"),1==s?(C.transition().delay(dur*B).duration(dur).attr(d[10],1),z.transition().delay(dur*B).duration(dur).attr(d[10],1),N.transition().delay(dur*B).duration(dur).attr(d[10],1),R.transition().delay(dur*B).duration(dur).attr("x2",$)):(C.attr(d[10],1),z.attr(d[10],1),N.attr(d[10],1),R.attr(d[10],1)),null!=w[2]){this.YA.append(d[16]).text(function(t){return k}).attr(d[11],"obsText").attr("fill",function(t){return d[B]}).attr(d[12],d[14]+"("+($+3)+","+(G-3)+")")}v[B]=T(k),U[0]==typeof v[B]&&(v[B]=T(b.domain()[k])),c+=w[3],p+=w[4],f+=v[B]}var V=d3.scale.linear().domain([0,p]).range([h,n-i[1]]);
	this.YA.append("svg:g").attr(d[12],function(t){return d[14]+"(0,"+D*(A+1.5)+")"}).attr(d[11],"axis").attr(d[15],"#222").call(d3.svg.axis().scale(V).orient("bottom"));
	var S=d3.scale.logit().domain([-5,f]).range([h,n-i[1]]);this.YA.append("svg:g").attr(d[12],function(t){return d[14]+"(0,"+D*(A+2.5)+")"}).attr(d[11],"axis").attr(d[15],"#222").call(d3.svg.axis().scale(S).orient("bottom"));var E=d3.scale.linear().domain([0,f]).range([h,V(f)]);for(var B in v){var I=this.YA.append("svg:line").attr("x1",function(t){if(0==B)return h;for(var a=E(v[0]),e=1;B>e;e++)a+=E(v[e])-h;return a}).attr("x2",function(t){if(0==B)return h;for(var a=E(v[0]),e=1;B>e;e++)a+=E(v[e])-h;return a}).attr("y1",D*(A+1.5)).attr("y2",D*(A+1.5)).attr(d[13],d[15]+":"+d[B]+";stroke-width:5");1==s?I.transition().delay(dur*B).duration(dur).attr("x2",function(t){for(var a=E(v[0]),e=1;B>=e;e++)a+=E(v[e])-h;return a}):I.attr("x2",function(t){for(var a=E(v[0]),e=1;B>=e;e++)a+=E(v[e])-h;return a})}this.YA.append("svg:circle").attr(d[12],d[14]+"("+S(r)+","+D*(A+2.5)+")").attr("r",3),this.YA.append("svg:line").attr("x1",h).attr("x2",S(r)).attr("y1",D*(A+2.5)).attr("y2",D*(A+2.5)).attr(d[13],d[15]+":red;stroke-width:5;")}function prob(n,coef,conv){for(var pred=coef[0],i=0;i<n.length;i++){var val=$(n[i]).val();if(!val.length)return n[i]+" is empty!";U[0]!=typeof eval('conv["'+n[i]+'"]')&&(val=Number(val),eval('val = conv["'+n[i]+'"](Number(val))')),pred+=val*coef[i+1]}return 1/(1+Math.exp(-pred))}function ZT(){var t=["#ageval",":radio[name='sex']:checked","#logcea","#logca199","#mainduct","#cystsize",":radio[name='muralnodule']:checked"],a=[-5.964893,.01094,.259659,.31324,.451022,.156631,.01518,.999965],e=[["Age",20,90,20*a[1],90*a[1]],["Sex",["None","Male","Female"],null,0*a[2],2*a[2]],["log(CEA)",0,Math.log(200),0*a[3],a[3]*Math.log(200),Math.log],["log(CA19-9)",0,Math.log(5e3),0*a[4],a[4]*Math.log(5e3),Math.log],["Main duct size",0,20,0*a[5],20*a[5]],["Cyst size",0,200,0*a[6],200*a[6]],["Mural nodule",["No","Yes"],null,0*a[7],1*a[7]]],r=["#ageval","#logcea","#logca199","#mainduct","#cystsize",":radio[name='muralnodule']:checked"],n=[-4.562976,.018464,.24484,.222167,.185497,.017445,1.194933],o=[["Age",20,90,20*n[1],90*n[1]],["log(CEA)",0,Math.log(200),0*n[2],n[2]*Math.log(200),Math.log],["log(CA19-9)",0,Math.log(5e3),0*n[3],n[3]*Math.log(5e3),Math.log],["Main duct size",0,20,0*n[4],20*n[4]],["Cyst size",0,200,0*n[5],200*n[5]],["Mural nodule",["No","Yes"],null,0*n[6],1*n[6]]],i=prob(t,a,{"#logcea":Math.log,"#logca199":Math.log}),s=prob(r,n,{"#logcea":Math.log,"#logca199":Math.log});i!==Number(i)||s!==Number(s)?$("#comment").val(i):($("#invaprob").val(Math.round(1e4*i)/100),$("#maliprob").val(Math.round(1e4*s)/100));for(var l=0;l<t.length;l++)if(!$(t[l]).val()){alert("Empty value found!");return;}for(var l=[],d=1;d<a.length;d++)l.push($(t[d-1]).val());ZR("#invanomo",l,e,Math.log(i/(1-i)),440),l=[];for(var d=1;d<n.length;d++)l.push($(r[d-1]).val());ZR("#malinomo",l,o,Math.log(s/(1-s)),440)}function downvis(t,a){var e=$("#"+t+" > svg"),r=e.width(),n=e.height(),o=new XMLSerializer,i="";if(0==e.length)return U[0]!=typeof d&&d.dialog("close"),void $("#error-modal").dialog({modal:!0});for(var s=0;s<e.length;s++)i+=o.serializeToString(e[s]);var l="width="+r+"&height="+n+"&svg="+encodeURIComponent('<\?xml version="1.0" encoding="UTF-8"?><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="'+r+'" height="'+n+'"><defs><style type="text/css"><![CDATA[\n')+".ZX+%7B%0D%0A%09font-weight%3Abold%3B%0D%0A%09text-anchor%3Aend%3B%0D%0A%09font-size%3A11pt%3B%0D%0A%7D%0D%0A%0D%0A.axis+text+%7B%0D%0A++font%3A+11px+sans-serif%3B%0D%0A++stroke-width%3A+0%3B%0D%0A%7D%0D%0A.axisValue+%7B%0D%0A%09stroke-width%3A3%3B%0D%0A%7D%0D%0A%0D%0A.axis+line%2C%0D%0A.axis+path+%7B%0D%0A++fill%3A+none%3B%0D%0A++shape-rendering%3A+crispEdges%3B%0D%0A%7D%0D%0A%0D%0A.ZU+%7B+font-weight%3Abold%3B+%7D%0D%0A.main+%7B+width%3A980px%3B+%7D%0D%0A.res1+%7B+width%3A480px%3B+float%3Aleft%3B+%7D%0D%0A.res2+%7B+width%3A480px%3B+float%3Aright%3B+%7D%0D%0A.ZY+%7B+text-align%3Acenter%3B+font-size%3A90%25%3B+clear%3Aboth%3B+%7D%0D%0Alegend+%7B+font-size%3A120%25%3B+font-weight%3Abold%3B+%7D%0D%0A"+encodeURIComponent("]]></style></defs>"+i+"</svg>")+"&format="+a,d=$("#preparing-file-modal");return d.dialog({modal:!0}),$.fileDownload("../pathome/convert.php",{successCallback:function(t){d.dialog("close")},failCallback:function(t,a){d.dialog("close"),$("#error-modal").dialog({modal:!0})},httpMethod:"POST",data:l}),!1}$(function(){$("#age").slider({min:30,max:100,value:50,slide:function(t,a){$("#ageval").val(a.value)}}),$("#ageval").val($("#age").slider("value")).change(function(){$("#age").slider("value",$(this).val())}),$("button").button()});
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
		<td class='ZU'>Age</td>
		<td>
			<div style='float:left;width:200px;'>
			<div id='age'></div>
			</div>
			<div style='float:left;margin-left:20px;'><input type='text' id='ageval' name='ageval' size='3' /></div>
		</td>
		</tr>
		<tr>
		<td class='ZU'>Sex</td>
		<td>
			<input type='radio' id='sex' name='sex' value='1' checked /> Male
			<input type='radio' id='sex' name='sex' value='2' /> Female<br />
		</td>
		</tr>
		<tr>
		<td class='ZU'>CEA value</td>
		<td>
			<input type='text' id='logcea' /> Raw value, range: 1~200<br />
		</td>
		</tr>
		<tr>
		<td class='ZU'>CA19-9 value</td>
		<td>
			<input type='text' id='logca199' /> Raw value, range: 1~5000<br />
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
			<input type='text' id='cystsize' /> mm, range: 0~200<br />
		</td>
		</tr>
		<tr>
		<td class='ZU'>Mural nodule</td>
		<td> 
			<input type='radio' id='muralnodule' name='muralnodule' value='0' checked /> No
			<input type='radio' id='muralnodule' name='muralnodule' value='1' /> Yes<br />
		</td>
		</tr>
		<tr height='50'>
		<td colspan='2'>
			<input type='button' value='   Calculate   ' onclick="ZT()" />
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
	<div class='ZY'>
	<br />
	Created by Sungyoung Lee, BIBS Labratory, Seoul National University<br />
	Version 0.3.0 by December 11, 2015.<br />
	Contact: tspark@stats.snu.ac.kr
	</div>
</div>

</body>
</html>