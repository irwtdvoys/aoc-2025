<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Dsu;
	use AoC\Utils\Position;
	use AoC\Utils\Vector;

	class Playground extends Helper
	{
		/** @var array<string, float> */
		private array $connections = [];
		private Dsu $dsu;
		private bool $overridden;

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			$this->overridden = $override !== null;
			$lines = explode(PHP_EOL, $raw);
			$count = count($lines);

			$this->dsu = new Dsu();

			foreach ($lines as $box)
			{
				$this->dsu->add($box);
			}

			for ($index = 0; $index < $count; $index++)
			{
				$current = Position::createFromString($lines[$index]);

				for ($loop = $index + 1; $loop < $count; $loop++)
				{
					$next = Position::createFromString($lines[$loop]);

					$vector = new Vector([
						$next->x() - $current->x(),
						$next->y() - $current->y(),
						$next->z() - $current->z(),
					]);

					$this->connections[$lines[$index] . "-" . $lines[$loop]] = $vector->magnitude();
				}
			}

			asort($this->connections);
		}

		private function score(array $data): int
		{
			rsort($data);

			return count($data[0]) * count($data[1]) * count($data[2]);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$limit = $this->overridden ? 10 : 1000;
			$count = 1;

			foreach ($this->connections as $pair => $distance)
			{
				$this->output("Connecting " . $pair . " with distance " . $distance);
				[$box1, $box2] = explode("-", $pair);

				$this->dsu->union($box1, $box2);

				if ($count === $limit)
				{
					$result->part1 = $this->score($this->dsu->toArray());
					$this->output("Part 1 reached");
				}

				if ($this->dsu->count() === 1)
				{
					$position1 = Position::createFromString($box1);
					$position2 = Position::createFromString($box2);

					$result->part2 = $position1->x() * $position2->x();
					break;
				}

				$count++;
			}

			return $result;
		}
	}
?>
