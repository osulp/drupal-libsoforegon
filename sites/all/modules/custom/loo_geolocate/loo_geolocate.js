(function ($) {
  Drupal.behaviors.looGeolocateDisplayLocation = {
    attach: function (context, settings) {
      $(document).ajaxComplete(function (event, xhr, settings) {
        if (isset(settings.url) && '/?q=geolocate-user' == settings.url) {
          if (isset(settings.data)) {
            var info = settings.data.split("&");
            var city = '';
            var state = '';
            var country = '';
            $.each(info, function (index, value) {
              var parts = value.split("=");
              var key = parts[0];
              var val = parts[1].replace("+", " ");
              if ('locality' == key) {
                city = val;
              } else if ('administrative_area_level_1' == key) {
                state = val;
              } else if ('country' == key) {
                country = val;
              }
            });
            var message = '';
            if ('' != city && '' != state && '' != country) {
              message = 'You are currently accessing the Libraries of Oregon portal from <strong>'
                + city + ', ' + state + ', ' + country + '</strong>. '
                + '<a href="/libraries-by-city/' + city + '">Find your nearest library</a>.';
            } else {
              message = 'We were unable to determine your location, so some services may not be available. Please <a href="mailto:support@librariesoforegon.org">contact us</a> if you need assistance. ';
            }
            $('#loo-location-info').html(message);
          }
        }


      })
    }
  };
})(jQuery);
