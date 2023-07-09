<?php

namespace WP_CLI\ChangeUrl;

use WP_CLI;
use WP_CLI_Command;

class WpCliHelper extends WP_CLI_Command
{
    /**
     * Echo a new line with text provided.
     *
     * @param string $text
     * @return void
     */
    protected function nl($text=null)
    {
        WP_CLI::line($text);
    }

    /**
     * underline and display the provided text.
     *
     * @param string $text
     * @return void
     */
    protected function u($text)
    {
        $this->nl(WP_CLI::colorize("%9%U{$text}%n"));
    }

    /**
     * Display options based on the array of options provided.
     *
     * @param array $data
     * @return mixed
     */
    protected function askOptions($data)
    {
        $this->nl($data['title']);
        foreach ($data['options'] as $k => $v)
        {
            $this->nl("{$k}. {$v}");
        }
        $choosen = readline(":");
        while(!array_key_exists($choosen, $data['options']))
        {
            $this->nl("Invalid selection. choose any of ".implode(',', array_keys($data['options'])));
            $choosen = readline(":");
        }
        return $choosen;
    }
}