<!DOCTYPE html>
<html>
<head>
    <title>Directory Scanner</title>
    <style>
        /* CSS styles for the table */
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #dddddd;
        }

        /*Change the background color of the rows */
        .exists {
            background-color: #90EE90; /* Light Green */
        }

        .contains-secret {
            background-color: #FFFF00; /* Yellow */
        }

        .not-exists {
            background-color: #F08080; /* Light Coral */
        }
    </style>
</head>
<body>
    <h1>Directory Scanner</h1>
    <table>
        <tr>
            <th>URL</th>
            <th>Status</th>
        </tr>
       <?php

// Function to check if a directory exists and check if a specific pattern exists in the response
function checkDirectory($url, $pattern)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        if (preg_match($pattern, $output)) {
            return "Exists and contains the word 'secret'";
        } else {
            return "Exists";
        }
    } else {
        return "Does not exist";
    }
}

$wordlist = file("wordlist.txt"); // Read wordlist file
$base_url = "http://example.com/"; // Base URL to scan
$pattern = '/secret/i'; // Regular expression pattern to match

// Function call
foreach ($wordlist as $word) {
    $url = $base_url . $word;
    $status = checkDirectory($url, $pattern);
    echo $url . " : " . $status . "\n";
}
    </table>
</body>
</html>