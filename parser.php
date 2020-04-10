<?php

class WmParser {
	public function getCases() {
		$data = [];

		$html = file_get_contents('https://www.worldometers.info/coronavirus/coronavirus-cases/');

		$data['total'] = 0;

		if(preg_match('/<tr><td><strong>Currently Infected<\/strong> <br><\/td><\/tr><tr><td><div class="number-table">(.*)<\/div><\/td><\/tr><tr><td>Mild Condition <\/td>/i', $html, $m)) {
			$data['currently'] = (int)str_replace(',', '', $m[1]);
		} else {
			$data['currently'] = 0;
		}

		if(preg_match('/<tr><td><strong>Cases with Outcome<\/strong><\/td><\/tr><tr><td><div class="number-table">(.*)<\/div><\/td><\/tr>/i', $html, $m)) {
			$data['outcome'] = (int)str_replace(',', '', $m[1]);
		} else {
			$data['outcome'] = 0;
		}

		$data['total'] = $data['currently'] + $data['outcome'];

		if(preg_match('/<tr><td>Mild Condition <\/td><\/tr><tr><td><div class="number-table">(.*)<\/div>\((\d+)%\)<\/td><\/tr><tr><td>Serious or Critical <\/td>/i', $html, $m)) {
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

		if(preg_match('/<tr><td>Serious or Critical <\/td><\/tr><tr><td><div class="number-table">(.*)<\/div>\((\d+)%\)<\/td><\/tr><\/table><\/div><\/div>/i', $html, $m)) {
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

		if(preg_match('/<tr><td>Deaths<\/td><\/tr><tr><td><div class="number-table">(.*)<\/div> \((\d+)%\)<\/td><\/tr><\/table><\/div><\/div><\/div>/i', $html, $m)) {
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

		if(preg_match('/<\/div><\/td><\/tr><tr><td>Recovered\/Discharged<\/td><\/tr><tr><td><div class="number-table">(.*)<\/div> \((\d+)%\)<\/td><\/tr><tr><td>Deaths<\/td><\/tr>/i', $html, $m)) {
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