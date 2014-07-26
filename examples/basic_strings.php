<?php
include '../treelist.php';

// Create a TreeList
$tree = new TTreeList();

// Add some sample data to the tree
$tree->AddNode(array(1,"alfa"));
$tree->AddNode(array(2,"bravo"));
$tree->AddNode(array(3,"charlie"));
$tree->AddNode(array(4,"delta"));
$tree->AddNode(array(5,"echo"));
$tree->AddNode(array(6,"foxtrot"));
$tree->AddNode(array(7,"golf"));
$tree->AddNode(array(8,"hotel"));
$tree->AddNode(array(9,"india"));
$tree->AddNode(array(10,"juliett"));
$tree->AddNode(array(11,"delta"));
$tree->AddNode(array(12,"golf"));

// Check how many records we have
echo "The treelist has ".count($tree)." nodes".PHP_EOL;
// Loop the tree as an array
foreach($tree as $node) {
  echo ' '.$node[0].' - '.$node[1];
}
echo PHP_EOL;

// Build the tree and index it on the second index
echo "Building tree".PHP_EOL;
$tree->Build(1);

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