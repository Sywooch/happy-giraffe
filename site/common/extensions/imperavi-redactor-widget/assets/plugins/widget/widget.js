if (!RedactorPlugins) var RedactorPlugins = {};

RedactorPlugins.widget = {

    generate: function(entity, entity_id, html)
    {
        return '<!-- widget: { entity : \'' + entity + '\', entity_id : \'' + entity_id + '\' } -->' + html + '<!-- /widget -->';
    }

}

