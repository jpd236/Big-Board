<?php
use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1702756395.
 * Generated on 2023-12-16 19:53:15  */
class PropelMigration_1702756395{
    /**
     * @var string
     */
    public $comment = '';

    /**
     * @param \Propel\Generator\Manager\MigrationManager $manager
     *
     * @return null|false|void
     */
    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    /**
     * @param \Propel\Generator\Manager\MigrationManager $manager
     *
     * @return null|false|void
     */
    public function postUp(MigrationManager $manager)
    {
        // Populate sort_order column based on existing order
        $sql = "UPDATE puzzle, (SELECT @rownum:=@rownum+1 'rank', p.* FROM puzzle p, (SELECT @rownum:=0) r ORDER BY status DESC, title) AS puzzle1 SET puzzle.sort_order = puzzle1.rank WHERE puzzle.id = puzzle1.id";
        $pdo = $manager->getAdapterConnection('palindrome');
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    /**
     * @param \Propel\Generator\Manager\MigrationManager $manager
     *
     * @return null|false|void
     */
    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    /**
     * @param \Propel\Generator\Manager\MigrationManager $manager
     *
     * @return null|false|void
     */
    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL(): array
    {
        $connection_palindrome = <<< 'EOT'

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `puzzle`

  ADD `sort_order` INTEGER AFTER `sheet_mod_date`;

ALTER TABLE `puzzle_archive`

  ADD `sort_order` INTEGER AFTER `sheet_mod_date`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
EOT;

        return [
            'palindrome' => $connection_palindrome,
        ];
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL(): array
    {
        $connection_palindrome = <<< 'EOT'

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `puzzle`

  DROP `sort_order`;

ALTER TABLE `puzzle_archive`

  DROP `sort_order`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
EOT;

        return [
            'palindrome' => $connection_palindrome,
        ];
    }

}
