<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Diet;
	use AoC\Utils\Range;

	class Cafeteria extends Helper
	{
		/** @var int[] */
		private array $ingredients;
		private Diet $diet;

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			[$freshRanges, $ingredients] = explode(PHP_EOL . PHP_EOL, $raw);

			$this->diet = new Diet();

			$freshRanges = explode(PHP_EOL, $freshRanges);
			sort($freshRanges);

			foreach ($freshRanges as $line)
			{
				$this->diet->add(new Range(...array_map("intval", explode("-", $line))));
			}

			$this->ingredients = array_map("intval", explode(PHP_EOL, $ingredients));
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->ingredients as $ingredient)
			{
				$result->part1 += $this->diet->contains($ingredient);
			}

			$result->part2 = $this->diet->count();

			return $result;
		}
	}
?>
