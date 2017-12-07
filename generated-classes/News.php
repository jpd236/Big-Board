<?php

use Base\News as BaseNews;

/**
 * Skeleton subclass for representing a row from the 'news' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */

class News extends BaseNews {
	public function getNewsFilter() {
		$status = $this->getNewsType();
		if ($status != "important") {
			return "puzzle";
		}
		return $status;
	}
}
