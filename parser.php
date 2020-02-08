<?php

class WmParser {
	public function getCases() {
		$data = [];

		$html = file_get_contents('https://www.worldometers.info/coronavirus/');
		if(preg_match('/<div class="maincounter-number"> <span style="color:#aaa">(.*)<\/span><\/div>/i', $html, $m)) {
			$data['infected'] = (int)str_replace(',', '', $m[1]);
		} else {
			$data['infected'] = -1;
		}

		if(preg_match('/of which <span style="font-size:22px; font-weight:bold; color:red">(.*)<\/span> <br> in <strong>severe condition<\/strong>/i', $html, $m)) {
			$data['critical'] = (int)str_replace(',', '', $m[1]);
		} else {
			$data['critical'] = -1;
		}

		if(preg_match('/<h1>Deaths:<\/h1> <div class="maincounter-number"> <span>(.*)<\/span> <\/div><\/div> <div id="maincounter-wrap" style="margin-top:15px;">/i', $html, $m)) {
			$data['death'] = (int)$m[1];
		} else {
			$data['death'] = -1;
		}

		if(preg_match('/<h1>Recovered:<\/h1> <div class="maincounter-number" style="color:#8ACA2B "> <span>(.*)<\/span>/i', $html, $m)) {
			$data['recovered'] = (int)str_replace(',', '', $m[1]);
		} else {
			$data['recovered'] = -1;
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