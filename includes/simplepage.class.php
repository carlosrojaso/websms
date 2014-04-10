<?php

/**
 * simplepage.class.php
 * 
 * Este archivo permite armar interfaces.
 * @author Carlos A. Rojas <carlkant@gmail.com> 
 * @version 1.0
 * @package package_name
 * @creacion: 16/05/2007
 * @license: GNU/GPL	
 * 
 * CAMBIOS LOG.
 * 06/09/2007: Se agrego soporte a varios javascript files y varios CSS files.
*/

class simplepage {

	var $charset;
	var $mimecontent;
	var $title;
	var $cssfile;
	var $jsfile;

	/**
	 * Constructor de la clase
	 * @param string $param1 name to declare
	 * @param string $param2 value of the name
	 * @return integer 
	 */
	function simplepage() {
		$host = $_SERVER['HTTP_HOST'];
		$this->charset = 'iso-8859-1';
		$this->cssfile = "";
		$this->title = "Onspot-SMS";
		$this->mimecontent = "text/html";
	}
	/**
	 * Configurar el charset
	 * @param string $charset encoding de reemplazo
	 * @return void 
	 */

	function setCharset($charset) {
		$this->charset = $charset;
	}

	/**
	 * retorna el charset
	 * @return string 
	 */

	function getCharset() {
		return $this->charset;
	}

	/**
	 * Configurar el mimetype
	 * @param string $mime encoding de reemplazo
	 * @return void 
	 */

	function setMime($mime) {
		$this->mimecontent = $mime;
	}

	/**
	 * retorna el mimetype
	 * @return string 
	 */

	function getMime() {
		return $this->mimecontent;
	}

	/**
	 * Configurar el titulo
	 * @param string $title de reemplazo
	 * @return void 
	 */

	function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * retorna el titulo
	 * @return string 
	 */

	function getTitle() {
		return $this->title;
	}

	/**
	 * Configurar el css
	 * @param string $css de reemplazo
	 * @return void 
	 */

	function setCSS($css) {
		$this->cssfile = $this->cssfile . '<link href="' . $css . '" rel="stylesheet" type="text/css">';
	}

	/**
	 * retorna el css
	 * @return string 
	 */

	function getCSS() {
		return $this->cssfile;
	}

	/**
	 * Configurar el js
	 * @param string $css de reemplazo
	 * @return void 
	 */

	function setJS($js) {
		$this->jsfile = $this->jsfile . '<script type="text/JavaScript" src="' . $js . '"></script>';
	}

	/**
	 * retorna el js
	 * @return string 
	 */

	function getJS() {
		return $this->jsfile;
	}

	/**
	 * retorna el header
	 * @return string 
	 */

	function getHeader() {
		$header = 
		'<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html40/strict.dtd">
			<html>
				<head>
					<meta http-equiv="Content-Type" content="' . $this->mimecontent . '; charset=' . $this->charset . '">
					<meta name="author" content="Adminnova Victor M. Vallecilla-Carlos A. Rojas">
					<meta name="description" content="' . $this->title . '">
					<title>' . $this->title . '</title>
					' . $this->getCSS() . $this->getJS() . '
				</head>
				<body bgcolor="#FFFFFF">';
		return $header;
	}

	/**
	 * retorna el footer
	 * @return string 
	 */

	function getFooter() {
		$footer = '
			<div id="footer" align="center">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td class="footer"><img src="../../images/bullet1.gif" alt="bullet1" width="7" height="7" title=""> &copy;  ' . DATE("Y") . ' <a href="../../ui/core/login.php">Onspot.es </a><img src="../../images/bullet1.gif" alt="bullet1" width="7" height="7" title=""></td>
			  </tr>
			  <tr>
			  	<td class="footer">All rights reserved - Todos los derechos reservados</td>
			  </tr>
			</table>
			</div>	
		</body>
		</html>';
		return $footer;
	}

}
?>