<?php
include '../treelist.php';

// Create a TreeList
$tree = new TTreeList();

// Add some sample data to the tree
$tree->AddNode(array(
  'id' => 1,
  'name' => 'alfa'
));
$tree->AddNode(array(
  'id' => 2,
  'name' => 'bravo'
));
$tree->AddNode(array(
  'id' => 3,
  'name' => 'charlie'
));
$tree->AddNode(array(
  'id' => 4,
  'name' => 'delta'
));
$tree->AddNode(array(
  'id' => 5,
  'name' => 'echo'
));
$tree->AddNode(array(
  'id' => 6,
  'name' => 'foxtrot'
));
$tree->AddNode(array(
  'id' => 7,
  'name' => 'golf'
));
$tree->AddNode(array(
  'id' => 8,
  'name' => 'hotel'
));
$tree->AddNode(array(
  'id' => 9,
  'name' => 'india'
));
$tree->AddNode(array(
  'id' => 10,
  'name' => 'juliett'
));
$tree->AddNode(array(
  'id' => 11,
  'name' => 'delta'
));
$tree->AddNode(array(
  'id' => 12,
  'name' => 'golf'
));

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