<html>
  <head>
    <script src="https://www.google.com/jsapi"></script>
    <script>
      var appId = '344141462448795';
      var appNamespace = 'nsbetcha';
      var appCenterURL = '//www.facebook.com/games/' + appNamespace;
      
    </script>
  </head>

  <body>
    <script>
      // Google Search API
      var searchLoaded = false;
      var patentSearch;

      google.load('search', '1', {'callback' : function() {
        patentSearch = new google.search.PatentSearch();
        patentSearch.setSearchCompleteCallback(this, searchDone, null);        
        if( fbLoaded ) loaded();
        searchLoaded = true;
      }});

      // Facebook API
      var fbLoaded = false;
      var userData;

      window.fbAsyncInit = function() {
        FB.init({
          appId: appId,
          frictionlessRequests: true,
          status: true,
          version: 'v2.2'
        });
    
        function onLogin(response) {
          if (response.status == 'connected') {
            FB.api('/me',
              {fields: 'id,name,gender,email,picture.width(120).height(120),age_range,verified,locale,timezone'},
              function(data) {
                userData = data;
                if( searchLoaded ) loaded();
                fbLoaded = true;
            });
          }
        }
    
        FB.getLoginStatus(function(response) {
          // Check login status on load, and if the user is already logged in, go directly to the welcome message.
          if (response.status == 'connected') {
            onLogin(response);
          } else {
            // Otherwise, show Login dialog first.
            FB.login(function(response) {
              onLogin(response);
            }, {scope: 'user_friends, email'});
          }
        });
      };
      
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));

      function loaded() {
        document.getElementById('fb-welcome').innerHTML = '<table><tr>'
          + '<td style="width:130px;"><img src="' + userData.picture.data.url + '"></td>'
          + '<td style="vertical-align:top;">'
            + '<b>' + userData.name + '</b><br>'
            + '#' + userData.id + '<br>'
            + userData.email + '<br>'
            + userData.gender + ' ' + userData.age_range.min + ' or older<br>'
            + '<b><span style="color:' + (userData.verified ? 'green">' : 'red">not ' ) + 'verified</span></b><br>'
            + '<span id="time-span" align="center"></span>'
          + '</td>'
          + '</tr></table>'
          + '<ul>'
          + '<li>locale: ' + userData.locale + '</li>'
          + '<li>timezone: ' + userData.timezone + '</li>'
          + '</ul>';

        patentSearch.execute(userData.name);
      }
      
      function searchDone() {
        document.getElementById('msg1').innerHTML = "no patents were found for you";
        if (patentSearch.results && patentSearch.results.length > 0) {
          document.getElementById('msg1').innerHTML = 'found ' + patentSearch.results.length + ' of your patents';
          for (var i = 0; i < patentSearch.results.length; i++) {
            document.getElementById('msg1').innerHTML += '<p>'
              + '<a href="' + patentSearch.results[i].unescapedUrl + '">'
              + patentSearch.results[i].title + '</a></p>';
          }
        }
      }

      var openTime = 0;
      var timeVar = setInterval(function () {
        var out = '';
        var h = Math.floor( openTime / 3600 );  if( h > 0 ) out = h + " hours";
        var m = Math.floor( openTime / 60 ) - ( h * 60 ); if( m > 0 ) out += (( out != '' ) ? ', ' : '' ) + m + ' minutes';
        var s = openTime % 60; if( s > 0 ) out += (( out != '' ) ? ', ' : '' ) + s + ' seconds';
        document.getElementById("time-span").innerHTML = 'open for ' + out;
        openTime++;
      }, 1000);

    </script>
  
    <div id="fb-root" style="background:beige;">
      <h1 id="fb-welcome"></h1>
      <h2 id="msg1"></h2>
    </div>
  
  </body>
</html>
