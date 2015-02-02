define(['knockout', 'models/Model'], function ClubHandler(ko, Model) {
    var Geography = {
        getCountriesUrl: '/api/geo/countriesList/',
        getSearchCities: '/api/geo/searchCities/',
        getCountries: function getCountries() {
            return Model.get(this.getCountriesUrl, {});
        },
        getCities: function getCities() {
            return Model.get(this.getSearchCities, {  });
        }
    };
    return Geography;
});