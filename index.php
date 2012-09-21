<?php
include_once('data.php');


function make_table($id, $rows, $columns, $value_src = null){
  $table = null;
  $cell_count = 0;
  for($i = 1; $i<=$rows; $i++){
    $table .= '<tr>';
      for($j = 1; $j<=$columns; $j++){
        $table .= "<td " . ($value_src ? $value_src . "='$cell_count'" : "") . " >"
        . (!$value_src ? $cell_count : "")
        . "</td>";
        $cell_count++;
      }
    $table .= '</tr>';
  }

  return sprintf("<table id='$id'>%s</table>", $table);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Colorful.js: Demonstrations</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/css/bootstrap.no-icons.min.css" rel="stylesheet">
    <link href="prettify.css" type="text/css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500' rel='stylesheet' type='text/css'>
    <style>
      body {
        padding-top: 30px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <!-- <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png"> -->
    

    <style type="text/css">
      #table0 td {
        color: #666;
      }
      table, #div {
        width:100%;
      }
      table tr td {
        width:40px;
        height:40px;

        text-align:center;
        color:white;
        font-family:sans-serif;
        font-size:12px;
      }
      #table2 {
        font-size:15px;
        font-weight:bold;
      }
      .demo-div div{
        width:10%;
        height:25px;
        text-indent:-10000px;
        float:left;
      }
      .pattern-background {
        background:url(img/back_pattern.png) repeat;
        padding:10px;
        box-sizing:border-box;
      }
      #intro {
        font-family: 'Ubuntu', sans-serif;
        box-shadow: inset 0 0 40px 0 rgba(0,0,0,0.6);
        color: #FFF;
        border-radius:15px;
        -webkit-border-radius:15px;

        transition: background 1s;
      }
      pre.prettyprint {
        padding: 10px;
        border: none;
        box-shadow: inset 0 0 10px 0 rgba(0,0,0,0.1);
      }
      #mri {
        background: url(mri_rmommaerts.jpg) no-repeat;
        width:395px;
        height:500px;
      }

      #mri tr td {
        height:7px;
        width:7px;
      }

      #bball .column {
        float:left;
      }

      #bball .heading, #bball .datum {
        height:15px;
        display:block;
        padding:12px 20px;
      }
      #bball .datum {
        text-align: center;
        background: #991C1C;
        /*-webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;    
        box-sizing: border-box;*/        
      }
      #bball .nat-champs {
        border: 2px solid white;
        padding:10px 18px;
      }
      #bball div.colorful-el {
        color: #fff;
        font-weight:bold;
      }
      .bad {
        background-image: url(img/bad.png);
      }
      .nat-champs-message {
        text-align: center;
        margin-top: 10px;
      }
      h2 {
        margin:20px 0;
      }
      #table6 td, #min-max td {
        border: 2px solid whiteSmoke;
        border-radius:3px;
        box-shadow: inset 0 0 10px 0 rgba(0,0,0,0.15);
        color:rgba(255,255,255,0.5);
        /*text-indent:-10000px;*/
      }
      #min-max td {
        border-color: #FFF;
      }
      .colorful {
        font-family: 'Ubuntu', sans-serif;
      }
    /*  h2 > a.colorful:after {
        content: "";
        background:red;
        width:100%;
        height:20px;
        position:relative;
      }
      */
     h2 {
      background: #fff;
     }
     h2[title]::before {
      content: attr(title);
      background: white;
      z-index: 2;
      position: absolute;
      padding-right: 25px;
    }
    h2[title]::after {
     content: "";
     display: block;
     position: relative;
     top: -0.8em;
/*     border-bottom: 1px solid #99B3D8;
*/    }
    ul.features {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    ul.features li {
      padding-bottom:35px;
      margin-bottom:20px;
      border-bottom: 1px solid #E3E3E3;
    }

    </style>
    
  </head>

  <body data-spy="scroll" data-target=".navbar">

   <!--  <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">colorful</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Demos</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div> -->

    <div class="container">
      <div id="intro" class="hero-unit">
        <h1>Colorful.js</h1>
        <p>Makes Data Beautiful</p>
      </div>
      <div id="navbar" class="navbar subnav">
        <div class="navbar-inner">
          <div class="container">
            <a class="brand colorful" href="#">Colorful.js</a>
            <ul class="nav">
              <li><a href="#about-colorful">About</a></li>
              <li><a href="#features">Features</a></li>
              <li><a href="#demos">Demos</a></li>
              <li><a href="#download">Download</a></li>
              <li><a href="#supporters">Our Supporters</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="row" >
        <div class="span12">
          <h2 title="Download Colorful.js" class="colorful" name="download" id="download">Download Colorful.js</h2>
          <ul>
            <li>Minified: <a href="#" title="Download Colorful.min.js">Colorful.min.js</a></li>
            <li>Unminified: <a href="#" title="Download Colorful.js">Colorful.js</a></li>
            <li>GitHub: <a href="https://github.com/ltk/Heat-Chart" title="Colorful.js on GitHub">The Repo</a></li>
        </div>

        <div class="span12">
          <h2 title="Colorful.js Demos" class="colorful" name="demos" id="demos">Colorful.js Demos</h2>
          <div class="row">
            <div class="span12">
              <pre class="prettyprint">$('#college-bball').colorful({theta: 180, reverse: true});</pre>
              <div class="well">
                <h3>College Basketball in the 21st Century</h3>
                <h4>Final AP Poll Rankings by Year</h4>
              <?php echo $bball_table; ?>
              <hr/>
            </div>
            <div class="span12">
              <pre class="prettyprint">$('#web-visits').colorful({theta: 180, reverse: true});</pre>
              <div class="well">
                <h3>Website Visits by Day of Week and Time of Day</h3>
              <?php echo $web_visits_table; ?>
            </div>
              <hr/>
            </div>
          </div>
        </div>

        <div class="span12">
          <h2 title="Features" class="colorful" name="features" id="features">Features</h2>
          <ul class="features">
            <li>
              <h3>Map Data to Hue, Saturation, Lightness, and/or Alpha</h3>
              <p>Some text goes here.</p>
              <p><span class="label">Options</span> An array containing one or more of the following strings: 'h', 's', 'l', 'a' (e.g. ['h', 's'] or ['a'])</p>
              <p><span class="label label-info">Defaults</span> ['h']</p>
              <pre class="prettyprint">$('#some-element').colorful({mapDataTo:['h','a']});</pre>
              <?php echo make_table("map_data_to", 6, 10); ?>
            </li>

            <li>
              <h3>Color Only the Right Elements</h3>
              <p>Some text goes here.</p>
              <p><span class="label">Options</span> Any valid jQuery selector string.</p>
              <p><span class="label label-info">Defaults</span> "td"</p>
              <pre class="prettyprint">$('#some-element').colorful({elementSelector:".data", preventionSelector:".label"});</pre>
            </li>

            <li>
              <h3>Color What You Want</h3>
              <p>Some text goes here.</p>
              <p><span class="label">Options</span> "background", "color", "border-color"</p>
              <p><span class="label label-info">Defaults</span> "background"</p>
              <pre class="prettyprint">$('#some-element').colorful({attributeToColor: "color"});</pre>
              <?php echo make_table("text_color", 6, 10); ?>
            </li>

            <li>
              <h3>Pull Data from Content or Data Attributes</h3>
              <p>Some text goes here.</p>
              <p><span class="label">Options</span> "html" or any valid HTML attribute (e.g. "title", "data-val", etc.)</p>
              <p><span class="label label-info">Defaults</span> "html"</p>
              <pre class="prettyprint">$('#some-element').colorful({dataAttribute:"data-value"});</pre>
              <?php echo make_table("data_attr", 6, 10, 'data-value'); ?>
            </li>

            <li>
              <h3>Choose Your Scale</h3>
              <p>Some text goes here.</p>
              <p><span class="label">Options</span> "linear", "log"</p>
              <p><span class="label label-info">Defaults</span> "linear"</p>
              <pre class="prettyprint">$('#some-element').colorful({scale:"log"});</pre>
              <?php echo $scale_tables; ?>
            </li>

            <li>
              <h3>Focus on the Important Things</h3>
              <p>Don't waste precious gradient space on values you don't care about. Zero in on the important data by defining a minimum and/or a maximum value for coloring. Elements with associated values that don't qualify will be totally ignored.</p>
              <p><span class="label">Options</span> Any numerical value.</p>
              <p><span class="label label-info">Defaults</span> There is no default min/max value.</p>
              <pre class="prettyprint">$('#some-element').colorful({min_val: 0.5, max_val: 2});</pre>
              <?php echo $min_max_table; ?>
            </li>

            <li>
              <h3>Custom Classes on Colored Elements</h3>
              <p>Some text goes here.</p>
              <p><span class="label">Options</span> A string containing any valid CSS class name.</p>
              <p><span class="label label-info">Defaults</span> "js-colorful"</p>
              <pre class="prettyprint">$('#some-element').colorful({addedClass:"colorful"});</pre>
              <p>(Items on this demo page recieving the "colorful" class will have their text color slowly rotated.)</p>
              <?php echo make_table("custom_class", 6, 10); ?>
            </li>

            <li>
              <h3>Stepwise Coloring</h3>
              <p>Some text goes here.</p>
              <p><span class="label">Options</span> stepwise: boolean true or false, steps: any integer > 0</p>
              <p><span class="label label-info">Defaults</span> stepwise: false, steps: 10</p>
              <pre class="prettyprint">$('#some-element').colorful({stepwise: true, steps: 6});</pre>
              <?php echo make_table("stepwise", 6, 10); ?>
            </li>

            <li>
              <h3>Custom Defined Hues</h3>
              <p>Some text goes here.</p>
              <p><span class="label">Options</span> An array of integers between 0 and 359.</p>
              <p><span class="label label-info">Defaults</span> There is no default value for custom colors.</p>
              <pre class="prettyprint">$('#some-element').colorful({colors: [0,25,250]});</pre>
              <?php echo make_table("custom_hues", 6, 10); ?>
            </li>

            <li>
              <h3>Reversable</h3>
              <p>Some text goes here.</p>
              <p><span class="label">Options</span> boolean true or false</p>
              <p><span class="label label-info">Defaults</span> false</p>
              <pre class="prettyprint">$('#some-element').colorful({reverse: true});</pre>
              <?php echo make_table("reversable", 6, 10); ?>
            </li>

            <li>
              <h3>Choose Your Color Output</h3>
              <p>Some text goes here.</p>
              <p><span class="label">Options</span> 'hsla', 'rgb', 'grayscale'</p>
              <p><span class="label label-info">Defaults</span> 'hsla'</p>
              <pre class="prettyprint">$('#some-element').colorful({colorModel: 'grayscale'});</pre>
              <?php echo make_table("grayscale", 6, 10); ?>
            </li>
          </ul>
        </div>

        

        <div class="span12">
          <h2 title="About Colorful.js" class="colorful" name="about-colorful" id="about-colorful">About Colorful.js</a></h2>
          
          <h3>What is it?</h3>
          <p>Colorful is a data-visualization jQuery plugin. It assigns color values to each element of dataset based on the relationship between the elements. It's easy to use, a cinch to customize, and best of all, it makes your data beautiful.</p>
         
          <h3>How does it work?</h3>
          <p>
          <ol>
            <li>Colorful.js extracts numerical values from HTML elements to build a dataset.</li>
            <li>The data is run through a feature-scaling algorithm.</li>
            <li>An HSLA color gradient is constructed.</li>
            <li>Each datum is assigned a position along the gradient.</li>
            <li>The element associate with each datum recieves the color.</li>
          </ol>

          <h3>How about browser compatibility?</h3>

          <p>Since Colorful.js computes color values in HSL colorspace, it adds HSLA color values to elements by default. Certain nasty browsers (IE) don't play nicely with HSL or HSLA. If you are misfortunate enough to be using one of these browsers, Colorful.js can convert its HSL color values to output the same pretty colors in RGB (minus any alpha). Just be sure to set your colorModel property to 'rgb'.</p>
          <pre class="prettyprint">$('#ie-is-the-worst').colorful({colorModel: 'rgb'});</pre>
          <p>Why do we use HSL colorspace? Get your dose of color theory below.</p>


          <h3>Where can I download it?</h3>
          <p>That's easy. <a href="#download" title="Go to the Download section.">Go grab it right here.</a></p>
          
        </div>
        <div class="span12">
          <h3>A Dose of Color Theory</h3>
          <p>HSL and RGB are two popluar color models (mathematical models that describe all possible colors). A quick comparison between the <a href="http://www.spotimaging.com/images/hsl_solid.jpg" title="HSL Color Model" target="_blank">HSL Color Model</a> and the <a href="http://learn.colorotate.org/media.colorotate.org/c/rgb.jpg" title="RGB Color Model" target="_blank">RGB Color Model</a> will demonstrate that the two are very different. The cylindrical nature of HSL color space is quite conducive to radial hue traversal (like traveling across the rainbow by spinning the color model). This makes it extremely easy to construct color gradients composed of attractive colors. Simple traversal of RGB colorspace typically results in a gradient that is mostly composed of, well, disgusting shades of in between.</p>

          <div class="well">
          <span class="label label-success">Good</span><h4>HSL Color Computation</h4>
          <p>Colorful.js bases color computations on axial rotation through Hue-Saturation-Lightness (HSL) colorspace.</p>
          <p>If you would like to experiment with HSL colorspace, checkout Brandon Mathis' excellent <a href="http://hslpicker.com/#001A57" title="HSL Color Picker" target="_blank">HSL Color Picker</a>. (This is also a helpful tool for picking your color ranges and offsets.)</p>
          <?php echo $hsl_table; ?>
        </div>
          <br/>
          
          <div class="well bad">
          <span class="label label-important">Bad</span>
          <h4>RGB Color Computation</h4>
          <p>Colorful.js does NOT use point-to-point traversal of RGB colorspace, and will never output something this heinous.</p>
          <?php echo $rgb_table; ?>
        </div>
          <hr/>
        </div>
        
          
        

                
                
        <div class="span12">
          <h2 title="Supporters" class="colorful" name="supporters" id="supporters">Supporters</h2>
          <h3>Contributors</h3>
          <p>Colorful.js was developed by <a href="http://twitter.com/lawsonkurtz" title="Find Lawson Kurtz on Twitter" target="_blank">@lawsonkurtz</a>. Have a feature suggestion? <a href="https://github.com/ltk/Heat-Chart" title="Fork me on GitHub">Fork me on GitHub.</a></p>

          <h3>Supported by The Jake Group</h3>
          <p><a href="http://www.thejakegroup.com/" title="The Jake Group" target="_blank">The Jake Group</a> is proud to support several open source initiatives, including Colorful.js. If require assistance with your web project, or think you have what it takes to to work at Jake, <a href="http://www.thejakegroup.com/contact/contact/" title="The Jake Group" target="_blank">get in touch</a>.</p>
        </div>
      </div> 
    </div> <!-- /container -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
  <script src="./js/bootstrap.min.js"></script>
  <script src="./heatChart.js"></script>
  <script src="./prettify.js"></script>
  <script type="text/javascript">
  function nasty_rgb_gradient( el ) {
    var r, g, b, val;
    val = $(el).attr('data-value');
    console.log(val);
    r = Math.round(255 * val);
    g = Math.round(255 * (1 - val));
    $(el).css('background', 'rgb(' + r + ', ' + g + ',0)');
  }

  $(function(){

    $('#rgb-sample').find('td').each(function(){
      window.nasty_rgb_gradient($(this));
    });

    $('#table0').colorful({portion: 0.25, reverse: true, saturation: 100});
    $('#table1').colorful({portion: 0.25, discrete: true, steps: 3});
    $('#table1point5, #table1point6').colorful({portion: 0.25, scale: 'log'});
    $('#table2').colorful({portion: 0.25, attributeToColor: 'color'});
    $('#table3').colorful({portion: 0.5});
    $('#table4').colorful({portion: 0.5, offset: 180});
    $('#table5').colorful({portion: 0.5, offset: 180, reverse: true});
    $('#div1').colorful({portion: 1, elementSelector: 'div'});
    $('#div2').colorful({colorModel: 'grayscale', elementSelector: 'div'});
    $('#div3').colorful({colorModel: 'grayscale', discrete: true, steps:3, elementSelector: 'div'});
    $('#div4').colorful({colorModel: 'grayscale', discrete: true, steps:5, elementSelector: 'div'});
    $('#div5').colorful({theta: 220, elementSelector: 'a', attributeToColor: 'color'});
    $('#table6').colorful({portion: 0.5, reverse: true});
    $('#min-max').colorful({portion: 0.5, reverse: true, min_val: 0.5, max_val: 2});
    $('#table7').colorful({portion: 0.5, reverse: true, alpha:0.5, saturation:90, lightness: 40});
    $('#mri').colorful({portion: 0.25, reverse: true, alpha:0.5, saturation:100, dataAttribute: 'data-val'});
    

    $('#bball').colorful({portion: 0.25, reverse: true, saturation: 85, lightness: 50, elementSelector: 'div.datum'});
    $('#reversable').colorful({reverse: true});
    $('#grayscale').colorful({colorModel: 'grayscale'});
    $('#custom_hues').colorful({colors: [0,25,250]});
    $('#stepwise').colorful({stepwise: true, steps: 6});
    $('#custom_class').colorful({addedClass:"colorful"});
    $('#data_attr').colorful({dataAttribute:"data-value"});
    $('#text_color').colorful({attributeToColor: "color"});

    $('#map_data_to').colorful({mapDataTo:['h','a']});

    prettyPrint();

    var color_index = 0;
    var int=self.setInterval(function(){color_change()},50);

    function color_change(){
        color_val = ((color_index * 360) + 200) % 360;
        $('.hero-unit').css('background', 'hsl(' + color_val + ', 60%, 50%)');
        $('pre').css('background', 'hsla(' + color_val + ', 100%, 50%, 0.03)');
        $('h2.colorful').css({'background' : 'hsl(' + color_val + ', 60%, 50%)'});
        $('.colorful').css({'color' : 'hsl(' + color_val + ', 60%, 50%)'});

        color_index += 0.001;
        if( color_index > 1 ){ color_index = 0; }
    }
    $(document).scroll(function(){
      var elem = $('.subnav');
      if (!elem.attr('data-top')) {
          if (elem.hasClass('navbar-fixed-top'))
              return;
          var offset = elem.offset();
          elem.attr('data-top', offset.top);
      }
      if (elem.attr('data-top') - elem.outerHeight() <= $(this).scrollTop()){
          elem.addClass('navbar-fixed-top');
      } else {
          elem.removeClass('navbar-fixed-top');
      }
    });
        
        
    //});​

  });

  </script>
  </body>
</html>
