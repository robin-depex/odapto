<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Picker Example</title>

    <script type="text/javascript">

      // The Browser API key obtained from the Google API Console.
      var developerKey = 'AIzaSyCKMQcF1xc3pWlC_Cn4T2i8mJPP9jHBdVg';

      // The Client ID obtained from the Google API Console. Replace with your own Client ID.
      var clientId = '728850243222-11dnnlv5brofk51087hgqhrglfk6mnun.apps.googleusercontent.com';

      // Scope to use to access user's photos.
       var scope = ['https://www.googleapis.com/auth/drive'];

      var pickerApiLoaded = false;
      var oauthToken;

      // Use the API Loader script to load google.picker and gapi.auth.
      function onApiLoad() {
        gapi.load('auth2', onAuthApiLoad);
        gapi.load('picker', onPickerApiLoad);
      }

      function onAuthApiLoad() {
        var authBtn = document.getElementById('auth');
        authBtn.disabled = false;
        authBtn.addEventListener('click', function() {
          gapi.auth2.authorize({
            client_id: clientId,
            scope: scope
          }, handleAuthResult);
        });
      }

      function onPickerApiLoad() {
        pickerApiLoaded = true;
        createPicker();
      }

      function handleAuthResult(authResult) {
        if (authResult && !authResult.error) {
          oauthToken = authResult.access_token;
          createPicker();
        }
      }

      // Create and render a Picker object for picking user Photos.
      function createPicker() {
        if (pickerApiLoaded && oauthToken) {
          var picker = new google.picker.PickerBuilder().
              addView(google.picker.ViewId.PHOTOS).
              setOAuthToken(oauthToken).
              setDeveloperKey(developerKey).
              setCallback(pickerCallback).
              build();
          picker.setVisible(true);
        }
      }

      // A simple callback implementation.
      function pickerCallback(data) {
        var url = 'nothing';
        if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
          var doc = data[google.picker.Response.DOCUMENTS][0];
          url = doc[google.picker.Document.URL];
        }
        var message = 'You picked: ' + url;
        document.getElementById('result').innerHTML = message;
      }
    </script>
  </head>
  <body>
    <button type="button" id="auth" disabled>Authenticate</button>

    <div id="result"></div>

    <!-- The Google API Loader script. -->
    <script type="text/javascript" src="https://apis.google.com/js/api.js?onload=onApiLoad"></script>
  </body>
</html>