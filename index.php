<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 10/7/18
 * Time: 6:22 PM
 */

$csvFile = 'csvFile.csv';

Main::start($csvFile);

class Main {

    public static function start($fileName) {
        TableBuilder::buildHtmlTable($fileName);
    }
}


class CsvReader {

    public static function getColumnArray($line) {
        $wordsPerLine = count($line);
        $columnArray  = array();
        $wordCount    = 1;
        while ($wordCount <= $wordsPerLine) {
            $item = "<th>" . "Column" . " " . $wordCount . "</th>";
            array_push($columnArray, $item);
            $wordCount++;
        }
        return $columnArray;
    }

    public static function readCsv($fileName) {

        $f = fopen($fileName, "r");
        $rowCount = 1;
        while (($line = fgetcsv($f)) !== false) {

            $columns = self::getColumnArray($line);

            if ($rowCount == 1) {
                echo "<tr>";
                foreach ($columns as $column) {
                    echo $column;
                }
                echo "</tr>";
            } else
                echo '<tr>';

            foreach ($line as $cell) {
                echo "<td>" . $cell . "</td>";
                $rowCount++;
            }
            echo "</tr>\n";
        }
        fclose($f);
    }
}

class TableBuilder {

    public static function buildHtmlTable($fileName)
    {
        echo "<html>
                <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\">
                <body>
                    <table class='table table-striped'>\n\n";
                    CsvReader::readCsv($fileName);
        echo "\n</table></body></html>";
    }
}

?>