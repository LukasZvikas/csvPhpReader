<?php

main::start("csvFile.csv");
class main  {
    static public function start($filename) {
        $records = csvFileReader::getRecords($filename);
        html::bootstrapTemplate($records);

    }
}

class printer {
    public static function echoString($string) {
        echo $string;
    }
}

class recordsGenerator {
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
    public static function rowGenerator($array)
    {

        $count = 0;

        foreach ($array as $item) {
            printer::echoString("<tr>");
            self::cellGenerator($item, $count);
            printer::echoString("</tr>");

            $count++;
        }

    }

    public static function cellGenerator($item, $count) {

        foreach ($item as $i) {

            if ($count == 0) {
                $th = "<th>" . $i . "</th>";
                printer::echoString($th);

            }
            else {
                $td = "<td>" . $i . "</td>";
                printer::echoString($td);
            }
        }
    }


    public static function bootstrapTemplate($record) {

        printer::echoString(
            "<html>
                        <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\">
                        <body>
                            <table class='table table-striped'>\n\n"
        );
        self::rowGenerator(recordsGenerator::generateRecordArray($record));
        printer::echoString( "\n</table></body></html>");
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
class record {
    public function __construct(Array $fieldNames = null, $values = null )
    {
        $record = array_combine($fieldNames, $values);
        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }
    }
    public function returnArray() {
        $array = (array) $this;
        return $array;
    }
    public function createProperty($name, $value) {
        $this->{$name} = $value;
    }
}

class recordFactory {
    public static function create(Array $fieldNames = null, Array $values = null) {
        $record = new record($fieldNames, $values);
        return $record;
        }
}

?>