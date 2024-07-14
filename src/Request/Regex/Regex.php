<?php

declare(strict_types=1);

namespace Alvinios\Miel\Request\Regex;

class Regex implements RegexInterface
{
    private array $matches;
    private bool $match;

    private array $groups;

    public function __construct(
        private string $pattern,
        private string $subject
    ) {
        $this->match = (preg_match(
            $pattern,
            $subject,
            $matches
        ) && $matches[0] === $subject);

        $this->matches = $matches;

        $this->groups = array_filter($matches, fn ($k) => !is_numeric($k), ARRAY_FILTER_USE_KEY);
    }

    public function matches(): bool
    {
        return $this->match;
    }

    public function group(string $name): string
    {
        if (!isset($this->groups[$name])) {
            throw new InvalidArgumentException(sprintf('invalid Matcher Group %', $name));
        }

        return $this->groups[$name];
    }
}
