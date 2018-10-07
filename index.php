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

    public static function readCsv($fileName) {

        $f = fopen($fileName, "r");
        $rowCount = 1;
        echo "<tr>";
        while (($line = fgetcsv($f)) !== false) {
            echo "<tr>";
            foreach ($line as $cell) {
                echo "<td>" . $cell . "</td>";
                $rowCount++;
            }
            echo "</tr>";
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