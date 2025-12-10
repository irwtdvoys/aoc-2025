<?php
	namespace App\Factory;

	use Stringable;

	class Machine implements Stringable
	{
		/** @var State[] */
		private array $lights;
		/** @var array[] */
		private array $buttons;
		/** @var int[] */
		private array $joltage;

		public function __construct(string $data)
		{
			$regex = '/\[(?<lights>[^\]]*)\]|\((?<buttons>[^)]*)\)|\{(?<joltage>[^}]*)\}/';
			preg_match_all($regex, $data, $matches);

			$this->lights = array_map(
				fn ($element) => State::tryFrom($element),
				str_split(reset($matches['lights']) ?? "")
			);
			$this->joltage = array_map("intval", explode(",", end($matches['joltage']))) ?? [];
			$this->buttons = array_map(
				fn ($element) => array_map("intval", explode(",", $element)),
				array_filter($matches['buttons'])
			);
		}

		public function __toString(): string
		{
			$buttons = array_map(
				fn ($element) => "(" . implode(",", $element) . ")",
				$this->buttons
			);

			return "[" . implode("", array_map(fn(State $element) => $element->value, $this->lights)) . "] " . implode(" ", $buttons) . " {" . implode(",", $this->joltage) . "}";
		}
	}
?>
