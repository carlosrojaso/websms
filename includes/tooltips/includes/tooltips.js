/**
 *  JavaScript Cross-Browser Tooltips
 *
 *  copyright (c) Stefan Gabos
 *
 *  This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivs 2.5 License.
 *  To view a copy of this license, visit {@link http://creativecommons.org/licenses/by-nc-nd/2.5/} or send a letter to
 *  Creative Commons, 543 Howard Street, 5th Floor, San Francisco, California, 94105, USA.
 *
 *  For more resources visit {@link http://stefangabos.blogspot.com}
 */

/**
 *  The speed with which a tooltip should fade in.
 *  Can be any value between 1 and 100
 */
var JavaScriptTooltips_fadeInSpeed;

/**
 *  The speed with which a tooltip should fade out.
 *  Can be any value between 1 and 100
 */
var JavaScriptTooltips_fadeOutSpeed;

/**
 *  How long (in milliseconds) should the script wait onmouseout,
 *  before starting to fade out a tooltip
 */
var JavaScriptTooltips_fadeOutDelay;

/**
 *  How long (in milliseconds) should the script wait onmouseover,
 *  before starting to fade in a tooltip
 */
var JavaScriptTooltips_fadeInDelay;

/**
 *  A percentual value representing the maximum opacity a tooltip can get
 */
var JavaScriptTooltips_maximumOpacity;

/**
 *  How far (in pixels), horizontally, should the tooltip be positioned relatively to the mouse cursor
 */
var JavaScriptTooltips_offsetX;

/**
 *  How far (in pixels), vertically, should the tooltip be positioned relatively to the mouse cursor
 */
var JavaScriptTooltips_offsetY;

/**
 *  Array that keeps track of created tooltips
 *
 *  @access private
 */
function dataArray(opacity, timer, context)
{

    this.opacity = opacity;
    this.timer = timer;
    this.context = context;

}

var tooltipData = new Array();


/**
 *  Displays a tooltip
 *
 *  No onmouseout required. The scripts takes care of fading the tooltip out once you mouseout.
 *
 *  @param  context     context     This MUST always be the <b>this</b> keyword
 *
 *  @param  content     content     The content to be displayed in the tooltip
 *
 *                                  If you are using this script as a stand-alone script (not with it's related PHP class
 *                                  don't forget to delete the "unescape" word in the first row of the function)
 *
 *  @param  event       event       This MUST always be <b>event</b>
 *
 *  @return void
 */
function show(context, content, event)
{	
    // unescape the content sent by the related PHP class
    // DELETE THE "unescape" WORD IF YOU'RE USING THIS SCRIPT AS A STAND-ALONE SCRIPT (NOT WITH IT'S RELATED PHP CLASS!)
    content = unescape(content);

    // if the caller HTML element hasn't got an ID yet
    if (!context.id) {
    
        // generate a 12 characters long random name
        var HTMLelID = '';
        var letters = 'abcdefghijklmnopqrstuvwxyz';
        var numbers = '0123456789';
        for (i = 0; i < 12; i++) {
        
            HTMLelID += Math.floor(Math.random() * 2) == 0 ? letters.charAt(Math.floor(Math.random() * 26)) : numbers.charAt(Math.floor(Math.random() * 10));
            
        }
    
        // assign the name as the ID of the caller HTML element
        context.id = HTMLelID;
        
    }
    
    // if the associated tooltip was not created yet
    if (!document.getElementById(context.id + "_tooltip")) {

        // the tooltip's ID will be the caller element's ID plus the "_tooltip" suffix
        tooltipID = context.id + "_tooltip";

        // create a new entry in the tooltipData array
        tooltipData[tooltipID] = new dataArray(0, false, context);

        // if browser is Internet Explorer -> note that because Opera identifies itself as IE we make one more additional check
        if (navigator.appName == "Microsoft Internet Explorer" && navigator.userAgent.indexOf("Opera") == -1) {

            // we create an IFRAME element which will be always positioned behind the tooltip
            // to cover SELECT elements - which, by default in Internet Explorer, are always
            // above all elements in a page
            var newIFrame = document.createElement("iframe");

            // set the IFRAME's default properties
            newIFrame.id = tooltipID + "_iframe";
            newIFrame.src = "about:blank";
            newIFrame.frameBorder = "0";
            newIFrame.scrolling = "no";
            newIFrame.style.position = "absolute";
            newIFrame.style.display = "block";
            newIFrame.top = 0;
            newIFrame.left = 0;
            newIFrame.height = 0;
            newIFrame.width = 0;

            // and actually add the element to the body of the document
            document.body.appendChild(newIFrame);

        }

        // create a new DIV element as a container for the tooltip
        var newTooltip = document.createElement("div");

        // set the DIV's default properties
        newTooltip.id = tooltipID;
        newTooltip.style.position = "absolute";
        newTooltip.style.display = "block";
        newTooltip.style.left = '0px';
        newTooltip.style.top = '0px';
        newTooltip.style.width = "auto";
        newTooltip.style.height = "auto";

        // and actually add the element to the body of the document
        document.body.appendChild(newTooltip);

        // set the onmouseout event for the caller element to hide the tooltip
        // this is how we handle "automatically" the fade out of the tooltip :)
        context.onmouseout = function() { hide(tooltipID) }

        // set some events for the tooltip so that the tooltip will not fade out accidentally
        document.getElementById(tooltipID).onmouseover = function () { _fadeIn(tooltipID); }
        document.getElementById(tooltipID).onmouseout = function () { hide(tooltipID); }
        document.getElementById(tooltipID).onclick = function () { hide(tooltipID, true); }

        // if browser is Internet Explorer -> note that because Opera identifies itself as IE we make one more additional check
        if (navigator.appName == "Microsoft Internet Explorer" && navigator.userAgent.indexOf("Opera") == -1) {

            // set some events for the IFRAME element so that the tooltip will not fade out accidentally
            document.getElementById(tooltipID + "_iframe").onmouseover = function () { _fadeIn(tooltipID); }
            document.getElementById(tooltipID + "_iframe").onmouseout = function () { hide(tooltipID); }
            document.getElementById(tooltipID + "_iframe").onclick = function () { hide(tooltipID, true); }

        }

        // add content to tooltip
        document.getElementById(tooltipID).innerHTML = content;
        
    }

    // get the tooltip's name (which is the caller element's ID plus the "_tooltip" suffix)
    tooltipID = context.id + "_tooltip";
    document.getElementById(tooltipID).style.display = 'block';

    // get mouse coordinates
    var posx = 0;
    var posy = 0;

    if (event.pageX || event.pageY) {		    	
    	posx = event.pageX;
    	posy = event.pageY;

    } else if (event.clientX || event.clientY) {		    	
    	posx = event.clientX + document.documentElement.scrollLeft;
    	posy = event.clientY + document.documentElement.scrollTop;

    }   
	
    // move tooltip position relative to mouse cursor by specified offsetX and offsetY    
    
    with (document.getElementById(tooltipID).style) {
        left = (posx + JavaScriptTooltips_offsetX) + "px";
        top  = (posy - JavaScriptTooltips_offsetY - document.getElementById(tooltipID).offsetHeight) + "px";		 
    }
   
    // next we adjust the tooltips position so that it always stays in the visible area of the browser
	
    // we strip "px" from the left and top position of the tooltip 
    
    leftPos = eval(document.getElementById(tooltipID).style.left.replace(/px/g, ''));
    //leftPos = (posy - JavaScriptTooltips_offsetY - document.getElementById(tooltipID).offsetHeight);
    topPos = eval(document.getElementById(tooltipID).style.top.replace(/px/g, ''));
    //topPos = (posy - JavaScriptTooltips_offsetY - document.getElementById(tooltipID).offsetHeight);
    
    

    // get the width and height of the tooltip
    width = document.getElementById(tooltipID).offsetWidth;
    height = document.getElementById(tooltipID).offsetHeight;

    // cross-browser detection of browser's window width and height
    // this code is from http://www.howtocreate.co.uk/tutorials/javascript/browserwindow
    // and is written by Mark Wilton-Jones
    
    //Non-IE
    if (typeof( window.innerWidth ) == 'number') {
    
        screenWidth = window.innerWidth;
        screenHeight = window.innerHeight;
        
    //IE 6+ in 'standards compliant mode'
    } else if(document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
    
        screenWidth = document.documentElement.clientWidth;
        screenHeight = document.documentElement.clientHeight;
        
    //IE 4 compatible
    } else if(document.body && ( document.body.clientWidth || document.body.clientHeight)) {
    
        screenWidth = document.body.clientWidth;
        screenHeight = document.body.clientHeight;
    }

    // cross-browser detection of browser's scroll values
    // this code is from http://www.howtocreate.co.uk/tutorials/javascript/browserwindow
    // and is written by Mark Wilton-Jones
    
    //Netscape compliant
    if (typeof(window.pageYOffset) == 'number') {
    
        scrollY = window.pageYOffset;
        scrollX = window.pageXOffset;
        
    //IE6 standards compliant mode
    } else if(document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
    
        scrollY = document.documentElement.scrollTop;
        scrollX = document.documentElement.scrollLeft;
        
    //DOM compliant
    } else {
    
        scrollY = document.body.scrollTop;
        scrollX = document.body.scrollLeft;
        
    }
	
    // adjust the tooltip's position so that it is in the visible part of the browser's window

    if (leftPos + width > screenWidth + scrollX) {

        leftPos = posx - width - JavaScriptTooltips_offsetX;
    }

    if (leftPos < scrollX) {

        leftPos = posx + JavaScriptTooltips_offsetX;

    }

    if (topPos + height > screenHeight + scrollY) {

        topPos = posy - heigh - JavaScriptTooltips_offsetY;

    }

    if (topPos < scrollY) {

        topPos = posy + JavaScriptTooltips_offsetY;

    }
	
	
    document.getElementById(tooltipID).style.left = leftPos + "px";
    document.getElementById(tooltipID).style.top = topPos + "px";

    // if browser is Internet Explorer -> note that because Opera identifies itself as IE we make one more additional check
    if (navigator.appName == "Microsoft Internet Explorer" && navigator.userAgent.indexOf("Opera") == -1 && document.getElementById(tooltipID + "_iframe").style.display != 'block') {

        // move the IFRAME behind the tooltip, set it to the same size and show it
        with (document.getElementById(tooltipID + "_iframe").style) {

            left = document.getElementById(tooltipID).style.left;
            top = document.getElementById(tooltipID).style.top;
            width = document.getElementById(tooltipID).offsetWidth;
            height = document.getElementById(tooltipID).offsetHeight;
            visibility = 'visible';

        }

    }

    // show tooltip
    _fadeIn(tooltipID);

}

/**
 *  Hides a tooltip
 *
 *  @access private
 */
function hide(tooltipID, instantly)
{

    // if tooltip has reached the maximum allowed opacity
    if (tooltipData[tooltipID].opacity >= JavaScriptTooltips_maximumOpacity && !instantly) {
    
        // start fading it out - after waiting for JavaScriptTooltips_fadeOutDelay milliseconds
        tooltipData[tooltipID].timer = setTimeout(fadeOut(tooltipID), JavaScriptTooltips_fadeOutDelay);
        
    // if tooltip has not yet reached the maximum allowed opacity
    } else {
    
        // start fading it out right away
        tooltipData[tooltipID].timer = setTimeout(fadeOut(tooltipID), 1);
        
    }
    
}

/**
 *  Enabler function for the _fadeIn method
 *  in order to pass context to the setTimeout function
 *
 *  It is called by the 'show()' function
 *
 *  @access private
 */
function fadeIn(tooltipID)
{

    // clear any previously set timer for this tooltip
    clearTimeout(tooltipData[tooltipID].timer);

    // return prepared string
    return '_fadeIn(\'' + tooltipID + '\')';
    
}

/**
 *  Fades in a tooltip
 *
 *  @access private
 */
function _fadeIn(tooltipID)
{

    // function will be called recursively until the tooltip reaches the maximum allowed opacity
    if (tooltipData[tooltipID].opacity <= JavaScriptTooltips_maximumOpacity) {

        // if browser is Internet Explorer -> note that because Opera identifies itself as IE we make one more additional check
        if (navigator.appName == "Microsoft Internet Explorer" && navigator.userAgent.indexOf("Opera") == -1) {

            // set the opacity level for the IFRAME element, too
            setOpacity(tooltipID + "_iframe", tooltipData[tooltipID].opacity);
            
        }
        
        // set the opacity level for the tooltip
        setOpacity(tooltipID, tooltipData[tooltipID].opacity);

        // increase the opacity with the specified amount
        tooltipData[tooltipID].opacity += JavaScriptTooltips_fadeInSpeed;

        // recursively call itself
        tooltipData[tooltipID].timer = setTimeout(fadeIn(tooltipID), 1);

    // if tooltip has reached the maximum allowed opacity
    } else {
    
        // if the browser is Internet Explorer
        if (navigator.appName == "Microsoft Internet Explorer" && navigator.userAgent.indexOf("Opera") == -1) {
        
            // set the opacity level for the IFRAME element, too
            setOpacity(tooltipID + "_iframe", JavaScriptTooltips_maximumOpacity);
            
        }
        
        // set the opacity level for the tooltip
        setOpacity(tooltipID, JavaScriptTooltips_maximumOpacity);
    
        // clear the timeout
        clearTimeout(tooltipData[tooltipID].timer);
    
    }

    // we decrease every tooltip's z-index -> this is a hack for Opera
    for (var i in tooltipData) {
    
        document.getElementById(i).style.zIndex -= 1;

    }
    
    // and make the current one have the highest z-index
    document.getElementById(tooltipID).style.zIndex = 9999;

}

/**
 *  Enabler function for the _fadeOut method
 *  in order to pass context to the setTimeout function
 *
 *  It is called by the 'hide()' function
 *
 *  @access private
 */
function fadeOut(tooltipID)
{

    // clear any previously set timer for this tooltip
    clearTimeout(tooltipData[tooltipID].timer);
    
    // return prepared string
    return '_fadeOut(\'' + tooltipID + '\')';
}

/**
 *  Fades out a tooltip
 *
 *  @access private
 */
function _fadeOut(tooltipID)
{

    // function will be called recursively until the tooltip becomes 0% opaque
    if (tooltipData[tooltipID].opacity >= 0) {
    
        // if the browser is Internet Explorer
        if (navigator.appName == "Microsoft Internet Explorer" && navigator.userAgent.indexOf("Opera") == -1) {

            // set the opacity level for the IFRAME element, too
            setOpacity(tooltipID + "_iframe", tooltipData[tooltipID].opacity);

        }

        // set the opacity level for the tooltip
        setOpacity(tooltipID, tooltipData[tooltipID].opacity);

        // decrease the opacity with the specified amount
        tooltipData[tooltipID].opacity -= JavaScriptTooltips_fadeOutSpeed;

        // recursively call itself
        tooltipData[tooltipID].timer = setTimeout(fadeOut(tooltipID), 1);

    // if tooltip becomes 0% opaque (100% transparent)
    } else {

        // clear the timeout
        clearTimeout(tooltipData[tooltipID].timer);
        
        // hide the tooltip
        document.getElementById(tooltipID).style.display = 'none';

        // if the browser is Internet Explorer
        if (navigator.appName == "Microsoft Internet Explorer" && navigator.userAgent.indexOf("Opera") == -1) {

            // also hide the IFRAME element
            document.getElementById(tooltipID + "_iframe").style.display = "none";
            
        }

    }
    
}

/**
 *  Sets opacity
 *
 *  @param  integer     value   a value between 0-100 indicating the opacity of the layer
 *                              0 is fully transparent, 100 is fully opaque
 *
 *  @return void
 *
 *  @access private
 */
function setOpacity(tooltipID, value)
{

    // if browser is Internet Explorer -> note that because Opera identifies itself as IE we make one more additional check
    if (navigator.appName == "Microsoft Internet Explorer" && navigator.userAgent.indexOf("Opera") == -1) {

        // set opacity this way
        document.getElementById(tooltipID).style.filter = "alpha(opacity=" + value + ")";

    // if browser is a Netscape clone
    // but not Safari -> because Safari has the navigator.appName property set to 'Netscape'
    } else if (navigator.appName == "Netscape" && navigator.userAgent.indexOf("Safari") == -1) {

        // set opacity this way
        document.getElementById(tooltipID).style.MozOpacity = value / 100;

    // if browser is Konqueror
    } else if (navigator.vendor == "KDE") {

        // set opacity this way
        document.getElementById(tooltipID).style.KHTMLOpacity = value / 100;

    // any else DOM compliant browser
    } else {

        // set opacity this way
        document.getElementById(tooltipID).style.opacity = value / 100;

    }

}
