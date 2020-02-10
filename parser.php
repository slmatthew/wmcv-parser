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

		if(preg_match('/<td><strong>Currently Infected<\/strong> <br><\/td> <\/tr> <tr> <td><div class="number-table-main">(.*)<\/div> <\/td>/i', $html, $m)) {
			$data['currently'] = (int)str_replace(',', '', $m[1]);
		} else {
			$data['currently'] = 0;
		}

		if(preg_match('/<td><strong>Cases with Outcome<\/strong><\/td> <\/tr> <tr> <td><div class="number-table-main">(.*)<\/div><\/td>/i', $html, $m)) {
			$data['outcome'] = (int)str_replace(',', '', $m[1]);
		} else {
			$data['outcome'] = 0;
		}

		if(preg_match('/<td style="background-color:#66CCFF; color:white"><div class="number-table">(.*)<\/div> \(<strong>(.*)%<\/strong> of currently infected\)<\/td>/i', $html, $m)) {
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

		if(preg_match('/<tr> <td style="background-color:#FF9900; color:white"><div class="number-table">(.*)<\/div> \(<strong>(.*)%<\/strong> of currently infected\) <\/td> <\/tr>/i', $html, $m)) {
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

		if(preg_match('/<td style="background-color:black; color:white "><div class="number-table">(.*)<\/div> \(<strong>(.*)%<\/strong> of cases with outcome\) <\/td>/i', $html, $m)) {
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

		if(preg_match('/<td>Recovered\/Discharged<\/td> <\/tr> <tr> <td style="background-color:#8ACA2B; color:white"><div class="number-table">(.*)<\/div> \(<strong>(.*)%<\/strong> of cases with outcome\) <\/td> <\/tr><\/table><\/div><div class="visible-xs" style="margin-top:20px;"><\/div><div class="table-responsive" style="font-size:16px; margin: auto; width:100%; text-align:center"> <table class="table table-striped table-bordered" cellspacing="0"> <tr> <td>Deaths<\/td>/i', $html, $m)) {
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