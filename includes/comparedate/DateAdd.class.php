<?php

/**
* +------------------------------------------------------------------------------+
* Author(s): Vijay Kiran Maddireddy
* +------------------------------------------------------------------------------+
* Date Manipulation Class
* Parameters for the object: $date $strSeperator
* Explanation: purpose of this class is compare two dates
* Date Format: mm-dd-yyyy
* Separator: -

*/

class DateCK{
 
    //Variable Decleration 
            var $Date;
            var $Month;
            var $Day;
            var $Year;
		    var $DateSeperator;
           	var $verbose;
           	
	// Constructor: Separates date into Month Day and Year
    function DateCK($date,$strSeperator)
	{
			   $this->Date = $date;
			   $this->DateSeperator = $strSeperator;
			   $date_ar = split($this->DateSeperator,$this->Date,3);
			   $this->Month = intval($date_ar[1]);
			   $this->Day = intval($date_ar[2]);
			   $this->Year = intval($date_ar[0]);
			   $this->verbose=0;
    }


	// Function to compare 2 dates, target date is passed as a parameter and the start date is used to call this function
	function comparedates($targetdate)
	{
				
		$validate_status = $this->Validatedate();
		if ($validate_status==0) {
			if($this->verbose==1){
				
				echo "<br> Invalid start date";
			}
	   		return (-10);
	   }
	   $validate_status = $targetdate->Validatedate();
		if ($validate_status==0) {
			if($this->verbose==1)
			echo "<br> Invalid end date";
	   		return (-10);
	   }
	   //compare years
	   if ($this->Year!=$targetdate->Year) {
	   		if ($this->Year>$targetdate->Year) {
				if($this->verbose==1)
				echo "<br>from year is greater than to year";
				return -1;
			}
			else if ($this->Year<$targetdate->Year) {
				if($this->verbose==1)
				echo "<br>to year is greater than from year";
				return 1;
			}
			else {
				if($this->verbose==1)
				echo "<br>could not identify the years";
				return -10;
			}
	   }
	   if ($this->Month==$targetdate->Month) {
	   		if ($this->Day == $targetdate->Day) {
				if($this->verbose==1)
				echo "<br>Dates are the same";
				return 0;
			}
			else if ($this->Day > $targetdate->Day) {
				if($this->verbose==1)
				echo "<br>From Day is greater than to day";
				return -1;
			}
			else if ($this->Day < $targetdate->Day) {
				if($this->verbose==1)
				echo "<br>To day is greater than from day";
				return 1;
			}
			else {
				if($this->verbose==1)
				echo "<br>Could not identify the days";
				return 0;
			}
	   }
	   else {
	   		if ($this->Month>$targetdate->Month) {
				if($this->verbose==1)
				echo "<br>From month is greater than to month";
				return -1;
			}
			if ($this->Month<$targetdate->Month) {
				if($this->verbose==1)
				echo "<br>To month is greater than from month";
				return 1;
			}
	   }
	   if($this->verbose==1)
	   echo "<br>Valid Dates";
	   return 1;
	}

   // To check if the date passed is correct
   function Validatedate()
   {
		if (($this->Month<1)||($this->Month>12)) {
			//echo "<br> Invalid Month";
			return 0;
		}
		// doing the math using K Maps for calculating whether it is a leap year or not, I got the following formula
		// A B` C`  +  A B C 
		// A - divisible by 4; B - divisible by 100; C - divisible by 400
		$leapday = 0;
		$A = (($this->Year%4)==0)?1:0;
		$B = (($this->Year%100)==0)?1:0;
		$C = (($this->Year%400)==0)?1:0;
		$R = ($A && (!($B)) && (!($C))) || ($A && $B && $C);
		
		//verifying the day
		//months with 31 days
		$month31 = (($this->Month==1)||($this->Month==3)||($this->Month==5)||($this->Month==7)||($this->Month==8)||($this->Month==10)||($this->Month==12))?1:0;
		
		if (($R && ( ($this->Month==2) && (($this->Day<1) || ($this->Day>29)) ))||(!$R && (($this->Month==2) && (($this->Day<1) || ($this->Day>28))))) {
			//echo "<br> Invalid Day";
			return 0;
		}
		else
		if ( ($month31 && ( ($this->Day<1) || ($this->Day>31) ) ) || (!$month31 && ( ($this->Day<1) || ($this->Day>30) ) ) ) {
			//echo "<br> Invalid Day";
			return 0;
		}
		return 1;
   } 
	

	function display()
	{
		echo "$this->Month-$this->Day-$this->Year";
	}
}

?>
