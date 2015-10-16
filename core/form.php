<?php
/**
* 
*/
class Form
{
	public $controller;

	public function __construct($controller){
		$this->controller = $controller;
	}
	
	public function input($field,$label,$option=array()){
		//debug($this->controller);die();
		$errors = false;
		$classError = '';
		//debug($this->controller);
		
		if ($label == 'hidden'){
			if (isset($option['value'])) {
				if (isset($option['type'])) {
					if ($option['type'] == 'textarea') {
						return '<textarea type="text" id="input'.$field.'" name="'.$field.'"'.$attr.'>'.$option['value'].'</textarea >';
					}
				}
				return '<input type="hidden" name="'.$field.'" value="'.$option['value'].'">' ;
			}
			//debug($option['value']);
			return '<input type="hidden" name="'.$field.'" value="'.self::controlField($field).'">' ;
		}
		if (isset($this->errors[$field])) {
			$errors = $this->errors[$field];
			$classError = ' error';
		}
		$valdata = self::controlField($field);
		if ($valdata == '') {
			if (isset($option['value'])) {
				$valdata = $option['value'];
			}
		}
		//debug("CHAMP".$field." VALUE".$valdata);
		$html = '<div class="clearfix'.$classError.'">';
			if (strlen($label) > 0) {
				$html .= '<label for="input'.$field.'">'.$label.'</label>'; 
			}
					
		$html .='<div class="input">';
		$attr = ' ';
		foreach ($option as $key=>$value) {
			if($key!='type' && $key!='val' && $key!='src'){
				$attr .= " $key=\"$value\"";
			}				
		}
		if (!isset($option['type'])){
			if (!isset($option['required'])){
				
				$html .= '<input type="text" id="input'.$field.'" name="'.$field.'" value="'.$valdata.'"'.$attr.'>';
			}else{
				if ($field == 'prix'){
					$html .= '<input type="text" id="input'.$field.'" required pattern="(0\.((0[1-9]{1})|([1-9]{1}([0-9]{1})?)))|(([1-9]+[0-9]*)(\.([0-9]{1,2}))?)" name="'.$field.'" value="'.$valdata.'"'.$attr.'>';
				}else{
					$html .= '<input type="text" id="input'.$field.'" required name="'.$field.'" value="'.$valdata.'"'.$attr.'>';
				}
			}
			
		}elseif ($option['type'] == 'textarea') {
			$html .= '<textarea type="text" id="input'.$field.'" name="'.$field.'"'.$attr.'>'.$valdata.'</textarea >';
		}elseif ($option['type'] == 'checkbox') {
			if (!isset($option['required'])){
				$html .= '<input type="hidden" required="required" name="'.$field.'" required value="0">
					<input type="checkbox"  required="required" name="'.$field.'"value="1" '.(empty($valdata)?'':'checked').'>';
			}else{
				$html .= '<input type="hidden" name="'.$field.'" value="0">
					<input type="checkbox" name="'.$field.'" value="1" '.(empty($valdata)?'':'checked').'>';
			}
			
		}elseif ($option['type'] == 'radio') {
			if (isset($option['val'])) {
				$mtml='';
				foreach ($option['val'] as $key => $value) {
					if ($valdata==$value){
						$mtml .= '<input type="radio" name="'.$field.'" value="'.$value.'" checked> '.$value;
					}else{
						$mtml .='<input type="radio" name="'.$field.'" value="'.$value.'"> '.$value;
					}
				}
				$html .= $mtml;
			}
		}elseif ($option['type'] == 'datetime') {
			//$html .= '<input type="type="hidden" id="input'.$field.'" name="'.$field.'" value="'.$valdata.'"'.$attr.'';
			$date =$valdata;
			$time=$valdata;
			if ($valdata) {
				$dt = explode(' ',$valdata);
				$date = explode('-',$dt[0])[2].'/'.explode('-',$dt[0])[1].'/'.explode('-',$dt[0])[0]; 
				$time = explode(':',$dt[1])[0].':'.explode(':',$dt[1])[1];
			}
			
			$html .= '<div class="ladate"><input type="text" size="12" class="date" required pattern="\d{1,2}/\d{1,2}/\d{4}" value="'.$date.'" placeholder="dd/mm/yyyy" name="date_'.$field.'"></div>';
    		$html .= '<div class="heure"><input type="text" size="12" class="time" required pattern="\d{1,2}:\d{2}([ap]m)?" value="'.$time.'" placeholder="hh:mn" style="width: 50px" name="time_'.$field.'"></div>';	

		}elseif ($option['type'] == 'date') {
			//$html .= '<input type="type="hidden" id="input'.$field.'" name="'.$field.'" value="'.$valdata.'"'.$attr.'';
			$date;
			if ($valdata) {
				$dt = explode(' ',$valdata);
				$date = explode('-',$dt[0])[2].'/'.explode('-',$dt[0])[1].'/'.explode('-',$dt[0])[0]; 
			}
			$html .= '<input type="text" size="12" required pattern="\d{1,2}/\d{1,2}/\d{4}" value="'.$date.'" placeholder="dd/mm/yyyy" name="date_'.$field.'">';
    		
		}elseif ($option['type'] == 'password') {
			$html .= '<input type="password" size="12" required value="'.$valdata.'" name="'.$field.'"'.$attr.'>';
    		
		}elseif ($option['type'] == 'email') {
			$html .= '<input type="email" size="12"  required value="'.$valdata.'" name="'.$field.'"'.$attr.'>';
    		
		}elseif ($option['type'] == 'time') {
			//$html .= '<input type="type="hidden" id="input'.$field.'" name="'.$field.'" value="'.$valdata.'"'.$attr.'';
			$time;
			if ($valdata) {
				$dt = explode(' ',$valdata);
				$time = explode(':',$dt[1])[0].':'.explode(':',$dt[1])[1];
			
			}
			$html .= '<input type="text" size="12" required pattern="\d{1,2}:\d{2}([ap]m)?" value="'.$time.'" placeholder="hh:mn" style="width: 50px" name="time_'.$field.'">';	

		}elseif ($option['type'] == 'select') {
			//$html .= '<input type="type="hidden" id="input'.$field.'" name="'.$field.'" value="'.$valdata.'"'.$attr.'';
			//$html .= '<select name="'.$field.'">\n';
			//<option value="">Select $label</option>
			
			$soucr = $option['src'];
			if (!isset($option['required'])) {
				$html .= '<select name="'.$field.'">\n';
			}else{
				
				$html .= '<select required name="'.$field.'">\n';
			}
			$html .= '<option value="">'.$label.'</option>';
			foreach ($soucr as $key => $value) {
				$html .= "<option value=$key\n";
				if ($valdata == $key) {
					$html .= " selected";
				}
				$html .= "> $value\n";
			}$html .= "</select>";
		
		}
		if ($errors) {
			$html .='<span class="help-inline">'.$errors.'</span>';
		}

		$html .= '</div></div>';


		return $html;
	}

	function controlField($champ){
		if (!isset($this->controller->request->data->$champ)) {
			$valdata = '';
		}else{
			$valdata = $this->controller->request->data->$champ;
		}
		return $valdata;
	}
	
	function formaDate(){
		
		$var_days = 0;
		$var_month= 0;
		$var_years= 0;
		$html_str='';
		$Mois =array("Jan","Fév","Mar","Avr","Mai","Juin","Jui","Aout","Sep","Oct","Nov","Dec");
		$var_years_ini=2015;
		$date = new DateTime("2015-03-15");
		$html_str .= "<div style= 'text-aligne: center'>\n";
		//liste des jours
		$html .= "<select name='Jour'>\n";
		$var_days=0;
		$var_month =0;
		$var_years=0;
		$Mois =array(1=>"Jan","Fév","Mar","Avr","Mai","Juin","Jui","Aout","Sep","Oct","Nov","Dec");
		for ($i=1; $i<=31 ; $i++) { 
			$html .= "<option value=$i";
			if ($var_days == $i) {
				$html .= " selected";
			}
			$html .= "> $i\n";
			}
		$html .= "</select>\n";

		$html .= "<select name='Mois'>\n";
		for ($i=1; $i<=12 ; $i++) { 
			$html .= "<option value=$i\n";
			if ($var_month == $i) {
				$html .= " selected";
			}
			$html .= "> $Mois[$i]\n";
		}
		$html .= "</select>\n";
		// liste pour les année
		$var_years_ini = 2015;
		$html .= "<select name='annee'>\n";
		for ($i=$var_years_ini; $i<=$var_years_ini+10 ; $i++) { 
			$html .= "<option value=$i\n";
			if ($var_years == $i) {
				$html .= " selected";
			}
			$html .= "> $i\n";
		}
		$html .= "</select>\n";
		$html_str .= "</div>";
		return $html_str ;

	}
}

?>