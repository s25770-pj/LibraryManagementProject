<!DOCTYPE html>
<html>
<head>
    <title>Kodowanie Huffmana</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Kodowanie Huffmana</h1>

    <form method="POST" action="">
        <label for="text">Tekst do zakodowania:</label>
        <input type="text" name="text" id="text" required>
        <button type="submit">Zakoduj</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        function countOccurrences($text) {
            $occurrences = array();
            $text = str_replace(' ', '', $text);
            $text = preg_replace('/[^a-zA-Z]/', '', $text);
            $length = strlen($text);
            
            for ($i = 0; $i < $length; $i++) {
                $char = $text[$i];
                if (isset($occurrences[$char])) {
                    $occurrences[$char]++;
                } else {
                    $occurrences[$char] = 1;
                }
            }
            
            return $occurrences;
        }

        function buildHuffmanTree($occurrences) {
            $nodes = array();
            foreach ($occurrences as $char => $count) {
                $nodes[] = array('char' => $char, 'count' => $count);
            }
            
            while (count($nodes) > 1) {
                usort($nodes, function($a, $b) {
                    return $a['count'] - $b['count'];
                });
                
                $left = array_shift($nodes);
                $right = array_shift($nodes);
                
                $parent = array(
                    'char' => null,
                    'count' => $left['count'] + $right['count'],
                    'left' => $left,
                    'right' => $right
                );
                
                $nodes[] = $parent;
            }
            
            return $nodes[0];
        }

        function generateCodes($node, $prefix = '') {
            $codes = array();
            
            if ($node['char'] !== null) {
                $codes[$node['char']] = $prefix;
            } else {
                $codes = array_merge(
                    generateCodes($node['left'], $prefix . '0'),
                    generateCodes($node['right'], $prefix . '1')
                );
            }
            
            return $codes;
        }

        function encodeText($text, $codes) {
            $encodedText = '';
            $length = strlen($text);

            for ($i = 0; $i < $length; $i++) {
                $char = $text[$i];
                if (isset($codes[$char])) {
                    $encodedText .= $codes[$char];
                }
            }

            return $encodedText;
        }

        function displayResults($occurrences, $codes, $encodedText) {
            echo '<h2>Wyniki:</h2>';
            echo '<table>';
            echo '<tr><th>Znak</th><th>Kod</th><th>Liczba wystąpień</th></tr>';

            foreach ($codes as $char => $code) {
                echo '<tr>';
                echo '<td>' . $char . '</td>';
                echo '<td>' . $code . '</td>';
                echo '<td>' . $occurrences[$char] . '</td>';
                echo '</tr>';
            }

            echo '</table>';

            echo '<h3>Zakodowany tekst:</h3>';
            echo '<p>' . $encodedText . '</p>';
        }
        

        $text = $_POST['text'];
        $occurrences = countOccurrences($text);
        $huffmanTree = buildHuffmanTree($occurrences);
        $codes = generateCodes($huffmanTree);
        $encodedText = encodeText($text, $codes);

        displayResults($occurrences, $codes, $encodedText);
    }
    ?>

</body>
</html>
