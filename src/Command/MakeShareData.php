<?php namespace Wirelab\SharesPlugin\Command;

use Anomaly\Streams\Platform\View\ViewTemplate;
use Exception;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Wirelab\SharesPlugin\Command\GetNetworks;

class MakeShareData
{
    use DispatchesJobs;

    protected $params;

    /**
     * Get the user input
     *
     * @param Array $params The parameters
     */
    public function __construct(Array $params){
    	$this->params = $params;
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
            'facebook' => [
                'data-url' => $url,
                'class'    => 'shares-facebook'
            ],
            'twitter' => [
                'href' => 'http://twitter.com/intent/tweet?status=' . urlencode($title) . '&url=' . urlencode($url)
            ],
            'whatsapp' => [
                'href'  => 'whatsapp://send?text=' . urlencode($url),
                'class' => 'shares-whatsapp'
            ],
            'linkedin' => [
                'data-sitename' => $site_name,
                'data-title'    => $title,
                'data-url'      => $url,
                'data-summary'  => $description,
                'class'         => 'shares-linkedin'
            ]
        ];

        return $data;
    }
}
