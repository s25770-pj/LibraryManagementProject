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
        // Funkcja do zliczania częstości wystąpień znaków
        function countOccurrences($text) {
            $occurrences = array();
            $text = str_replace(' ', '', $text); // Usunięcie spacji
            $text = preg_replace('/[^a-zA-Z]/', '', $text); // Usunięcie znaków niebędących literami
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

        // Funkcja do budowania drzewa Huffmana
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

        // Funkcja do generowania kodów dla znaków
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


        // Funkcja do wyświetlania wyników
        function displayResults($occurrences, $codes) {
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
        }
        

        $text = $_POST['text'];
        $occurrences = countOccurrences($text);
        $huffmanTree = buildHuffmanTree($occurrences);
        $codes = generateCodes($huffmanTree);

        // foreach ($codes as &$code)
        // {
        //     if(strlen($code) < count($codes))
        //     {
        //         $code=str_repeat('0',(count($codes)-strlen($code)-2)).$code;
        //     }
            
        // }

        displayResults($occurrences, $codes);
    }
    
    ?>
</body>
</html>