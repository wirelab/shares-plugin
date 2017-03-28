<?php namespace Wirelab\SharesPlugin\Command;

use Anomaly\Streams\Platform\View\ViewTemplate;
use Exception;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Kint;

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
        $site_name   = $config->get('streams::distribution.name');

        $data = [
            'url'         => $url,
            'title'       => $title,
            'description' => $description,
            'site_name'   => $site_name
        ];

        if (isset($this->params['networks'])) {
            $networks = $this->params['networks'];
        } else {
            $networks = [];
            $composer_folder   = '../core/wirelab/shares-plugin/resources/views'; // The location of the views if the user installed the plugin using composer
            $manual_folder     = '../addons/' . env('APPLICATION_REFERENCE') . '/wirelab/shares-plugin/resources/views'; // The location of the views if the user installed the plugin manually
            $published_folder  = '../resources' . env('APPLICATION_REFERENCE') . 'addons/wirelab/shares-plugin/views'; // The locations of the views if the user published the views

            // Try to find the views folder
           if (file_exists($published_folder)) {
                $views_dir = published_folder;
           } elseif (file_exists($manual_folder)) {
                $views_dir = $manual_folder;
            } elseif(file_exists($composer_folder )) {
                $views_dir = $composer_folder;
            } else {
                // If we can't find it throw a new exception
                throw new Exception("Couldn't find view folder.");
            }
            foreach (File::allFiles($views_dir) as $file){
                // Use the names of the views as networks
                $networks[] = $file->getBaseName('.' . $file->getExtension());
            }
        }

        foreach ($networks as $network) {
            $shares .= view()->make("wirelab.plugin.shares::$network", $data);
        }

        return $shares;
    }
}
