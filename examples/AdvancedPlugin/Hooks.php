<?php


namespace AdvancedPluginSystem\AdvancedPlugin;

class Hooks
{
    public function exampleHook() : string
    {
        $text = "I am a example hook.";
        print_r($text . "\r\n");
        return $text;
    }
}
