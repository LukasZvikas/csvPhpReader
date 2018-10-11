<?php

main::start("csvFile.csv");
class main  {
    static public function start($filename) {
        $records = csvFileReader::getRecords($filename);
    }
}

class records {
    public static function generateRecordArray($records) {

        $recordArray = array();
        foreach ($records as $record) {
            array_push($recordArray, $record);
        }
        return $recordArray;
    }
}

class html
{
    public static function templateGenerator($array)
    {
        $count = 0;

        foreach ($array as $item) {
            echo "<tr>";
            foreach ($item as $i) {
                if ($count == 0)
                    echo "<th>" . $i . "</th>";
                else
                    echo "<td>" . $i . "</td>";
            }
            $count++;
        }
        echo "</tr>";
    }
}

class csvFileReader {
    static public function getRecords($filename) {
        $file = fopen($filename,"r");
        $fieldNames = array();
        $count = 0;
        while(! feof($file))
        {
            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }
        fclose($file);
        return $records;
    }
}

class recordFactory {
    public static function create(Array $fieldNames = null, Array $values = null) {
        $record = new record($fieldNames, $values);
        return $record;
        }
}

?>