<?php

require './vendor/autoload.php';

$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
$cachefile = 'cached-' . substr_replace($file, "", -4) . '.json';
$cachetime = 60 * 1; // one minute

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    readfile($cachefile);
    exit;
}
$choices = array(
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=love&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=innovate&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=accept&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=kind&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=laughter&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=art&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=affection&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=music&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=speed&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=funny&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=free&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=freedom&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=choice&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=moral&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=morality&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=sex&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=sexual&format=json",
    "https://www.stands4.com/services/v2/poetry.php?uid=9662&tokenid=AYlUMKRRmjZJfqiK&term=sexuality&format=json",
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
