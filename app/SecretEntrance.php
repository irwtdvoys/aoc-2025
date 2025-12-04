<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;
    use AoC\Utils\CircularLinkedList;
    use App\SecretEntrance\Direction;
    use App\SecretEntrance\Instruction;

    class SecretEntrance extends Helper
	{
		/** @var Instruction[] */
		private array $instructions;
        private CircularLinkedList $dial;

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

            $this->instructions = array_map(
                function ($line) {
                    return new Instruction($line);
                },
                explode(PHP_EOL, $raw)
            );

            $this->dial = new CircularLinkedList(100);
            $this->dial->forward(50);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);
            $this->output("The dial starts by pointing at " . $this->dial->current()->data . ".");

            foreach ($this->instructions as $instruction)
            {
                $count = 0;

                for ($loop = 0; $loop < $instruction->quantity; $loop++)
                {
                    switch ($instruction->direction)
                    {
                        case Direction::Left:
                            $this->dial->previous();
                            break;
                        case Direction::Right:
                            $this->dial->next();
                            break;
                    }

                    if ($this->dial->current()->data === 0)
                    {
                        $count++;
                        $result->part2++;
                    }
                }

                if ($this->dial->current()->data === 0)
                {
                    $result->part1++;
                }

				$output = "The dial is rotated " . $instruction . " to point at " . $this->dial->current()->data;
				$output .= $count > 0 ? " (" . $count . " times)" : ".";

				$this->output($output);
            }

			return $result;
		}
	}
?>
