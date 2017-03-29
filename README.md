# Shares plugin
Plugin which provides users with a quick way of adding customizable share links with GA tracking.

## Usage
1. Set your facebook app key in `settings > plugins > shares plugin` _(optional)_
2. Selects the networks that are enabled by default `settings > plugins > shares plugin` _(optional)_
3. put `{{ shares_scripts()|raw }}` in your theme
4. call `{{ shares({title: '', url: '', description: '', networks: ['']|raw }}` in any twig file.

_All parameters are optional_

## Parameters
| Name | Description | Optional | Default value | Type |
|------|-------------|----------|---------------|------|
| title | The title used in the shares | yes | template.meta_title | String |
| description | The description used in the shares | yes | template.meta_description | String |
| url | The url that gets shares | yes | the current url | String |
| networks | List of social media networks to return | yes | all _(configurable in the settings)_ | Array |