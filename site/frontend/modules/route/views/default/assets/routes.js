/**
 * Author: alexk984
 * Date: 01.02.13
 */

var Routes = {
    map:null,
    PlacesService:null,
    init:function (start, end) {
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();
        var mapOptions = {
            zoom:7,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };
        this.map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
        directionsDisplay.setMap(this.map);

        this.PlacesService = new google.maps.places.PlacesService(this.map);
        this.initializeAutoComplete();

        var request = {
            origin:start,
            destination:end,
            travelMode:google.maps.DirectionsTravelMode.DRIVING,
            provideRouteAlternatives:true
        };
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            }
        });
    },
    FoundPlaceCallback:function (place, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK) {

        }
        console.log(place);
        console.log(status);
    },
    initializeAutoComplete:function () {
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('city_from'), {types:['(cities)']});
        var autocomplete2 = new google.maps.places.Autocomplete(document.getElementById('city_to'), {types:['(cities)']});

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // Inform the user that the place was not found and return.
                console.log('not found');
                return;
            }

            console.log(place);
        });

        google.maps.event.addListener(autocomplete2, 'place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // Inform the user that the place was not found and return.
                console.log('not found');
                return;
            }

            console.log(place);
        });
    }
}

var RoutesModel = function (distance, currencyArray) {
    this._distance = ko.observable(distance);
    this.speed = ko.observable(80);
    this.currency = ko.observableArray(currencyArray);
    this.currentCurrency = ko.observable(1);
    this.fuelConsumption = ko.observable(8);

    this.distance = ko.computed(function () {
        return (this._distance() + '').replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
    }, this);

    this.DurationHours = ko.computed(function () {
        return Math.floor(this._distance() / this.speed());
    }, this);

    this.DurationMinutes = ko.computed(function () {
        return Math.round((this._distance() - this.speed() * this.DurationHours()) / (this.speed()) * 60);
    }, this);

    this.fuelNeeds = ko.computed(function () {
        return Math.round(this._distance() / 100 * this.fuelConsumption());
    }, this);

    this.fuelCost = ko.computed(function () {
        var cur = this.currency()[this.currentCurrency() - 1];
        return cur.value;
    }, this);

    this.summaryCost = ko.computed(function () {
        var value = Math.round(this.fuelNeeds() * this.fuelCost());
        return (value + '').replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
    }, this);

    this.currencySign = ko.computed(function () {
        var cur = this.currency()[this.currentCurrency() - 1];
        return cur.name;
    }, this);
}