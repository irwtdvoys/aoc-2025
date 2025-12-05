# Advent of Code 2025

https://adventofcode.com/2025/

| Day | Name                |      Part 1 |          Part 2 | Time       | Memory     |
|----:|:--------------------|------------:|----------------:|:-----------|:-----------|
|   1 | Secret Entrance     |        1102 |            6172 | 42.3287ms  | 1.8947 MiB |
|   2 | Gift Shop           | 40214376723 |     50793864718 | 207.2846ms | 1.2513 MiB |
|   3 | Lobby               |       17443 | 172167155440541 | 1.9539ms   | 2.4475 MiB |
|   4 | Printing Department |        1395 |            8451 | 162.48ms   | 2.8751 MiB |
|   5 | Cafeteria           |         821 | 344771884978261 | 1.6384ms   | 1.2505 MiB |

## Notes

##### Day 01: Secret Entrance

Got to use the CircularLinkedList from the Cruxoft AoC utilities package again! Thought part 2 might require an alternative but was an instant result.

##### Day 02: Gift Shop

Lovely bit of regex. It was nice to use backreference as I've never really needed to use it before.

##### Day 03: Lobby

Implemented a sliding window approach, which I then tweaked for part 2 to have a dynamic window size. Saw that a monotonic stack was a good approach so also implemented that but it runs slower than the sliding window. Turns out I implemented a lot of efficiency shortcuts.

##### Day 04: Printing Department

Simple grid traversal and a cheeky little do-while loop.

##### Day 05: Cafeteria

Turns out I accidentally created a Discrete Interval Encoding Tree, so I pulled it out into my aoc package incase I need it again!
