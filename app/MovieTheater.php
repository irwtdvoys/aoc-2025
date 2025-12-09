<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Line;
	use AoC\Utils\Position;

	class MovieTheater extends Helper
	{
		/** @var Position[] */
		private array $points = [];

		/** @var Line[] */
		private array $lines = [];

		private array $pointCache = [];
		private array $cache = [];

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);
			$points = explode(PHP_EOL, $raw);

			for ($index = 0; $index < count($points); $index++)
			{
				[$x, $y] = explode(",", $points[$index]);

				$position = new Position([(int)$x, (int)$y]);

				$this->points[] = $position;

				if ($index > 0)
				{
					$this->lines[] = new Line($this->points[$index - 1], $this->points[$index]);
				}
			}

			$this->lines[] = new Line(end($this->points), reset($this->points));
		}

		private function intersects(Line $line, Position $pointA, Position $pointB): bool
		{
			$pointKey = $pointA . $pointB;
			$lineKey = (string)$line;

			if (!isset($this->pointCache[$pointKey]))
			{
				$this->output("Caching point bounds for: " . $pointA . " and " . $pointB);
				$this->pointCache[$pointKey] = [
					"minX" => min($pointA->x(), $pointB->x()),
					"maxX" => max($pointA->x(), $pointB->x()),
					"minY" => min($pointA->y(), $pointB->y()),
					"maxY" => max($pointA->y(), $pointB->y())
				];
			}

			if (!isset($this->cache[$lineKey]))
			{
				$this->output("Caching line segment bounds for: " . $line);
				$this->cache[(string)$line] = [
					"segMinX" => min($line->start->x(), $line->end->x()),
					"segMaxX" => max($line->start->x(), $line->end->x()),
					"segMinY" => min($line->start->y(), $line->end->y()),
					"segMaxY" => max($line->start->y(), $line->end->y())
				];
			}

			$pointData = $this->pointCache[$pointKey];
			$lineData = $this->cache[$lineKey];

			return $lineData['segMaxX'] > $pointData['minX'] && $lineData['segMinX'] < $pointData['maxX'] && $lineData['segMaxY'] > $pointData['minY'] && $lineData['segMinY'] < $pointData['maxY'];
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			for ($index = 0; $index < count($this->points); $index++)
			{
				$pointA = $this->points[$index];

				for ($loop = $index + 1; $loop < count($this->points); $loop++)
				{
					$pointB = $this->points[$loop];
					$x = abs($pointA->x() - $pointB->x()) + 1;
					$y = abs($pointA->y() - $pointB->y()) + 1;
					$area = $x * $y;

					$result->part1 = max($result->part1, $area);
					$this->output($pointA . "-" . $pointB . " (" . $x . "x" . $y . ") = " . $area);

					if ($area <= $result->part2)
					{
						continue;
					}

					$intersected = false;

					$this->pointCache = [];

					foreach ($this->lines as $line)
					{
						if ($this->intersects($line, $pointA, $pointB))
						{
							$this->output("Intersects with line: " . $line);
							$intersected = true;
							break;
						}
					}

					if (!$intersected)
					{
						$result->part2 = $area;
					}
				}
			}

			return $result;
		}
	}
?>
