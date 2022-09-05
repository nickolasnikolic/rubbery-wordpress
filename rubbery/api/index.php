<?php

require './vendor/autoload.php';

$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
$cachefile = 'cached-' . substr_replace($file, "", -4) . '.json';
$cachetime = 60 * 100; // one minute

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    readfile($cachefile);
    exit;
}
$choices = array(
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=love&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=innovate&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=accept&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=kind&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=laughter&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=art&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=affection&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=music&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=speed&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=funny&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=free&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=freedom&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=choice&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=moral&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=morality&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=sex&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=sexual&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=[your_uid]&tokenid=[your_token_id]&term=sexuality&format=json",
);

$choice = array_rand($choices, 1);

ob_start(); // Start the output buffer

$client = new GuzzleHttp\Client();
$res = $client->request('GET', $choices[$choice]);
echo $res->getBody();

// Cache the contents to a cache file
$cached = fopen($cachefile, 'w');
fwrite($cached, ob_get_contents());
fclose($cached);

ob_end_flush(); // Send the output
