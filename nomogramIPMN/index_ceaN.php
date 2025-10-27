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
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('k 2E(M,b){6 T=M[0];6 28=T.2w(k(v){l v.3r()});6 o=28.2v(k(v){l v.b>0});6 14=T.2w(k(v,i){l i}).2v(k(i){l 28[i].b>0});c(o[1].1f>o[0].1f)C(6 i=1;i<o.t;i++){c(o[i].1f<o[i-1].2t){6 2A=o[i-1].1f+o[i-1].b/2;6 2y=o[i].1f+o[i].b/2;T[14[i]].1H("x",T[14[i]].1I("x")+o[i].b/2);T[14[i-1]].1H("x",T[14[i-1]].1I("x")-o[i-1].b/2)}}N C(6 i=o.t-2;i>=0;i--){c(o[i+1].2t>o[i].1f){6 2A=o[i].1f+o[i].b/2;6 2y=o[i+1].1f+o[i+1].b/2;T[14[i+1]].1H("x",T[14[i+1]].1I("x")-o[i+1].b/2);T[14[i]].1H("x",T[14[i]].1I("x")+o[i].b/2)}}}k 2T(19,1P,q,1k,b,Y,W,1o,1j){c(S b=="K")b=2W;c(S Y=="K")Y=3l;c(S L=="K")L=3q;c(S W=="K")W=[20,30,30,40];c(S 1o=="K")1o=Z;6 1i=["#3O","#4n","#4x","#3u","#3v","#3w","#3x","#3y","#3z","#3A","3b","3B",];6 E=Z;6 y=0;6 1c=2J;6 1d=-2J;6 1z=E?0:q[0];6 1g=E?0:q[0];6 2n=q[0];6 1T=q[0];6 2m=q[0];6 u=[q[0]];6 2I=1;6 2x=2;6 2u=2I+2x;6 V=1P.t;6 z=(Y-W[0]-W[2])/(V+2u);C(6 i 1W q){c(i=="0")3G;c(S q[i][3]==\'2s\'){C(6 j 1W q[i][3])c(q[i][3].2L(j)){1d=D.10(1d,q[i][3][j]);1c=D.2D(1c,q[i][3][j])}}N{1d=D.10(1d,q[i][4]);1c=D.2D(1c,q[i][3])}}1J.1C("1X F ",1c," ~ ",1d);A.2H(19).3H("");e.f=A.2H(19).p("f").7("b",b).7("Y",Y);e.1y=e.f.p("f:g");e.1O=e.1y.p("f:M").M("1X").7("X","1S");e.1M=e.1y.2F("#q").3a(q).3J().p("f:M").M(k(d,i){l d[0]}).7("X","1S").7("O",0).7("2q",k(d,i){l 1i[i]}).3K(k(d){y=D.10(y,e.1s().b)});c(1o==Z)e.1M.1q().1t(k(d,i){l L*i}).1j(L).7("O",1);N e.1M.7("O",1);6 1p=Z;c(1p)e.2c=e.1y.p("f:M").M("2B 1X").7("X","1S 2G");e.1N=e.1y.p("f:M").M("3L").7("X","1S 2G");c(1p)y=D.10(e.1N.1w().1s().b,D.10(e.2c.1w().1s().b,D.10(e.1O.1w().1s().b,y)))+W[3];N y=D.10(e.1N.1w().1s().b,D.10(e.1O.1w().1s().b,y))+W[3];e.1O.7("U",k(d,i){l"R(0,"+(z*0.5)+")"});e.1M.7("U",k(d,i){l"R(0,"+z*(i+0.5)+")"});c(1p)e.2c.7("U",k(d,i){l"R(0,"+z*(V+1.5)+")"});e.1N.7("U",k(d,i){l"R(0,"+z*(V+2.5)+")"});e.G=e.f.p("f:g");6 m=I;6 P=I;c(E){m=A.J.1h().Q([1c,1d]).F([0,13]);P=A.J.1h().Q([0,13]).F([y,b-W[1]])}N m=A.J.1h().Q([1c,1d]).F([y,b-W[1]]);e.G.p("f:g").7("B","#2j").7("X","17").1G(A.f.17().J(P?P:m).1E("1F")).7("U","R(0,"+(z*0.5)+")");C(6 i=1;i<q.t;i++){6 9=q[i];6 H=I;6 1v=I;6 2p=3f(1P[i-1]);6 s=S 9[5]==\'k\'?D.2i(9[5](2p)*2o)/2o:1P[i-1];c(9[2]==I&&9[1].t){6 27=[],24=[];6 26=2M;C(6 j=0;j<9[1].t;j++){27.2h(P?P(m(9[3][9[1][j]])):m(9[3][9[1][j]]));24.2h(9[3][9[1][j]])}H=A.J.2z().Q(26?[""].2C(9[1]):9[1]).F(27);1v=A.J.2z().Q(26?[""].2C(9[1]):9[1]).F(24)}N{H=A.J.1h().Q(9[2].t!==K?9[2]:[0,9[2]]).F(P?[P(m(9[3])),P(m(9[4]))]:[m(9[3]),m(9[4])]);1v=A.J.1h().Q(9[2].t!==K?9[2]:[9[1],9[2]]).F([9[3],9[4]])}6 11=z*(i+0.5);6 12=H(s);c(S 12=="K")12=H(H.Q()[s]);6 1R=(H.F()[1]-H.F()[0])/40;c(1R<2)1R=2;e.G.p("f:2f").7("r",2).7("U","R("+12+","+(z*0.5)+")");6 1L=e.G.p("f:g").7("U",k(d){l"R(0,"+11+")"}).7("X","17").7("B",1i[i]).7("O",0).1G(A.f.17().J(H).1E("1F").3P(1R));2E(1L.2F(".4h M"));6 1Z=e.G.p("f:2f").7("r",3).7("O",0).7("U","R("+12+","+11+")");6 1Y=e.G.p("f:1u").7("1x",12).7("1e",12).7("1D",z*0.5).7("1A",11).7("O",0).7("16","B:4i(4j,0,0);B-b:0.5").16("B-4k",("5, 5"));6 1B=I;c(9[2]==I&&9[1].t){1B=e.G.p("f:1u").7("1x",P?H(P(0)):m(0)).7("1e",P?H(P(0)):m(0)).7("1D",11).7("1A",11).7("16","B:"+1i[i]+";B-b:5")}N{1B=e.G.p("f:1u").7("X","4l").7("1x",H(9[2].t!==K?0:9[1])).7("1e",H(9[2].t!==K?0:9[1])).7("1D",11).7("1A",11).7("16","B:"+1i[i]+";B-b:5")}c(1o==Z){1L.1q().1t(L*i).1j(L).7("O",1);1Z.1q().1t(L*i).1j(L).7("O",1);1Y.1q().1t(L*i).1j(L).7("O",1);1B.1q().1t(L*i).1j(L).7("1e",12)}N{1L.7("O",1);1Z.7("O",1);1Y.7("O",1);1B.7("O",1)}c(9[2]!=I){6 2K=e.G.p("f:M").M(k(d){l D.2i(s*13)/13}).7("X","2K").7("2q",k(d){l 1i[i]}).7("U","R("+(12+3)+","+(11-3)+")")}u[i]=1v(s);c(S u[i]=="K")u[i]=1v(H.Q()[s]);N c(u[i]!=u[i])u[i]=0;c(S 9[3]==\'2s\'){6 1a=2r;6 1b=-2r;C(6 j 1W 9[3])c(9[3].2L(j)){6 v=9[3][j];c(1a>v)1a=v;c(1b<v)1b=v}1z+=E?m(1a):1a;1g+=E?m(1b):1b;2n+=1a;1T+=1b;c(E)1J.1C(9[0]+" 2e F "+m(1a)+" ~ "+m(1b));N 1J.1C(9[0]+" 2e F "+1a+" ~ "+1b)}N{1z+=E?m(9[3]):9[3];1g+=E?m(9[4]):9[4];2n+=9[3];1T+=9[4]}2m+=u[i]}6 1V=A.J.1h().Q([E?0:1z,1g]).F([y,b-W[1]]);c(1p)e.G.p("f:g").7("U",k(d){l"R(0,"+z*(V+1.5)+")"}).7("X","17").7("B","#2j").1G(A.f.17().J(1V).1E("1F"));1J.1C("2B 2e 10 "+2m);6 1K=A.J.4d().Q([-5,1g]).F([y,b-W[1]]);e.G.p("f:g").7("U",k(d){l"R(0,"+z*(V+2.5)+")"}).7("X","17").7("B","#2j").1G(A.f.17().J(1K).1E("1F"));6 15=A.J.1h().Q([E?0:1z,1g]).F([y,1V(1g)]);c(1p)C(6 i=1;i<u.t;i++){6 21=e.G.p("f:1u").7("1x",k(d){6 b=15(E?0:u[1]);C(6 j=1;j<i;j++){b+=15(m(u[j]))-(y)}l b}).7("1e",k(d){6 b=15(E?0:u[1]);C(6 j=1;j<i;j++){b+=15(m(u[j]))-(y)}l b}).7("1D",z*(V+1.5)).7("1A",z*(V+1.5)).7("16","B:"+1i[i]+";B-b:5");c(1o==Z)21.1q().1t(L*i).1j(L).7("1e",k(d){6 b=15(E?0:u[1]);C(6 j=1;j<=i;j++){b+=15(m(u[j]))-(y)}l b});N 21.7("1e",k(d){6 b=15(E?0:u[1]);C(6 j=1;j<=i;j++){b+=15(m(u[j]))-(y)}l b})}e.G.p("f:2f").7("U","R("+1K(1k)+","+z*(V+2.5)+")").7("r",3);e.G.p("f:1u").7("1x",y).7("1e",1K(1k)).7("1D",z*(V+2.5)).7("1A",z*(V+2.5)).7("16","B:3b;B-b:5;")}k 32(n,38,22){6 1k=n[0];C(6 i=1;i<n.t;i++){6 a=38[i-1];6 s=$(a).s();c(!s.t)l a+" 4b 4a!";c(S 35("22[\\""+a+"\\"]")!=\'K\'){s=2b(s);35("s = 22[\\""+a+"\\"](2b(s))")}c(n[i][4]===K)1k+=n[i][3][s];N 1k+=s*n[i][1]}l 1/(1+D.48(-1k))}k 47(){6 1Q=["#46","23[19=45]:2k","#44","#42","23[19=3S]:2k","23[19=41]:2k"];6 1U=[-3.3Z,["3Y",0.2g,[20,13],0.2g*20,0.2g*13,I],["3X",["2Q","3d"],I,{"2Q":-.3W,"3d":0}],["3V 3T 2O",0.2l,[0,20],0.2l*0,0.2l*20,I],["4e 2O",0.2d,[0,13],0.2d*0,0.2d*13,I],["4g 4w",["37","39"],I,{"37":0,"39":.4v}],["4u",["2V/36","2Z","2Y"],I,{"2V/36":-0.4t,"2Z":0,"2Y":0.4s}],];6 18=32(1U,1Q,{});c(18!==2b(18))$("#4r").s(18);N{$("#18").s(D.2i(18*4q)/13)}6 29=[];C(6 i=0;i<1Q.t;i++)29.2h($(1Q[i]).s());2T("#4p",29,1U,D.1C(18/(1-18)),2W)}$(k(){$("2X").2X()});k 4o(19,2S){6 1l=$(\'#\'+19+" > f");6 w=1l.b();6 h=1l.Y();6 33=3Q 4m();6 2a=\'\';c(1l.t==0){c(S $1r!=\'K\')$1r.1n(\'25\');$(\'#34-1m\').1n({1m:Z});l}C(6 i=0;i<1l.t;i++)2a+=33.4f(1l[i]);6 3c="b="+w+"&Y="+h+"&f="+2R("<"+"?3M 31=\\"1.0\\" 3o=\\"3n-8\\"?><f 31=\\"1.1\\" 3k=\\"3j://3i.3h.3g/3e/f\\" b=\\""+w+"\\" Y=\\""+h+"\\"><2P><16 3s=\\"M/2N\\"><![3E[\\n")+"<'+'?=3N($2N)?>"+2R("]]></16></2P>"+2a+"</f>")+"&3I="+2S;6 $1r=$("#3F-3D-1m");$1r.1n({1m:Z});$.3t(\'../3C/3m.3p\',{3R:k(2U){$1r.1n(\'25\')},43:k(3U,2U){$1r.1n(\'25\');$(\'#34-1m\').1n({1m:Z})},49:\'4c\',3a:3c});l 2M}',62,282,'||||||var|attr||aAx||width|if||this|svg|||||function|return|fScalePoint||rects|append|axes||val|length|points||||textMax|axisHeight|d3|stroke|for|Math|bUsePointNorm|range|axesGroup|fScaleAxis|null|scale|undefined|dur|text|else|opacity|fScalePointNorm|domain|translate|typeof||transform|nObs|margin|class|height|true|max|posY|posObs|100|ridxs|calcTotalScale|style|axis|maliprob|id|tMin|tMax|pointMin|pointMax|x2|left|totalMax|linear|colors|duration|pred|svgelem|modal|dialog|anim|B_showTotalPoint|transition|preparingFileModal|getBBox|delay|line|fScaleCalcPt|node|x1|dataGroup|totalMin|y2|hLineValue|log|y1|orient|bottom|call|setAttribute|getAttribute|console|fScalePred|hAxis|hTextVar|hTextPred|hTextPoint|obs|maliv|nTick|hmRowText|rawTotalMax|malix|fScaleTotal|in|Point|hLineConnect|hCircle||curLine|conv|input|tm2|close|adj|tm|aBCRrect|obs1|str|Number|hTextTotalPt|018977|point|circle|017509|push|round|222|checked|201230|totalPoint|rawTotalMin|1000|obsi|fill|99999999|object|right|nFixedAxis|filter|map|nFixedAxisB|c2|ordinal|c1|Total|concat|min|wrap|selectAll|hmBoldText|select|nFixedAxisT|999999|obsText|hasOwnProperty|false|css|size|defs|Male|encodeURIComponent|fmt|d3nomogram|url|Body|900|button|Diffuse|Head||version|prob|serializer|error|eval|Tail|No|acc|Yes|data|red|S_svg|Female|2000|parseFloat|org|w3|www|http|xmlns|500|convert|UTF|encoding|php|300|getBoundingClientRect|type|fileDownload|d62728|9467bd|8c564b|e377c2|7f7f7f|bcbd22|17becf|blue|pathome|file|CDATA|preparing|continue|html|format|enter|each|Prediction|xml|urlencode|1f77b4|ticks|new|successCallback|muralnodule|duct|responseHtml|Main|199866|Gender|Age|266789||location|cystsize|failCallback|mainduct|sex|age|calc|exp|httpMethod|empty|is|POST|logit|Cyst|serializeToString|Mural|tick|rgb|255|dasharray|lineValue|XMLSerializer|ff7f0e|downvis|malinomo|10000|comment|376753|328433|Location|857989|nodule|2ca02c'.split('|'),0,{}))
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