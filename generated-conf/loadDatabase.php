<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'palindrome' => 
  array (
    'tablesByName' => 
    array (
      'link' => '\\Map\\LinkTableMap',
      'member' => '\\Map\\MemberTableMap',
      'puzzle' => '\\Map\\PuzzleTableMap',
      'puzzle_archive' => '\\Map\\PuzzleArchiveTableMap',
      'relationship' => '\\Map\\PuzzlePuzzleTableMap',
      'solver' => '\\Map\\PuzzleMemberTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\Link' => '\\Map\\LinkTableMap',
      '\\Member' => '\\Map\\MemberTableMap',
      '\\Puzzle' => '\\Map\\PuzzleTableMap',
      '\\PuzzleArchive' => '\\Map\\PuzzleArchiveTableMap',
      '\\PuzzleMember' => '\\Map\\PuzzleMemberTableMap',
      '\\PuzzlePuzzle' => '\\Map\\PuzzlePuzzleTableMap',
    ),
  ),
));
