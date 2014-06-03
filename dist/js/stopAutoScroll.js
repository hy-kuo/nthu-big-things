$(document).ready(function() {      
   $('.carousel').carousel('pause');
});

$('.panel').hover(
  function() {
    $( this ).toggleClass( 'active' );
  }, function() {
    $( this ).toggleClass( 'active' );
  }
);

window.onload = function ()
{
	locationSuccess();
}

function locationSuccess() {
        var zoom = 10;
        var latlng = new google.maps.LatLng(23.5, 120.0);
             
        if (google.loader.ClientLocation) {
        latlng = new google.maps.LatLng(google.loader.ClientLocation.latitude,
                                                google.loader.ClientLocation.longitude);
            

        var lat = google.loader.ClientLocation.latitude;   
        var lon = google.loader.ClientLocation.longitude;   
  		}
        var geoAPI = 'http://where.yahooapis.com/geocode?location='+lat+','+lon+'&flags=J&gflags=R&appid=';   
               
        var wsql = 'select * from weather.forecast where woeid=WID and u="'+DEG+'"',   
            weatherYQL = 'http://query.yahooapis.com/v1/public/yql?q='+encodeURIComponent(wsql)+'&format=json&callback=?',   
            code, city, results, woeid;   
}  

$.getJSON(weatherYQL.replace('WID',woeid), function(r){   
                   
                if(r.query && r.query.count == 1){   
                       
                    // Create the weather items in the #scroller UL   
                       
                    var item = r.query.results.channel.item.condition;   
                       
                    if(!item){   
                        showError("We can't find weather information about your city!");   
                        if (window.console && window.console.info){   
                            console.info("%s, %s; woeid: %d", city, code, woeid);   
                        }   
                           
                        return false;   
                    }   
                       
                    addWeather(item.code, "Now", item.text + ' <b>'+item.temp+'°'+DEG+'</b>');   
                       
                    for (var i=0;i<2;i++){   
                        item = r.query.results.channel.item.forecast[i];   
                        addWeather(   
                            item.code,    
                            item.day +' <b>'+item.date.replace('\d+$','')+'</b>',   
                            item.text + ' <b>'+item.low+'°'+DEG+' / '+item.high+'°'+DEG+'</b>'  
                        );   
                    }   
                       
                    // Add the location to the page   
                    location.html(city+', <b>'+code+'</b>');   
                       
                    weatherDiv.addClass('loaded');   
                       
                    // Set the slider to the first slide   
                    showSlide(0);   
                  
                }   
                else {   
                    showError("Error retrieving weather data!");   
                }   
            });  
function addWeather(code, day, condition){   
           
        var markup = '<li>'+   
            '<img src="img/icons/'+ weatherIconMap[code] +'.png" />'+   
            ' <p class="day">'+ day +  '</p> <p class="cond">'+ condition +   
            '</p></li>';   
           
        scroller.append(markup);   
    }  
