<?php
//
// +---------------------------------------------+
// |     IP2MORE :: IP2COUNTRY V3                |
// |     http://www.SysTurn.com                  |
// +---------------------------------------------+
//
//
//   This program is free software; you can redistribute it and/or modify
//   it under the terms of the GNU General Public License as published by
//   the Free Software Foundation; either version 2, or (at your option)
//   any later version.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of the GNU General Public License
//   along with this program; if not, write to the Free Software Foundation,
//   Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
//
//

require_once('i2m.class.php');
if(isset($_GET['ip']) &&  !empty($_GET['ip'])){
  $i2m = new ip2more($_GET['ip'], true);  #<< The 'true' forces a lookup in WHOIS server if not found in the local database
} else {
  $i2m = new ip2more(null, true); #<< We pass a null value for the IP, to use users' real IP address
}

// IF FLAGS DIR IN ANOTHER FOLDER YOU HAVE TO SET IT (WITH OR WITHOUT TRAILING SLASH)
#$i2m->flags_dir = './flags/';
#$i2m->flags_dir = 'http://domain-name/flags/';
?>
<html>
<head>
  <title>IP2More :: IP2Country V3</title>
</head>
<body>
<?php if(isset($_GET['do']) && $_GET['do']=='src'){?>
<center>
<a href="demo.php">return back</a>
<div align="left" style="padding:5px; border:solid #000000 1px; background-color:#EFEFEF; width:95%; height:390; overflow:auto">
<?php highlight_file(__FILE__) ?>
</div>
</center>
<?php } else { ?>
<script language="javascript">
<!--
  function is_valid_ip(ip_address)
  {
    var allowed  = '.0123456789';
    var dots     = 0;
    var is_valid = true;
    if(ip_address.length < 8 || ip_address.length > 15){
      is_valid = false;
    } else {
      for(i=0,l=ip_address.length;i<l;i++){
        t = ip_address.substr(i,1);
        if(t == '.') dots++;
        if(allowed.indexOf(t) == -1){
          is_valid = false;
          break;
        }
      }
    }
    if(dots != 3) is_valid = false;
    if(!is_valid) alert('Invalid IP Address');
    return is_valid;
  }
-->
</script>
<center><a href="demo.php?do=src">view source</a></center>
<FORM name="ip2country" method="GET" onSubmit="return is_valid_ip(this.ip.value);">
IP: <INPUT type="text" name="ip" style="text-align: center; border: solid 1px #000000; height:20px;" value="<?php echo $i2m->ip ?>">
<INPUT type="submit" style="border: solid 1px #000000; background-color:#EFEFEF; height:20px;" value="Translate">
</FORM>

<table border=0 cellpadding=2 cellspacing=2>
  <tr>
    <td><b>IP</b></td>
    <td><?php echo $i2m->ip ?></td>
  </tr>
  <tr>
    <td><b>Country</b></td>
    <td><?php echo $i2m->country['name'] ?></td>
  </tr>
  <tr>
    <td><b>ISO2</b></td>
    <td><?php echo $i2m->country['iso2'] ?></td>
  </tr>
  <tr>
    <td><b>ISO3</b></td>
    <td><?php echo $i2m->country['iso3'] ?></td>
  </tr>
  <tr>
    <td><b>FIPS104</b></td>
    <td><?php echo $i2m->country['fips104'] ?></td>
  </tr>
  <tr>
    <td><b>ISO Number</b></td>
    <td><?php echo $i2m->country['isono'] ?></td>
  </tr>
  <tr>
    <td><b>Flag Small</b></td>
    <td><img src="<?php echo $i2m->country['flag_small'] ?>"</td>
  </tr>
  <tr>
    <td><b>Flag Big</b></td>
    <td><img src="<?php echo $i2m->country['flag_big'] ?>"></td>
  </tr>
  <tr>
    <td><b>Region</b></td>
    <td><?php echo $i2m->country['region'] ?></td>
  </tr>
  <tr>
    <td><b>Capital</b></td>
    <td><?php echo $i2m->country['capital'] ?></td>
  </tr>
  <tr>
    <td><b>Currency</b></td>
    <td><?php echo $i2m->country['currency'] ?></td>
  </tr>
  <tr>
    <td><b>Currency Code</b></td>
    <td><?php echo $i2m->country['currency_code'] ?></td>
  </tr>
</table>
<br />
<select name=country>
  <option value="">select country</option>
  <?php
    #$i2m->sort_countries_list(COUNTRY_ORDER); // DEFAULT IF NOT SET
    #$i2m->sort_countries_list(REGION_ORDER);
    #$i2m->sort_countries_list(ISO2_ORDER);
    #$i2m->sort_countries_list(ISO3_ORDER);

    $i2m->print_countries_list('iso2');
    
    // IF USING TEMPLATE ENGINE, YOU CAN USE return_countries_list() instead
    #$i2m->return_countries_list('iso2');
    
    // THIS WILL DISABLE 'AUTO SELECT' COUNTRY FOR ACTIVE IP ADDRESS
    #$i2m->print_countries_list('iso3', false);
  ?>
</select>
<?php } ?>
</body>
</html>