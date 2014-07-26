<?php
include '../treelist.php';

$db = new PDO('sqlite::memory:');
$db->exec('CREATE TABLE testdata (id integer primary key, name string);');
$db->exec('INSERT INTO testdata (name) VALUES (\'alfa\');');
$db->exec('INSERT INTO testdata (name) VALUES (\'bravo\');');
$db->exec('INSERT INTO testdata (name) VALUES (\'charlie\');');
$db->exec('INSERT INTO testdata (name) VALUES (\'delta\');');
$db->exec('INSERT INTO testdata (name) VALUES (\'echo\');');
$db->exec('INSERT INTO testdata (name) VALUES (\'foxtrot\');');
$db->exec('INSERT INTO testdata (name) VALUES (\'golf\');');
$db->exec('INSERT INTO testdata (name) VALUES (\'hotel\');');
$db->exec('INSERT INTO testdata (name) VALUES (\'india\');');
$db->exec('INSERT INTO testdata (name) VALUES (\'juliett\');');
$db->exec('INSERT INTO testdata (name) VALUES (\'delta\');');
$db->exec('INSERT INTO testdata (name) VALUES (\'golf\');');

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
}
?>