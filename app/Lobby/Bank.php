<?php
    namespace App\Lobby;

    use Stringable;

	class Bank implements Stringable
	{
		/** @var int[] */
		private array $batteries;

		public function __construct(array $batteries)
		{
			$this->batteries = $batteries;
		}

		public function __toString(): string
		{
			return $this->asString($this->batteries);
		}

		public function joltage(int $size = 2, Strategy $strategy = Strategy::SlidingWindow): int
		{
			return $this->{$strategy->value}($size);
		}

		private function slidingWindow(int $size = 2): int
		{
			$result = [];
			$offset = 0;
			$chunkSize = count($this->batteries) - $size + 1;

			while ($chunkSize + $offset <= count($this->batteries))
			{
				$slice = array_slice($this->batteries, $offset, $chunkSize);
				$max = max($slice);
				$pos = array_search($max, $slice);

				$offset += $pos + 1;
				$chunkSize -= $pos;

				if ($max > end($result) && (count($this->batteries) - $offset > $size - count($result)))
				{
					array_pop($result);
				}

				$result[] = $max;
			}
			return (int)$this->asString($result);
		}

		private function monotonicStack(int $size = 2): int
		{
			$stack = [];
			$drop = count($this->batteries) - $size;

			foreach ($this->batteries as $battery)
			{
				while ($drop > 0 && !empty($stack) && end($stack) < $battery)
				{
					array_pop($stack);
					$drop--;
				}
				$stack[] = $battery;
			}

			return (int)$this->asString(array_slice($stack, 0, $size));
		}

		private function asString(array $batteries)
		{
			return implode("", $batteries);
		}
	}
?>
