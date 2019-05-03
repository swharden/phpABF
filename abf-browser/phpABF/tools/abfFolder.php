<?php

class AbfFolder
{
    public $logger;

    public $path;
    public $filenames;
    public $filenamesAbf = array();
    public $filenamesNonAbf = array();
    public $analysisFolder;
    public $analysisFilenames;

    public $parents; // an array of parent filenames
    public $childrenOfParents; // every key (parent) has an array (children)
    public $parentsOfChildren; // every key (child) has a single value (parent)

    public function __construct($path)
    {
        if (file_exists($path) && is_dir($path)) {
            $this->path = abspath($path);
            $this->analysisFolder = abspath("$path/" . phpABFconfig::GetAnalysisFolderName());
            $this->logger = new Logger("path");
            $this->logger->Message("loading folder: $this->path");
            $this->ScanFolder();
            $this->DetermineParents();
        } else {
            throw new Exception("does not exist: $path");
        }
    }

    public function ScanFolder()
    {
        $this->logger->Message("scanning ABF folder ...");
        $this->filenames = array_slice(scandir($this->path), 2);
        sort($this->filenames);
        foreach ($this->filenames as $filename) {
            $filePath = $this->path . DIRECTORY_SEPARATOR . $filename;
            if (StringTools::EndsWith(strtolower($filename), ".abf")) {
                $this->filenamesAbf[] = $filename;
            } else {
                $this->filenamesNonAbf[] = $filename;
            }
        }
        $countMessage = "found " . count($this->filenames) . " files";
        $countMessage .= " (" . count($this->filenamesAbf) . " ABFs";
        $countMessage .= " and " . count($this->filenamesNonAbf) . " non-ABF)";
        $this->logger->Message($countMessage);

        $this->logger->Message("scanning analysis folder ...");
        if (file_exists($this->analysisFolder) && is_dir($this->analysisFolder)) {
            $this->analysisFilenames = scandir($this->path);
            $countMessage = "found " . count($this->analysisFilenames) . " analysis files";
            $this->logger->Message($countMessage);
        } else {
            $this->logger->Message("analysis folder not found: " . $this->analysisFolder);
        }
    }

    public function DetermineParents()
    {
        // DEFINING A PARENT:
        //  * a file ID is the filename without the extension
        //  * if a non-abf file ID starts with an abf ID, that abf is a parent.
        $this->logger->Message("identifying parent ABFs ...");
        $parentFilenames = array();
        $nonAbfCsv = ",," . join(",", $this->filenamesNonAbf);
        foreach ($this->filenamesAbf as $fname) {
            $abfID = StringTools::GetFilenameWithoutExtension($fname);
            if (strstr($nonAbfCsv, $abfID)) {
                $parentFilenames[] = $fname;
            }
        }
        $parentCount = count($parentFilenames);

        $this->logger->Message("matching parents with children...");
        $parent = "orphan";
        foreach ($this->filenamesAbf as $child) {
            if (in_array($child, $parentFilenames)) {
                $parent = $child;
            }
            $this->parents[] = $parent;
            $this->parentsOfChildren[$child] = $parent;
            $this->childrenOfParents[$parent][] = $child;
        }
        $childCount = count($this->filenamesAbf) - $parentCount;
        $this->logger->Message("matched $parentCount parents with $childCount children");
    }

    public function GetJson()
    {
        $values = array();
        $values['path'] = $this->path;
        $values['filenames'] = $this->filenames;
        $values['filenamesAbf'] = $this->filenamesAbf;
        $values['analysisFolder'] = $this->analysisFolder;
        $values['analysisFilenames'] = $this->analysisFilenames;
        $values['parents'] = $this->parents;
        $values['childrenOfParents'] = $this->childrenOfParents;
        $values['parentsOfChildren'] = $this->parentsOfChildren;
        $json = Json::EncodeTight($values);
        $jsonSize = strlen($json);
        $this->logger->Message("encoded AbfFolder into $jsonSize bytes of JSON");
        return $json;
    }

}
