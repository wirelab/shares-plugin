# Shares plugin
Plugin which provides users with a quick way of adding customizable share links with GA tracking.

## Usage
1. Set your facebook app key in `settings > plugins > shares plugin` _(optional)_
2. Selects the networks that are enabled by default `settings > plugins > shares plugin` _(optional)_
3. put `{{ shares_scripts()|raw }}` in your theme to load all javascript files
4. call `{{ shares({title: '', url: '', description: '', networks: ['']|raw }}` in any twig file.

_All parameters are optional_

## Parameters
| Name | Description | Optional | Default value | Type |
|------|-------------|----------|---------------|------|
| title | The title used in the shares | yes | template.meta_title | String |
| description | The description used in the shares | yes | template.meta_description | String |
| url | The url that gets shares | yes | the current url | String |
| networks | List of social media networks to return | yes | all _(configurable in the settings)_ | Array |

## Examples
```twig
{{ shares() }}

{{ shares({'networks':['twitter','facebook']}) }}

{{
	shares({
		'title': 'Wirelab',
		'description': 'The website of Wirelab',
		'url': 'http:://www.wirelab.nl'
	})
}}
```

## Adding google analytics
Add the following code near the top of the `<head>` tag. Replace `UA-XXXXX-Y` with the property ID (also called the "tracking ID") of the Google Analytics property you wish to track.
```html
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-XXXXX-Y', 'auto');
ga('send', 'pageview');
</script>
```