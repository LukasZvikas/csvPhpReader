<?php

main::start("csvFile.csv");
class main  {
    static public function start($filename) {
        $records = csvFileReader::getRecords($filename);
    }
}

class html
{
    public static function generateRecordArray($records) {

        $recordArray = array();
        foreach ($records as $record) {
                array_push($recordArray, $record);
        }
        return $recordArray;
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