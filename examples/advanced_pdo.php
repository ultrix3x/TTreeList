<?php
include '../treelist.php';

// Create a map with a few character combinations
$map = array('as', 'be', 'ca', 'da', 'en', 'fo', 'gu', 'he', 'in', 'ja');

// Create a database (in memory)
$db = new PDO('sqlite::memory:');
$db->exec('CREATE TABLE testdata (id integer primary key, name string, dummy integer);');
// Create 1000 entries in the database by creating random character combinations
// based on the map defined earlier
for($i = 0; $i < 1000; $i++) {
  $value = '';
  for($j = 0; $j < 3; $j++) {
    $value .= $map[rand(0, 9)];
  }
  $db->exec('INSERT INTO testdata (name,dummy) VALUES (\''.$value.'\', '.rand(0,100).');');
}

// Execute a query that returns all 1000 entries
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

// Display the amount of nodes in the tree (this will probably be somwhere
// around 620-640 items)
echo "There is ".$tree->treeCount." nodes in the tree".PHP_EOL;

// Get the first node in the treelist
$node = $tree->GetFirst();
$count = 0;
// Walk through the treelist
while($node !== null) {
  $count++;
  echo $node['name'].' ';
  $node = $node->next;
}
echo PHP_EOL;
// Display how many nodes we have passed (should be equal to the treeCount)
echo "We walked ".$count." nodes".PHP_EOL;
?>