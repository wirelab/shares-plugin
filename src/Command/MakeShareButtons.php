<?php namespace Wirelab\SharesPlugin\Command;

use Anomaly\Streams\Platform\View\ViewTemplate;
use Exception;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Wirelab\SharesPlugin\Command\GetNetworks;

class MakeShareButtons
{
    use DispatchesJobs;

    protected $params;

    /**
     * Get the user input
     *
     * @param Array $params The parameters
     */
    public function __construct(Array $params){
    	$this->params      = $params;
    }

    /**
     * Handle the command.
     */
    public function handle(
        Request $request,
        Repository $config,
        ViewTemplate $template
    )
    {
        $url         = isset($this->params['url']) ? $this->params['url'] : $request->url();
        $shares      = '';
        $title       = isset($this->params['title']) ? $this->params['title'] : $template['meta_title'];
        $description = isset($this->params['description']) ? $this->params['description'] : $template['meta_description'];
        $site_name   = $config->get('app.name');

        $data = [
            'url'         => $url,
            'title'       => rawurlencode($title),
            'description' => rawurlencode($description),
            'site_name'   => rawurlencode($site_name)
        ];

        if (isset($this->params['networks'])) {
            $networks = $this->params['networks'];
        } else {
            $networks = GetNetworks::enabled();
        }

        foreach ($networks as $network) {
            $shares .= view()->make("wirelab.plugin.shares::networks/$network", $data);
        }

        return $shares;
    }
}
