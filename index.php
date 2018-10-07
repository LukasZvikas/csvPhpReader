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

    public static function start($filename) {
        CsvReader::readCsv($filename);
    }
}


class CsvReader {

    public static function readCsv($fileName) {

        $f = fopen($fileName, "r");
        $rowCount = 1;
        while (($line = fgetcsv($f)) !== false) {

            foreach ($line as $cell) {
                echo "<td>" . $cell . "</td>";
                $rowCount++;
            }
        }
        fclose($f);
    }
}

?>