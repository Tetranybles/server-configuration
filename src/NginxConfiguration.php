<?php


namespace Tetranybles\ServerConfiguration;


class NginxConfiguration
{
    protected string $file;
    public static function load(string $path): self {
        $instance = new static();
        $instance->file = file_get_contents($path);
        return $instance;
    }

    /**
     * @param array $server
     * @param array $text
     * @return string
     */
    public function setDirective(array $server = ['markitti.com www.markitti.com'], array $text = []): self
    {
        $this->file = str_replace($server,$text,$this->file);
        return $this;
    }

    public function save(string $path = __DIR__ . '/stubs/serve.conf'){
        file_put_contents($path, $this->file);
    }

    public function __toString(): string
    {
        return  $this->file;
    }

}