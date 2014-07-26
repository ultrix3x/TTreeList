TTreeList
=========
TreeList is a hybrid between a double linked list and a binary tree.

class TTreeList
===============
Properties
  TTreeNode root
    returns the root node of the tree if the tree isn't dirty

  TTreeNode first
    returns the first node of the linked list if the tree isn't dirty

  TTreeNode last
    returns the last node of the linked list if the tree isn't dirty

  TTreeNode treeCount (alternative name treecount)
    returns the number of nodes in the tree if the three isn't dirty

  boolean isDirty (alternative name isdirty)
    returns the dirty state. Returns true if a node has been added since the
    last build.

Functions
  AssignPDO(PDOStatement)
    Assigns the dataset from an PDOStatement as the data nodes

  AssignArray(array)
    Assigns the array as the data nodes. The array must be an array of arrays.

  TTreeNode GetRoot()
    returns the root node of the tree if the tree isn't dirty.

  TTreeNode GetFirst()
    returns the first node of the linked list if the tree isn't dirty.

  TTreeNode GetLast()
    returns the last node of the linked list if the tree isn't dirty.

  AddNode(mixed)
    Add a new node to the data nodes

  Clear()
    Clear tree properties.

  Clean()
    Clear tree properties and empties the data nodes.

  AddBuildFilter(function)
    Add a filter functions that is called then a build is performed.
    The function should accept a TTreeNode as an argument and return a boolean
    value. True will accept the current node and false will reject the current
    node.

  ClearBuildFilter()
    Removes all filter functions.

  TTreeNode Build(string)
    Builds a tree based on the index defined by the argument.

  TTreeNode Seek(string)
    Locates a node in the tree which matches the argument.
    Returns a TTreeNode if a match is found or null if no match found.

Supporting functions for implemented interfaces (not documented here)
  count
  serialize
  unserialize
  offsetExists
  offsetGet
  offsetSet
  offsetUnset
  current
  key
  next
  rewind
  valid

class TTreeData
===============

Properties
  array data (read-only)
    array data for the object

Functions
  array ClonedData()
    makes a copy of the data in the object

  array GetKeys()
    get an array with the keys of the contained data

Supporting functions for implemented interfaces (not documented here)
  count
  current
  key
  next
  offsetExists
  offsetGet
  offsetSet
  offsetUnset
  rewind
  serialize
  unserialize
  valid

class TTreeNode
===============

Properties
  string key
    contains the value for which the node is indexed in the tree/linked list

  TTreeNode prev (read-only)
    returns the previous node in the linked list

  TTreeNode left (read-only)
    returns the left node in the tree

  TTreeNode parent (read-only)
    returns the parent node in the tree

  TTreeNode right (read-only)
    returns the right node in the tree

  TTreeNode next (read-only)
    returns the next node in the linked list

Functions
  AddPayload(TTreeNode)
    add another node to this node. This is done when the build function finds
    a duplicate value

  integer PayloadCount()
    returns the number of data carrying nodes in this node

  array PayloadKeys()
    returns an array containing the indexes for the available data carrying
    nodes

  SetActivePayload(mixed)
    Set the index representing the data carrying node in the payload array.
    The index must exist. Otherwise the payload is not changed.

  SetPrev(TTreeNode, boolean $doReverse = true)
    Set the previous node for the linked list.
    If the second argument (doReverse) is set to true then the node
    automatically sets the next value for the added node.

  SetLeft(TTreeNode, boolean $doReverse = true)
    Set the left node for the tree node.
    If the second argument (doReverse) is set to true then the node
    automatically sets the parent value for the added node.

  SetParent(TTreeNode, boolean $doReverse = true)
    Set the parent node for the tree node.
    If the second argument (doReverse) is set to true then nothing happend (yet)

  SetRight(TTreeNode, boolean $doReverse = true)
    Set the right node for the tree node.
    If the second argument (doReverse) is set to true then the node
    automatically sets the parent value for the added node.

  SetNext(TTreeNode, boolean $doReverse = true)
    Set the next node for the linked list.
    If the second argument (doReverse) is set to true then the node
    automatically sets the prev value for the added node.

Supporting functions for implemented interfaces (not documented here)
  count
  current
  key
  next
  offsetExists
  offsetGet
  offsetSet
  offsetUnset
  rewind
  valid
  

How to use
==========
Create a TTreeList the stanard way.
  $treelist = new TTreeList();

Then add nodes by either adding them manually
  $treelist->AddNode($anArray); // adding a previously defined array
  $treelist->AddNode($aTreeDataNode); // adding a previously defined TTreeData

or you can add an array of arrays
  $data = array();
  $data[] = array(1,2,3);
  $data[] = array(4,5,6);
  $data[] = array(7,8,9);
  $treelist->AssignArray($data);

or you can add a resultset from a PDO-query
  $rs = $pdo->query('SELECT * FROM tablename');
  $treelist->AssignPDO($rs);

Just beware that when using AssignArray and AssignPDO the tree is first clean
from previously added nodes.

To build a tree and a linked list just call Build and as an argument you state
which index in the nodes you wish to use as an sort key. The Build function
walks through all added nodes, if any filter function has been added then they
are called, sorts the list and then creates a tree and a linked list returning
the root node of the tree.

  $data = array();
  $data[] = array(1,2,3);
  $data[] = array(4,5,6);
  $data[] = array(7,8,9);
  $treelist->AssignArray($data);
  $root = $treelist->Build(1);
This will result in a simple tree based on the second data value from each array
as the key from which the tree is built. The root node will have the key 5 and
its left node will have the key 2 and the right node will have the key 8.

  $data = array();
  $data[] = array(1,2,3);
  $data[] = array(4,5,6);
  $data[] = array(7,8,9);
  $data[] = array(1,2,0);
  $data[] = array(4,5,0);
  $data[] = array(7,8,0);
  $treelist->AssignArray($data);
  $treelist->AddBuildFilter(function($node) {
    if($node[2] == 0) {
      return false;
    }
    return true;
  });
  $root = $treelist->Build(1);
This will return the same result as the previous example since the filter
function removes the three last added arrays (the third index is 0 in these
arrays).

  $data = array();
  $data[] = array(1,2,3);
  $data[] = array(4,5,6);
  $data[] = array(7,8,9);
  $treelist->AssignArray($data);
  $root = $treelist->Build(1);
  $node = $treelist->GetFirst();
  while($node !== null) {
    echo $node[0];
  }
Will walk through the linked list and echo 147.

  $data = array();
  $data[] = array(1,2,3);
  $data[] = array(4,5,6);
  $data[] = array(7,8,9);
  $data[] = array(1,5,9);
  $treelist->AssignArray($data);
  $root = $treelist->Build(1);
  $node = $treelist->GetFirst();
  while($node !== null) {
    echo $node[0];
  }
Will walk through the linked list and echo 147. The index used for building the
tree has the same value for the second end fouth array which makes them
duplicates.

  $data = array();
  $data[] = array(1,2,3);
  $data[] = array(4,5,6);
  $data[] = array(7,8,9);
  $data[] = array(1,5,9);
  $treelist->AssignArray($data);
  $root = $treelist->Build(1);
  $node = $treelist->GetFirst();
  while($node !== null) {
    echo $node->PayloadCount();
  }
Will walk through the linked list and echo the number of payloads (data carrying
nodes for the node) each node. This will produce 121 since the second array has
a duplicate value in the fourth array.

  $data = array();
  $data[] = array(1,2,3);
  $data[] = array(4,5,6);
  $data[] = array(7,8,9);
  $treelist->AssignArray($data);
  $root = $treelist->Build(1);
  $node = $treelist->GetRoot();
  while($node !== null) {
    echo $node->key;
    $node = $node->left;
  }
Walk through the tree and keep left. This will produce the output 52.