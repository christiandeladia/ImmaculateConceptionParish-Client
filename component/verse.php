<?php

function readQuotesFromFile($filename) {
    $quotes = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return $quotes;
}


function getRandomQuote($quotes) {
    $index = array_rand($quotes);
    return $quotes[$index];
}


function extractQuoteAndAuthor($combinedString) {
    list($quote, $author) = explode(' - ', $combinedString, 2);
    return array('quote' => trim($quote, '"'), 'author' => trim($author));
}


$filename = './component/verse.txt';
$rawQuotes = readQuotesFromFile($filename);
$quotes = array_map('extractQuoteAndAuthor', $rawQuotes);
$dayOfYear = date('z');

srand($dayOfYear);
$verseOfTheDay = getRandomQuote($quotes);

// echo '<p>Quote of the day:</p>';
// echo '<blockquote>' . $verseOfTheDay['quote'] . '<footer>' . $verseOfTheDay['author'] . '</footer></blockquote>';
?>
