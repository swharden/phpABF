"""

This script creates a folder which looks like an ABF analysis folder.

Output is complete with:
  - ABFs (dated today's date)
  - parent TIFs (randomized to approximate every Nth ABF)
  - analysis directory filled with JPGs of TIFs and simualted graphs
  - experiment.json

"""

import os
import sys
import glob
import time
import datetime
import random
import json


FOLDER_NAME_ANALYSIS = "_autoanalysis"
FILE_NAME_JSON = "_experiment.json"

path_here = os.path.dirname(__file__)

def createFakeAbfFolder(folderPath):
    """Create a folder that looks like an ABF folder (with empty ABFs)."""
    folderPath = os.path.abspath(folderPath)
    print(f"Creating fake ABF folder: {folderPath}")
    createOrClearFolder(folderPath)
    createFakeABFs(folderPath)
    createFakeAnalysisFolder(folderPath, FOLDER_NAME_ANALYSIS)
    createAbfFolderJson(folderPath)
    print("fake ABF folder complete!")


def createOrClearFolder(folderPath):
    """If the folder doesn't exist, create it. If it does, clean it out."""
    if os.path.exists(folderPath):
        print(f"clearing-out folder ...")
        deleteFilesInFolder(folderPath)
    else:
        print(f"creating folder ...")
        os.mkdir(folderPath)


def createFakeABFs(folderPath, abfCount=150, parentEvery=7, createToo=True):
    abfPaths = []
    for i in range(abfCount):
        now = datetime.datetime.now()
        abfID = "%02d%s%02d%03d" % (now.year - 2000, now.month, now.day, i)
        assert len(abfID) == 8
        abfFileName = abfID + ".abf"
        abfParentFileName = abfID + ".tif"
        abfPaths.append(os.path.join(folderPath, abfFileName))
        if parentEvery and int(random.random()*parentEvery) == 0:
            abfPaths.append(os.path.join(folderPath, abfParentFileName))
    abfPaths = sorted(abfPaths)
    if createToo:
        createFakeFiles(abfPaths)
    return abfPaths


def createFakeFile(fakeFilePath):
    # TODO: make smart enough to use real JPEGs
    with open(fakeFilePath, 'w') as f:
        f.write("fake file")


def createFakeFiles(fakeFilePaths):
    print(f"creating {len(fakeFilePaths)} fake files ...")
    for filePath in sorted(fakeFilePaths):
        createFakeFile(filePath)


def deleteFilesInFolder(folderPath):
    filesToDelete = glob.glob(folderPath+"/*.*")
    print(f"deleting {len(filesToDelete)} files ...")
    for fileToDelete in filesToDelete:
        os.remove(fileToDelete)


def createFakeAnalysisFolder(folderPath, subFolderName, analysesPerFile=5):
    subFolderPath = os.path.join(folderPath, subFolderName)
    if os.path.exists(subFolderPath):
        print(f"clearing-out {subFolderName} folder ...")
        deleteFilesInFolder(subFolderPath)
    else:
        print(f"creating {subFolderName} folder ...")
        os.mkdir(subFolderPath)
    analysisFilePaths = []
    for fname in glob.glob(folderPath+"/*.*"):
        abfBasename = os.path.basename(fname)
        pathSourceInSubfldr = os.path.join(subFolderPath, abfBasename)
        pathNewFile = False
        if (pathSourceInSubfldr.endswith(".abf")):
            for i in range(analysesPerFile):
                pathNewFile = "%s.graph_%03d.jpg" % (pathSourceInSubfldr, i)
        elif (pathSourceInSubfldr.endswith(".tif")):
            pathNewFile = "%s.jpg" % (pathSourceInSubfldr)
        analysisFilePaths.append(pathNewFile)
    print(f"creating {len(analysisFilePaths)} fake analysis files ...")
    createFakeFiles(analysisFilePaths)


def getJsonString(dictionary, tight=False):
    if tight:
        return getJsonTight(dictionary)
    else:
        return getJsonPretty(dictionary)


def getJsonPretty(jsonData):
    if isinstance(jsonData, str):
        jsonData = json.loads(jsonData)
    return json.dumps(jsonData, sort_keys=True, indent=4)


def getJsonTight(jsonData):
    if isinstance(jsonData, str):
        jsonData = json.loads(jsonData)
    return json.dumps(jsonData, sort_keys=True)


def getParentAbfPaths(folderPath):
    pathsTif = glob.glob(os.path.join(folderPath, "*.tif"))
    pathsAbf = glob.glob(os.path.join(folderPath, "*.abf"))
    parentIDs = []
    for pathTif in pathsTif:
        maybePathAbf = pathTif[:-4]+".abf"
        if maybePathAbf in pathsAbf:
            parentIDs.append(os.path.basename(maybePathAbf))
    return sorted(parentIDs)


def createAbfFolderJson(folderPath, pretty=True):
    colors = 'green', 'gray', 'red', 'yellow', 'none', 'blue'

    abfNotes = []
    for parentAbfPath in getParentAbfPaths(folderPath):
        abfID = os.path.basename(parentAbfPath)[:-4]
        abfNote = {}
        abfNote["abfID"] = abfID
        abfNote["color"] = random.choice(colors)
        abfNote["comment"] = f"comment about {abfID} or something"
        abfNote["group"] = "group %d" % (random.randint(0, 3))
        time.sleep(random.random()/1000.0)
        abfNotes.append(abfNote)

    experiment = {}
    experiment['type'] = 'abf folder'
    experiment['internal'] = 'k-glu (54 mM Cl)'
    experiment['bath'] = 'ACSF +DNQX+AP5'
    experiment['project'] = 'demonstrations'
    experiment['goalSentence'] = 'demonstrate how to isolate IPSCs'
    experiment['notes'] = ('blah ' * 123).strip()

    data = {}
    data['experiment'] = experiment
    data['created'] = str(datetime.datetime.now())
    data['modified'] = str(datetime.datetime.now())
    data['abfNotes'] = abfNotes

    jsonStringFull = getJsonString(data)
    jsonStringTight = getJsonString(data, True)
    jsonInfo = f"pretty jason string is {len(jsonStringFull)} characters"
    jsonInfo += f" ({len(jsonStringTight)} if tight)"
    print(jsonInfo)

    jsonFilePath = os.path.join(folderPath, FILE_NAME_JSON)
    with open(jsonFilePath, 'w') as f:
        if pretty:
            print(f"writing pretty json file ...")
            f.write(jsonStringFull)
        else:
            print(f"writing tight json file ...")
            f.write(jsonStringTight)


if __name__ == "__main__":
    fakeFolderPath = os.path.abspath(os.path.join(path_here, "fake-folder"))
    input("press ENTER to delete old files and create new ones...")
    createFakeAbfFolder(fakeFolderPath)
    print("DONE")
