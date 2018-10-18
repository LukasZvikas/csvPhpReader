<?php
main::start("csvFile.csv");
class main {
    static public function start($filename) {
        $records = csvFileReader::getRecords($filename);
        staticHtml::bootstrapTemplate($records);
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
class staticHtml
{

    public static function trTagGeneratorStart()
    {
        printer::echoString( "<tr>");
    }

    public static function trTagGeneratorEnd()
    {
        printer::echoString( "</tr>");
    }

    public static function tableTagGenerator($type, $item)
    {
        printer::echoString( "<" . $type . ">" . $item . "</" . $type . " >");
    }

    public static function bootstrapLinkGenerator() {
        printer::echoString( "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\">");
    }
    public static function htmlTagGeneratorStart(){
        printer::echoString( "<html>");
    }
    public static function htmlTagGeneratorEnd(){
        printer::echoString( "</html>");
    }
    public static function bodyTagGeneratorStart(){
        printer::echoString( "<body>");
    }
    public static function bodyTagGeneratorEnd(){
        printer::echoString( "</body>");
    }
    public static function tableTagGeneratorStart()
    {
        printer::echoString( "<table class='table table-striped'>\n\n");
    }
    public static function tableTagGeneratorEnd()
    {
        printer::echoString( "</table>");
    }
    public static function bootstrapTemplate($record) {
        self::htmlTagGeneratorStart();
        self::bootstrapLinkGenerator();
        self::bodyTagGeneratorStart();
        self::tableTagGeneratorStart();
        dynamicHtmlGenerator::rowGenerator(recordsGenerator::generateRecordArray($record));
        self::tableTagGeneratorEnd();
        self::bodyTagGeneratorEnd();
        self::htmlTagGeneratorEnd();

    }
}

class dynamicHtmlGenerator {
    public static function rowGenerator($array) {
        $count = 0;
        foreach ($array as $item) {
            //I dont use tableTagGenerator here because it echoes the same color rows if I use it
            staticHtml::trTagGeneratorStart();
            self::cellGenerator($item, $count);
            staticHtml::trTagGeneratorEnd();
            $count++;
        }
    }
    public static function cellGenerator($item, $count) {
        foreach ($item as $i) {
            if ($count == 0) {
                staticHtml::tableTagGenerator("th", $i);
            } else {
                staticHtml::tableTagGenerator("td", $i);
            }
        }
}

}
class csvFileReader {
    static public function getRecords($filename) {
        $file = fopen($filename, "r");
        $fieldNames = array();
        $count = 0;
        while (!feof($file)) {
            $record = fgetcsv($file);
            if ($count == 0) {
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
    public function __construct(Array $fieldNames = null, $values = null) {
        $record = array_combine($fieldNames, $values);
        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }
    }
    public function returnArray() {
        $array = (array)$this;
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