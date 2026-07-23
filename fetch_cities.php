<?php
$provincesUrl = 'https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json';
$provinces = json_decode(file_get_contents($provincesUrl), true);
$allRegencies = [];

if (is_array($provinces)) {
    foreach ($provinces as $prov) {
        $regenciesUrl = 'https://emsifa.github.io/api-wilayah-indonesia/api/regencies/' . $prov['id'] . '.json';
        $regencies = json_decode(file_get_contents($regenciesUrl), true);
        if (is_array($regencies)) {
            foreach ($regencies as $regency) {
                $name = ucwords(strtolower($regency['name']));
                $allRegencies[] = $name;
            }
        }
    }
}

sort($allRegencies);
file_put_contents('public/cities.json', json_encode($allRegencies));
echo 'Saved ' . count($allRegencies) . ' cities to public/cities.json';
