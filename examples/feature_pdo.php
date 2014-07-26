<?php
include '../treelist.php';

$db = new PDO('sqlite::memory:');
$db->exec('CREATE TABLE testdata (id integer primary key, name string, dummy integer);');
$db->exec('INSERT INTO testdata (name,dummy) VALUES (\'alfa\', 9);');
$db->exec('INSERT INTO testdata (name,dummy) VALUES (\'bravo\', 2);');
$db->exec('INSERT INTO testdata (name,dummy) VALUES (\'charlie\', 8);');
$db->exec('INSERT INTO testdata (name,dummy) VALUES (\'delta\', 7);');
$db->exec('INSERT INTO testdata (name,dummy) VALUES (\'echo\', 2);');
$db->exec('INSERT INTO testdata (name,dummy) VALUES (\'foxtrot\', 4);');
$db->exec('INSERT INTO testdata (name,dummy) VALUES (\'golf\', 8);');
$db->exec('INSERT INTO testdata (name,dummy) VALUES (\'hotel\', 2);');
$db->exec('INSERT INTO testdata (name,dummy) VALUES (\'india\', 1);');
$db->exec('INSERT INTO testdata (name,dummy) VALUES (\'juliett\', 7);');
$db->exec('INSERT INTO testdata (name,dummy) VALUES (\'delta\', 5);');
$db->exec('INSERT INTO testdata (name,dummy) VALUES (\'golf\', 3);');

$rs = $db->query('SELECT * FROM testdata', PDO::FETCH_ASSOC);

// Create a TreeList
$tree = new TTreeList();
// Assign the result of the database query as the data content for the tree
$tree->AssignPDO($rs);

// Check how many records we have
echo "The treelist has ".count($tree)." nodes".PHP_EOL;
// Loop the tree as an array
foreach($tree as $node) {
  echo ' '.$node["id"].' - '.$node["name"];
}
echo PHP_EOL;

// Add an anonymous function as a filter when building the tree
$tree->AddBuildFilter(function($node) {
  if($node['name'] == 'alfa') {
    return false;
  }
  if($node['name'] == 'bravo') {
    return false;
  }
  return true;
});

// Build the tree and index it on the name field
echo "Building tree".PHP_EOL;
$tree->Build('name');

// Display the amount of nodes in the tree (returns 10 since we have two 
// duplicates)
echo "There is ".$tree->treeCount." nodes in the tree".PHP_EOL;

// Locate a node in the tree
$node = $tree->Seek("delta");
// If we found a match then display it
if($node !== null) {
  echo "Found match".PHP_EOL;
  // Display the number of nodes that matches the search
  echo "The match has ".$node->PayloadCount()." data nodes".PHP_EOL;
  // Loop through all matches found
  foreach($node->PayloadKeys() as $key) {
    echo "Setting active payload to ".$key.PHP_EOL;
    // Set the active payload by index
    $node->SetActivePayload($key);
    // Display the active payload
    foreach($node as $nodeKey => $nodeValue) {
      echo $nodeKey;
      echo ' - ';
      echo $nodeValue;
      echo PHP_EOL;
    }
  }
}
?>