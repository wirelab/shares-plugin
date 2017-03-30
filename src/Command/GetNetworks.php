<?php namespace Wirelab\SharesPlugin\Command;

use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use App;
use Exception;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class GetNetworks
{
	/**
	 * Return all networks
	 *
	 * @throws Exception `Couldn't find view folder`
	 *
	 * @return array ['network','network']
	 */
	public static function all()
	{
        $networks = [];
        $filesystem        = new Filesystem;
        $composer_folder   = base_path() . '/core/wirelab/shares-plugin/resources/views/networks'; // The location of the views if the user installed the plugin using composer
        $manual_folder     = base_path() . '/addons/' . env('APPLICATION_REFERENCE') . '/wirelab/shares-plugin/resources/views/networks'; // The location of the views if the user installed the plugin manually
        $published_folder  = base_path() . '/resources' . env('APPLICATION_REFERENCE') . 'addons/wirelab/shares-plugin/views/networks'; // The locations of the views if the user published the views

        // Try to find the views folder
       if ($filesystem->exists($published_folder)) {
            $views_dir = published_folder;
       } elseif ($filesystem->exists($manual_folder)) {
            $views_dir = $manual_folder;
        } elseif($filesystem->exists($composer_folder )) {
            $views_dir = $composer_folder;
        } else {
            // If we can't find it throw a new exception
            throw new Exception("[shares-plugin] Couldn't find view folder.");
        }
        foreach ($filesystem->allFiles($views_dir) as $file){
            // Use the names of the views as networks
            $networks[] = $file->getBaseName('.' . $file->getExtension());
        }

        return $networks;
	}

	/**
	 * Return all enabled networks
	 *
	 * @return array ['network','network']
	 */
	public static function enabled()
	{
		$networks         = GetNetworks::all();
		$enabled_networks = App::make('Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface')->get('wirelab.plugin.shares::networks');
		$facebook_app_id  = App::make('Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface')->get('wirelab.plugin.shares::facebook_app_id');
		$facebook_enabled = isset($facebook_app_id) && !empty($facebook_app_id);

		if ($facebook_enabled && str_replace(' ', '', $facebook_app_id->value ) == '') {
			// If the facebook api key setting does exsits but doesn't contain anything disable facebook.
			$facebook_enabled = false;
		}

		if (isset($enabled_networks) && !empty($enabled_networks)) {
			$enabled_networks = $enabled_networks->value;
		} else {
			// If no 'networks' setting exists yet use all networks
			return $networks;
		}

		foreach ($networks as $key => $network) {
			if (!in_array($key, $enabled_networks) || $network == 'facebook' && !$facebook_enabled) {
				// If the key isn't in the list of enabled networks or
				// if facebook is enabled but no api key is given, unset it
				unset($networks[$key]);
			}
		}

		return $networks;
	}
}
