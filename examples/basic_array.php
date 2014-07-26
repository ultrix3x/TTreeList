<?php
include '../treelist.php';

// Create a sample array with some data
$data = array();
$data[] = array(
  'id' => 1,
  'name' => 'alfa'
  );
$data[] = array(
  'id' => 2,
  'name' => 'bravo'
  );
$data[] = array(
  'id' => 3,
  'name' => 'charlie'
  );
$data[] = array(
  'id' => 4,
  'name' => 'delta'
  );
$data[] = array(
  'id' => 5,
  'name' => 'echo'
  );
$data[] = array(
  'id' => 6,
  'name' => 'foxtrot'
  );
$data[] = array(
  'id' => 7,
  'name' => 'golf'
  );
$data[] = array(
  'id' => 8,
  'name' => 'hotel'
  );
$data[] = array(
  'id' => 9,
  'name' => 'india'
  );
$data[] = array(
  'id' => 10,
  'name' => 'juliett'
  );
$data[] = array(
  'id' => 11,
  'name' => 'delta'
  );
$data[] = array(
  'id' => 12,
  'name' => 'golf'
  );

// Create a TreeList
$tree = new TTreeList();
// Assing the the array to the TreeList
$tree->AssignArray($data);

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

// Display the amount of nodes in the tree (this will probably be somwhere
// around 620-640 items)
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