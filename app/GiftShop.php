<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Diet;
	use AoC\Utils\Range;

	class GiftShop extends Helper
	{
		private Diet $ranges;

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			$this->ranges = new Diet();

			foreach (explode(",", $raw) as $line)
			{
				$this->ranges->add(new Range(...array_map("intval", explode("-", $line))));
			}
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$this->output($this->ranges);

			foreach ($this->ranges as $value)
			{
				if (preg_match('/^(\d+)\1$/', (string)$value))
				{
					$result->part1 += $value;
				}

				if (preg_match('/^(\d+)\1+$/', (string)$value))
				{
					$result->part2 += $value;
				}
			}

			return $result;
		}
	}
?>
