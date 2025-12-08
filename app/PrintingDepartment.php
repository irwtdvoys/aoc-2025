<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Grid;
	use AoC\Utils\Position;

	class PrintingDepartment extends Helper
	{
		private Grid $grid;

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$this->grid = new Grid(parent::load($override));
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$this->output($this->grid);
			$loop = 0;

			do
			{
				$found = [];

				for ($x = $this->grid->dimensions->x->min; $x <= $this->grid->dimensions->x->max; $x++)
				{
					for ($y = $this->grid->dimensions->y->min; $y <= $this->grid->dimensions->y->max; $y++)
					{
						if ($this->grid->get($x, $y) === "@")
						{
							$count = $this->countSurrounding($x, $y);

							if ($count < 4)
							{
								$this->grid->set($x, $y, "x");
								$found[] = new Position([$x, $y]);
							}
						}
					}
				}

				$removed = count($found);

				if ($loop === 0)
				{
					$result->part1 = $removed;
				}

				$result->part2 += $removed;

				$this->output("Loop " . $loop . ": removed " . $removed . " rolls");
				$this->output($this->grid);
				$this->removeRolls($found);
				$loop++;
			}
			while ($removed);

			return $result;
		}

		private function removeRolls(array $locations): void
		{
			foreach ($locations as $location)
			{
				$this->grid->set($location->x(), $location->y(), ".");
			}
		}

		private function countSurrounding(int $x, int $y): int
		{
			$count = 0;

			for ($checkX = $x - 1; $checkX <= $x + 1; $checkX++)
			{
				for ($checkY = $y - 1; $checkY <= $y + 1; $checkY++)
				{
					if ($checkX === $x && $checkY === $y)
					{
						continue;
					}

					if (in_array($this->grid->get($checkX, $checkY), ["@", "x"]))
					{
						$count++;
					}
				}
			}

			return $count;
		}
	}
?>
