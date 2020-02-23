<?php

class WmParser {
	public function getCases() {
		$data = [];

		$html = file_get_contents('https://www.worldometers.info/coronavirus/');
		if(preg_match('/<div class="maincounter-number"> <span style="color:#aaa">(.*)<\/span><\/div>/i', $html, $m)) {
			$count = str_replace(',', '', $m[1]);

			$data['total'] = (int)$count;
		} else {
			$data['total'] = 0;
		}

		if(preg_match('/<div class="panel_flip"> <div class="panel_front" style="width:100%;height:100%;"> <div class="number-table-main">(.*)<\/div> <div style="font-size:13.5px">Currently Infected Patients<\/div>/i', $html, $m)) {
			$data['currently'] = (int)str_replace(',', '', $m[1]);
		} else {
			$data['currently'] = 0;
		}

		if(preg_match('/<div class="panel panel-default"> <div class="panel-heading" style="text-align:center;"> <span class="panel-title" style="font-size:18px; text-transform:uppercase; font-weight:100"> Closed Cases<\/span><\/div> <div class="panel-body" style="text-align:center;height:200px;"> <div class="panel_flip"> <div class="panel_front" style="width:100%;height:100%;"> <div class="number-table-main">(.*)<\/div> <div style="font-size:13.5px">Cases which had an outcome:<\/div>/i', $html, $m)) {
			$data['outcome'] = (int)str_replace(',', '', $m[1]);
		} else {
			$data['outcome'] = 0;
		}

		if(preg_match('/<span class="number-table" style="color:#8080FF">(.*)<\/span> \(<strong>(.*)<\/strong>%\) <div style="font-size:13px">in Mild Condition<\/div>/i', $html, $m)) {
			$data['mild'] = [
				'count' => (int)str_replace(',', '', $m[1]),
				'percent' => (int)str_replace(',', '', $m[2])
			];
		} else {
			$data['mild'] = [
				'count' => 0,
				'percent' => 0
			];
		}

		if(preg_match('/<span class="number-table" style="color:red ">(.*)<\/span> \(<strong>(.*)<\/strong>%\) <div style="font-size:13px">Serious or Critical<\/div>/i', $html, $m)) {
			$data['critical'] = [
				'count' => (int)str_replace(',', '', $m[1]),
				'percent' => (int)str_replace(',', '', $m[2])
			];
		} else {
			$data['critical'] = [
				'count' => 0,
				'percent' => 0
			];
		}

		if(preg_match('/<div style="float:right; text-align:center"><span class="number-table"> (.*)<\/span> \(<strong>(.*)<\/strong>%\) <div style="font-size:13px">Deaths<\/div><br> <\/div>/i', $html, $m)) {
			$data['death'] = [
				'count' => (int)str_replace(',', '', $m[1]),
				'percent' => (int)str_replace(',', '', $m[2])
			];
		} else {
			$data['death'] = [
				'count' => 0,
				'percent' => 0
			];
		}

		if(preg_match('/<div style="float:left; text-align:center"> <span class="number-table" style="color:#8ACA2B">(.*)<\/span> \(<strong>(.*)<\/strong>%\) <div style="font-size:13px">Recovered \/ Discharged<\/div><br> <\/div>/i', $html, $m)) {
			$data['recovered'] = [
				'count' => (int)str_replace(',', '', $m[1]),
				'percent' => (int)str_replace(',', '', $m[2])
			];
		} else {
			$data['recovered'] = [
				'count' => 0,
				'percent' => 0
			];
		}

		return $data;
	}

	public function getCountries() {
		$date = [];

		$html = file_get_contents('https://www.worldometers.info/coronavirus/countries-where-coronavirus-has-spread/');
		if(preg_match('/<tbody>(.*)<\/tbody>/i', $html, $table)) {
			if(isset($table) && isset($table[1])) {
				$tr = explode('</tr>', $table[1]);
				foreach($tr as $key => $val) {
					if(preg_match('/<tr> <td style="font-weight: bold; font-size:16px; text-align:left; padding-left:5px; padding-top:10px; padding-bottom:10px">(.*)<\/td> <td style="font-weight: bold; text-align:right">(.*)<\/td> <td style="font-weight: bold; text-align:right">(.*)<\/td> <td style="font-size:14px; color:#aaa; text-align:right">(.*)<\/td>/i', trim($val), $country)) {
						$data[] = [
							'name' => $country[1],
							'cases' => (int)str_replace(',', '', $country[2]),
							'deaths' => (int)str_replace(',', '', $country[3]),
							'region' => $country[4]
						];
					}
				}
			}
		}

		return $data;
	}
}

?>