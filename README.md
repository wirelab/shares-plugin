# shares plugin
shares plugin for pyrocms 3

## Usage
1. put `{{ shares_scripts()|raw }}` in your theme
2. call `{{ shares({title: '', url: '', description: '', networks: ['']}}` in any twig file.

_All parameters are optional_

## Parameters
| Name | Description | Optional | Default value | Type |
|------|-------------|----------|---------------|------|
| title | The title used in the shares | yes | template.meta_title | String |
| description | The description used in the shares | yes | template.meta_description | String |
| url | The url that gets shares | yes | the current url | String |
| networks | List of social media networks to return | yes | all | Array |