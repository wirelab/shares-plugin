<?php namespace Wirelab\SharesPlugin;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Twig_Environment;
use Twig_NodeVisitorInterface;
use Wirelab\SharesPlugin\Command\MakeShareButtons;
use Wirelab\SharesPlugin\Command\MakeShareData;

class SharesPlugin extends Plugin
{

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'shares',
                function ($params = []) { return $this->dispatch(new MakeShareButtons($params)); },
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'shares_data',
                function ($params = []) { return $this->dispatch(new MakeShareData($params)); },
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'shares_scripts',
                function () { return view()->make('wirelab.plugin.shares::scripts'); },
                ['is_safe' => ['html']]
            )
        ];
    }
}
