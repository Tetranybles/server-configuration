<?php


namespace Tetranybles\ServerConfiguration;


class Nginx
{
    protected array $lines;
    public static function load(string $path): self {
        $instance = new static();
                $instance->lines = $instance->discardIrrelevantLines(file($path));
        return $instance;
    }

    /**
     * @return string
     */
    public function lines(): array
    {
        return $this->lines;
    }

    public function discardIrrelevantLines(array $lines): array {
        return array_filter(array_map('trim', $lines),
            fn($line) =>  $line !== 'server' && $line !== ''
        );
    }

    public static function setDirective($lines,array $server = ['markitti.com www.markitti.com'], array $text = []): array{
        return  array_map(function($line) use($server, $text){
            return str_replace($server,$text,$line);
        }, $lines);


    }
    public function __toString(): string
    {
        return implode("", $this->lines);
    }

}