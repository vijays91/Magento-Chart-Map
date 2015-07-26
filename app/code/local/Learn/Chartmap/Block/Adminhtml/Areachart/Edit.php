<?php
class Learn_Chartmap_Block_Adminhtml_Areachart_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public $final_amount;
	public $yAxis;
	public $head_txt;
	public function __construct() {
		$this->setTemplate('chartmap/areachart.phtml');
		$this->final_amount = 0;
		$this->yAxis = 'Year';
		$this->head_txt = 'Last 24 Hours';
	}
		
	public function final_amount() {
		return Mage::helper('core')->currency($this->final_amount, true, false);
	}
	public function hAxis() {
		return $this->yAxis;
	}
	public function HeadText() {
		return $this->head_txt;
	}
	
	public function getTotalOrdersByFillter() {
		$data = Mage::app()->getRequest()->getParams();
		$period	= isset($data['period']) ? $data['period'] : "24h";
		if($period != "") {
			if($period == "24h") {
				$data = $this->Last24Hours();
				$this->head_txt = "Last 24 Hours";
				$this->yAxis = 'Hour(s)';  
				return $data;
			}
			else if($period == "lw") {
				$data = $this->LastWeek();
				$this->head_txt = "Last Week";
				$this->yAxis = 'Day(s)'; 
				return $data;
			}
			else if($period == "lm") {
				$data = $this->LastMonth();
				$this->head_txt = "Last Month";
				$this->yAxis = 'Day(s)';
				return $data;
			}
			else if($period == "l6m") {
				$data = $this->Last6Month();
				$this->head_txt = "Last 6 Month" ;
				$this->yAxis = 'Month(s)'; 
				return $data;
			}
			else if($period == "ly") {
				$data = $this->LastYear();
				$this->head_txt = "Last Year";
				$this->yAxis = 'Month(s)';
				return $data;
			}
			else if($period == "l5y") {
				$data = $this->Last5Year();
				$this->head_txt = "Last 5 Year";
				$this->yAxis = 'Year(s)';
				return $data;
			}
			else if($period == "l10y") {
				$data = $this->Last10Year();
				$this->head_txt = "Last 10 Year";
				$this->yAxis = 'Year(s)';
				return $data;
			}
			else if($period == "cw") {
				$data = $this->currentWeek();
				$this->head_txt = "Current Week";
				$this->yAxis = 'Day(s)';
				return $data;
			}
			else if($period == "cm") {
				$data = $this->currentMonth();
				$this->head_txt = "Current Month";
				$this->yAxis = 'Day(s)';
				return $data;
			}
			else if($period == "c6m") {
				$data = $this->current6Month();
				$this->yAxis = 'Month(s)';
				$this->head_txt = "Current 6 Month";
				return $data;
			}
			else if($period == "cy") {
				$data = $this->currentYear();
				$this->head_txt = "Current Year";
				$this->yAxis = 'Month(s) - '.date('Y', strtotime('first day of this year'));
				return $data;
			}
		}
	}
	
	public function currentYear() {
		$final_amt = 0;
		$return = " ['Month', 'Sales'],";
		$from = date('Y-01-01 00:00:00', strtotime('first day of this year'));
		for($i=1;$i <=12;$i++) {
			$time = " +1 month ";
			$to   = date('Y-m-t 23:59:59', strtotime($from));
			$value = $this->Data($from, $to);
			$amt = ($value[0]['amount']) ? $value[0]['amount'] : 00.00;
			$final_amt = $final_amt + $amt;
			/* $amt = Mage::helper('core')->currency($amt, true, false); */
			$hours = date('M', strtotime($from ));
			$return .= "['".  $hours . "', ". $amt ."],";
			$from = date('Y-m-01 00:00:00', strtotime($from . $time));
		}
		$return = substr($return, 0, -1);
		$this->final_amount = $final_amt;
		return $return;
	}
	public function currentMonth() {
		$final_amt = 0;
		$return = " ['Day', 'Sales'],";		
		$year = date('Y', strtotime('this month'));
		$mont = date('m', strtotime('this month'));
		$day = cal_days_in_month(CAL_GREGORIAN, $mont, $year);
		$from = date('Y-m-d 00:00:00', strtotime('first day of this month'));
		for($i=1;$i <= $day;$i++) {
			$time = "+1 day";
			$to   = date('Y-m-d 23:59:59', strtotime($from));
			$value = $this->Data($from, $to);
			$amt = ($value[0]['amount']) ? $value[0]['amount'] : 00.00;
			$final_amt = $final_amt + $amt;
			/* $amt = Mage::helper('core')->currency($amt, true, false); */
			$hours = date('d-m-Y', strtotime($from ));
			$return .= "['".  $hours . "', ". $amt ."],";
			$from  = date('Y-m-d 00:00:00', strtotime($to. " +1 day "));
		}		
		$return = substr($return, 0, -1);		
		$this->final_amount = $final_amt;
		return $return;
	}
	public function currentWeek() {
		$final_amt = 0;
		$return = " ['Day', 'Sales'],";
		$from = date('Y-m-d 00:00:00', strtotime(' monday this week'));
		for($i=1;$i<=7;$i = $i+1) {
			$to   = date('Y-m-d 23:59:59', strtotime($from));
			$value = $this->Data($from, $to);
			$amt = ($value[0]['amount']) ? $value[0]['amount'] : 00.00;
			/* $amt = Mage::helper('core')->currency($amt, true, false); */
			$final_amt = $final_amt + $amt;
			$hours = date('d-m-Y', strtotime($from ));
			$return .= "['".  $hours . "', ". $amt ."],";
			$from  = date('Y-m-d 00:00:00', strtotime($to. " +1 day "));
		}
		$return = substr($return, 0, -1);
		$this->final_amount = $final_amt;
		return $return;
	}
	
	public function current6Month() {
		$final_amt = 0;
		$return = " ['Month', 'Sales'],";
		$from = date('Y-07-01 00:00:00');
		for($i=1;$i <=6;$i++) {
			$time = " +1 month ";
			$to   = date('Y-m-t 23:59:59', strtotime($from));
			$value = $this->Data($from, $to);
			$amt = ($value[0]['amount']) ? $value[0]['amount'] : 00.00;
			$final_amt = $final_amt + $amt;
			/* $amt = Mage::helper('core')->currency($amt, true, false); */
			$hours = date('M', strtotime($from ));
			$return .= "['".  $hours . "', ". $amt ."],";
			$from = date('Y-m-01 00:00:00', strtotime($from . $time));
		}
		$return = substr($return, 0, -1);
		$this->final_amount = $final_amt;
		return $return;
	}
	
	public function Last10Year() {
		$final_amt = 0;
		$return = " ['Month', 'Sales'],";
		$from = date('Y-01-01 00:00:00', strtotime('-10 year'));
		for($i=1;$i <=10;$i++) {
			$time = " +1 year ";
			$to   = date('Y-12-t 23:59:59', strtotime($from));
			$value = $this->Data($from, $to);
			$amt = ($value[0]['amount']) ? $value[0]['amount'] : 00.00;
			$final_amt = $final_amt + $amt;
			/* $amt = Mage::helper('core')->currency($amt, true, false); */
			$hours = date('Y', strtotime($from ));
			$return .= "['".  $hours . "', ". $amt ."],";
			$from = date('Y-01-01 00:00:00', strtotime($from . $time));
		}
		$return = substr($return, 0, -1);
		$this->final_amount = $final_amt;
		return $return;
	}	
	public function Last5Year() {
		$final_amt = 0;
		$return = " ['Month', 'Sales'],";
		$from = date('Y-01-01 00:00:00', strtotime('-5 year'));
		for($i=1;$i <=5;$i++) {
			$time = " +1 year ";
			$to   = date('Y-12-t 23:59:59', strtotime($from));
			$value = $this->Data($from, $to);
			$amt = ($value[0]['amount']) ? $value[0]['amount'] : 00.00;
			$final_amt = $final_amt + $amt;
			/* $amt = Mage::helper('core')->currency($amt, true, false); */
			$hours = date('Y', strtotime($from ));
			$return .= "['".  $hours . "', ". $amt ."],";
			$from = date('Y-01-01 00:00:00', strtotime($from . $time));
		}
		$return = substr($return, 0, -1);
		$this->final_amount = $final_amt;

		return $return;
	}	
	public function LastYear() {
		$final_amt = 0;
		$return = " ['Month', 'Sales'],";
		$from = date('Y-01-01 00:00:00', strtotime('first day of last year'));
		for($i=1;$i <=12;$i++) {
			$time = " +1 month ";
			$to   = date('Y-m-t 23:59:59', strtotime($from));
			$value = $this->Data($from, $to);
			$amt = ($value[0]['amount']) ? $value[0]['amount'] : 00.00;
			$final_amt = $final_amt + $amt;
			/* $amt = Mage::helper('core')->currency($amt, true, false); */
			$hours = date('M', strtotime($from ));
			$return .= "['".  $hours . "', ". $amt ."],";
			$from = date('Y-m-01 00:00:00', strtotime($from . $time));
		}
		$return = substr($return, 0, -1);
		$this->final_amount = $final_amt;

		return $return;
	}
	
	public function Last6Month() {
		$final_amt = 0;
		$return = " ['Month', 'Sales'],";
		$from = date('Y-01-01 00:00:00');
		for($i=1;$i <=6;$i++) {
			$time = " +1 month ";
			$to   = date('Y-m-t 23:59:59', strtotime($from));
			$value = $this->Data($from, $to);
			$amt = ($value[0]['amount']) ? $value[0]['amount'] : 00.00;
			$final_amt = $final_amt + $amt;
			/* $amt = Mage::helper('core')->currency($amt, true, false); */
			$hours = date('M', strtotime($from ));
			$return .= "['".  $hours . "', ". $amt ."],";
			$from = date('Y-m-01 00:00:00', strtotime($from . $time));
		}
		$return = substr($return, 0, -1);
		$this->final_amount = $final_amt;
		return $return;
	}
	public function LastMonth() {
		$final_amt = 0;
		$return = " ['Day', 'Sales'],";		
		$year = date('Y', strtotime('last month'));
		$mont = date('m', strtotime('last month'));
		$day = cal_days_in_month(CAL_GREGORIAN, $mont, $year);
		$from = date('Y-m-d 00:00:00', strtotime('first day of last month'));
		for($i=1;$i <= $day;$i++) {
			$time = "+1 day";
			$to   = date('Y-m-d 23:59:59', strtotime($from));
			$value = $this->Data($from, $to);
			$amt = ($value[0]['amount']) ? $value[0]['amount'] : 00.00;
			$final_amt = $final_amt + $amt;
			/* $amt = Mage::helper('core')->currency($amt, true, false); */
			$hours = date('d-m-Y', strtotime($from ));
			$return .= "['".  $hours . "', ". $amt ."],";
			$from  = date('Y-m-d 00:00:00', strtotime($to. " +1 day "));
		}		
		$return = substr($return, 0, -1);		
		$this->final_amount = $final_amt;

		return $return;
	}
	
	public function LastWeek() {
		$final_amt = 0;
		$return = " ['Day', 'Sales'],";
		$from = date('Y-m-d 00:00:00', strtotime('last week monday'));
		for($i=1;$i<=7;$i = $i+1) {
			$to   = date('Y-m-d 23:59:59', strtotime($from));
			$value = $this->Data($from, $to);
			$amt = ($value[0]['amount']) ? $value[0]['amount'] : 00.00;
			/* $amt = Mage::helper('core')->currency($amt, true, false); */
			$final_amt = $final_amt + $amt;
			$hours = date('d-m-Y', strtotime($from ));
			$return .= "['".  $hours . "', ". $amt ."],";
			$from  = date('Y-m-d 00:00:00', strtotime($to. " +1 day "));
		}
		$return = substr($return, 0, -1);
		$this->final_amount = $final_amt;
		return $return;
	}
	
	public function Last24Hours() {
		$final_amt = 0;
		$return = " ['Hours', 'Sales'],";
		$to   = date('Y-m-d H:m:s');
		for($i=1;$i<=24;$i = $i+2) {
			$time = "- $i hours";
			$from = date('Y-m-d H:m:s', strtotime($time));
			$value = $this->Data($from, $to);
			$amt = ($value[0]['amount']) ? $value[0]['amount'] : 00.00;
			/* $amt = Mage::helper('core')->currency($amt, true, false); */
			$final_amt = $final_amt + $amt;
			$hours = date(' h:i A', strtotime($to));
			$return .= "['".  $hours . "', ". $amt ."],";
			$to = $from;
		}
		$return = substr($return, 0, -1);
		$this->final_amount = $final_amt;
		return $return;
	}

	public function Data($from, $to) { 
		$collection = Mage::getModel('sales/order')->getCollection();
		$collection->addFieldToSelect('customer_email');
		$collection->addFieldToFilter('created_at', array('date' => true, 'from' => $from));
		$collection->addFieldToFilter('created_at', array('date' => true, 'to'   => $to));
		$collection->getSelect()->columns('SUM( grand_total ) AS amount');
		/* echo $collection->getSelect();
		echo "<br/>"; */
		return $collection->getData();
	}
}

