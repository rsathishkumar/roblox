jQuery(document).ready(function() {
  
jQuery( ".keyword_search" ).autocomplete({
  source: function (request, response) {
    var host_api = 'https://app.eightfold.ai';
    if (_options.iframeURL) {
      host_api = _options.iframeURL;
    }
    var domain = jQuery('input[name="domain"]').val();
    jQuery.ajax({
      url: host_api + "/api/suggest",
      data: { term: request.term,dictionary: 'job_search',domain: domain },
      success: function (data) {
        var suggestions = jQuery.parseJSON(data);
        var transformed = jQuery.map(suggestions.suggestions, function (el) {
          return {
            label: el.term,
            id: el.term
          };
        });
        response(transformed);
      },
      error: function () {
        response([]);
      }
    })
  },
});

jQuery('.keyword_search').on('autocompleteselect', function (event, ui) {
    if (jQuery(this).hasClass("on-select-submit")) {
        jQuery(this).val(ui.item.id);
        jQuery(this).parents('.search-job-widget').find('.button-field button').trigger('click');
    }
}).change();

  jQuery( ".location" ).autocomplete({
    source: function (request, response) {
      var domain = jQuery('input[name="domain"]').val();
      var location_host = jQuery('input[name="location_host"]').val();
      var ajaxurl = "//" + location_host + '/wp-admin/admin-ajax.php';
      jQuery.get(ajaxurl,{'action': 'locationList','data':request.term, domain: domain},
        function (data) {
          var suggestions = jQuery.parseJSON(data);
          var transformed = jQuery.map(suggestions.suggestions, function (el) {
            return {
              label: el.term,
              id: el.term
            };
          });
          response(transformed);
        });
    }
  });

  function makeBaseAuth(user, pswd){
    var token = user + ':' + pswd;
    var hash = "";
    if (btoa) {
      hash = btoa(token);
    }
    return "Basic " + hash;
  }

  jQuery('.button-field button, .job-search-submit').click(function() {
    var host_api = 'https://app.eightfold.ai';
    if (_options.iframeURL) {
      host_api = _options.iframeURL;
    }
    var domain = jQuery(this).parents('.search-job-widget').find('input[name="domain"]').val();
    var job_search_url = jQuery(this).parents('.search-job-widget').find('input[name="job_search_url"]').val();
    var search = jQuery(this).parents('.search-job-widget').find('.keyword_search').val();
    var url = host_api+job_search_url;
    if(job_search_url.indexOf("?") === -1) {
      url += "?";
    }
    else {
      url += "&";
    }
    if( jQuery(this).parents('.search-job-widget').find('.location').length ) {
        var location = jQuery(this).parents('.search-job-widget').find('.location').val();
        var location_query_param = jQuery(this).parents('.search-job-widget').find(".location").attr('name');
        if (location != '') {
            url += location_query_param+"="+location+"&";
        }
    }
    if (search != '') {
      url += "query="+search+"&";
    }
    window.location.href = url+"domain="+domain;
  })

  jQuery('.getAddress').click(function() {
      getLocation(this);
  })

  jQuery(".keyword_search").on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        jQuery(this).parents('.search-job-widget').find('.button-field button').trigger('click');
    }
  });

});

function getLocation(obj){
  if(navigator.geolocation){
      // timeout at 60000 milliseconds (60 seconds)
      var options = {
          enableHighAccuracy: true,
          timeout: 5000,
          maximumAge: 0
      };

      var findResult = function(results, name){
           let result = results.find(obj => obj.types[0] == name && obj.types[1] == "political");
           return result ? result.long_name : null;
      };

      function success(pos) {
          var crd = pos.coords;
          const key = 'AIzaSyA7mF47PJ1jwNHCQwr4JuzIIWayJ6jyx1c';
          const lat = crd.latitude;
          const long = crd.longitude;
          //const lat = 34.155834;
          //const long = -119.202789;
          const url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+long+'&key='+key;
          fetch(url)
          .then( response => response.json() )
          .then( data => {
            console.log(data);
            var address_components = data.results[0].address_components;
            var city = findResult(address_components, "locality");
            var state = findResult(address_components, "administrative_area_level_1");
            var country = findResult(address_components, "country");
            var address = city+', '+state+', '+country;
            obj.parents('.search-job-widget').find('.location').val(address);
              
          })
          .catch(err => console.log(err.message))
      }

      function error(err) {
          console.warn(`ERROR(${err.code}): ${err.message}`);
      }

      navigator.geolocation.getCurrentPosition(success, error, options);
  } 
  else{
     alert("Sorry, browser does not support geolocation!");
  }
} 

