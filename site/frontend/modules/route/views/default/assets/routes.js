/**
 * Author: alexk984
 * Date: 01.02.13
 */

var Routes = {
    from_city:null,
    to_city:null,
    map:null,
    PlacesService:null,
    directionsDisplay:null,
    directionsService:null,
    initAutoComplete:function(){
        Routes.directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
        var mapOptions = {
            zoom:7,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };
        Routes.map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
        Routes.directionsDisplay.setMap(Routes.map);

        Routes.PlacesService = new google.maps.places.PlacesService(Routes.map);
        Routes.initializeAutoComplete();
    },
    init:function (start, end) {
        Routes.directionsService = new google.maps.DirectionsService();
        Routes.initAutoComplete();

        var request = {
            origin:start,
            destination:end,
            travelMode:google.maps.DirectionsTravelMode.DRIVING,
            provideRouteAlternatives:false,
            waypoints:window.way_points
        };
        Routes.directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                Routes.directionsDisplay.setDirections(response);
                var myRoute = response.routes[0].legs[0];

                new google.maps.Marker({position: myRoute.steps[0].start_point,map: Routes.map,icon: '/images/services/map-route/point/point-start.png'});
                new google.maps.Marker({position: myRoute.steps[myRoute.steps.length - 1].end_point,map: Routes.map,icon: '/images/services/map-route/point/point-finish.png'});
            }
        });
    },
    initializeAutoComplete:function () {
        var autocomplete_from = new google.maps.places.Autocomplete(document.getElementById('city_from'), {types:['(cities)']});
        var autocomplete_to = new google.maps.places.Autocomplete(document.getElementById('city_to'), {types:['(cities)']});

        google.maps.event.addListener(autocomplete_from, 'place_changed', function () {
            var place = autocomplete_from.getPlace();
            if (!place.geometry) {
                // Inform the user that the place was not found and return.
                console.log('not found');
            } else {
                Routes.from_city = {
                    text:place.formatted_address,
                    lat:place.geometry.location.lat(),
                    lng:place.geometry.location.lng()
                };
            }
        });

        google.maps.event.addListener(autocomplete_to, 'place_changed', function () {
            var place = autocomplete_to.getPlace();
            if (!place.geometry) {
                // Inform the user that the place was not found and return.
                console.log('not found');
                return;
            } else
                Routes.to_city = {
                    text:place.formatted_address,
                    lat:place.geometry.location.lat(),
                    lng:place.geometry.location.lng()
                };
        });
    },
    reversePlaces:function () {
        if (Routes.to_city == null || Routes.from_city == null)
            return;

        var city = Routes.to_city;
        Routes.to_city = Routes.from_city;
        Routes.from_city = city;

        $('#city_from').val(Routes.from_city.text);
        $('#city_to').val(Routes.to_city.text);
    },
    go:function () {
        $.post('/routes/getRouteId/', {
            city_from_lat:Routes.from_city.lat,
            city_from_lng:Routes.from_city.lng,
            city_to_lat:Routes.to_city.lat,
            city_to_lng:Routes.to_city.lng
        }, function (response) {
            if (response.status) {
                location.href = '/routes/' + response.id + '/';
            } else{
                alert('Невозможно проложить маршрут');
            }
        }, 'json');
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