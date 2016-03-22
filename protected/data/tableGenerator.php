<?php

require __DIR__ . "/../yii.php";

class Application extends CConsoleApplication {
    public function processRequest() {
        $protectedDir = realpath(__DIR__ . "/../");
        foreach (Yii::app()->new_cms->schema->tables as $name => $tableSchema) {
            $classname = join(array_map("ucfirst", array_map("strtolower", explode("_", $name))));
            $filename = "{$protectedDir}/tables/newh/{$classname}.php";

            fprintf(STDERR, "Processing {$filename} ...\n");

            $file = "";
            $file .= "<?php\n";
            $file .= "\n";
            $file .= "class {$classname} extends ActiveRecord {\n";
            $file .= "\n";

            foreach ($tableSchema->columns as $column) {
                $file .= "    public \${$column->name};";
                if ($column->comment) {
                    $file .= " // {$column->comment}";
                }
                $file .= "\n";
            }
            $file .= "\n";
            $file .= "    // DO NOT CHANGE THIS LINE: HUMAN_DEFINED_METHODS_BEGIN\n";
            if (file_exists($filename)) {
                $in = false;
                $fp = fopen($filename, "r");
                while (!feof($fp)) {
                    $line = fgets($fp);
                    if (strpos($line, "HUMAN_DEFINED_METHODS_") != false) {
                        $in = (strpos($line, "HUMAN_DEFINED_METHODS_BEGIN") != false);
                    } else {
                        if ($in) {
                            $file .= $line;
                        }
                    }
                }
                fclose($fp);
            }
            $file .= "    // DO NOT CHANGE THIS LINE: HUMAN_DEFINED_METHODS_END\n";
            $file .= "\n";
            $file .= "    // MetaData below\n";
            $file .= "\n";

            $table = get_object_vars($tableSchema);
            unset($table["columns"]);
            unset($table["foreignKeys"]);
            $tableReflection = new ReflectionClass("CDbTableSchema");
            foreach (array_keys($table) as $key) {
                if (! $tableReflection->hasProperty($key)) {
                    unset($table[$key]);
                }
            }
            $tableExport = var_export($table, TRUE);
            $tableExport = str_replace("\n", "\n    ", $tableExport);

            $file .= "    protected \$_table = {$tableExport};\n";
            $file .= "\n";

            $columns = array();
            $columnReflection = new ReflectionClass("CDbColumnSchema");
            foreach ($tableSchema->columns as $columnName => $columnObject) {
                $column = get_object_vars($columnObject);
                foreach (array_keys($column) as $key) {
                    if (! $columnReflection->hasProperty($key)) {
                        unset($column[$key]);
                    }
                }
                $columns[] = $column;
            }
            $columnsExport = var_export($columns, TRUE);
            $columnsExport = preg_replace("/\\n  \\d+ => /", "", $columnsExport);
            $columnsExport = str_replace("\n", "\n    ", $columnsExport);

            $file .= "    protected \$_columns = {$columnsExport};\n";
            $file .= "\n";

            foreach ($tableSchema->columns as $column) {
                $file .= "    const " . strtoupper($column->name) . " = \"" . addslashes($column->name) . "\";\n";
            }
            $file .= "\n";

            $file .= "}\n";
            file_put_contents($filename, $file);
        }
    }

}

Yii::createApplication("Application")->run();


